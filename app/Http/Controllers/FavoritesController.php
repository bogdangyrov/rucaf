<?php

namespace App\Http\Controllers;

use App\Helper\Seo;

class FavoritesController extends Controller
{
    public function index()
    {
        $seo = new Seo(
            'Избранные товары — Rucaf | Промышленное оборудование',
            'Ваш список избранных товаров в Rucaf. Сохраняйте и сравнивайте промышленное оборудование перед покупкой. Доставка по всей России.',
            'Избранные товары — Rucaf',
            'Просмотрите и управляйте своим списком избранных товаров. Выберите лучшее оборудование от Rucaf с доставкой по всей России.',
            asset('assets/img/logo.svg'),
            route('favorites'),
            'website',
        );

        return view('favorites')->with('seo', $seo);
    }
}
