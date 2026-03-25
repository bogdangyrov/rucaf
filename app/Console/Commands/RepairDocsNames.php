<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Subcategory;

class RepairDocsNames extends Command
{
    protected $signature = 'docs:repair-names';
    protected $description = 'Исправляет структуру docs_file_names для товаров и подкатегорий';

    public function handle()
    {
        $this->info('Starting repair for Products...');
        $this->repair(Product::query());

        $this->info('Starting repair for Subcategories...');
        $this->repair(Subcategory::query());

        $this->info('Done!');
    }

    private function repair($query)
    {
        $items = $query->whereNotNull('docs_file_names')->get();

        foreach ($items as $item) {
            $oldDocs = $item->docs_file_names;

            if (!empty($oldDocs) && array_is_list($oldDocs)) {
                $newDocs = [];

                foreach ($oldDocs as $path) {
                    $originalName = basename($path);
                    $newDocs[$path] = $originalName;
                }

                $item->update(['docs_file_names' => $newDocs]);
                $this->line("Repaired ID: {$item->id}");
            }
        }
    }
}
