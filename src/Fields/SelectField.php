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
 * Class TextField
 * @package BlackfyreStudio\CRUD\Fields
 */
class SelectField extends BaseField
{
    /**
     * Holds the select options.
     * @var array
     */
    protected $options = [];
    /**
     * Set the select options.
     *
     * @param  array $options
     *
     * @access public
     * @return SelectField
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }
    /**
     * Get the select options
     *
     * @access public
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Render the field.
     *
     * @access public
     * @return mixed|string
     */
    public function render()
    {
        switch ($this->getContext()) {
            default:
            case $this::CONTEXT_INDEX:
            case $this::CONTEXT_FILTER:
                return $this->getValue();
                break;
            case $this::CONTEXT_FORM:
                return view('crud::fields.select', [
                    'field' => $this
                ]);
                break;
        }

    }
}
