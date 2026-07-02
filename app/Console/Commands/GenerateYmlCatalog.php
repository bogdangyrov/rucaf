<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use XMLWriter;

class GenerateYmlCatalog extends Command
{
    protected $signature = 'app:generate-yml-catalog';
    protected $description = 'Generate split YML catalog files for products (Size optimized)';

    protected const MAX_OFFERS_PER_FILE = 50000;

    protected $fileCounter = 1;
    protected $offerCounter = 0;
    protected $writer = null;
    protected $categoryIdMap = [];
    protected $categoriesCache = [];

    public function handle()
    {
        $this->info('Starting split YML catalog generation...');

        try {
            $directoryPath = public_path('yml');
            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true);
            }

            $this->prepareCategoriesCache();

            $this->startNewFile();

            $this->addOffers();

            $this->closeCurrentFile();

            $this->info('YML catalogs generated successfully! Total files: ' . ($this->fileCounter - 1));
            $this->info('Files saved to: ' . $directoryPath);
        } catch (\Exception $e) {
            $this->error('Error generating YML catalog: ' . $e->getMessage());
            if ($this->writer) {
                $this->closeCurrentFile();
            }
            return 1;
        }

        return 0;
    }

    protected function startNewFile()
    {
        $this->closeCurrentFile();

        $filePath = public_path("yml/yml_catalog_{$this->fileCounter}.xml");

        $this->writer = new XMLWriter();
        $this->writer->openURI($filePath);
        $this->writer->startDocument('1.0', 'UTF-8');
        $this->writer->setIndent(true);

        $this->writer->startElement('yml_catalog');
        $this->writer->writeAttribute('date', now()->format('Y-m-d\TH:iP'));
        $this->writer->startElement('shop');

        $this->writer->writeElement('name', 'Rucaf');
        $this->writer->writeElement('company', 'Компания "Промтеплострой"');
        $this->writer->writeElement('url', url('/'));

        $this->writer->startElement('currencies');
        $this->writer->startElement('currency');
        $this->writer->writeAttribute('id', 'RUR');
        $this->writer->writeAttribute('rate', '1');
        $this->writer->endElement();
        $this->writer->endElement();

        $this->writeCategoriesFromCache();

        $this->writer->startElement('offers');

        $this->offerCounter = 0;
        $this->fileCounter++;
    }

    protected function closeCurrentFile()
    {
        if ($this->writer) {
            $this->writer->endElement();
            $this->writer->endElement();
            $this->writer->endElement();
            $this->writer->endDocument();
            $this->writer->flush();
            $this->writer = null;
        }
    }

    protected function prepareCategoriesCache()
    {
        $currentId = 1;
        $categoryIdMap = [];

        $productTypes = \App\Models\ProductType::select('id', 'name')->get();
        foreach ($productTypes as $productType) {
            $this->categoriesCache[] = [
                'name' => $productType->name,
                'id' => $currentId,
                'parentId' => null
            ];
            $categoryIdMap['pt_' . $productType->id] = $currentId;
            $currentId++;
        }

        $categories = \App\Models\Category::select('id', 'product_type_id', 'name')->get();
        foreach ($categories as $category) {
            $parentId = ($category->product_type_id && isset($categoryIdMap['pt_' . $category->product_type_id]))
                ? $categoryIdMap['pt_' . $category->product_type_id]
                : null;

            $this->categoriesCache[] = [
                'name' => $category->name,
                'id' => $currentId,
                'parentId' => $parentId
            ];
            $categoryIdMap['c_' . $category->id] = $currentId;
            $currentId++;
        }

        $subcategories = \App\Models\Subcategory::select('id', 'category_id', 'name')->get();
        foreach ($subcategories as $subcategory) {
            $parentId = ($subcategory->category_id && isset($categoryIdMap['c_' . $subcategory->category_id]))
                ? $categoryIdMap['c_' . $subcategory->category_id]
                : null;

            $this->categoriesCache[] = [
                'name' => $subcategory->name,
                'id' => $currentId,
                'parentId' => $parentId
            ];
            $categoryIdMap['sc_' . $subcategory->id] = $currentId;
            $currentId++;
        }

        $this->categoryIdMap = $categoryIdMap;
    }

    protected function writeCategoriesFromCache()
    {
        $this->writer->startElement('categories');
        foreach ($this->categoriesCache as $cat) {
            $this->writer->startElement('category');
            $this->writer->writeAttribute('id', $cat['id']);
            if ($cat['parentId']) {
                $this->writer->writeAttribute('parentId', $cat['parentId']);
            }
            $this->writer->text($cat['name']);
            $this->writer->endElement();
        }
        $this->writer->endElement();
    }

    protected function addOffers()
    {
        Product::where('is_active', true)
            ->select('id', 'subcategory_id', 'slug', 'name', 'description', 'images', 'price', 'discount_price', 'is_active')
            ->with([
                'subcategory:id,category_id,slug,description,images',
                'subcategory.category:id,product_type_id,slug',
                'subcategory.category.productType:id,slug'
            ])
            ->chunkById(5000, function ($products) {
                foreach ($products as $product) {

                    if ($this->offerCounter >= self::MAX_OFFERS_PER_FILE) {
                        $this->startNewFile();
                    }

                    $sub = $product->subcategory;
                    $cat = $sub?->category;
                    $type = $cat?->productType;

                    if (!$cat || !$type || !$sub) {
                        continue;
                    }

                    $price = $product->discount_price ?: $product->price;
                    if (!$price) {
                        continue;
                    }

                    $this->writer->startElement('offer');
                    $this->writer->writeAttribute('id', $product->id);
                    $this->writer->writeAttribute('available', $product->is_active ? 'true' : 'false');

                    $this->writer->writeElement('name', $product->name);
                    $this->writer->writeElement('price', number_format($price, 0, '.', ''));
                    $this->writer->writeElement('currencyId', 'RUR');

                    if (isset($this->categoryIdMap['sc_' . $sub->id])) {
                        $this->writer->writeElement('categoryId', $this->categoryIdMap['sc_' . $sub->id]);
                    }

                    $nameParts = explode(' ', $product->name);
                    $replacementName = isset($nameParts[1]) ? $nameParts[1] : '';

                    $fullDescription = '';
                    if ($sub->description) {
                        $fullDescription .= str_replace('{NAME}', $replacementName, $sub->description) . ' ';
                    }
                    if ($product->description) {
                        $fullDescription .= str_replace('{NAME}', $replacementName, $product->description);
                    }

                    if (!empty(trim($fullDescription))) {
                        $cleanDescription = trim(strip_tags(html_entity_decode($fullDescription)));
                        if ($cleanDescription !== '') {
                            if (mb_strlen($cleanDescription) > 2990) {
                                $cleanDescription = mb_substr($cleanDescription, 0, 2987) . '...';
                            }

                            $this->writer->writeElement('description', $cleanDescription);
                        }
                    }

                    if ($product->images || $sub->images) {
                        $images = is_array($product->images) ? $product->images : json_decode($product->images, true);

                        if (empty($images) && $sub->images) {
                            $images = is_array($sub->images) ? $sub->images : json_decode($sub->images, true);
                        }

                        if (!empty($images) && isset($images[0])) {
                            $this->writer->writeElement('picture', asset('storage/' . $images[0]));
                        }
                    }

                    $url = route('products.show', [
                        'productType' => $type->slug,
                        'category' => $cat->slug,
                        'subcategory' => $sub->slug,
                        'product' => $product->slug
                    ]);
                    $this->writer->writeElement('url', $url);
                    $this->writer->writeElement('sales_notes', 'Предоплата. Доставка по России.');

                    $this->writer->endElement();

                    $this->offerCounter++;
                }

                unset($products);
                gc_collect_cycles();
            });
    }
}
