<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductType extends Model
{
    use HasFactory;

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
