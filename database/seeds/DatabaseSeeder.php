<?php

use App\Personnage;
use App\TypePersonnage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        TypePersonnage::firstOrCreate([
            'name' => 'gobelin'
        ]);
        TypePersonnage::firstOrCreate([
            'name' => 'sorciere'
        ]);
        TypePersonnage::firstOrCreate([
            'name' => 'orc'
        ]);

        Personnage::firstOrCreate([
            'name' => 'Grimelin',
            'lp' => 100,
            'poisoned' => false,
            'type_personnage_id' => 1,
        ]);
        Personnage::firstOrCreate([
            'name' => 'Karaba',
            'lp' => 100,
            'poisoned' => false,
            'type_personnage_id' => 2,
        ]);
        Personnage::firstOrCreate([
            'name' => 'Orc',
            'lp' => 100,
            'poisoned' => false,
            'type_personnage_id' => 3,
        ]);
    }
}
