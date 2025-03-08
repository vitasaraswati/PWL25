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
        //PRAKTIKUM 2.4
        $user = UserModel::firstOrNew(
            [
                'username' => 'manager33',
                'nama' => 'Manager Tiga Tiga',
                'level_id' => 2
            ]
        );
        $user->password = Hash::make('12345');
        $user->save();
        
        return view('user', ['data' => $user]);
    }
} 