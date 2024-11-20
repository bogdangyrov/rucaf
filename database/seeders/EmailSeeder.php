<?php

namespace Database\Seeders;

use App\Models\Email;
use Illuminate\Database\Seeder;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Email::insert([
            ['email' => 'info-order@rucaf.ru', 'data' => 'Общие вопросы'],
            ['email' => 'site-review@rucaf.ru', 'data' => 'Вопросы по сайту'],
        ]);
    }
}
