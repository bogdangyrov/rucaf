<?php

namespace App\Models;

use App\Helpers\Filter;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function scopeWithProductsCount($query, Filter $filter)
    {
        $query->withCount(['products' => function ($query) use ($filter) {
            $query->active();
            $query->filterByAttributes($filter->attributes);
            if ($filter->priceRange) {
                $query->filterByPriceRange($filter->priceRange);
            }
        }]);
    }
}
