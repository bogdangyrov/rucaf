<?php

namespace Database\Seeders;

use App\Models\PhoneNumber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhoneNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PhoneNumber::insert(
            [
                [
                    'number' => '8 (800) 770-08-90',
                    'data' => 'с 09:00 до 20:00'
                ],
                [
                    'number' => '8 (812) 700-33-76',
                    'data' => '<strong>Офис</strong> с 10:00 до 18:00'
                ],
                [
                    'number' =>   '8 (495) 430-02-43',
                    'data' =>  '<strong>Главный склад</strong> с 08:00 до 18:00'
                ]
            ]
        );
    }
}
