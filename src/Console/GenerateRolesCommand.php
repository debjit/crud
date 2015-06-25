<?php
namespace BlackfyreStudio\CRUD\Console;

use BlackfyreStudio\CRUD\Models\CrudPermission;
use File;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Finder\SplFileInfo;

/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class GenerateRolesCommand extends Command {
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'crud:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the roles table based on created CRUD controllers';

    /**
     * Create a new command instance.
     *
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

        if (is_null($this->option('controller'))) {
            $controllers = File::allFiles('./app/Http/Controllers/' . \Config::get('crud.directory') . '/');

            CrudPermission::truncate();
            $this->info('Permissions table pruged');

            /** @var SplFileInfo $controller */
            foreach ($controllers AS $controller) {
                $name = str_replace('Controller.php','',$controller->getBasename());

                $this->createPermissionsFor($name);

            }

        } else {
            $this->createPermissionsFor($this->option('controller'));
        }

    }

    private function createPermissionsFor($ControllerName = '') {
        $permissions = ['create','read','update','delete'];

        foreach ($permissions AS $permission) {

            $permission = $ControllerName . ':' . $permission;

            $model = new CrudPermission();
            $model->permission = $permission;
            $model->save();

            $this->info($permission . ' permission created');
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['controller', null, InputOption::VALUE_OPTIONAL , 'The name of the controller for which the roles will be created', null]
        ];
    }
}