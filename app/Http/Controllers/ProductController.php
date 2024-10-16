<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductType;
use Illuminate\Contracts\Database\Query\Builder;

class ProductController extends Controller
{

    public function index()
    {
        $types = ProductType::get();
        return view('products.index')->with('types', $types);
    }

    public function type(string $typeId)
    {
        $type = ProductType::findOrFail($typeId);


        $categories = Category::where('product_type_id', $type->id)->get();

        $attributes = $type->attributes()->with('values.products')->get();
        foreach ($attributes as $attribute) {
            $attribute->values = $attribute->values->unique('value');
        }

        $query = request()->query();
        $filter = [];
        foreach ($query as $name => $value) {
            if (in_array($name, $attribute->toArray())) {
                $filter[$name] = $value;
            }
        }

        $category = request()->query('category');

        $products = Product
            ::with('attributeValues.attribute', 'attributeValues.value')
            ->withWhereHas(
                'category',
                function ($query) use ($category) {
                    if ($category) {
                        $query->where('id', $category);
                    }
                }
            )
            ->where('product_type_id', $type->id);

        $products->whereHas('attributeValues', function ($query) use ($name, $value) {
            $query
                ->whereHas('attribute', function ($query) use ($name) {
                    $query->where('id', $name);
                })
                ->whereHas('value', function ($query) use ($value) {
                    $query->where('id', $value);
                });
        });

        $products = $products->get();

        return view('products.type')->with(['type' => $type, 'products' => $products, 'categories' => $categories, 'attributes' => $attributes]);
    }
}
