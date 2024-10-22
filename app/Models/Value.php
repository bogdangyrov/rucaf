<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Value extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = Str::slug($model->value);
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'attribute_values', 'value_id', 'product_id');
    }
}
