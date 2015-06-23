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

class MarkdownField extends BaseField {
    public function render()
    {
        $this->setAttribute('data-provide','markdown');
        $this->setAttribute('data-iconlibrary','fa');

        switch ($this->getContext()) {
            default:
            case $this::CONTEXT_INDEX:
                return null;
                break;
            case $this::CONTEXT_FILTER:
                return $this->getValue();
                break;
            case $this::CONTEXT_FORM:
                return view('crud::fields.textarea', [
                    'field' => $this
                ]);
                break;
        }
    }
}