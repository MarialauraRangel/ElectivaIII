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
    		['id' => 1, 'about' => '<p><strong>Nuestra Misi&oacute;n</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p><img alt="Imagen Nosotros" src="/admins/img/template/imagen.jpg" style="height:250px; width:100%" /></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>', 'terms' => NULL, 'privacity' => NULL, 'map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d21539.919951533986!2d-66.15001568713983!3d-17.375476670536546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1smaesma!5e0!3m2!1ses!2sbo!4v1543502164856" frameborder="0" allowfullscreen></iframe>', 'phone' => '+1 253 565 2365', 'email' => 'admin@gmail.com', 'address' => 'Buttonwood, California. Rosemead, CA 91770', 'facebook' => 'https://www.facebook.com', 'twitter' => 'https://www.twitter.com', 'instagram' => 'https://www.instagram.com', 'discount' => 0]
    	];
    	DB::table('settings')->insert($settings);
    }
}
