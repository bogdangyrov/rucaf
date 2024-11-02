<?php

namespace App\Models;

use App\Helpers\Filter;
use App\Models\Value;
use Illuminate\Support\Str;
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

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'attribute_values');
    }

    public static function scopeWithUniqueValues($query, Filter $filter)
    {
        $attributes = $query->with(['values' => function ($query) use ($filter) {
            $query->withCount(['products' => function ($query) use ($filter) {
                $query->withCategory($filter->categories)
                    ->filterByAttributes($filter->attributes);
            }]);
        }])->get();

        foreach ($attributes as $attribute) {
            $attribute->values = $attribute->values->unique('value');
        }
        return $attributes;
    }

    public function scopeWithAttributesValuesFromQuery($query, array $requestQuery)
    {
        return  $query->withWhereHas(
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
        );
    }
}
