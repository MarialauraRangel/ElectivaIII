<?php

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banner = [
    		['id' => 1, 'image' => 'imagen.jpg', 'title' => 'Colección de Invierno', 'slug' => 'banner', 'text' => 'Lo mejor en ropa para este 2020', 'button' => "1", 'button_text' => 'Comprar Ahora', 'pre_url' => NULL, 'url' => NULL, 'target' => '0', 'type' => '1', 'state' => '1']
    	];
    	DB::table('banners')->insert($banner);
    }
}
