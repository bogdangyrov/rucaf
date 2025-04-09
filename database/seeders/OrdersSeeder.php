<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = Subcategory::all();

        if ($subcategories->isEmpty()) {
            $this->command->info('Нет подкатегорий для генерации заказов!');
            return;
        }

        foreach (range(1, 50) as $index) {
            Order::create([
                'subcategory_id' => $subcategories->random()->id,
                'quantity' => fake()->numberBetween(1, 100),
                'created_at' => fake()->dateTimeThisYear(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Сидирование заказов завершено!');
    }
}
