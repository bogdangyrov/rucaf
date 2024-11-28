<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::create([
            'title' => 'О компании',
            'html' => '<h1>О компании</h1><h2>Заголовок поменьше</h2>',
            'description' => 'О компании Rucaf',
            'og_title' => 'О компании',
            'og_description' => 'О компании'
        ]);

        Page::create([
            'title' => 'Доставка и оплата',
            'html' => '<h1>Доставка и оплата</h1><h2>Заголовок поменьше</h2>',
            'description' => 'Доставка и оплата Rucaf',
            'og_title' => 'Доставка и оплата',
            'og_description' => 'Доставка и оплата'
        ]);

        Page::create([
            'title' => 'Контакты',
            'html' => '<h1>Контакты</h1><h2>Заголовок поменьше</h2>',
            'description' => 'Контакты',
            'og_title' => 'Контакты',
            'og_description' => 'Контакты'
        ]);
    }
}
