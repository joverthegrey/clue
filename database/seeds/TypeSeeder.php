<?php

use Illuminate\Database\Seeder;
use App\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['verdachte', 'wapen', 'locatie'] as $type) {
            Type::firstOrCreate(['name' => $type]);
        }
    }
}
