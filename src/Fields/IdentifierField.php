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

class IdentifierField extends BaseField
{
    /**
     * Render the field.
     *
     * @access public
     * @return mixed|string
     */
    public function render()
    {
        switch ($this->getContext()) {

            /*
             * Identifiers are only required in the index view, nowhere else
             */
            case $this::CONTEXT_INDEX:

                /*
                 * Remove unnecessary form-control class
                 */
                $this->attributes['class'] = str_replace('form-control', '', $this->attributes['class']);

                return view('crud::fields.identifier', [
                    'model' => $this->getMasterInstance()->getModelBaseName(),
                    'row' => $this->getRowId(),
                    'value' => $this->getValue(),
                    'attributes' => $this->attributes
                ]);
                break;
            default:
            case $this::CONTEXT_FILTER:
            case $this::CONTEXT_FORM:
                return null;
                break;
        }


    }
}