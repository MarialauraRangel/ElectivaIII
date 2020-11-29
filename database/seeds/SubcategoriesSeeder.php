<?php

use Illuminate\Database\Seeder;

class SubcategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = [
            ['id' => 1, 'name' => 'Sin Subcategoría', 'slug' => 'sin-subcategoria', 'category_id' => 1],
            ['id' => 2, 'name' => 'Arroz, Frijoles y Pastas', 'slug' => 'arroz-frijoles-y-pastas', 'category_id' => 2],
            ['id' => 3, 'name' => 'Azúcar, Café y Té', 'slug' => 'azucar-cafe-y-te', 'category_id' => 2],
            ['id' => 4, 'name' => 'Botanas y Frutas Secas', 'slug' => 'botanas-y-frutas-secas', 'category_id' => 2],
            ['id' => 5, 'name' => 'Aderezos, Salsas y Sazonadores', 'slug' => 'aderezo-salsas-y-sazonadores', 'category_id' => 2],
            ['id' => 6, 'name' => 'Botanas y Dulces', 'slug' => 'botanas-y-dulces', 'category_id' => 2],
            ['id' => 7, 'name' => 'Mermeladas y Untables', 'slug' => 'mermeladas-y-untables', 'category_id' => 2],
            ['id' => 8, 'name' => 'Cereales, Galletas y Barras', 'slug' => 'cereales-galletas-y-barras', 'category_id' => 2],
            ['id' => 9, 'name' => 'Agua', 'slug' => 'agua', 'category_id' => 3],
            ['id' => 10, 'name' => 'Refrescos', 'slug' => 'refrescos', 'category_id' => 3],
            ['id' => 11, 'name' => 'Bebidas Deportivas y Energéticas', 'slug' => 'bebidas-deportivas-y-energeticas', 'category_id' => 3],
            ['id' => 12, 'name' => 'Jugos y Saborizantes', 'slug' => 'jugos-y-saborizantes', 'category_id' => 3],
            ['id' => 13, 'name' => 'Leche', 'slug' => 'leche', 'category_id' => 3],
            ['id' => 14, 'name' => 'Destilados', 'slug' => 'destilados', 'category_id' => 4],
            ['id' => 15, 'name' => 'Cervezas', 'slug' => 'cervezas', 'category_id' => 4],
            ['id' => 16, 'name' => 'Lavatrastes y Desengrasantes', 'slug' => 'lavatrastes-y-desengrasantes', 'category_id' => 5],
            ['id' => 17, 'name' => 'Lavandería', 'slug' => 'lavanderia', 'category_id' => 5],
            ['id' => 18, 'name' => 'Productos de Limpieza', 'slug' => 'productos-de-limpieza', 'category_id' => 5],
            ['id' => 19, 'name' => 'Jarciería', 'slug' => 'jarcieria', 'category_id' => 5],
            ['id' => 20, 'name' => 'Desechables e Insumos', 'slug' => 'desechables-e-insumos', 'category_id' => 5],
            ['id' => 21, 'name' => 'Papel Higiénico, Servitoallas y Dispensadores', 'slug' => 'papel-higienico-servitoallas-y-dispensadores', 'category_id' => 5],
            ['id' => 22, 'name' => 'Cuidado del Cabello', 'slug' => 'cuidado-del-cabello', 'category_id' => 6],
            ['id' => 23, 'name' => 'Afeitado', 'slug' => 'afeitado', 'category_id' => 6],
            ['id' => 24, 'name' => 'Perfumes y Fragancias', 'slug' => 'perfumes-y-fragancias', 'category_id' => 6],
            ['id' => 25, 'name' => 'Cuidado Corporal', 'slug' => 'cuidado-corporal', 'category_id' => 6],
            ['id' => 26, 'name' => 'Cuidado Bucal', 'slug' => 'cuidado-bucal', 'category_id' => 6],
            ['id' => 27, 'name' => 'Cuidado Facial', 'slug' => 'cuidado-facial', 'category_id' => 6],
            ['id' => 28, 'name' => 'Productos para Spa', 'slug' => 'productos-para-spa', 'category_id' => 6],
            ['id' => 29, 'name' => 'Higiene y Cuidado del Bebé', 'slug' => 'higiene-y-cuidado-del-bebe', 'category_id' => 7],
            ['id' => 30, 'name' => 'Lactancia y Alimentación', 'slug' => 'lactancia-y-alimentacion', 'category_id' => 7],
            ['id' => 31, 'name' => 'Muebles para Bebé', 'slug' => 'muebles-para-bebe', 'category_id' => 7],
            ['id' => 32, 'name' => 'Medicamentos sin Receta', 'slug' => 'medicamentos-sin-receta', 'category_id' => 8],
            ['id' => 33, 'name' => 'Equipo y Botiquin', 'slug' => 'equipos-y-botiquin', 'category_id' => 8],
            ['id' => 34, 'name' => 'Fórmulas Infantiles', 'slug' => 'formulas-infantiles', 'category_id' => 8],
            ['id' => 35, 'name' => 'Incontinencia', 'slug' => 'incontinencia', 'category_id' => 8],
            ['id' => 36, 'name' => 'Salud Natural', 'slug' => 'salud-natural', 'category_id' => 8],
            ['id' => 37, 'name' => 'Suplementos', 'slug' => 'suplementos', 'category_id' => 8],
            ['id' => 38, 'name' => 'Planificación Familiar', 'slug' => 'planificacion-familiar', 'category_id' => 8],
            ['id' => 39, 'name' => 'Perros', 'slug' => 'perros', 'category_id' => 9],
            ['id' => 40, 'name' => 'Gatos', 'slug' => 'gatos', 'category_id' => 9],
            ['id' => 41, 'name' => 'Accesorios para Mascotas', 'slug' => 'accesorios-para-mascotas', 'category_id' => 9]

    	];
    	DB::table('subcategories')->insert($subcategories);
    }
}
