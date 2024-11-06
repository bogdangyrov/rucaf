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
use App\Models\Page;
use App\Models\QuickFilter;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'admin'
        ]);

        // Создание типа продукта
        $productType = ProductType::create(['name' => 'Редукторы']);

        $categoryNames = ['Редукторы ЦУ', 'Редукторы Ц2У', 'Редукторы Ц3У'];
        $productNames = ['1ЦУ-100', '1ЦУ-160', '1ЦУ-200'];

        $products = [];
        $productDescription = '<b>Этот великолепный товар.</b> Предварительные выводы неутешительны: повышение уровня гражданского сознания говорит о возможностях модели развития. <i>Внезапно</i>, сделанные на базе интернет-аналитики выводы преданы социально-демократической анафеме.';
        for ($i = 0; $i < count($productNames); $i++) {
            $category = Category::create([
                'name' => $categoryNames[$i],
                'product_type_id' => $productType->id
            ]);
            $products[] = Product::create([
                'name' => $productNames[$i],
                'product_type_id' => $productType->id,
                'category_id' => $category->id,
                'description' => $productDescription
            ]);
        }

        $attributeNames = ['Страна' => 'Россия', 'Тип передачи' => 'цилиндрический', 'Межосевое расстояние, мм' => 160];
        foreach ($attributeNames as $name => $value) {
            $attribute = Attribute::create(['name' => $name, 'product_type_id' => $productType->id, 'slug' => Str::slug($name)]);
            $value = Value::create(['value' => $value, 'slug' => Str::slug($value), 'attribute_id' => $attribute->id]);
            foreach ($products as $product) {
                AttributeValue::create(['attribute_id' => $attribute->id, 'value_id' => $value->id, 'product_id' => $product->id]);
            }
        }

        $newProductName = 'Китайский 1ЦУ-200';
        $product = Product::create([
            'name' => $newProductName,
            'slug' => Str::slug($newProductName),
            'product_type_id' => 1,
            'category_id' => 3,
            'description' => $productDescription
        ]);

        $newValue = 'Китай';
        $value = Value::create(['value' => $newValue, 'slug' => Str::slug($newValue), 'attribute_id' => 1]);

        AttributeValue::create(['attribute_id' => 1, 'value_id' => $value->id, 'product_id' => $product->id]);
        AttributeValue::create(['attribute_id' => 2, 'value_id' => 2, 'product_id' => $product->id]);
        AttributeValue::create(['attribute_id' => 3, 'value_id' => 3, 'product_id' => $product->id]);

        QuickFilter::create(['attribute_id' => 1, 'value_id' => 1, 'product_type_id' => 1, 'name' => 'Россия']);
        QuickFilter::create(['attribute_id' => 2, 'value_id' => 2, 'product_type_id' => 1, 'name' => 'Цилиндрическая передача']);


        Page::create(['title' => 'Новая страница', 'html' => '<h1>Заголовок</h1><h2>Заголовок поменьше</h2>']);
    }
}
