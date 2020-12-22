<?php

use Illuminate\Database\Seeder;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$states = [
    		['id' => 1, 'name' => 'Aguascalientes', 'country_id' => 146],
    		['id' => 2, 'name' => 'Baja California', 'country_id' => 146],
    		['id' => 3, 'name' => 'Baja California Sur', 'country_id' => 146],
    		['id' => 4, 'name' => 'Campeche', 'country_id' => 146],
    		['id' => 5, 'name' => 'Coahuila de Zaragoza', 'country_id' => 146],
    		['id' => 6, 'name' => 'Colima', 'country_id' => 146],
    		['id' => 7, 'name' => 'Chiapas', 'country_id' => 146],
    		['id' => 8, 'name' => 'Chihuahua', 'country_id' => 146],
    		['id' => 9, 'name' => 'Ciudad de México', 'country_id' => 146],
    		['id' => 10, 'name' => 'Durango', 'country_id' => 146],
    		['id' => 11, 'name' => 'Guanajuato', 'country_id' => 146],
    		['id' => 12, 'name' => 'Guerrero', 'country_id' => 146],
    		['id' => 13, 'name' => 'Hidalgo', 'country_id' => 146],
    		['id' => 14, 'name' => 'Jalisco', 'country_id' => 146],
    		['id' => 15, 'name' => 'México', 'country_id' => 146],
    		['id' => 16, 'name' => 'Michoacán de Ocampo', 'country_id' => 146],
    		['id' => 17, 'name' => 'Morelos', 'country_id' => 146],
    		['id' => 18, 'name' => 'Nayarit', 'country_id' => 146],
    		['id' => 19, 'name' => 'Nuevo León', 'country_id' => 146],
    		['id' => 20, 'name' => 'Oaxaca', 'country_id' => 146],
    		['id' => 21, 'name' => 'Puebla', 'country_id' => 146],
    		['id' => 22, 'name' => 'Querétaro', 'country_id' => 146],
    		['id' => 23, 'name' => 'Quintana Roo', 'country_id' => 146],
    		['id' => 24, 'name' => 'San Luis Potosí', 'country_id' => 146],
    		['id' => 25, 'name' => 'Sinaloa', 'country_id' => 146],
    		['id' => 26, 'name' => 'Sonora', 'country_id' => 146],
    		['id' => 27, 'name' => 'Tabasco', 'country_id' => 146],
    		['id' => 28, 'name' => 'Tamaulipas', 'country_id' => 146],
    		['id' => 29, 'name' => 'Tlaxcala', 'country_id' => 146],
    		['id' => 30, 'name' => 'Veracruz de Ignacio de la Llave', 'country_id' => 146],
    		['id' => 31, 'name' => 'Yucatán', 'country_id' => 146],
    		['id' => 32, 'name' => 'Zacatecas', 'country_id' => 146]
    	];
    	DB::table('states')->insert($states);
    }
}
