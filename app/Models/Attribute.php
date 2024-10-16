<?php

namespace App\Models;

use App\Models\Value;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;

    public function values()
    {
        return $this->belongsToMany(Value::class, 'attribute_values', 'attribute_id', 'value_id');
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
