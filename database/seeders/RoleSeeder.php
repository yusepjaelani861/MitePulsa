<?php

namespace Database\Seeders;

use App\Models\Roles\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Member',
        ]);

        Role::create([
            'name' => 'Admin'
        ]);
    }
}
