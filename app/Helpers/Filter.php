<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Collection;

class Filter
{
    public Collection $categories;
    public Collection $attributes;

    public function __construct(array $requestQuery)
    {
        if (isset($requestQuery['category'])) {
            $this->categories = Category::whereIn('slug', $requestQuery['category'])->get();
            unset($requestQuery['category']);
        } else {
            $this->categories = new Collection();
        }

        if ($requestQuery) {
            $this->attributes = Attribute::withWhereHas(
                'values',
                function ($query) use ($requestQuery) {
                    $query->where(function ($query) use ($requestQuery) {
                        foreach ($requestQuery as $name => $values) {
                            $query->orWhere(function ($query) use ($name, $values) {
                                $query->whereHas('attribute', function ($query) use ($name) {
                                    $query->where('slug', $name);
                                })->whereIn('slug', $values);
                            });
                        }
                    });
                }
            )->get();
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
}
