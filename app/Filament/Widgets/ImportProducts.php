<?php

namespace App\Filament\Widgets;

use App\Models\Value;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductType;
use App\Models\Subcategory;
use Filament\Widgets\Widget;
use Livewire\WithFileUploads;
use App\Models\AttributeValue;
use App\Services\PriceExportService;
use App\Services\PriceImportService;
use Filament\Notifications\Notification;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImportProducts extends Widget
{
    use WithFileUploads;

    protected static string $view = 'filament.widgets.import-products';

    public TemporaryUploadedFile|null $file = null;

    protected function rules()
    {
        return [
            'file' => ['required', 'file', 'mimes:json'],
        ];
    }

    protected function messages()
    {
        return [
            'file.required' => 'Пожалуйста, выберите файл для загрузки.',
            'file.file' => 'Загружаемый объект должен быть файлом.',
            'file.mimes' => 'Файл должен быть в формате json.',
        ];
    }

    private function addProductsPath($path)
    {
        return 'products/' . $path;
    }

    public function updatedFile()
    {
        if ($this->file) {
            $this->validate();

            $data = json_decode($this->file->get(), true);
            foreach ($data as $item) {
                // 1. Создание типа продукта (если нужно)
                $productType = ProductType::firstOrCreate([
                    'name' => $item['product_type'],
                ]);

                // 2. Создание категории (если нужно)
                $category = Category::firstOrCreate([
                    'name' => $item['category'],
                    'product_type_id' => $productType->id,
                ]);

                // 3. Создание подкатегории (если нужно)
                $subcategory = Subcategory::where('name', $item['subcategory'])
                    ->where('category_id', $category->id)
                    ->first();

                if (!$subcategory) {
                    $subcategory = Subcategory::create([
                        'name' => $item['subcategory'],
                        'category_id' => $category->id,
                        'images' => array_map([$this, 'addProductsPath'], $item['subcategory_images'] ?? []),
                        'description' => $item['subcategory_description'] ?? '',
                    ]);
                }

                // 4. Создание товара
                $price = $item['price'] === 'Цена не указана' ? null : (int)preg_replace('/\s+/u', '', $item['price']);
                $product = Product::create([
                    'name' => $item['name'],
                    'price' => $price,
                    'subcategory_id' => $subcategory->id,
                    'images' => array_map([$this, 'addProductsPath'], $item['images'] ?? []),
                    'description' => $item['description'],
                    'is_active' => true,
                    'is_new' => true,
                    'docs' => array_map([$this, 'addProductsPath'], $item['files'] ?? []),
                    'docs_file_names' => array_map([$this, 'addProductsPath'], $item['files'] ?? []),
                ]);

                // 5. Создание атрибутов и значений
                foreach ($item['chars'] as $attrName => $valueText) {
                    $attribute = Attribute::firstOrCreate([
                        'name' => $attrName,
                        'subcategory_id' => $subcategory->id,
                    ]);

                    $value = Value::firstOrCreate([
                        'value' => str_replace(',', '.', $valueText),
                        'attribute_id' => $attribute->id,
                    ]);

                    AttributeValue::firstOrCreate([
                        'attribute_id' => $attribute->id,
                        'value_id' => $value->id,
                        'product_id' => $product->id,
                    ]);
                }
            }

            Notification::make()
                ->title('Импорт завершён')
                ->success()
                ->send();
        }
    }
}
