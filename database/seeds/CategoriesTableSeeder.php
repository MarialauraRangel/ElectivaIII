<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['id' => 1, 'name' => 'Abarrotes', 'slug' => 'abarrotes'],
            ['id' => 2, 'name' => 'Despensa', 'slug' => 'despensa'],
            ['id' => 3, 'name' => 'Jugos y Bebidas', 'slug' => 'jugos-y-bebidas'],
            ['id' => 4, 'name' => 'Vinos, Licores y Cervezas', 'slug' => 'vinos-licores-y-cerveras'],
            ['id' => 5, 'name' => 'Limpieza', 'slug' => 'limpieza'],
            ['id' => 6, 'name' => 'Cuidado Personal y Belleza', 'slug' => 'cuidado-personal-y-belleza'],
            ['id' => 7, 'name' => 'Bebes', 'slug' => 'bebes'],
            ['id' => 8, 'name' => 'Farmacia', 'slug' => 'farmacia'],
            ['id' => 9, 'name' => 'Mascotas', 'slug' => 'mascotas']
    	];
    	DB::table('categories')->insert($categories);
    }
}
