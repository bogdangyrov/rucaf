<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OutlierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategoryId = 25;
        $date = Carbon::create(2023, 4, 31);
        $quantity = 100;

        Order::create([
            'subcategory_id' => $subcategoryId,
            'quantity' => $quantity,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        $this->command->info('Сгенерирован выброс!');
    }
}
