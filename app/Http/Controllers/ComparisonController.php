<?php

namespace App\Http\Controllers;

use App\Helper\Seo;

class ComparisonController extends Controller
{
    public function index()
    {
        $seo = new Seo(
            'Сравнение товаров — Rucaf | Промышленное оборудование',
            'Сравните характеристики и цены на промышленное оборудование от Rucaf. Выберите лучший товар для ваших нужд с доставкой по всей России.',
            'Сравнение товаров — Rucaf',
            'Сравните и выберите подходящее промышленное оборудование от компании Rucaf. Узнайте ключевые характеристики и преимущества каждого товара.',
            asset('img/logo.svg'),
            route('comparison'),
            'website',
        );

        return view('comparison')->with('seo', $seo);
    }
}
