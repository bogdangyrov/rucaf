<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

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
}
