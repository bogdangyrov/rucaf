<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'is_new' => 'boolean',
        'is_hit_of_sales' => 'boolean',
        'is_active' => 'boolean',
        'images' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function discountPercentage()
    {
        return floor(100 - ($this->discount_price / $this->price) * 100);
    }

    public function getFormattedPrice()
    {
        return static::formatPrice($this->price);
    }

    public function getFormattedDiscountPrice()
    {
        return static::formatPrice($this->discount_price);
    }

    public static function formatPrice($price, $thousandsSeparator = '&nbsp')
    {
        return number_format($price, 0, ',', $thousandsSeparator);
    }

    public static function scopeWithAttributes($query)
    {
        return $query->with('attributeValues.attribute', 'attributeValues.value');
    }

    public static function scopeWithCategory($query, $categories)
    {
        if ($categories->count() > 0) {
            $categoriesArray = $categories->pluck('slug');
            return $query->withWhereHas(
                'category',
                function ($query) use ($categoriesArray) {
                    $query->whereIn('slug', $categoriesArray);
                }
            );
        } else {
            return $query->with('category');
        }
    }

    public static function scopeFilterByAttributes($query, $attributes)
    {
        foreach ($attributes as $attribute) {
            $query->whereHas('attributeValues', function ($query) use ($attribute) {
                $name = $attribute->slug;
                $values = $attribute->values->pluck('slug');
                $query
                    ->whereHas('attribute', function ($query) use ($name) {
                        $query->where('slug', $name);
                    })
                    ->whereHas('value', function ($query) use ($values) {
                        $query->whereIn('slug', $values);
                    });
            });
        }
        return $query;
    }

    public static function scopeSortBy($query, $sortBy)
    {
        switch ($sortBy) {
            case 'popular':
                break;
            case 'price':
                $query->whereNotNull('price')->orderByRaw('IFNULL(discount_price, price)');
                break;
            case 'category':
                $query->orderBy('category_id');
                break;
        }
    }

    public static function scopeShowProducts($query, $showProducts)
    {
        switch ($showProducts) {
            case 'all':
                break;
            case 'new':
                $query->where('is_new', 1);
                break;
            case 'hits':
                $query->where('is_hit_of_sales', 1);
                break;
            case 'discounts':
                $query->whereNotNull('discount_price');
                break;
        }
    }

    public static function scopeFilterByPriceRange($query, $priceRange)
    {
        $query->where(DB::raw('IFNULL(discount_price, price)'), '>=', $priceRange[0])->where(DB::raw('IFNULL(discount_price, price)'), '<=', $priceRange[1]);
    }

    public static function scopeGetPriceRange($query)
    {
        return $query->select(DB::raw(
            'MAX(IFNULL(discount_price, price)) as max_price, MIN(IFNULL(discount_price, price)) as min_price',
        ))->get();
    }

    public static function scopeActive($query)
    {
        $query->where('is_active', 1);
    }
}
