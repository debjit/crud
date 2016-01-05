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
 * Class RelationField
 * @package BlackfyreStudio\CRUD\Fields
 */
abstract class RelationField extends BaseField {

    /**
     * Holds the display field name.
     * @var string
     */
    protected $displayField = null;
    /**
     * Whether or not to render actions next to this field.
     * @var bool
     */
    protected $inline = true;
    /**
     * Set the display field name.
     *
     * @param  string $displayField
     *
     * @access public
     * @return BelongsToField
     */
    public function display($displayField)
    {
        $this->displayField = $displayField;
        return $this;
    }
    /**
     * Get the display field name.
     *
     * @access public
     * @return string
     */
    public function getDisplayField()
    {
        return $this->displayField;
    }
    /**
     * Set inline rendering.
     *
     * @param  boolean $inline
     *
     * @access public
     * @return BelongsToField
     */
    public function setInline($inline)
    {
        $this->inline = (bool) $inline;
        return $this;
    }
    /**
     * Get inline rendering.
     *
     * @access public
     * @return BelongsToField
     */
    public function getInline()
    {
        return $this;
    }

    /**
     * @param $input
     * @param \Illuminate\Database\Eloquent\Model $baseModel
     */
    public function postSubmitHook($input, $baseModel)
    {

        $model = $baseModel::find($this->getMasterInstance()->getFormBuilder()->getIdentifier());
        $pivot = $this->getName();
        if(isset($input[$pivot])) {
            $model->{$pivot}()->sync($input[$pivot]);
        }
    }
}