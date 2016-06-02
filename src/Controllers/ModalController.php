<?php
/**
 *  This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *  Copyright (C) 2016. Galicz Miklós <galicz.miklos@blackfyre.ninja>.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */
namespace BlackfyreStudio\CRUD\Controllers;

use BlackfyreStudio\CRUD\Master;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Routing\Controller;

/**
 * Class ModalController.
 */
class ModalController extends Controller
{
    use AppNamespaceDetectorTrait;

    /**
     * ModalController constructor.
     */
    public function __construct()
    {
        $this->nameSpaceRoot = $this->getAppNamespace();
        $this->nameSpace = $this->nameSpaceRoot.'Http\\Controllers\\'.\Config::get('crud.directory').'\\';
    }

    /**
     * Show the form for deleting a resource.
     *
     * @param string $modelName
     *
     * @return $this
     */
    public function delete($modelName)
    {
        $modelNameWithNamespace = sprintf($this->nameSpace.'%sController', $modelName);

        $master = Master::getInstance($modelNameWithNamespace)->buildForm();

        return view('crud::modals.delete', [
            'name'  => $modelName,
            'model' => $master,
        ]);
    }
}
