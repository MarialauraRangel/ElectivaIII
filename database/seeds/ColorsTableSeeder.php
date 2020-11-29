<?php

use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
        	['id' => 1, 'name' => 'Blanco', 'slug' => 'blanco', 'color' => '#ffffff'],
        	['id' => 2, 'name' => 'Negro', 'slug' => 'negro', 'color' => '#000000'],
    		['id' => 3, 'name' => 'Rojo', 'slug' => 'rojo', 'color' => '#ff0000'],
            ['id' => 4, 'name' => 'Azul', 'slug' => 'azul', 'color' => '#1e00ff']
    	];
    	DB::table('colors')->insert($colors);
    }
}
