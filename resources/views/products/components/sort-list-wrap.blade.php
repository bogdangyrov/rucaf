<div class="wrap-sort-list">
    @php
        $originalQuery = $filter->getQuery();
    @endphp

    @include('products.components.sort-list', [
        'sortTitle' => 'Сортировка по',
        'sortList' => ['Популярности' => 'popular', 'Цене' => 'price', 'Категории' => 'category'],
        'sortSlug' => 'sort-by',
        'attr' => 'sortBy',
    ])

    @include('products.components.sort-list', [
        'sortTitle' => 'Показывать',
        'sortList' => ['Все' => 'all', 'Новинки' => 'new', 'Хиты продаж' => 'hits', 'Скидки' => 'discounts'],
        'sortSlug' => 'show-products',
        'attr' => 'showProducts',
    ])

    @include('products.components.sort-list', [
        'sortTitle' => 'Показать по',
        'sortList' => ['20' => '20', '60' => '60', '100' => '100', 'Все' => 'all'],
        'sortSlug' => 'page-size',
        'attr' => 'pageSize',
    ])

</div>
