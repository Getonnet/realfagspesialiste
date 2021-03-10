<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        return view('home');
    }

    public function register(){
        if(Auth::guest())
        {
            return view('register');

        }else{
            return redirect()->route('admin.dashboard');
        }

    }

}
