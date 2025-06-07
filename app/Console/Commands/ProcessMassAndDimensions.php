<?php

namespace App\Console\Commands;

use App\Models\Subcategory;
use Illuminate\Console\Command;

class ProcessMassAndDimensions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-mass-and-dimensions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subcategories = Subcategory::get();

        foreach ($subcategories as $i => $subcategory) {
            $product = $subcategory->products()->whereNotNull('mass')->first();
            if (!$product) {
                echo "[$i] - {$subcategory->name} - Масса не указана\n";
                continue;
            }

            $mass = $product->mass;
            $dimensions = $product->dimensions;

            $subcategory->products()->update([
                'mass' => $mass,
                'dimensions' => $dimensions
            ]);
            echo "[$i] - {$subcategory->name} - Масса: $mass, Размеры: $dimensions\n";
        }
    }
}
