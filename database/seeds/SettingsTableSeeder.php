<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
    		['id' => 1, 'about' => '<p><strong>Nuestra Misi&oacute;n</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p><img alt="Imagen Nosotros" src="/admins/img/template/imagen.jpg" style="height:250px; width:100%" /></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>', 'terms' => NULL, 'privacity' => NULL, 'map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5710.223960652141!2d-100.63238461534492!3d17.213097403882255!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8434cd45c6aac951%3A0x15c686051fbc7836!2sCajero%20Banamex%20SEG!5e0!3m2!1ses-419!2smx!4v1606844860159!5m2!1ses-419!2smx" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>', 'phone' => '+1 253 565 2365', 'email' => 'ventas@supertecpan.com', 'address' => 'Zihuatanejo Acapulco, Tecpan de Galeana', 'facebook' => 'https://www.facebook.com', 'twitter' => 'https://www.twitter.com', 'instagram' => 'https://www.instagram.com', 'discount' => 0, 'max_value_delivery' => 300.00, 'min_delivery_price' => 50.00, 'banner' => NULL]
    	];
    	DB::table('settings')->insert($settings);
    }
}
