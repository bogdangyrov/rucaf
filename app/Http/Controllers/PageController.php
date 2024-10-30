<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Page $page)
    {
        return view('page')->with('page', $page);
    }
}
