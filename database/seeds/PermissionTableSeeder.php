<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{

    public function run()
    {
        $permissions = [
            'Add_User',
            'Update_User',
            'Delete_User',
            'Activate_User',
            'Add_Role',
            'Update_Role',
            'Delete_Role',
            'Add_Push_Notification',
            'List_Users',
            'Roles_and_Permissions',
            'List_Roles',
            'List_Permissions',
            'List_Push_Notifications',
            'Settings',
            'Log_Viewer',
            'Profile',
            'Reset_Password',
            'Notifications',
            'Reports',
        ];
        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }
    }
}
