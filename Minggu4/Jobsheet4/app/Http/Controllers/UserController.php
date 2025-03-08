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

        //PRAKTIKUM 2.1

        // find or fail 
        // $user = UserModel::findOrFail(1);
        // return view('user', ['data' => $user]);

        $user = UserModel::where('username', 'manager9')->firstOrFail();
        return view('user', ['data' => $user]);
    }
}