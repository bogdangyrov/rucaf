<?php

namespace App\Http\Controllers;

use App\Service\ComparisonService;
use Illuminate\Http\Request;

class ComparisonController extends Controller
{
    public function index()
    {
        $productTypes = ComparisonService::getProductTypes();
        return view('comparison')
            ->with('productTypes', $productTypes);
    }
}
