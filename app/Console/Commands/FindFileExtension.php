<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Subcategory;

class FindFileExtension extends Command
{
    protected $signature = 'docs:find {extension=.file} {--fix : Очистить найденные массивы в БД}';
    protected $description = 'Ищет все записи, где в docs_file_names есть указанное расширение';

    public function handle()
    {
        $ext = $this->argument('extension');
        $this->info("Searching for files with extension: {$ext}");

        $this->warn("\n--- Products ---");
        $this->searchInModel(Product::query(), $ext);

        $this->warn("\n--- Subcategories ---");
        $this->searchInModel(Subcategory::query(), $ext);
    }

    private function searchInModel($query, $ext)
    {
        $cleanExt = ltrim($ext, '.');
        $isFixMode = $this->option('fix');

        $results = $query->where('docs_file_names', 'LIKE', "%{$ext}%")->get();

        if ($results->isEmpty()) {
            $this->line(" <fg=gray>No matches found.</>");
            return;
        }

        $rows = [];
        foreach ($results as $item) {
            $docsFileNames = is_array($item->docs_file_names) ? $item->docs_file_names : [];

            $hasTarget = false;
            foreach ($docsFileNames as $path => $name) {
                if (pathinfo($path, PATHINFO_EXTENSION) === $cleanExt || str_contains($path, $ext)) {
                    $hasTarget = true;
                    break;
                }
            }

            if ($hasTarget) {
                if ($isFixMode) {
                    $item->update([
                        'docs' => [],
                        'docs_file_names' => []
                    ]);
                    $rows[] = [$item->id, 'EMPTY', 'EMPTY (Updated)'];
                } else {
                    $rows[] = [
                        $item->id,
                        json_encode($item->docs, JSON_UNESCAPED_UNICODE),
                        json_encode($item->docs_file_names, JSON_UNESCAPED_UNICODE),
                    ];
                }
            }
        }

        if (!empty($rows)) {
            $this->table(['ID', 'Column: docs', 'Column: docs_file_names'], $rows);

            if ($isFixMode) {
                $this->info("Successfully cleared arrays for " . count($rows) . " items.");
            } else {
                $this->warn("Run with --fix to clear these arrays.");
            }
        }
    }
}
