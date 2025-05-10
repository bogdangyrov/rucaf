<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        $subcategoryId = 25;
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
                'subcategory_id' => $subcategoryId,
                'quantity' => $quantity,
                'created_at' => $month,
                'updated_at' => $month,
            ]);
        }

        $this->command->info('Сгенерированы заказы с сезонностью!');
    }
}
