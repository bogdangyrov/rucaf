<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductType::create(['name' => 'Автоматические выключатели', 'image' => 'product-types/img-1.png']);
        ProductType::create(['name' => 'Вакуумные контакторы', 'image' => 'product-types/img-2.png']);
        ProductType::create(['name' => 'Крановые весы', 'image' => 'product-types/img-3.png']);
        ProductType::create(['name' => 'Радиоуправление краном', 'image' => 'product-types/img-4.png']);
        ProductType::create(['name' => 'Лебедки электрические', 'image' => 'product-types/img-5.png']);
        ProductType::create(['name' => 'Редукторы', 'image' => 'product-types/img-6.png']);
        ProductType::create(['name' => 'Крановые электродвигатели', 'image' => 'product-types/img-7.png']);
        ProductType::create(['name' => 'Пульт управления', 'image' => 'product-types/img-8.png']);
        ProductType::create(['name' => 'Электрические тали и тельферы', 'image' => 'product-types/img-9.png']);
        ProductType::create(['name' => 'Запчасти для тельфера', 'image' => 'product-types/img-10.png']);
    }
}
