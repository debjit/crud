<?php
/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackfyreStudio\CRUD\Builders;

use BlackfyreStudio\CRUD\Fields\BaseField;
use BlackfyreStudio\CRUD\Results\FormResult;
use BlackfyreStudio\CRUD\Util\Value;
use Closure;
use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Validator;

class FormBuilder extends BaseBuilder
{

    const CONTEXT_CREATE = 'create';
    const CONTEXT_EDIT = 'edit';

    /**
     * @var
     */
    protected $context;

    /**
     * Holds the form result.
     * @var array
     */
    protected $result = [];
    /**
     * Holds the record identifier(id).
     * @var int
     */
    protected $identifier;

    /**
     * Set the form identifier.
     *
     * @param  int $identifier
     *
     * @access public
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
     * @access public
     * @return int
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set the form context.
     *
     * @param  FormBuilder $context
     *
     * @access public
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
     * @access public
     * @return mixed
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Build the list data.
     *
     * @access public
     * @return mixed|void
     */
    public function build()
    {
        $formMapper = $this->getPlanner();
        $model = $this->getAppNamespace() . $this->getModel();

        /** @var Model $primaryKey */
        $primaryKey = (new $model)->getKeyName();

        /**
         * Empty form
         * @var FormResult $result
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

        $result = new FormResult;
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
     * @return FormBuilder
     * @access public
     */
    public function setResult(FormResult $result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * Returns the form result.
     *
     * @access public
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Create a new model from input.
     *
     * @param array|\Input $input
     * @return FormBuilder
     * @access public
     */
    public function create($input)
    {
        $mapper = $this->getPlanner();
        $admin = $mapper->getCRUDMasterInstance();
        $model = $this->getAppNamespace() . $this->getModel();
        $primaryKey = (new $model)->getKeyName();
        $this->setInput($input);

        /**
         * Field pre update
         * @var BaseField $field
         */
        foreach ($mapper->getFields() as $field) {

            $field->preSubmitHook();
            $input = $this->getInput();

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

        /* Model before create hook */
        if (method_exists($admin, 'beforeCreate')) {
            $admin->beforeCreate($input);
        }

        /* Validate */
        if (property_exists($model, 'rulesOnCreate')) {
            $validator = Validator::make($this->getInput(), $model::$rules);
            if ($validator->fails()) {
                return $validator;
            }
        }

        /* Model create hook */
        if (method_exists($admin, 'create')) {
            $model = $admin->create($this->getInput(),$model);
        } else {
            $model = $model::create($this->getInput());
        }

        /* Set the primary id from the `new` model */
        $this->setIdentifier($model->{$primaryKey});

        /* Field post update */
        foreach ($mapper->getFields() as $field) {
            $field->postSubmitHook($this->getInput(), $model);
        }

        /* Model after create hook */
        if (method_exists($admin, 'afterCreate')) {
            $result = $admin->afterCreate($this->getInput());
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
     * @access public
     * @return FormBuilder
     */
    public function update($input)
    {
        $mapper = $this->getPlanner();
        $admin = $mapper->getCRUDMasterInstance();
        /** @var Model $model */
        $model = $this->getAppNamespace() . $this->getModel();
        $this->setInput($input);
        // Field pre update
        /** @var BaseField $field */
        foreach ($this->getPlanner()->getFields() as $field) {
            $field->preSubmitHook();

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
            $admin->beforeUpdate($input);
        }

        /* Validate */
        if (property_exists($model, 'rulesOnUpdate')) {
            $validator = Validator::make($this->getInput(), $model::$rules);
            if ($validator->fails()) {
                return $validator;
            }
        }

        /* Model update hook */
        if (method_exists($this->getPlanner()->getCRUDMasterInstance(), 'update')) {
            $this->getPlanner()->getCRUDMasterInstance()->update($this->getInput(), $model);
        } else {
            $model::find($this->getIdentifier())
                ->update($this->getInput());
        }
        /* Field post update */
        foreach ($this->getPlanner()->getFields() as $field) {
            $field->postSubmitHook($this->getInput(),$model);
        }

        /* Model after update hook */
        if (method_exists($admin, 'afterUpdate')) {
            $result = $admin->afterUpdate($this->getInput(), $model);
            if ($result instanceof RedirectResponse) {
                $result->send();
            }
        }
        return $this;
    }

    /**
     * Destroy a specific item.
     *
     * @access public
     * @return FormBuilder
     */
    public function destroy()
    {
        $mapper = $this->getPlanner();
        $admin = $mapper->getCRUDMasterInstance();
        $model = $this->getAppNamespace() . $this->getModel();
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