<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontTeacherController extends Controller
{
    public function index(){
        return view('frontend.teacher.index');
    }

    /**
     * View: Profile
     */
    public function profile(){
        $table = User::find(Auth::id());
        return view('frontend.student.profile')->with(['table' => $table]);
    }
}
