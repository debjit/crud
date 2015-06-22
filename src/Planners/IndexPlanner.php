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
use BlackfyreStudio\CRUD\Fields\BaseField;
use BlackfyreStudio\CRUD\Fields\IdentifierField;
use BlackfyreStudio\CRUD\Fields\StringField;

/**
 * Class IndexMapper
 * @package BlackfyreStudio\CRUD\Planner
 */
class IndexPlanner extends BasePlanner
{
    /**
     * Create an identifier column in the index view. It's usually the record ID
     * @param string $name
     * @return IdentifierField
     */
    public function identifier($name = '') {
        return $this->call('identifier',$name);
    }

    /**
     * Create a simple string in the index view
     * @param string $name
     * @return StringField
     */
    public function string($name = '') {
        return $this->call('string',$name);
    }

    /**
     * @param string $name
     * @return BaseField
     */
    public function boolean($name='') {
        return $this->call('boolean',$name);
    }

    /**
     * @param string $name
     * @return BaseField
     */
    public function image($name='') {
        return $this->call('image',$name);
    }

    /**
     * @param string $name
     * @return BaseField
     */
    public function select($name='') {
        return $this->call('select',$name);
    }
}
