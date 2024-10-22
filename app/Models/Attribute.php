<?php

namespace App\Models;

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

    public static function scopeWithUniqueValues($query)
    {
        $attributes = $query->with('values')->get();
        foreach ($attributes as $attribute) {
            $attribute->values = $attribute->values->unique('value');
        }
        return $attributes;
    }
}
