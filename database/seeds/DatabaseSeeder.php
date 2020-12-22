<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(StatesSeeder::class);
        $this->call(MunicipalitiesSeeder::class);
        $this->call(LocationsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(SubcategoriesSeeder::class);
        $this->call(ColorsTableSeeder::class);
        $this->call(SizesTableSeeder::class);
        $this->call(BannersTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
    }
}
