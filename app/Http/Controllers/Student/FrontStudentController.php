<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontStudentController extends Controller
{
    public function index(){
        return view('frontend.student.index');
    }
}
