<?php

namespace App\Http\Controllers;

use App\Models\User;


use Illuminate\Http\Request;

class adminController extends Controller
{
    // 
    function index()
    {
        return '<h1> Cek2 </h1>';
    }

    function addRole()
    {
        $user = User::find(1);
        $user->assignRole('admin');
    }

    function admin()
    {
        return view('admin.dashboard');
    }
}
