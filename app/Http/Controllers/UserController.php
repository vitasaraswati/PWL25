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
        // $user = UserModel::find(1); //find id1 untuk ditampilkan ke browser
        // return view('user', ['data' => $user]);

        // where 
        // $user = UserModel::where('level_id', 1) -> first(); //mencari data UserModel di mana kolom level_id = 1
        // return view('user', ['data' => $user]);

        // firstwhere 
        // $user = UserModel::firstWhere('level_id', 1); //mencari data UserModel di mana kolom level_id = 1
        // return view('user', ['data' => $user]);

        $user = UserModel::findOr(20, ['username', 'nama'], function() { 
            abort (404); 
        }); 

        return view('user', ['data' => $user]);
    }
}