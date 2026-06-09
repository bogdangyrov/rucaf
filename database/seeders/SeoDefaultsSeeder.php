<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeoDefaultsSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        ProductType::chunkById(100, function ($types) {
            foreach ($types as $type) {
                $h1 = $type->h1 ?: $type->name;
                $seoTitle = $type->seo_title ?: "{$type->name}, цена, купить";
                $seoDescription = $type->seo_description ?: "Купить {$type->name} для промышленных нужд от компании Rucaf.ru Надежное оборудование с доставкой по всей России.";

                $type->update([
                    'h1'              => $h1,
                    'seo_title'       => $seoTitle,
                    'seo_description' => $seoDescription,
                    'og_title'        => $type->og_title ?: $seoTitle,
                    'og_description'  => $type->og_description ?: $seoDescription,
                ]);
            }
        });

        Category::chunkById(200, function ($categories) {
            foreach ($categories as $category) {
                $h1 = $category->h1 ?: $category->name;
                $seoTitle = $category->seo_title ?: "{$category->name}, цена, купить";
                $seoDescription = $category->seo_description ?: "Купить {$category->name} для промышленных нужд от компании Rucaf.ru Надежное оборудование с доставкой по всей России.";

                $category->update([
                    'h1'              => $h1,
                    'seo_title'       => $seoTitle,
                    'seo_description' => $seoDescription,
                    'og_title'        => $category->og_title ?: $seoTitle,
                    'og_description'  => $category->og_description ?: $seoDescription,
                ]);
            }
        });

        Subcategory::chunkById(200, function ($subcategories) {
            foreach ($subcategories as $subcategory) {
                $h1 = $subcategory->h1 ?: $subcategory->name;
                $seoTitle = $subcategory->seo_title ?: "{$subcategory->name}, цена, купить";
                $seoDescription = $subcategory->seo_description ?: "Купить {$subcategory->name} для промышленных нужд от компании Rucaf.ru Надежное оборудование с доставкой по всей России.";

                $subcategory->update([
                    'h1'              => $h1,
                    'seo_title'       => $seoTitle,
                    'seo_description' => $seoDescription,
                    'og_title'        => $subcategory->og_title ?: $seoTitle,
                    'og_description'  => $subcategory->og_description ?: $seoDescription,
                ]);
            }
        });

        $chunkSize = 5000;
        $totalProducts = Product::count();
        $totalChunks = (int) ceil($totalProducts / $chunkSize);
        $currentChunk = 0;

        $this->command->info("Начало обработки товаров. Всего товаров: {$totalProducts}. Будет обработано чанков: {$totalChunks}.");

        Product::chunkById($chunkSize, function ($products) use ($totalChunks, &$currentChunk) {
            foreach ($products as $product) {
                $h1 = $product->h1 ?: $product->name;
                $seoTitle = $product->seo_title ?: "{$product->name}, цена, купить";
                $seoDescription = $product->seo_description ?: "Купить {$product->name} для промышленных нужд от компании Rucaf.ru Надежное оборудование с доставкой по всей России.";

                $product->update([
                    'h1'              => $h1,
                    'seo_title'       => $seoTitle,
                    'seo_description' => $seoDescription,
                    'og_title'        => $product->og_title ?: $seoTitle,
                    'og_description'  => $product->og_description ?: $seoDescription,
                ]);
            }

            $currentChunk++;
            $this->command->info("Обработано: {$currentChunk}/{$totalChunks} чанков...");
        });

        $this->command->info("Заполнение SEO-данных успешно завершено!");
    }
}
