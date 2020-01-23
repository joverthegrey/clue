<?php

use App\Role;
use App\Type;
use Illuminate\Database\Seeder;

class RoleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // define relations
        $role_types = [
            'fox' => ['verdachte', 'wapen'],
            'post' => ['locatie']
        ];

        // save to the db
        foreach ($role_types as $role_name => $types) {
            $role = Role::where(['name' => $role_name])->first();
            foreach ($types as $type_name) {
                $type = Type::where(['name' => $type_name])->first();
                $role->types()->attach($type);
                $role->save();
            }
        }
    }
}
