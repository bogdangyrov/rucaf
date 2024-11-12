<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function index(Page $page)
    {
        return view('page')->with('page', $page);
    }
}
