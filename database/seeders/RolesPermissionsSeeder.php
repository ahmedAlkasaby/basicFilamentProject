<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $this->truncatePermissionTables();

        $config = Config::get('roles_permissions.roles_structure');
        $mapPermission = collect(config('roles_permissions.permissions_map'));

        foreach ($config as $roleName => $modules) {

            // Create Role
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $permissions = [];

            foreach ($modules as $module => $perms) {
                foreach (explode(',', $perms) as $perm) {
                    $permissionValue = $mapPermission->get($perm);

                      if ($module === 'role') {
                        $name = "{$permissionValue}_role"; // مثل view_role
                    } else {
                        $plural = $module . 's'; // تحويل city to cities
                        $name = "{$permissionValue}_{$plural}::{$module}"; // مثل view_cities::city
                    }

                    $permission = Permission::firstOrCreate([
                        'name' => $name,
                        'guard_name' => 'web',
                    ]);
                    $permissions[] = $permission->id;
                }
            }

            // Sync Permissions with Role
            $role->permissions()->sync($permissions);
        }
    }

    protected function truncatePermissionTables(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();

        Schema::enableForeignKeyConstraints();
    }
}
