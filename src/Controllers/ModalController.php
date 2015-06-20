<?php
/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackfyreStudio\CRUD\Controllers;

use BlackfyreStudio\CRUD\Master;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Routing\Controller;

class ModalController extends Controller
{

    use AppNamespaceDetectorTrait;

    public function __construct()
    {
        $this->nameSpaceRoot = $this->getAppNamespace();
        $this->nameSpace = $this->nameSpaceRoot . 'Http\\Controllers\\' . \Config::get('crud.directory') . '\\';
    }

    /**
     * Show the form for deleting a resource.
     *
     * @param  string $modelName
     *
     * @access public
     * @return $this
     */
    public function delete($modelName)
    {
        $modelNameWithNamespace = sprintf($this->nameSpace . '%sController', $modelName);;

        $master = Master::getInstance($modelNameWithNamespace)->buildForm();
        return view('crud::modals.delete', [
            'name' => $modelName,
            'model' => $master
        ]);
    }
}