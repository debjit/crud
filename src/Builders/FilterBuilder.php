<?php
/**
 *  This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *  Copyright (C) 2016. Galicz Miklós <galicz.miklos@blackfyre.ninja>
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
 use BlackfyreStudio\CRUD\Results\FilterResult;
 use Input;

 /**
  * Class FilterBuilder
  * @package BlackfyreStudio\CRUD\Builders
  */
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