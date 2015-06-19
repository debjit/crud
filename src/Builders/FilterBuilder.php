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
 use BlackfyreStudio\CRUD\Results\FilterResult;
 use Input;

 class FilterBuilder extends BaseBuilder {

     /**
      * Holds the filter result
      * @var array
      */
     protected $result = [];

     /**
      * Build the filter data.
      * @return mixed|void
      */
     public function build()
     {
         $filterMapper = $this->getPlanner();
         $input = Input::all();
         $result = new FilterResult();
         /** @var BaseField $field */
         foreach ($filterMapper->getFields() as $field) {
             $clone = clone $field;
             $name  = $clone->getName();
             if (Input::has($name)) {
                 $clone->setValue($input[$name]);
             }
             $clone->setContext(BaseField::CONTEXT_FILTER);
             $result->addField($name, $clone);
         }
         $this->setResult($result);
     }

     /**
      * Sets the filter result.
      *
      * @param array|FilterResult $result
      * @return FilterBuilder
      * @access public
      */
     public function setResult(FilterResult $result)
     {
         $this->result = $result;
         return $this;
     }
     /**
      * Returns the filter result.
      *
      * @access public
      * @return array
      */
     public function getResult()
     {
         return $this->result;
     }
 }