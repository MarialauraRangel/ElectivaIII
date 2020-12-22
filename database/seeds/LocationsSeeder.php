<?php

use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$locations = [
    		['id' => 1, 'municipality_id' => 1, 'name' => 'Aguascalientes'],
    		['id' => 2, 'municipality_id' => 1, 'name' => 'Granja Adelita'],
    		['id' => 3, 'municipality_id' => 1, 'name' => 'Agua Azul'],
    		['id' => 4, 'municipality_id' => 1, 'name' => 'Rancho Alegre'],
    		['id' => 5, 'municipality_id' => 1, 'name' => 'Los Arbolitos [Rancho]'],
    		['id' => 6, 'municipality_id' => 1, 'name' => 'Ardillas de Abajo (Las Ardillas)'],
    		['id' => 7, 'municipality_id' => 1, 'name' => 'Arellano'],
    		['id' => 8, 'municipality_id' => 1, 'name' => 'Bajío los Vázquez'],
    		['id' => 9, 'municipality_id' => 1, 'name' => 'Bajío de Montoro'],
    		['id' => 10, 'municipality_id' => 1, 'name' => 'Residencial San Nicolás [Baños la Cantera]'],
    		['id' => 11, 'municipality_id' => 1, 'name' => 'Buenavista de Peñuelas'],
    		['id' => 12, 'municipality_id' => 1, 'name' => 'Cabecita 3 Marías (Rancho Nuevo)'],
    		['id' => 13, 'municipality_id' => 1, 'name' => 'Cañada Grande de Cotorina'],
    		['id' => 14, 'municipality_id' => 1, 'name' => 'Cañada Honda [Estación]'],
    		['id' => 15, 'municipality_id' => 1, 'name' => 'Los Caños'],
    		['id' => 16, 'municipality_id' => 1, 'name' => 'El Cariñán'],
    		['id' => 17, 'municipality_id' => 1, 'name' => 'El Carmen [Granja]'],
    		['id' => 18, 'municipality_id' => 1, 'name' => 'El Cedazo (Cedazo de San Antonio)'],
    		['id' => 19, 'municipality_id' => 1, 'name' => 'Centro de Arriba (El Taray)'],
    		['id' => 20, 'municipality_id' => 1, 'name' => 'Cieneguilla (La Lumbrera)'],
    		['id' => 21, 'municipality_id' => 1, 'name' => 'Cobos'],
    		['id' => 22, 'municipality_id' => 1, 'name' => 'El Colorado (El Soyatal)'],
    		['id' => 23, 'municipality_id' => 1, 'name' => 'El Conejal'],
    		['id' => 24, 'municipality_id' => 1, 'name' => 'Cotorina de Abajo'],
    		['id' => 25, 'municipality_id' => 1, 'name' => 'Coyotes']
    	];
    	DB::table('locations')->insert($locations);
    }
}
