<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
        ['id' => 1, 'guard_name' => 'api','name' => 'patient_dashboard'],
        ['id' => 2, 'guard_name' => 'api','name' => 'admin_dashboard'],
        ['id' => 3, 'guard_name' => 'api','name' => 'doctor_dashboard'],
        ['id' => 4, 'guard_name' => 'api','name' => 'register_rol'],
        ['id' => 5, 'guard_name' => 'api','name' => 'list_rol'],
        ['id' => 6, 'guard_name' => 'api','name' => 'edit_rol'],
        ['id' => 7, 'guard_name' => 'api','name' => 'delete_rol'],

        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Create roles
        $roles = [
            ['id' => 1, 'name' => 'SUPERADMIN', 'guard_name' => 'api'],
            ['id' => 2, 'name' => 'ADMIN', 'guard_name' => 'api'],
            ['id' => 3, 'name' => 'MEMBER', 'guard_name' => 'api'],
            ['id' => 4, 'name' => 'GUEST', 'guard_name' => 'api'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        
        // Give all permissions to SUPERADMIN
        // $role3 = Role::create(['guard_name' => 'api','name' => 'SUPERADMIN']);
        $superadminRole = Role::find(1);
        
        $superadminRole->givePermissionTo(Permission::all());
        
        // Give all permissions to ADMIN
        $adminRole = Role::find(2);
        $adminRole->givePermissionTo(Permission::all());
        // $adminRole->givePermissionTo(Permission::all());

        // Assign specific permissions to other roles
        // $doctorRole = Role::find(3);
        // $recepcionRole = Role::find(4);
        // $laboratorioRole = Role::find(5);
        // $asistenteRole = Role::find(6);
        // $enfermeraRole = Role::find(7);
        $memberRole = Role::find(3);
        $guestRole = Role::find(4);
        // $personaladicionalRole = Role::find(5);

        // Assign permissions based on the provided SQL dump
        // $adminRole->givePermissionTo([2,5,8,9,10,12,13.14,15,17,18,19,20,22,23,24,26,27,28,29,30,32,35,38,40,41,42,44,48,49,52,53,54,59,60,61,62,66]);
        // $doctorRole->givePermissionTo([3,10,12,15,17,49,50,52,53,54,55,56,62,63,64,65,66]); // doctor specific permissions
        $guestRole->givePermissionTo([1,2]); // doctor specific permissions
        $memberRole->givePermissionTo([1,2]); // doctor specific permissions
       
    }
}
