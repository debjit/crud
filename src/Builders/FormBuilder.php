<?php
/**
 *  This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *  Copyright (C) 2016. Galicz Miklós <galicz.miklos@blackfyre.ninja>.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */
namespace BlackfyreStudio\CRUD\Builders;

use BlackfyreStudio\CRUD\Fields\BaseField;
use BlackfyreStudio\CRUD\Results\FormResult;
use BlackfyreStudio\CRUD\Util\Value;
use Closure;
use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Validator;

/**
 * Class FormBuilder.
 */
class FormBuilder extends BaseBuilder
{
    /**
     * Constant value for the create view.
     */
    const CONTEXT_CREATE = 'create';
    /**
     * Constant value for the edit view.
     */
    const CONTEXT_EDIT = 'edit';

    /**
     * @var
     */
    protected $context;

    /**
     * Holds the form result.
     *
     * @var array
     */
    protected $result = [];
    /**
     * Holds the record identifier(id).
     *
     * @var int
     */
    protected $identifier;

    /**
     * Set the form identifier.
     *
     * @param int $identifier
     *
     * @return FormBuilder
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get the form identifier.
     *
     * @return int
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set the form context.
     *
     * @param FormBuilder $context
     *
     * @return FormBuilder
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get the form context.
     *
     * @return mixed
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Build the list data.
     *
     * @return mixed|void
     */
    public function build()
    {
        $formMapper = $this->getPlanner();
        $model = $this->getModel();

        /** @var Model $primaryKey */
        $primaryKey = (new $model())->getKeyName();

        /*
         * Empty form.
         *
         * @var FormResult
         */
        $result = new FormResult();
        if ($this->getIdentifier() === null) {

            /** @var BaseField $field */
            foreach ($formMapper->getFields() as $field) {
                $clone = clone $field;
                $name = $clone->getName();
                // Is this a multiple field?
                if ($clone->checkIfMultiple()) {
                    $clone->setValue(['']);
                }
                $clone->setContext(BaseField::CONTEXT_FORM);
                $result->addField($name, $clone);
            }
            $this->setResult($result);

            return;
        }
        $items = $model::with([]);
        $items->where($primaryKey, $this->getIdentifier());
        $item = $items->first();

        // modifyModelItem hook
        if (method_exists($this->getPlanner()->getCRUDMasterInstance(), 'modifyModelItem')) {
            $item = $this->getPlanner()->getCRUDMasterInstance()->modifyModelItem($item);
        }

        $result = new FormResult();
        $result->setIdentifier($item->{$primaryKey});

        /** @var BaseField $field */
        foreach ($formMapper->getFields() as $field) {
            $clone = clone $field;
            $name = $clone->getName();
            $value = $item->{$name};
            if ($clone->hasBefore()) {
                $before = $clone->getBefore();
                if ($before instanceof Closure) {
                    $value = $before($value);
                } else {
                    $value = $before;
                }
            }
            // Is this a multiple field?
            if ($clone->checkIfMultiple()) {
                $value = Value::decode(Config::get('crud.multiple-serializer'), $value);
            }
            $clone
                ->setContext(BaseField::CONTEXT_FORM)
                ->setValue($value);
            $result->addField($name, $clone);
        }
        $this->setResult($result);
    }

    /**
     * Sets the form result.
     *
     * @param array|FormResult $result
     *
     * @return FormBuilder
     */
    public function setResult(FormResult $result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Returns the form result.
     *
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Create a new model from input.
     *
     * @param Request
     *
     * @return FormBuilder
     */
    public function create($request)
    {
        /* Get form plan */
        $planner = $this->getPlanner();

        /* Get Master instance */
        $admin = $planner->getCRUDMasterInstance();

        /* Get the related model */
        $model = $this->getModel();

        /* Get the model's primary key */
        $primaryKey = (new $model())->getKeyName();
        
        /* Set up the request object for sharing */
        $this->setRequest($request);


        /** @var BaseField $field */
        foreach ($planner->getFields() as $field) {
            
            /* Modification on the request based on the field's settings */
            $field->preSubmitHook();
            $input = $this->getRequest();

            /* Is this a multiple field? */
            /* TODO: make compatible with type casting */
            if ($field->checkIfMultiple()) {
                $value = Value::encode(Config::get('crud::multiple-serializer'), $this->getRequest()->input($field->getName()));
                $this->getRequest()->offsetSet($field->getName(), $value);
            }

            /* Does the field have special rules before saving */
            if ($field->hasSaving()) {
                $saving = $field->getSaving();
                $this->getRequest()->offsetSet($field->getName(), $saving($input[$field->getName()]));
            }
        }

        /* Model before create hook */
        if (method_exists($admin, 'beforeCreate')) {
            $admin->beforeCreate();
        }

        /* Validate */
        if (property_exists($model, 'rulesOnCreate')) {
            $validator = Validator::make($this->getRequest()->all(), $model::$rulesOnCreate);
            if ($validator->fails()) {
                return $validator;
            }
        }

        /* Model create hook */
        if (method_exists($admin, 'create')) {
            $model = $admin->create($this->getRequest(), $model);
        } else {
            $model = $model::create($this->getRequest()->all());
        }

        /* Set the primary id from the `new` model */
        $this->setIdentifier($model->{$primaryKey});

        /* Field post update */
        foreach ($planner->getFields() as $field) {
            $field->postSubmitHook($model);
        }

        /* Model after create hook */
        if (method_exists($admin, 'afterCreate')) {
            $result = $admin->afterCreate($this->getRequest(), $model);
            if ($result instanceof RedirectResponse) {
                $result->send();
            }
        }

        return $this;
    }

    /**
     * Update a model from input.
     *
     * @param array $input
     *
     * @return FormBuilder
     */
    public function update($input)
    {
        $mapper = $this->getPlanner();
        $admin = $mapper->getCRUDMasterInstance();
        /** @var Model $model */
        $model = $this->getModel();
        $this->setRequest($input);
        // Field pre update
        /** @var BaseField $field */
        foreach ($this->getPlanner()->getFields() as $field) {
            $this->setRequest($field->preSubmitHook($this->getRequest()));

            /* Is this a multiple field? */
            if ($field->checkIfMultiple()) {
                $value = Value::encode(Config::get('crud::multiple-serializer'), $input[$field->getName()]);
                $this->setInputVariable($field->getName(), $value);
            }
            if ($field->hasSaving()) {
                $saving = $field->getSaving();
                $this->setInputVariable($field->getName(), $saving($input[$field->getName()]));
            }
        }

        /* Model before update hook */
        if (method_exists($admin, 'beforeUpdate')) {
            $this->setRequest($admin->beforeUpdate($this->getRequest()));
        }

        /* Validate */
        if (property_exists($model, 'rulesOnUpdate')) {
            $validator = Validator::make($this->getRequest(), $model::$rulesOnUpdate);
            if ($validator->fails()) {
                return $validator;
            }
        }

        /* Model update hook */
        if (method_exists($this->getPlanner()->getCRUDMasterInstance(), 'update')) {
            $this->getPlanner()->getCRUDMasterInstance()->update($this->getRequest(), $model::find($this->getIdentifier()));
        } else {
            $model::find($this->getIdentifier())
                ->update($this->getRequest());
        }

        /* Field post update */
        foreach ($this->getPlanner()->getFields() as $field) {
            $field->postSubmitHook($this->getRequest(), $model::find($this->getIdentifier()));
        }

        /* Model after update hook */
        if (method_exists($admin, 'afterUpdate')) {
            $result = $admin->afterUpdate($this->getRequest(), $model::find($this->getIdentifier()));
            if ($result instanceof RedirectResponse) {
                $result->send();
            }
        }

        return $this;
    }

    /**
     * Destroy a specific item.
     *
     * @return FormBuilder
     */
    public function destroy()
    {
        $mapper = $this->getPlanner();
        $admin = $mapper->getCRUDMasterInstance();
        $model = $this->getModel();
        $model = $model::find($this->getIdentifier());
        // Model before delete hook
        if (method_exists($admin, 'beforeDelete')) {
            $admin->beforeDelete($model);
        }
        // Model delete hook
        if (method_exists($admin, 'deleting')) {
            $admin->deleting($model);
        } else {
            $model->delete();
        }
        // Model after delete hook
        if (method_exists($admin, 'afterDelete')) {
            $result = $admin->afterDelete($model);
            if ($result instanceof RedirectResponse) {
                $result->send();
            }
        }

        return $this;
    }
}
