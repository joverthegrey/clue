<?php

use App\User;
use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $admin_role = Role::where('name', '=', 'admin')->first();
        if (!$admin_role) throw new Exception('Missing admin role');

        $admin = new User();
        $admin->name = 'Clue Admin';
        $admin->email = 'admin@clue.local';
        $admin->password = Hash::make('admin');
        $admin->save();
    }
}
