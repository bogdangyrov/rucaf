<?php

namespace App\Http\Controllers\Web;

use App\Helper\Seo;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $seo = new Seo(
            'Корзина товаров — Rucaf | Оборудование с доставкой по России',
            'Просмотрите товары в корзине и оформите заказ на промышленное оборудование от компании Rucaf. Доставка по всей России.',
            'Ваша корзина — Rucaf',
            'Готовы оформить заказ? Просмотрите товары в корзине и завершите покупку промышленного оборудования от Rucaf.',
            asset('assets/img/logo.svg'),
            route('cart'),
            'website',
        );

        return view('cart')->with('seo', $seo);
    }
}
