<?php

namespace App\Models;

use App\Models\Value;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Model;

class QuickFilter extends Model
{
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function value()
    {
        return $this->belongsTo(Value::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
