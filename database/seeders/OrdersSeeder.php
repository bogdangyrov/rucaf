<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        $productId = Product::first()->id;
        $startDate = Carbon::create(2020, 1, 1);

        for ($i = 0; $i < 48; $i++) {
            $month = (clone $startDate)->addMonths($i);
            $monthNumber = (int)$month->format('n');

            // Базовое значение + тренд
            $baseQuantity = 10 + intdiv($i, 12) * 5;

            // Сезонность: пик в декабре-феврале
            $seasonBoost = in_array($monthNumber, [12, 1, 2]) ? 10 : 0;

            $quantity = fake()->numberBetween(
                $baseQuantity + $seasonBoost - 2,
                $baseQuantity + $seasonBoost + 2
            );

            Order::create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'created_at' => $month,
                'updated_at' => $month,
            ]);
        }

        $this->command->info('Сгенерированы заказы с сезонностью!');
    }
}
