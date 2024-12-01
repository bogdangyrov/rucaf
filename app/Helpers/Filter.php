<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Collection;

class Filter
{
    public Collection $categories;
    public Collection $attributes;

    public string $pageSize = '20';
    public string $sortBy = 'popular';
    public string $showProducts = 'all';
    public int $page = 1;
    public array $priceRange = [];

    private static array $availablePageSizes = [20, 60, 100];
    private static array $availableSortBy = ['popular', 'price', 'category'];
    private static array $availableShowProducts = ['all', 'new', 'hits', 'discounts'];


    public function __construct(array $requestQuery)
    {
        if (isset($requestQuery['category'])) {
            $this->categories = Category::whereIn('slug', $requestQuery['category'])->get();
            unset($requestQuery['category']);
        } else {
            $this->categories = new Collection();
        }

        if (isset($requestQuery['page-size']) && in_array($requestQuery['page-size'], static::$availablePageSizes)) {
            $this->pageSize = $requestQuery['page-size'];
            unset($requestQuery['page-size']);
        }

        if (isset($requestQuery['show-products']) && in_array($requestQuery['show-products'], static::$availableShowProducts)) {
            $this->showProducts = $requestQuery['show-products'];
            unset($requestQuery['show-products']);
        }

        if (isset($requestQuery['sort-by']) && in_array($requestQuery['sort-by'], static::$availableSortBy)) {
            $this->sortBy = $requestQuery['sort-by'];
            unset($requestQuery['sort-by']);
        }

        if (isset($requestQuery['page']) && ($requestQuery > 0)) {
            $this->page = $requestQuery['page'];
            unset($requestQuery['page']);
        }

        if (isset($requestQuery['min-price']) && isset($requestQuery['max-price']) && $requestQuery['min-price'] > 0 && $requestQuery['max-price'] > 0) {
            $this->priceRange = [$requestQuery['min-price'], $requestQuery['max-price']];
            unset($requestQuery['min-price'], $requestQuery['max-price']);
        }

        if ($requestQuery) {
            $this->attributes = Attribute::withAttributesValuesFromQuery($requestQuery)->get();
        } else {
            $this->attributes = new Collection();
        }
    }

    public function inCategories(string $slug)
    {
        if ($this->categories) {
            return $this->categories->contains('slug', $slug);
        } else {
            return false;
        }
    }

    public function attributeExists(string $slug)
    {
        if ($this->attributes) {
            return $this->attributes->contains('slug', $slug);
        } else {
            return false;
        }
    }

    public function inAttributeValues(string $attributeSlug, string $valueSlug)
    {
        return $this->attributes->filter(function ($attribute) use ($attributeSlug, $valueSlug) {
            return $attribute->slug === $attributeSlug && $attribute->values->contains('slug', $valueSlug);
        })->isNotEmpty();
    }

    public function filtersExists()
    {
        return $this->attributes->count() > 0 || $this->categories->count() > 0;
    }

    public function queryWithoutCategory(string $slug)
    {
        $categories = $this->categories->where('slug', '!==', $slug)->pluck('slug')->toArray();
        return $categories;
    }

    public function queryCategories()
    {
        return $this->categories->pluck('slug')->toArray();
    }

    public function queryAttributes()
    {
        $query = [];
        foreach ($this->attributes as $attribute) {
            $query[$attribute->slug] = $attribute->values->pluck('slug')->toArray();
        }
        return $query;
    }

    public function queryWithoutAttributeValue(string $attributeSlug, string $valueSlug)
    {
        $query = [];
        foreach ($this->attributes as $attribute) {
            if ($attribute->slug == $attributeSlug) {
                $query[$attribute->slug] = $attribute->values->where('slug', '!==', $valueSlug)->pluck('slug')->toArray();
            } else {
                $query[$attribute->slug] = $attribute->values->pluck('slug')->toArray();
            }
        }
        return $query;
    }

    public function getQuery()
    {
        $query = [
            'category[]' => $this->categories->pluck('slug')->toArray(),
            ...$this->queryAttributes(),
            'page-size' => $this->pageSize,
            'show-products' => $this->showProducts,
            'page' => $this->page,
            'sort-by' => $this->sortBy
        ];

        if ($this->priceRange) {
            $query['min-price'] = $this->priceRange[0];
            $query['max-price'] = $this->priceRange[1];
        }
        return $query;
    }
}
