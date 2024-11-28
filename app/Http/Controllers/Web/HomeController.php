<?php

namespace App\Http\Controllers\Web;

use App\Helper\Seo;
use App\Models\Product;
use App\Http\Controllers\Controller;

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
            asset('assets/img/logo.svg'),
            route('home'),
            'website',
        );

        return view('index')->with(['hotProducts' => $hotProducts, 'seo' => $seo]);
    }

    public function catalog()
    {
        $seo = new Seo(
            'Каталог промышленного оборудования — Rucaf | rucaf.com',
            'Каталог оборудования от компании RUCAF: автоматические выключатели, вакуумные контакторы, тали, лебедки, электродвигатели и многое другое. Доставка по всей России.',
            'Каталог оборудования — Rucaf',
            'Ознакомьтесь с каталогом промышленного оборудования Rucaf. Автоматические выключатели, запчасти для тельферов, редукторы, пульты управления и многое другое. Доставка по всей России.',
            asset('assets/img/logo.svg'),
            route('catalog'),
            'website',
        );

        return view('catalog')->with('seo', $seo);
    }
}
