<?php

namespace App\Models;

use App\Helpers\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        $query->withCount([
            'products' => function ($query) use ($filter) {
                $query->active();
                $subcategories = $filter->subcategories->pluck('id');
                //$query->whereIn('sub_category_id', $subcategories);
                $query->filterByAttributes($filter->attributes);
                if ($filter->priceRange) {
                    $query->filterByPriceRange($filter->priceRange);
                }
            }
        ]);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
