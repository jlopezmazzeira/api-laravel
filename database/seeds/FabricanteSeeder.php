<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Fabricante;

class FabricanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //$faker = new Faker::create();
      $faker = Faker\Factory::create();

      for ($i=0; $i < 3; $i++) {
        Fabricante::create([
          'nombre' => $faker->word(),
          'telefono' => $faker->randomNumber(7)
        ]);
      }
    }
}
