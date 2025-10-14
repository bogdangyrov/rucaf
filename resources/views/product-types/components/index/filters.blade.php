<div class="wrap-filters">
    <button class="filter-btn btn" type="button"><i class="icon-filter"></i><span>Фильтрация</span></button>
    <button class="filter-btn-second btn" type="button"><i class="icon-filter"></i><span>Фильтрация</span></button>
    <form class="w-filters scroll">
        <input type="text" hidden name="page-size" value="{{ $filter->pageSize }}">
        <input type="text" hidden name="sort-by" value="{{ $filter->sortBy }}">
        <input type="text" hidden name="show-products" value="{{ $filter->showProducts }}">
        @if (count($categories) > 0)
            <div class="filter-category">
                <div class="filter-category__title">Категория</div>
                <div class="filter-category__wrap-list wrap-category-list">
                    <div class="filter-category__list category-list open filters">
                        @foreach ($categories as $category)
                            <a class="category-list__item"
                                href="{{ route('categories.index', ['productType' => $type, 'category' => $category]) }}">
                                <input type="checkbox" class="category-list__checkbox">
                                <span class="category-list__txt">{{ $category->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>
