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

use Illuminate\Support\Str;

/**
 * Class FormPlanner
 * @package BlackfyreStudio\CRUD\Planner
 */
class FormPlanner extends BasePlanner
{
    protected $tab;

    protected $position = 'left';

    public function __call($type, array $arguments)
    {
        $name = array_shift($arguments);
        $type = '\\BlackfyreStudio\\CRUD\\Fields\\' . Str::studly($type);
        $field = new $type($name, $this->getCRUDMasterInstance());

        $this->fields[$name] = $field;

        return $this;
    }
}
