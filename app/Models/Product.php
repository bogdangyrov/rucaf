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

    public static function scopeWithCategory($query, array|null $categories = null)
    {
        if ($categories) {
            return $query->withWhereHas(
                'category',
                function ($query) use ($categories) {
                    $query->whereIn('slug', $categories);
                }
            );
        } else {
            return $query->with('category');
        }
    }

    public static function scopeFilterByAttributes($query, array $filters)
    {
        foreach ($filters as $name => $values) {
            $query->whereHas('attributeValues', function ($query) use ($name, $values) {
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
