<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan halaman kategori Food & Beverage
    public function foodBeverage()
    {
        return view('products.food-beverage'); 
    }

    // Menampilkan halaman kategori Beauty & Health
    public function beautyHealth()
    {
        return view('products.beauty-health'); 
    }

    // Menampilkan halaman kategori Home Care
    public function homeCare()
    {
        return view('products.home-care'); 
    }

    // Menampilkan halaman kategori Baby & Kid
    public function babyKid()
    {
        return view('products.baby-kid');
    }
}
