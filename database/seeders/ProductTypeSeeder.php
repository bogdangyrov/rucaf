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
        ProductType::create(['name' => 'Автоматические выключатели']);
        ProductType::create(['name' => 'Вакуумные контакторы']);
        ProductType::create(['name' => 'Крановые весы']);
        ProductType::create(['name' => 'Радиоуправление краном']);
        ProductType::create(['name' => 'Лебедки электрические']);
        ProductType::create(['name' => 'Редукторы']);
        ProductType::create(['name' => 'Крановые электродвигатели']);
        ProductType::create(['name' => 'Пульт управления']);
        ProductType::create(['name' => 'Электрические тали и тельферы']);
        ProductType::create(['name' => 'Запчасти для тельфера']);
    }
}
