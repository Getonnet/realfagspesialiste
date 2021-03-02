<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class FrontStudentController extends Controller
{
    public function index(){
        $today = date('Y-m-d H:i:s');
        $table = Package::orderBy('price')->where('expire', '>=', $today)->get()->chunk(4);
        return view('frontend.student.index')->with(['table' => $table]);
    }
}
