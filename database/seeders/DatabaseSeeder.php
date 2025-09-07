<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // the steps
        // Artisan::call('migrate:fresh');
        // Artisan::call('shield:generate --all');
        // Artisan::call('db:seed');

        $role = Role::firstOrCreate(['name' => 'super_admin']);



        $role->givePermissionTo(Permission::all());

        $admin = User::create([
            'name' => 'ahmed',
            'email' => 'ahmed@gmail.com',
            'password' => bcrypt('ahmed145'),
            'type' => 'admin',
            'active' => true,
            'lang' => 'ar',
            'theme' => 'dark',
        ]);

        $admin->assignRole($role);

      
        $this->call([
            CitySeeder::class,
            LocationSeeder::class,
        ]);
    }
}
