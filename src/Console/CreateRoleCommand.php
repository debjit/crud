<?php
namespace BlackfyreStudio\CRUD\Console;

use BlackfyreStudio\CRUD\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class CreateRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:role
                            {name : Role name for use with the code, eg.: admins or rootUsers}
                            {--label= : The human readable name for the role}
                            {--root : Create a role with root access}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user role for this instance';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

        $role = new Role();

        $name = camel_case($this->argument('name'));

        $role->name = $name;

        if (!is_null($this->option('label'))) {
            $role->label = $this->option('label');
        }

        $role->root = $this->option('root');

        try {
            $role->save();
        } catch (QueryException $e) {
            $this->error('The ' . $name . ' role exists');
        }
    }
}