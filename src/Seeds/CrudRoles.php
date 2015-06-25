<?php
namespace BlackfyreStudio\CRUD\Seeds;

use BlackfyreStudio\CRUD\Models\CrudRole;
use Illuminate\Database\Seeder;
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
            /**
             * Yes, pun intended :)
             * @var CrudRole $roleModel
             */
            $roleModel = new CrudRole();

            $roleModel->role_name = $role;

            if ($i === 0) {
                $roleModel->permissions = json_encode([
                    'access'=>['superuser']
                ]);
            }

            $roleModel->save();
        }
    }
}
