<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $total_student = User::where('user_type', 'Student')->count();
        $total_teacher = User::where('user_type', 'Teacher')->count();
        $total_pending_order = Purchase::where('status', 'Pending')->count();
        $total_package = Package::count();
        return view('home')->with([
            'total_student' => $total_student,
            'total_teacher' => $total_teacher,
            'total_pending_order' => $total_pending_order,
            'total_package' => $total_package
        ]);
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
