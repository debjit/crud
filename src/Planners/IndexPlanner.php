<?php
/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackfyreStudio\CRUD\Planner;

/**
 * Class IndexMapper
 * @package BlackfyreStudio\CRUD\Planner
 */
class IndexPlanner extends BasePlanner
{
    /**
     * Create an identifier column in the index view. It's usually the record ID
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\IdentifierField
     */
    public function identifier($name = '') {
        return $this->call('identifier',$name);
    }

    /**
     * Create a simple string in the index view
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\StringField
     */
    public function string($name = '') {
        return $this->call('string',$name);
    }

    /**
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\BooleanField
     */
    public function boolean($name='') {
        return $this->call('boolean',$name);
    }

    /**
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\BaseField
     */
    public function image($name='') {
        return $this->call('image',$name);
    }

    /**
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\SelectField
     */
    public function select($name='') {
        return $this->call('select',$name);
    }

    /**
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\BelongsToManyField
     */
    public function belongsToMany($name='') {
        return $this->call('BelongsToMany',$name);
    }
}
