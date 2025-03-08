<?php

namespace App\Http\Controllers;

use Illuminate\HTTP\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        //PRAKTIKUM 2.3
         // Menghitung jumlah pengguna dengan level_id = 2
         $jumlahPengguna = UserModel::where('level_id', 2)->count();

         // Mengirim data ke view
         return view('user', ['jumlahPengguna' => $jumlahPengguna]);
    }
} 