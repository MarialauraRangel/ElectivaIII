<?php

use Illuminate\Database\Seeder;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = [
    		['id' => 1, 'name' => 'S', 'slug' => 's'],
            ['id' => 2, 'name' => 'M', 'slug' => 'm'],
            ['id' => 3, 'name' => 'L', 'slug' => 'l']
    	];
    	DB::table('sizes')->insert($sizes);
    }
}
