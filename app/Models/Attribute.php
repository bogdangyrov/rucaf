<?php

namespace App\Models;

use App\Models\Value;
use App\Helpers\Filter;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function values()
    {
        return $this->hasMany(Value::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'attribute_values');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public static function scopeWithUniqueValues($query)
    {
        $attributes = $query->with(['values' => function ($query) {
            $query->orderBy('value');
        }])->get();

        $valueIds = $attributes->pluck('values')->flatten()->pluck('id')->unique();

        $counts = DB::table('attribute_values as av')
            ->whereIn('av.value_id', $valueIds)
            ->groupBy('av.value_id')
            ->select('av.value_id', DB::raw('COUNT(*) as products_count'))
            ->pluck('products_count', 'av.value_id');

        foreach ($attributes as $attribute) {
            foreach ($attribute->values as $value) {
                $value->products_count = $counts[$value->id] ?? 0;
            }
        }

        return $attributes;
    }

    /*   public static function scopeWithUniqueValues($query, Filter $filter)
    {
        $attributes = $query->with(['values' => function ($query) {
            $query->orderBy('value')->distinct();
        }])->get();

        foreach ($attributes as $attribute) {
            $attribute->values = $attribute->values->sortBy('value');
            /*
                Код ниже нужен для функции выбора нескольких значений у одного атрибута.
                Например: пользователь выбрал страну Россия,
                    в выборе фильтров мы должны дать возможность выбрать ему другую страну(Китай) и корректно отобразить
                    кол-во для России и для Китая.

            $attribute->values->loadCount(['products' => function ($productQuery) use ($filter, $attribute) {
                $productQuery->active();
                $productQuery->withSubcategory($filter->subcategory);
                if ($filter->priceRange) {
                    $productQuery->filterByPriceRange($filter->priceRange);
                }

                if (in_array($attribute->id, $filter->attributes->pluck('id')->toArray())) {
                    foreach ($filter->attributes as $filterAttribute) {
                        if ($filterAttribute->id == $attribute->id) {
                            $productQuery->whereHas('attributeValues', function ($query) use ($filterAttribute) {
                                $name = $filterAttribute->slug;
                                $values = $filterAttribute->values->pluck('slug');
                                $query
                                    ->whereHas('attribute', function ($query) use ($name) {
                                        $query->where('slug', $name);
                                    })
                                    ->orWhereHas('value', function ($query) use ($values) {
                                        $query->whereIn('slug', $values);
                                    });
                            });
                        } else {
                            $productQuery->whereHas('attributeValues', function ($query) use ($filterAttribute) {
                                $name = $filterAttribute->slug;
                                $values = $filterAttribute->values->pluck('slug');
                                $query
                                    ->whereHas('attribute', function ($query) use ($name) {
                                        $query->where('slug', $name);
                                    })
                                    ->whereHas('value', function ($query) use ($values) {
                                        $query->whereIn('slug', $values);
                                    });
                            });
                        }
                    }
                } else {
                    $productQuery->filterByAttributes($filter->attributes);
                }
            }]);
        }
        return $attributes;
    }
 */

    public function scopeWithAttributesValuesFromQuery($query, array $requestQuery)
    {
        return  $query->withWhereHas(
            'values',
            function ($query) use ($requestQuery) {
                $query->where(function ($query) use ($requestQuery) {
                    foreach ($requestQuery as $name => $values) {
                        if (!is_array($values)) {
                            continue;
                        }

                        $query->orWhere(function ($query) use ($name, $values) {
                            $query->whereHas('attribute', function ($query) use ($name) {
                                $query->where('slug', $name);
                            })->whereIn('slug', $values);
                        });
                    }
                });
            }
        );
    }
}
