<?php
/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackfyreStudio\CRUD\Results;

/**
 * Class BaseResult
 * @package BlackfyreStudio\CRUD\Results
 */
abstract class BaseResult
{
    /**
     * Holds the item identifier (normally the id).
     * @var integer
     */
    protected $identifier;
    /**
     * Holds the resources fields.
     * @var array
     */
    protected $fields = [];

    /**
     * Set the identifier.
     *
     * @param  integer $identifier
     *
     * @access public
     * @return BaseResult
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * Get the identifier.
     *
     * @access public
     * @return integer
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Add a field to the result.
     *
     * @param  string $key
     * @param  string $field
     *
     * @access public
     * @return BaseResult
     */
    public function addField($key, $field)
    {
        $this->fields[$key] = $field;
        return $this;
    }

    /**
     * Get the fields.
     *
     * @access public
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get a field.
     *
     * @access public
     * @param $key
     * @return string
     */
    public function getField($key)
    {
        return $this->fields[$key];
    }
}