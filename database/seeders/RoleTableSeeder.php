<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

       /*

        $insertPermissions = fn ($role) => collect($permissionsByRole[$role])
            ->map(fn ($name) => DB::table('permissions')->insertGetId(['name' => $name, 'guard_name' => 'web']))
            ->toArray();*/

           $per=['create','read','update','delete'];
        $permissionsByRole = [
            'super_admin' =>[
                'user'=>$per,
                'category'=>$per,
                'product'=>$per,
                'client'=>$per,
                'order'=>$per,
            ],
            'admin' =>[],

        ];
        collect($permissionsByRole)->each(function ($permissions, $role) {

            $role = Role::create(['name' => $role, 'guard_name' => 'web']);
            collect($permissions)->each(function ($actions, $resource) use ($role) {

                collect($actions)->each(function ($action) use ($role, $resource) {
                    $permission = Permission::create(['name' => $resource.'_'.$action, 'guard_name' => 'web']);
                    $role->givePermissionTo($permission);
                });
            });
        });


























       // $superAdmin = Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        //$editor = Role::create(['name' => 'editor', 'guard_name' => 'web']);
      //  $viewer = Role::create(['name' => 'viewer', 'guard_name' => 'web']);
      //  $superAdmin->syncPermissions($insertPermissions('super_admin'));



    }
}
