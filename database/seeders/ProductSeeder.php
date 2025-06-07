<?php

namespace Database\Seeders;

use App\Models\Value;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductType;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use Database\Seeders\DatabaseSeeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productType = ProductType::where('name', 'Мотор-редукторы')->first();

        $subcategories = DatabaseSeeder::readJSON(storage_path('app/json/products.json'));
        $allMods = DatabaseSeeder::readJSON(storage_path('app/json/modifications.json'));

        $subcategories = array_slice($subcategories, 91, 1);

        foreach ($subcategories as $subcategoryData) {
            $category = Category::firstOrCreate([
                'name' => $subcategoryData['category'],
                'product_type_id' => $productType->id,
            ]);

            $subcategory = Subcategory::firstOrCreate([
                'name' => $subcategoryData['name'],
                'category_id' => $category->id,
                'description' => $subcategoryData['description'] . " " . $subcategoryData['detailed_description']
            ]);

            $mods = $allMods[$subcategoryData['id']] ?? false;
            $chars = $subcategoryData['chars'] ?? false;

            if (!$mods) {
                $this->createSingleModification($subcategory, $chars);
                continue;
            }

            $variableChars = array_keys(array_filter($chars, function ($item) {
                return str_contains($item, ', ');
            }));

            $decodingDescription = static::extractReducerDecoding($subcategoryData['detailed_description']);
            [$pattern, $variables] = $this::extractPattern($decodingDescription, $variableChars);
            if (!$pattern) {
                continue;
            }

            $this->createModifications($mods, $subcategory, $pattern, $chars, $variables);
        }
    }

    private static function extractPattern($description, array $variableChars): array
    {
        $pattern = "/МРЧ-(\d+(?:\.\d+)?)-(\d+(?:\.\d+)?)-(\d+(?:\.\d+)?)-(\d+(?:\.\d+)?)-(\d+(?:\.\d+)?)-(\d+(?:\.\d+)?)-([А-Я])\-([А-Я])\-(\d+(?:\.\d+)?)/u";
        $variables = [
            "Типоразмер (межосевое расстояние)" => 1,
            "Частота вращения выходного вала" => 2,
            "Мощность электродвигателя" => 3,
            "Вариант сборки" => 4,
            "Вариант расположения червячной пары" => 5,
            "Вариант расположения лап в плоскости" => 6,
            "Исполнение конца выходного вала" => 7,
            "Климатическое исполнение" => 8,
            "Категория размещения" => 9,
        ];

        $apiKey = env('OPENAI_API_KEY'); // Храним API-ключ в .env
        $url = "https://api.openai.com/v1/chat/completions";

        $prompt = "Определи регулярное выражение для извлечения переменных из следующего описания:\n\n" .
            "$description\n\n" .
            "Переменные, которые нужно извлечь:\n" .
            implode("\n", $variableChars) . "\n\n" .
            "Верни ответ в PHP формате: \n\$pattern= \"регулярное выражение\";\n\$variables = [\"Название переменной\" => индекс в массиве matches]." .
            "Не изменяй названия переменных.\n" .
            "Учти, что всe буквы написаны кириллицей и ВСЕ числа могут быть с точкой, например 31.5.\n" .
            "Пример: Редуктор\\s[А-Я0-9]+-\\d+(?:\\.\\d+)?-(\\d+(?:\\.\\d+)?)-\\d+(?:\\.\\d+)?-([А-Я])?-([А-Я])?-(\\d+(?:\\.\\d+)?)\n" .
            "Не добавляй ничего лишнего.\n";

        echo $prompt;
        die();
        return [$pattern, $variables];
        /*
        $response = self::sendChatGPTRequest($url, $apiKey, $prompt);

        if (!$response) {
            return [null, []];
        }

        $data = json_decode($response, true);
        $responseContent = $data['choices'][0]['message']['content']; // Ответ с JSON в виде строки

        $jsonString = preg_replace('/^```json\s*(.*?)\s*```$/s', '$1', $responseContent);
        $jsonData = json_decode($jsonString, true);

        $pattern = "/" . $jsonData['pattern'] . "/u";
 */
        // return [$pattern, $jsonData['variables']];
    }

    private static function sendChatGPTRequest($url, $apiKey, $prompt)
    {
        $headers = [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ];

        $postData = json_encode([
            "model" => "gpt-4",
            "messages" => [["role" => "user", "content" => $prompt]],
            "temperature" => 0.3
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


    private static function extractReducerDecoding($html)
    {
        if (preg_match('/<h2>Расшифровка редуктора<\/h2>(.*?)<h2>/s', $html, $matches)) {
            return trim(strip_tags($matches[1]));
        }
        return null;
    }

    private function createModifications($mods, $subcategory, $pattern, $subcategoryChars, $variables)
    {
        foreach ($mods as $name => $price) {
            if (preg_match($pattern, $name, $matches)) {
                try {
                    $price = is_numeric($price) ? $price : null;
                    $product = Product::create([
                        'name' => $name,
                        'subcategory_id' => $subcategory->id,
                        'price' => $price ?? null,
                        'mass' => $subcategoryChars['Масса'] ?? null,
                        'dimensions' => (!empty($subcategoryChars['Длина']) && !empty($subcategoryChars['Ширина']) && !empty($subcategoryChars['Высота'])) ?
                            ($subcategoryChars['Длина'] . 'x' . $subcategoryChars['Ширина'] . 'x' . $subcategoryChars['Высота']) : null
                    ]);

                    $attributesMap = [];
                    foreach ($variables as $variable => $index) {
                        $attributesMap[$variable] = $matches[$index];
                    }

                    $modificationParams = ['Масса', 'Длина', 'Ширина', 'Высота', 'Цена', 'Id', ...array_keys($attributesMap)];
                    foreach ($modificationParams as $param) {
                        unset($subcategoryChars[$param]);
                    }

                    $attributeValuesData = [];
                    foreach (array_merge($attributesMap, $subcategoryChars) as $attrName => $attrValue) {
                        if (!$attrValue) continue;

                        $attr = Attribute::firstOrCreate([
                            'name' => $attrName,
                            'slug' => Str::slug($attrName),
                            'subcategory_id' => $subcategory->id,
                        ]);

                        $value = Value::firstOrCreate([
                            'value' => $attrValue,
                            'slug' => Str::slug($attrValue),
                            'attribute_id' => $attr->id,
                        ]);

                        $attributeValuesData[] = [
                            'attribute_id' => $attr->id,
                            'value_id' => $value->id,
                            'product_id' => $product->id,
                        ];
                    }

                    // Вставка всех значений одной операцией
                    if (!empty($attributeValuesData)) {
                        AttributeValue::insert($attributeValuesData);
                    }
                } catch (\Exception $e) {
                    echo "Ошибка при обработке названия: " . $e->getMessage() . "\n";
                    continue;
                }
            } else {
                echo "Паттерн $pattern, не подошел $name\n";
                return;
            }
        }
    }

    private function createSingleModification($subcategory, $subcategoryChars)
    {
        $product = Product::create([
            'name' => $subcategory->name,
            'subcategory_id' => $subcategory->id,
            'price' => $price ?? null,
            'mass' => $subcategoryChars['Масса'] ?? null,
            'dimensions' => (!empty($subcategoryChars['Длина']) && !empty($subcategoryChars['Ширина']) ?? !empty($subcategoryChars['Высота'])) ?
                ($subcategoryChars['Длина'] . 'x' . $subcategoryChars['Ширина'] . 'x' . $subcategoryChars['Высота']) : null
        ]);

        $modificationParams = ['Масса', 'Длина', 'Ширина', 'Высота', 'Цена', 'Id'];
        foreach ($modificationParams as $param) {
            unset($subcategoryChars[$param]);
        }

        foreach ($subcategoryChars as $attrName => $attrValue) {
            if (!$attrValue) continue;

            $attr = Attribute::firstOrCreate([
                'name' => $attrName,
                'slug' => Str::slug($attrName),
                'subcategory_id' => $subcategory->id,
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
