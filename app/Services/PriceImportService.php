<?php

namespace App\Services;

use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;

class PriceImportService
{
    public static function importFromExcel(UploadedFile $file): array
    {
        $imported = [];
        $rows = Excel::toArray([], $file)[0];
        unset($rows[0]);

        foreach ($rows as $row) {
            $id = $row[0] ?? null;
            if (!$id) continue;

            $product = Product::find($id);
            if (!$product) continue;

            $changed = false;
            if (isset($row[4]) && $product->price != $row[4]) {
                $product->price = $row[4];
                $changed = true;
            }

            if ($changed) {
                $product->save();
                $imported[] = $product->id;
            }
        }
        return $imported;
    }
}
