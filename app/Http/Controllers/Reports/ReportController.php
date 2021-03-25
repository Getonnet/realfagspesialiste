<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        return view('reports.reports');
    }

    public function student(){
        return view('reports.student');
    }

    public function teacher(){
        return view('reports.teacher');
    }
}
