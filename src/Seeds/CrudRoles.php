<?php
namespace BlackfyreStudio\CRUD\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use InvalidArgumentException;

class CrudRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = \Config::get('crud.default-roles');

        if (!is_array($roles)) {
            throw new InvalidArgumentException('The default roles must be an array!');
        }

        foreach($roles AS $i=>$role) {

            $roleModel = new Role();

            $roleModel = $roleModel->create([
                'name'=> $role,
                'slug'=> Str::slug($role)
            ]);

            if ($i === 0) {
                $permission = new Permission();

                $permission = $permission->create([
                    'name' => 'SuperUser',
                    'slug' => 'su',
                    'description' => 'The holder of this permission is the overlord'
                ]);

                $roleModel->assignPermission($permission->id);
            }
        }
    }
}
