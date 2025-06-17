<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Subcategory;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class PriceExportService
{
    public static function exportToExcel(?int $subcategoryId = null): string
    {
        $query = Product::with(['category', 'subcategory']);
        $subcategory = Subcategory::find($subcategoryId);
        if ($subcategoryId) {
            $query->where('subcategory_id', $subcategoryId);
        }
        $products = $query->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'category' => $product->category->name ?? '',
                'subcategory' => $product->subcategory->name ?? '',
                'name' => $product->name,
                'price' => $product->price,
            ];
        });

        $headings = [
            ['ID', 'Категория', 'Подкатегория', 'Название', 'Цена']
        ];

        $data = $headings;
        foreach ($products as $row) {
            $data[] = array_values($row);
        }

        $date = date('Y-m-d_H:i');
        $tempPath = 'exports/prices_' . $subcategory->slug . '_' . $date . '.xlsx';

        static::storeToExcel($data, $tempPath);

        return Storage::disk('local')->path($tempPath);
    }

    public static function storeToExcel(array $data, string $tempPath): void
    {
        Excel::store(new class($data) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $data;
            public function __construct(array $data)
            {
                $this->data = $data;
            }
            public function array(): array
            {
                return $this->data;
            }
        }, $tempPath, 'local');
    }
}
