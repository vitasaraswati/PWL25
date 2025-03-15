<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() // Method untuk menampilkan halaman utama
    {
        return view('kategori.index');

    }
}