<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*  User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */

        // Создание типа продукта
        $productType = ProductType::create(['name' => 'Редукторы']);

        // Создание продукта
        $product = Product::create([
            'name' => '1ЦУ-100',
            'product_type_id' => $productType->id
        ]);

        // Атрибуты продукта
        $attributes = [
            'Страна' => 'Россия',
            'Тип передачи' => 'цилиндрический',
            'Межосевое расстояние, мм' => 100
        ];

        // Массивы для массовой вставки атрибутов и их значений
        $attributeRecords = [];
        $attributeValueRecords = [];

        foreach ($attributes as $key => $value) {
            // Подготовка данных для вставки атрибутов
            $attributeRecords[] = ['name' => $key];
        }

        // Массовая вставка атрибутов
        Attribute::insert($attributeRecords);

        // Получение всех вставленных атрибутов
        $insertedAttributes = Attribute::whereIn('name', array_keys($attributes))->get();

        foreach ($insertedAttributes as $attribute) {
            // Подготовка данных для вставки значений атрибутов
            $attributeValueRecords[] = [
                'value' => $attributes[$attribute->name],
                'attribute_id' => $attribute->id,
                'product_id' => $product->id
            ];
        }

        // Массовая вставка значений атрибутов
        AttributeValue::insert($attributeValueRecords);
    }
}
