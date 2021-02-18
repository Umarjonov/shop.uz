<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $productAll = Product::latest()->get();
        return view('index')->with(compact('productAll'));
    }
}
