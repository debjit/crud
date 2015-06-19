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
use BlackfyreStudio\CRUD\Results\IndexResult;
use BlackfyreStudio\CRUD\Util\Value;
use Config;
use Illuminate\Pagination\Paginator;
use Input;

/**
 * Class IndexBuilder
 * @package BlackfyreStudio\CRUD\Builders
 */
class IndexBuilder extends BaseBuilder
{

    protected $result = [];

    /**
     * Holds the paginator object
     * @var Paginator
     */
    protected $paginator;

    /**
     * Returns the list result.
     *
     * @access public
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Sets the list result.
     *
     * @param  array $result
     *
     * @access public
     * @return IndexBuilder
     */
    public function setResult(array $result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * Get the paginator object.
     * @return Paginator
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    /**
     * Set the paginator object.
     *
     * @param  Paginator $paginator
     *
     * @access public
     * @return IndexBuilder
     */
    public function setPaginator($paginator)
    {
        $this->paginator = $paginator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function build()
    {
        /**
         * @var BaseField $field
         * @var BaseField $clone
         * @var \Illuminate\Database\Eloquent\Model $items
         */
        $indexPlanner = $this->getPlanner();

        $model = $this->getAppNamespace() . $this->getModel();

        $items = $model::with([]);
        $primaryKey = (new $model)->getKeyName();

        // Field ordering
        if (Input::has('_order_by')) {
            $items->orderBy(Input::get('_order_by'), Input::get('_order'));
        }

        // Field filters
        foreach (Input::all() as $key => $value) {
            if (empty($value) || substr($key, 0, 1) === '_' || $key === 'page') {
                continue;
            }
            $items->where($key, 'LIKE', '%' . $value . '%');
        }

        // Result scopes
        if (Input::has('_scope')) {
            $items->{Input::get('_scope')}();
        }

        $items = $items->paginate($indexPlanner->getCRUDMasterInstance()->getPerPage());
        $this->setPaginator($items);
        $result = [];
        foreach ($items as $item) {
            $row = new IndexResult();
            $row->setIdentifier($item->{$primaryKey});
            foreach ($indexPlanner->getFields() as $field) {
                $clone = clone $field;
                $name = $clone->getName();
                $value = $item->{$name};
                if ($clone->hasBefore()) {
                    $before = $clone->getBefore();
                    $value = $before($value);
                }
                if ($clone->checkIfMultiple()) {
                    $value = Value::decode(Config::get('crud.multiple-serializer'), $value);
                    $value = implode(', ', $value);
                }
                $clone
                ->setContext(BaseField::CONTEXT_INDEX)
                ->setRowId($item->{$primaryKey})
                ->setValue($value);

                $row->addField($name, $clone);
            }
            $result[] = $row;
        }
        $this->setResult($result);
    }
}
