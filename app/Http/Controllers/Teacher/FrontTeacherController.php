<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontTeacherController extends Controller
{
    public function index(){
        return view('frontend.teacher.index');
    }
}
