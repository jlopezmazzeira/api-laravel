<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Fabricante;
use App\Vehiculo;

class VehiculoSeeder extends Seeder
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

      $cantidad = Fabricante::all()->count();

      for ($i=0; $i < $cantidad; $i++) {
        Vehiculo::create([
          'color' => $faker->safeColorName(),
          'cilindraje' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 1, $max = 10.20),
          'potencia' => $faker->randomNumber(),
          'peso' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 1, $max = 1020.2),
          'fabricante_id' => $faker->numberBetween(1, $cantidad)
        ]);
      }
    }
}
