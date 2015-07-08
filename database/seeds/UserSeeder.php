<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class UserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
        $adminUser = User::create([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => 'admin@yoursite.com',
            'password' => bcrypt('password')
        ]);
        
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Super administrator role.',            
        ]);
        
        $permission['manageUsersPerm'] = Permission::create([
            'name' => 'manage-users',
            'display_name' => 'Manage Users',
            'description' => 'Has ability to view, create, edit and delete users as well as assign user roles.',
        ]);
        
        $permission['managePermissionsPerm'] = Permission::create([
            'name' => 'manage-permissions',
            'display_name' => 'Manage Permissions',
            'description' => 'Has ability to view and edit permissions.',
        ]);
        
        $permission['manageRolesPerm'] = Permission::create([
            'name' => 'manage-roles',
            'display_name' => 'Manage Roles',
            'description' => 'Has ability to view, create, edit and delete roles as well as assign role permissions.',
        ]);
        
        $adminRole->attachPermissions($permission);
        $adminUser->attachRole($adminRole);

        for ($i = 0; $i < 100; $i ++) { // random users
            $user = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'password' => bcrypt('pass')
            ]);        
        }
    }
}
