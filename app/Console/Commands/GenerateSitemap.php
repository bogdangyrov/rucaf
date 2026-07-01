<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    protected $signature = 'app:generate-sitemap';
    protected $description = 'Генерация sitemap для большого объема данных (300к+ товаров)';

    protected const MAX_URLS_PER_FILE = 45000;

    protected $fileCounter = 1;
    protected $urlCounter = 0;
    protected $currentFileHandle = null;
    protected $generatedFiles = [];

    public function handle()
    {
        $this->info('Starting sitemap generation...');

        $this->startNewFile('sitemap_products_');

        $this->addMainPages();
        $this->addCustomPages();
        $this->addProductTypes();
        $this->addCategories();
        $this->addSubcategories();

        $this->addProducts();

        $this->closeCurrentFile();

        $this->buildIndexSitemap();

        $this->info('Sitemap generated successfully! Total files: ' . count($this->generatedFiles));
    }

    protected function startNewFile($prefix = 'sitemap_products_')
    {
        $this->closeCurrentFile();

        $directory = public_path('sitemaps');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $fileName = $prefix . $this->fileCounter . '.xml';
        $filePath = $directory . '/' . $fileName;

        $this->currentFileHandle = fopen($filePath, 'w');
        fwrite($this->currentFileHandle, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
        fwrite($this->currentFileHandle, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

        $this->generatedFiles[] = $fileName;
        $this->fileCounter++;
        $this->urlCounter = 0;
    }

    protected function writeUrl($loc, $lastmod = null, $changefreq = 'weekly', $priority = 0.8)
    {
        if ($this->urlCounter >= self::MAX_URLS_PER_FILE) {
            $this->startNewFile();
        }

        $xml = '  <url>' . PHP_EOL;
        $xml .= '    <loc>' . htmlspecialchars($loc, ENT_QUOTES, 'UTF-8') . '</loc>' . PHP_EOL;
        if ($lastmod) {
            $xml .= '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
        }
        $xml .= '    <changefreq>' . $changefreq . '</changefreq>' . PHP_EOL;
        $xml .= '    <priority>' . $priority . '</priority>' . PHP_EOL;
        $xml .= '  </url>' . PHP_EOL;

        fwrite($this->currentFileHandle, $xml);
        $this->urlCounter++;
    }

    protected function closeCurrentFile()
    {
        if ($this->currentFileHandle) {
            fwrite($this->currentFileHandle, '</urlset>' . PHP_EOL);
            fclose($this->currentFileHandle);
            $this->currentFileHandle = null;
        }
    }

    protected function buildIndexSitemap()
    {
        $indexPath = public_path('sitemap.xml');
        $handle = fopen($indexPath, 'w');

        fwrite($handle, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
        fwrite($handle, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

        $baseUrl = config('app.url');
        $now = now()->toAtomString();

        foreach ($this->generatedFiles as $file) {
            $xml = '  <sitemap>' . PHP_EOL;
            $xml .= '    <loc>' . rtrim($baseUrl, '/') . '/sitemaps/' . $file . '</loc>' . PHP_EOL;
            $xml .= '    <lastmod>' . $now . '</lastmod>' . PHP_EOL;
            $xml .= '  </sitemap>' . PHP_EOL;
            fwrite($handle, $xml);
        }

        fwrite($handle, '</sitemapindex>' . PHP_EOL);
        fclose($handle);
    }

    protected function addMainPages()
    {
        $this->writeUrl(route('home'), null, 'daily', 1.0);
        $this->writeUrl(route('catalog'), null, 'daily', 0.9);
        $this->writeUrl(route('privacy'), null, 'monthly', 0.3);
        $this->writeUrl(route('cart'), null, 'weekly', 0.3);
        $this->writeUrl(route('comparison'), null, 'weekly', 0.3);
        $this->writeUrl(route('favorites'), null, 'weekly', 0.3);
    }

    protected function addCustomPages()
    {
        \App\Models\Page::select('id', 'slug', 'updated_at')->lazy()->each(function ($page) {
            $this->writeUrl(
                route('page', ['page' => $page->slug]),
                $page->updated_at?->toAtomString(),
                'monthly',
                0.6
            );
        });
    }

    protected function addProductTypes()
    {
        \App\Models\ProductType::select('id', 'slug', 'updated_at')->lazy()->each(function ($type) {
            $this->writeUrl(
                route('product-types.index', ['productType' => $type->slug]),
                $type->updated_at?->toAtomString(),
                'daily',
                0.8
            );
        });
    }

    protected function addCategories()
    {
        \App\Models\Category::select('id', 'product_type_id', 'slug', 'updated_at')
            ->with('productType:id,slug')
            ->lazy()
            ->each(function ($category) {
                if ($category->productType) {
                    $this->writeUrl(
                        route('categories.index', ['productType' => $category->productType->slug, 'category' => $category->slug]),
                        $category->updated_at?->toAtomString(),
                        'daily',
                        0.8
                    );
                }
            });
    }

    protected function addSubcategories()
    {
        \App\Models\Subcategory::select('id', 'category_id', 'slug', 'updated_at')
            ->with('category:id,product_type_id,slug', 'category.productType:id,slug')
            ->lazy()
            ->each(function ($sub) {
                if ($sub->category && $sub->category->productType) {
                    $this->writeUrl(
                        route('products.index', [
                            'productType' => $sub->category->productType->slug,
                            'category' => $sub->category->slug,
                            'subcategory' => $sub->slug
                        ]),
                        $sub->updated_at?->toAtomString(),
                        'daily',
                        0.8
                    );
                }
            });
    }

    protected function addProducts()
    {
        \App\Models\Product::select('id', 'subcategory_id', 'slug', 'updated_at')
            ->with([
                'subcategory:id,category_id,slug',
                'subcategory.category:id,product_type_id,slug',
                'subcategory.category.productType:id,slug'
            ])
            ->chunkById(5000, function ($products) {
                foreach ($products as $product) {
                    $sub = $product->subcategory;
                    $cat = $sub?->category;
                    $type = $cat?->productType;

                    if ($sub && $cat && $type) {
                        $this->writeUrl(
                            route('products.show', [
                                'productType' => $type->slug,
                                'category' => $cat->slug,
                                'subcategory' => $sub->slug,
                                'product' => $product->slug
                            ]),
                            $product->updated_at?->toAtomString(),
                            'weekly',
                            0.7
                        );
                    }
                }
                unset($products);
                gc_collect_cycles();
            });
    }
}
