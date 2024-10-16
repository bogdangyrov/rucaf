<?php

namespace App\Models;

use App\Models\Category;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public static function scopeWithAttributes($query)
    {
        return $query->with('attributeValues.attribute', 'attributeValues.value');
    }

    public static function scopeWithCategory($query, string $category = null)
    {
        if ($category) {
            return $query->withWhereHas(
                'category',
                function ($query) use ($category) {
                    $query->where('slug', $category);
                }
            );
        } else {
            return $query->with('category');
        }
    }

    public static function scopeFilterByAttributes($query, array $filters)
    {
        foreach ($filters as $name => $value) {
            $query->whereHas('attributeValues', function ($query) use ($name, $value) {
                $query
                    ->whereHas('attribute', function ($query) use ($name) {
                        $query->where('slug', $name);
                    })
                    ->whereHas('value', function ($query) use ($value) {
                        $query->where('slug', $value);
                    });
            });
        }
        return $query;
    }
}
