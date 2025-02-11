<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\QuickFilter;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Value;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CitySeeder::class,
            ProductTypeSeeder::class,
            PageSeeder::class,
            PhoneNumberSeeder::class,
            EmailSeeder::class
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'login' => 'admin',
            'password' => 'admin'
        ]);

        $productType = ProductType::where('name', 'Редукторы')->first();

        $categoryNames = ['Редукторы 1ЦУ', 'Редукторы 1Ц2У', 'Редукторы РМ'];
        $subcategoryNames = ['Редукторы 1ЦУ-200', 'Редукторы 1Ц2У-300', 'Редукторы 1Ц2У-160'];
        $productNames = [
            'Редуктор 1Ц2У-200-8-11-К-Т-2',
            'Редуктор 1Ц2У-200-8-11-К-Т-1',
            'Редуктор 1Ц2У-200-8-11-К-Т-3'
        ];

        foreach ($categoryNames as $categoryName) {
            Category::create([
                'name' => $categoryName,
                'product_type_id' => $productType->id
            ]);
        }

        $category = Category::get()->first();

        foreach ($subcategoryNames as $subcategoryName) {
            SubCategory::create([
                'name' => $subcategoryName,
                'category_id' => $category->id,
                'product_type_id' => $productType->id
            ]);
        }

        $subcategory = SubCategory::get()->first();

        $products = [];
        $productDescription = '<b>Этот великолепный товар.</b> Предварительные выводы неутешительны: повышение уровня гражданского сознания говорит о возможностях модели развития. <i>Внезапно</i>, сделанные на базе интернет-аналитики выводы преданы социально-демократической анафеме.';
        for ($i = 0; $i < count($productNames); $i++) {
            $products[] = Product::create([
                'name' => $productNames[$i],
                'product_type_id' => $productType->id,
                'category_id' => $category->id,
                'sub_category_id' => $subcategory->id,
                'description' => $productDescription,
                'article' => fake()->randomNumber(4),
                'dimensions' => fake()->randomNumber(3) . 'x' . fake()->randomNumber(3) . 'x' . fake()->randomNumber(3),
                'mass' => fake()->randomNumber(3),
                'price' => fake()->randomNumber(4),
            ]);
        }

        $newProducts = [
            'Редуктор 1Ц2У-160-20-32-К-У-3',
            'Редуктор 1Ц2У-160-20-32-К-У-4',
            'Редуктор 1Ц2У-160-20-32-К-У-2 '
        ];

        for ($i = 0; $i < count($newProducts); $i++) {
            $products[] = Product::create([
                'name' => $newProducts[$i],
                'product_type_id' => $productType->id,
                'category_id' => $category->id,
                'sub_category_id' => 3,
                'description' => $productDescription,
                'article' => fake()->randomNumber(4),
                'dimensions' => fake()->randomNumber(3) . 'x' . fake()->randomNumber(3) . 'x' . fake()->randomNumber(3),
                'mass' => fake()->randomNumber(3),
                'price' => fake()->randomNumber(4),
            ]);
        }

        $attributeNames = ['Страна' => 'Россия', 'Тип передачи' => 'цилиндрический', 'Межосевое расстояние, мм' => 160];
        foreach ($attributeNames as $name => $value) {
            $attribute = Attribute::create(
                ['name' => $name, 'product_type_id' => $productType->id, 'slug' => Str::slug($name)]
            );
            $value = Value::create(['value' => $value, 'slug' => Str::slug($value), 'attribute_id' => $attribute->id]);
            foreach ($products as $product) {
                AttributeValue::create(
                    ['attribute_id' => $attribute->id, 'value_id' => $value->id, 'product_id' => $product->id]
                );
            }
        }

        $newValue = 'Китай';
        $value = Value::create(['value' => $newValue, 'slug' => Str::slug($newValue), 'attribute_id' => 1]);

        AttributeValue::create(['attribute_id' => 1, 'value_id' => $value->id, 'product_id' => $product->id]);
        AttributeValue::create(['attribute_id' => 2, 'value_id' => 2, 'product_id' => $product->id]);
        AttributeValue::create(['attribute_id' => 3, 'value_id' => 3, 'product_id' => $product->id]);

        QuickFilter::create(
            ['attribute_id' => 1, 'value_id' => 1, 'product_type_id' => $productType->id, 'name' => 'Россия']
        );
        QuickFilter::create(
            [
                'attribute_id' => 2,
                'value_id' => 2,
                'product_type_id' => $productType->id,
                'name' => 'Цилиндрическая передача'
            ]
        );
    }
}
