<?php
/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

 namespace BlackfyreStudio\CRUD\Fields;

 /**
  * Class StringField
  * @package BlackfyreStudio\CRUD\Fields
  */
 class StringField extends BaseField {
     /**
      * Render the field.
      *
      * @access public
      * @return mixed|string
      */
     public function render()
     {
         return $this->getValue();
     }
 }