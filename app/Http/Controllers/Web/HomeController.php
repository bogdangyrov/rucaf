<?php

namespace App\Http\Controllers\Web;

use App\Helper\Seo;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\PhoneNumber;

class HomeController extends Controller
{
    public function index()
    {
        $hotProducts = Product::where('is_hit_of_sales', true)->limit(20)->get();

        $seo = new Seo(
            'Rucaf — Продажа промышленного оборудования по всей России | rucaf.com',
            'Rucaf — широкий ассортимент промышленного оборудования: автоматические выключатели, вакуумные контакторы, запчасти для тельфера, крановые весы, электродвигатели и многое другое. Доставка по всей России.',
            'Rucaf — Надежное промышленное оборудование по всей России',
            'Rucaf предлагает автоматические выключатели, вакуумные контакторы, лебедки и другие виды оборудования с доставкой по всей России.',
            asset('img/logo.svg'),
            route('home'),
            'website',
        );

        return view('index')->with(['hotProducts' => $hotProducts, 'seo' => $seo]);
    }

    public function catalog()
    {
        $seo = new Seo(
            'Каталог промышленного оборудования — Rucaf | rucaf.com',
            'Каталог оборудования от компании Rucaf: автоматические выключатели, вакуумные контакторы, тали, лебедки, электродвигатели и многое другое. Доставка по всей России.',
            'Каталог оборудования — Rucaf',
            'Ознакомьтесь с каталогом промышленного оборудования Rucaf. Автоматические выключатели, запчасти для тельферов, редукторы, пульты управления и многое другое. Доставка по всей России.',
            asset('img/logo.svg'),
            route('catalog'),
            'website',
        );

        return view('catalog')->with('seo', $seo);
    }

    public function privacy()
    {
        $seo = new Seo(
            'Политика конфиденциальности | Rucaf',
            'Узнайте, как мы обрабатываем и защищаем ваши персональные данные на сайте rucaf.com',
            'Защита персональных данных на сайте — Rucaf',
            'Полная информация о целях, условиях хранения и передачи данных.',
            asset('img/logo.svg'),
            route('privacy'),
            'website',
        );

        $phoneNumber = PhoneNumber::first();
        $email = Email::first();

        return view('privacy')->with([
            'seo' => $seo,
            'phoneNumber' => $phoneNumber,
            'email' => $email
        ]);
    }

    public function search()
    {
        $seo = new Seo(
            'Поиск по сайту — Rucaf | Найдите нужное оборудование',
            'Ищете промышленное оборудование? Используйте поиск по сайту Rucaf, чтобы быстро найти нужные товары: редукторы, тельферы, электродвигатели и многое другое.',
            'Поиск по сайту — Rucaf',
            'Найдите нужное промышленное оборудование с помощью поиска по сайту Rucaf. Широкий ассортимент товаров с доставкой по всей России.',
            asset('img/logo.svg'),
            route('search'),
            'website',
        );

        return view('search')->with([
            'seo' => $seo,
        ]);
    }
}
