<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
     public function show($id, $name)
     {
         return view('user.profil', compact('id', 'name')); // Mengirim data ID dan Nama ke view profile.blade.php
     }
}