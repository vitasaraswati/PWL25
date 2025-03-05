<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function articles (Request $request, $id)
    {
        return 'Halaman Artikel dengan ID ' . $id;
    }
}
