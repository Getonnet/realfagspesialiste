<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Subject;
use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $package = Package::orderBy('name')->get();
        $student = User::orderBy('name')->where('user_type', 'Student')->get();
        $teacher = User::orderBy('name')->where('user_type', 'Teacher')->get();
        return view('reports.reports')->with(['package' => $package, 'student' => $student, 'teacher' => $teacher]);
    }

    public function sells_reports(Request $request){
        $sp_date = explode(" - ", $request->date_range);

        $dates = [];
        foreach ($sp_date as $row){
            $dates[] = date('Y-m-d', strtotime(str_replace("/","-", $row)));
        }

        $pre_table = Purchase::orderBy('id', 'DESC')->whereBetween('created_at', $dates);
        if(isset($request->package_id)){
            $pre_table->where('package_id', $request->package_id);
        }
        if(isset($request->user_id)){
            $pre_table->where('user_id', $request->user_id);
        }
        $table =  $pre_table->get();

        return view('reports.lightbox.sells')->with(['table' => $table]);
    }


    public function payment_reports(Request $request){

        $sp_date = explode(" - ", $request->date_range);

        $dates = [];
        foreach ($sp_date as $row){
            $dates[] = date('Y-m-d', strtotime(str_replace("/","-", $row)));
        }

        $pre_table = Payment::orderBy('id', 'DESC')->whereBetween('created_at', $dates);
        if(isset($request->user_id)){
            $pre_table->where('user_id', $request->user_id);
        }
        $table =  $pre_table->get();

        return view('reports.lightbox.payments')->with(['table' => $table]);
    }

    public function times(){
        $student = User::orderBy('name')->where('user_type', 'Student')->get();
        $teacher = User::orderBy('name')->where('user_type', 'Teacher')->get();
        $subject = Subject::orderBy('name')->get();
        return view('reports.time_log')->with(['subject' => $subject, 'teacher' => $teacher, 'student' => $student]);
    }

    public function time_report(Request $request){
        $sp_date = explode(" - ", $request->date_range);

        $dates = [];
        foreach ($sp_date as $row){
            $dates[] = date('Y-m-d', strtotime(str_replace("/","-", $row)));
        }

        $pre_table = TimeLog::orderBy('id', 'DESC')->whereBetween('created_at', $dates);
        if(isset($request->subject_id)){
            $pre_table->where('subject_id', $request->subject_id);
        }
        if(isset($request->student_id)){
            $pre_table->where('student_id', $request->student_id);
        }
        if(isset($request->teacher_id)){
            $pre_table->where('teacher_id', $request->teacher_id);
        }
        $table =  $pre_table->get();
        return view('reports.lightbox.time_log')->with(['table' => $table]);
    }

}
