<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Value;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductType;
use Illuminate\Support\Str;
use App\Models\AttributeValue;
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
        $productType = ProductType::create(['name' => 'Редукторы', 'slug' => Str::slug('Редукторы')]);

        $categoryNames = ['Редукторы ЦУ', 'Редукторы Ц2У', 'Редукторы Ц3У'];
        $productNames = ['1ЦУ-100', '1ЦУ-160', '1ЦУ-200'];

        $products = [];
        for ($i = 0; $i < count($productNames); $i++) {
            $category = Category::create([
                'name' => $categoryNames[$i],
                'slug' => Str::slug($categoryNames[$i]),
                'product_type_id' => $productType->id
            ]);
            $products[] = Product::create([
                'name' => $productNames[$i],
                'slug' => Str::slug($productNames[$i]),
                'product_type_id' => $productType->id,
                'category_id' => $category->id
            ]);
        }

        $attributeNames = ['Страна' => 'Россия', 'Тип передачи' => 'цилиндрический', 'Межосевое расстояние, мм' => 160];
        foreach ($attributeNames as $name => $value) {
            $attribute = Attribute::create(['name' => $name, 'product_type_id' => $productType->id, 'slug' => Str::slug($name)]);
            $value = Value::create(['value' => $value, 'slug' => Str::slug($value)]);
            foreach ($products as $product) {
                AttributeValue::create(['attribute_id' => $attribute->id, 'value_id' => $value->id, 'product_id' => $product->id]);
            }
        }

        $newProductName = 'Китайский 1ЦУ-200';
        $product = Product::create(['name' => $newProductName, 'slug' => Str::slug($newProductName), 'product_type_id' => 1, 'category_id' => 3]);

        $newValue = 'Китай';
        $value = Value::create(['value' => $newValue, 'slug' => Str::slug($newValue)]);

        AttributeValue::create(['attribute_id' => 1, 'value_id' => $value->id, 'product_id' => $product->id]);
        AttributeValue::create(['attribute_id' => 2, 'value_id' => 2, 'product_id' => $product->id]);
        AttributeValue::create(['attribute_id' => 3, 'value_id' => 3, 'product_id' => $product->id]);
    }
}
