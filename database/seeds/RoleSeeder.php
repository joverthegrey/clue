<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['admin', 'fox', 'post'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
