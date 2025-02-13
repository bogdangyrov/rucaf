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
    public function readCsv($filePath)
    {
        $rows = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            $headers = fgetcsv($handle, 1000, ',');  // Чтение заголовков
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $rows[] = array_combine($headers, $data);
            }
            fclose($handle);
        }
        return $rows;
    }

    public function extractParams($modificationName, $charData)
    {
        // Пример: "Редуктор В-400-28-Т2"
        preg_match('/Редуктор (\w)-(\d+)-(\d+)-(\w+)(\d+)/u', $modificationName, $matches);

        if (!$matches) {
            return null; // Неправильный формат
        }

        list(, $series, $distance, $ratio, $climate, $placement) = $matches;

        // Проверка, что параметры существуют в основном файле
        $validRatios = array_map('trim', explode(',', $charData['Передаточное отношение (число)']));
        $validClimates = array_map('trim', explode(',', $charData['Климатическое исполнение']));
        $validPlacements = array_map('trim', explode(',', $charData['Категория размещения']));

        if (!in_array($ratio, $validRatios) || !in_array($climate, $validClimates) || !in_array($placement, $validPlacements)) {
            return null; // Параметры не соответствуют основным данным
        }

        return [
            'series' => $series,
            'distance' => $distance,
            'ratio' => $ratio,
            'climate' => $climate,
            'placement' => $placement,
        ];
    }

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
            EmailSeeder::class,
            UserSeeder::class
        ]);

        $productType = ProductType::where('name', 'Редукторы')->first();

        $charsCsv = $this->readCsv(storage_path('app/chars.csv'));
        $modsCsv = $this->readCsv(storage_path('app/modifications.csv'));
        $subcategoryCsv = $this->readCsv(storage_path('app/products.csv'))[0];

        $charsData = [];
        foreach ($charsCsv as $record) {
            $charsData[$record['Id']] = $record;
        }

        foreach ($modsCsv as $record) {
            $productId = $record['Id Продукта'];
            $productName = $record['Название'];

            if (!isset($charsData[$productId])) {
                continue;
            }

            $parentData = $charsData[$productId];

            if (preg_match('/([А-Я]+)-(\d+)-(\d+)-([А-Я]+)([\d])/', $productName, $matches)) {
                list(, $series, $size, $ratio, $climate, $placement) = $matches;

                $categoryName = "$series";
                $category = Category::firstOrCreate([
                    'name' => $categoryName,
                    'slug' => Str::slug($categoryName),
                    'product_type_id' => $productType->id,
                ]);

                $subcategoryName = "$series-$size";
                $subcategory = SubCategory::firstOrCreate([
                    'name' => $subcategoryName,
                    'slug' => Str::slug($subcategoryName),
                    'product_type_id' => $productType->id,
                    'category_id' => $category->id,
                    'description' => $subcategoryCsv['Описание'] . " " . $subcategoryCsv['Подр. описание']
                ]);

                $product = Product::create([
                    'name' => $productName,
                    'product_type_id' => $productType->id,
                    'category_id' => $category->id,
                    'sub_category_id' => $subcategory->id,
                    'price' => $record['Цена'] ?? 0,
                    'mass' => $parentData['Масса'] ?? 0,
                    'dimensions' => $parentData['Длина'] . 'x' . $parentData['Ширина'] . 'x' . $parentData['Высота']
                ]);

                $attributes = [
                    'Серия' => $series,
                    'Типоразмер (межосевое расстояние)' => $size,
                    'Передаточное отношение (число)' => $ratio,
                    'Климатическое исполнение' => $climate,
                    'Категория размещения' => $placement,
                ];

                $modificationParams = ['Масса', 'Длина', 'Ширина', 'Высота', 'Id', ...array_keys($attributes)];
                foreach ($modificationParams as $param) {
                    unset($parentData[$param]);
                }

                $parentAttributes = $parentData;

                foreach (array_merge($attributes, $parentAttributes) as $attrName => $attrValue) {
                    $attr = Attribute::firstOrCreate([
                        'name' => $attrName,
                        'slug' => Str::slug($attrName),
                        'product_type_id' => $productType->id,
                    ]);

                    $value = Value::firstOrCreate([
                        'value' => $attrValue,
                        'slug' => Str::slug($attrValue),
                        'attribute_id' => $attr->id,
                    ]);

                    AttributeValue::create([
                        'attribute_id' => $attr->id,
                        'value_id' => $value->id,
                        'product_id' => $product->id,
                    ]);
                }
            }
        }
    }
}
