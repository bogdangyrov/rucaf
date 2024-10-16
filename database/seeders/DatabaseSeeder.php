<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductType;
use App\Models\AttributeValue;
use App\Models\Value;
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

        $categoryNames = ['Редукторы ЦУ', 'Редукторы Ц2У', 'Редукторы Ц3У'];
        $productNames = ['1ЦУ-100', '1ЦУ-160', '1ЦУ-200'];

        $products = [];
        for ($i = 0; $i < count($productNames); $i++) {
            $category = Category::create(['name' => $categoryNames[$i], 'product_type_id' => $productType->id]);
            $products[] = Product::create(['name' => $productNames[$i], 'product_type_id' => $productType->id, 'category_id' => $category->id]);
        }

        $attributeNames = ['Страна' => 'Россия', 'Тип передачи' => 'цилиндрический', 'Межосевое расстояние, мм' => 160];
        foreach ($attributeNames as $name => $value) {
            $attribute = Attribute::create(['name' => $name, 'product_type_id' => $productType->id]);
            $value = Value::create(['value' => $value]);
            foreach ($products as $product) {
                AttributeValue::create(['attribute_id' => $attribute->id, 'value_id' => $value->id, 'product_id' => $product->id]);
            }
        }
    }
}
