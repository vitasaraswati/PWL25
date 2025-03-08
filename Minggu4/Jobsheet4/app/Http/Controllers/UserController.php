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
        // find berdasarkan id 
        // $user = UserModel::find(1); // find id1 untuk ditampilkan ke browser 
        // return view('user', ['data' => $user]);

        // where
        // $user = UserModel::where('level_id', 1) -> first(); // where id1 untuk ditampilkan ke browser 
        // return view('user', ['data' => $user]);

        //firstwhere
        // $user = UserModel::firstWhere('level_id', 1) -> first(); // mencari data dimana kolom level_id = 1
        // return view('user', ['data' => $user]);

        // findOr untuk menampilkan field tertentu
        $user = UserModel::findOr(id: 20, columns: ['username', 'nama'], callback: function(): never {
            abort (code: 404);
        });
        
        // return view(view: 'user', data: ['data' => $user]);

    }
}