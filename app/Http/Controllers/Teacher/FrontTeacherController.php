<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\Payment;
use App\Models\StudyMaterial;
use App\Models\Subject;
use App\Models\SubjectTaught;
use App\Models\TeacherProfile;
use App\Models\TimeLog;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FrontTeacherController extends Controller
{
    use UploadTrait;
    public function index(){

        $startTime = Carbon::parse("2004-01-23 19:01:00");
        $finishTime = Carbon::parse("2021-04-23 14:01:00");
        $totalDuration = $startTime->diffInMinutes($finishTime, false);

       // dd(number_format(($totalDuration / 60), 2, '.', ' '));

        $table = User::find(Auth::id());

        $subjects_id = TimeLog::select('subject_id')->where('teacher_id', Auth::id())->groupBy('subject_id')->pluck('subject_id')->toArray();
        $categories = Subject::select('name')->whereIn('id', $subjects_id)->pluck('name')->toArray();
        $data = [];
        foreach ($subjects_id as $subject_id){
            $time_log = TimeLog::where('teacher_id', Auth::id())->where('subject_id', $subject_id)->get();

            $hours = 0;
            foreach ($time_log as $row){
                $hours += (double)$row->spend_time('H');
            }

            $data[] = $hours;
        }

        return view('frontend.teacher.index')->with(['table' => $table, 'categories' => json_encode($categories), 'data' => json_encode($data)]);
    }

    public function register(){
        if(Auth::guest())
        {
            return view('frontend.teacher.register');

        }else{
            return redirect()->route('teacher.home');
        }
    }

    /**
     * View: Profile
     */
    public function profile(){
        $table = User::find(Auth::id());
        $subject = Subject::orderBy('name')->get();
        return view('frontend.teacher.profile')->with(['table' => $table, 'subject' => $subject]);
    }

    public function update_profile(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'password' => 'sometimes|nullable|alpha_num|min:8|confirmed',
            'address' => 'required|string|max:191',
            'zip' => 'required|string|max:191',
            'dob' => 'required|date',
            'city' => 'required|string|max:191',
            'contact' => 'required|string|min:10|max:20',
            'grade' => 'required|numeric',
            'working_hour' => 'required|numeric',
            'gender' => 'required|in:Male,Female,Other',
            'subject_id' => 'required|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = User::find($id);
            $table->name = $request->name;
            $table->user_type = 'Teacher';
            if (isset($request->password)){
                $table->password = bcrypt($request->password);
            }

            if ($request->has('photo')) {
                // Get image file
                $image = $request->file('photo');
                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->input('name')) . '_' . time();
                // Define folder path
                $folder = '/uploads/profile/';
                // Make a file path where image will be stored [ folder path + file name + file extension]
                $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                // Upload image
                $this->uploadOne($image, $folder, 'public', $name);
                // Set user profile image path in database to filePath
                $table->profile_photo_path = $filePath;
            }
            $table->save();

            $user_id = $table->id;

            $teacherProfile = TeacherProfile::updateOrCreate(
                ['user_id' => $user_id],
                [
                    'dob' => date('Y-m-d',  strtotime($request->dob)),
                    'contact' => $request->contact,
                    'address' => $request->address,
                    'zip' => $request->zip,
                    'city' => $request->city,
                    'grade' => $request->grade,
                    'working_hour' => $request->working_hour,
                    'gender' => $request->gender,
                    'description' => $request->description
                ]
            );

            $file_upload = TeacherProfile::find($teacherProfile->id);
            if ($request->has('cv')) {
                // Get image file
                $image = $request->file('cv');
                // Make a image name based on user name and current timestamp
                $name = 'cv'.md5(date('Y-m-d h:i:s'));
                // Define folder path
                $folder = '/uploads/files/';
                // Make a file path where image will be stored [ folder path + file name + file extension]
                $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                // Upload image
                $this->uploadOne($image, $folder, 'public', $name);
                // Set user profile image path in database to filePath
                $file_upload->cv = $filePath;
            }

            if ($request->has('diploma')) {
                // Get image file
                $image = $request->file('diploma');
                // Make a image name based on user name and current timestamp
                $name = 'diploma'.md5(date('Y-m-d h:i:s'));
                // Define folder path
                $folder = '/uploads/files/';
                // Make a file path where image will be stored [ folder path + file name + file extension]
                $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                // Upload image
                $this->uploadOne($image, $folder, 'public', $name);
                // Set user profile image path in database to filePath
                $file_upload->diploma = $filePath;
            }
            $file_upload->save();

            $subjects = $request->subject_id;

            SubjectTaught::where('user_id', $user_id)->delete();

            foreach ($subjects as $subject_id){
                $thought = new SubjectTaught();
                $thought->subject_id = $subject_id;
                $thought->user_id = $user_id;
                $thought->save();
            }


        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.edit'));

    }


    public function events(){
        $subjects = SubjectTaught::all();
        $students = AssignStudent::where('teacher_id', Auth::id())->get();
        $table = TimeLog::orderBy('Id', 'DESC')->where('teacher_id', Auth::id())->get();
        return view('frontend.teacher.events')->with(['subjects' => $subjects, 'students' => $students, 'table' => $table]);
    }

    public function event_save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'event_start' => 'required|date',
            'subject_id' => 'required|numeric',
            'student_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $student = User::find($request->student_id);
            $subject = Subject::find($request->subject_id);

            $table = new TimeLog();
            $table->name = $request->name;
            $table->event_start = date('Y-m-d H:i:s', strtotime($request->event_start));
            $table->subject_id = $request->subject_id;
            $table->subject_name = $subject->name;

            $table->student_id = $request->student_id;
            $table->student_name = $student->name;
            $table->student_email = $student->email;

            $table->teacher_id  = Auth::id();
            $table->teacher_name = Auth::user()->name;
            $table->teacher_email = Auth::user()->email;

            $table->description = $request->description;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }

    public function event_edit(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'event_start' => 'required|date',
            'subject_id' => 'required|numeric',
            'student_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $student = User::find($request->student_id);
            $subject = Subject::find($request->subject_id);

            $table = TimeLog::find($id);
            $table->name = $request->name;
            $table->event_start = date('Y-m-d H:i:s', strtotime($request->event_start));
            $table->subject_id = $request->subject_id;
            $table->subject_name = $subject->name;

            $table->student_id = $request->student_id;
            $table->student_name = $student->name;
            $table->student_email = $student->email;

            /*$table->teacher_id  = Auth::id();
            $table->teacher_name = Auth::user()->name;
            $table->teacher_email = Auth::user()->email;*/

            $table->description = $request->description;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }

    public function running_status($id){
        try{

            $table = TimeLog::find($id);
            $current = $table->status;
            if($current == 'Pending'){
                $table->status = 'Running';
                $table->start_time = date('Y-m-d H:i:s');
            }
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }

    public function end_status(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'subject_id' => 'required|numeric',
            'motivational' => 'required|numeric|min:1|max:10',
            'understanding' => 'required|numeric|min:1|max:10',
            'hour_spend' => 'required|numeric',//Transport Hour
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $subject = Subject::find($request->subject_id);

            $table = TimeLog::find($id);
            $table->start_time = date('Y-m-d H:i:s', strtotime($request->start_time));
            $table->end_time = date('Y-m-d H:i:s', strtotime($request->end_time));
            $table->name = $request->name;
            $table->hour_spend = $request->hour_spend;
            $table->understanding = $request->understanding;
            $table->motivational = $request->motivational;
            $table->description = $request->description;
            $table->summery = $request->summery;
            $table->subject_id = $request->subject_id;
            $table->subject_name = $subject->name;
            $table->status = 'End';
            $table->save();
            $time_log_id = $table->id;

            if (isset($request->materials)){
                $materials = $request->materials;
                foreach ($materials as $i => $row){
                    $image = $request->file('materials')[$i];
                    $name = md5(date('Y-m-d H:i:s').$i);
                    $folder = '/uploads/materials/';
                    $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                    $this->uploadOne($image, $folder, 'public', $name);

                    $st_mat = new StudyMaterial();
                    $st_mat->file_name = $filePath;
                    $st_mat->time_log_id = $time_log_id;
                    $st_mat->save();
                }
            }

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }

    public function del_event($id){
        try{

            TimeLog::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }

    public function overview($id){
        $table = TimeLog::find($id);
        return view('frontend.teacher.overview')->with(['table' => $table]);
    }

    public function all_events(){
        $table = TimeLog::where('teacher_id', Auth::id())->get();

        $data = [];
        foreach ($table as $row){
            $rowData['url'] = route('teacher.events-overview', ['id' => $row->id]);
            $rowData['start'] = $row->event_start;
            $rowData['title'] = $row->student_name;
            //$rowData['end'] = $row->event_start;
            $rowData['allDay'] = false;

            if ($row->status == 'Pending') {
                $rowData['className'] = 'fc-event-solid-primary';
            }elseif ($row->status == 'Running'){
                $rowData['className'] = 'fc-event-solid-success';
            }else{
                $rowData['className'] = 'fc-event-success';
            }
            $data[] = $rowData;
        }
        return response()->json($data);
    }

    public function payments(){
        $table = Payment::orderBy('id', 'DESC')->where('user_id', Auth::id())->get();
        return view('frontend.teacher.payments')->with(['table' => $table]);
    }

    public function reports(){
        $subjects = SubjectTaught::all();
        $students = TimeLog::orderBy('student_name')->groupBy('student_id')->having('teacher_id', Auth::id())->get();
        $student = AssignStudent::where('teacher_id', Auth::id())->get();
        return view('frontend.teacher.reports')->with(['subjects' => $subjects, 'student' => $student, 'students' => $students]);
    }

    public function show_reports(Request $request){

        $sp_date = explode(" - ", $request->date_range);
        $dates = [];
        foreach ($sp_date as $row){
            $dates[] = date('Y-m-d', strtotime(str_replace("/","-", $row)));
        }

        $pre_table = TimeLog::where('teacher_id', Auth::id())->where('status', 'End')->orderBy('id','DESC')->whereBetween('created_at', $dates);
        if(isset($request->subject_id)){
            $pre_table->where('subject_id', $request->subject_id);
        }
        if(isset($request->student_id)){
            $pre_table->where('student_id', $request->student_id);
        }
        $table =  $pre_table->get();
        return view('frontend.teacher.report_page')->with(['table' => $table]);
    }

    public function event_edit_view($id){
        $table = TimeLog::find($id);
        $subjects = SubjectTaught::all();
        $students = AssignStudent::where('teacher_id', Auth::id())->get();
       return view('frontend.teacher.events_view')->with(['table' => $table, 'subjects' => $subjects, 'students' => $students]);
    }

    public function add_new_event(Request $request){//Create from report

        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'event_start' => 'required|date',
            'start_end_time' => 'required',
            'student_id' => 'required|numeric',
            'subject_id' => 'required|numeric',
            'motivational' => 'required|numeric|min:1|max:10',
            'understanding' => 'required|numeric|min:1|max:10',
            'hour_spend' => 'required|numeric'//Transport Hour
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $student = User::find($request->student_id);
            $subject = Subject::find($request->subject_id);

            $sp_date = explode(" - ", $request->start_end_time);

            $table = new TimeLog();
            $table->event_start = date('Y-m-d H:i:s', strtotime($request->event_start));
            $table->start_time = date('Y-m-d H:i:s', strtotime($sp_date[0]));
            $table->end_time = date('Y-m-d H:i:s', strtotime($sp_date[1]));
            $table->name = $request->name;
            $table->teacher_name = Auth::user()->name;
            $table->teacher_email = Auth::user()->email;
            $table->teacher_id  = Auth::id();
            $table->student_id = $request->student_id;
            $table->student_name = $student->name;
            $table->student_email = $student->email;
            $table->hour_spend = $request->hour_spend;
            $table->understanding = $request->understanding;
            $table->motivational = $request->motivational;
            $table->description = $request->description;
            $table->summery = $request->summery;
            $table->subject_id = $request->subject_id;
            $table->subject_name = $subject->name;
            $table->status = 'End';
            $table->save();
            $time_log_id = $table->id;

            if (isset($request->materials)){
                $materials = $request->materials;
                foreach ($materials as $i => $row){
                    $image = $request->file('materials')[$i];
                    $name = md5(date('Y-m-d H:i:s').$i);
                    $folder = '/uploads/materials/';
                    $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                    $this->uploadOne($image, $folder, 'public', $name);

                    $st_mat = new StudyMaterial();
                    $st_mat->file_name = $filePath;
                    $st_mat->time_log_id = $time_log_id;
                    $st_mat->save();
                }
            }
        }catch (\Exception $ex) {
            //dd($ex);
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.save'));

    }

    public function edit_events(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'event_start' => 'required|date',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'student_id' => 'required|numeric',
            'subject_id' => 'required|numeric',
            'motivational' => 'required|numeric|min:1|max:10',
            'understanding' => 'required|numeric|min:1|max:10',
            'hour_spend' => 'required|numeric'//Transport Hour
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $student = User::find($request->student_id);
            $subject = Subject::find($request->subject_id);

            $table = TimeLog::find($id);
            $table->event_start = date('Y-m-d H:i:s', strtotime($request->event_start));
            $table->start_time = date('Y-m-d H:i:s', strtotime($request->start_time));
            $table->end_time = date('Y-m-d H:i:s', strtotime($request->end_time));
            $table->name = $request->name;
            $table->student_id = $request->student_id;
            $table->student_name = $student->name;
            $table->student_email = $student->email;
            $table->hour_spend = $request->hour_spend;
            $table->understanding = $request->understanding;
            $table->motivational = $request->motivational;
            $table->description = $request->description;
            $table->summery = $request->summery;
            $table->subject_id = $request->subject_id;
            $table->subject_name = $subject->name;
            //$table->status = 'End';
            $table->save();
            $time_log_id = $table->id;

            if (isset($request->materials)){
                $materials = $request->materials;
                foreach ($materials as $i => $row){
                    $image = $request->file('materials')[$i];
                    $name = md5(date('Y-m-d H:i:s').$i);
                    $folder = '/uploads/materials/';
                    $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                    $this->uploadOne($image, $folder, 'public', $name);

                    $st_mat = new StudyMaterial();
                    $st_mat->file_name = $filePath;
                    $st_mat->time_log_id = $time_log_id;
                    $st_mat->save();
                }
            }
        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }

    public function delete_up_file($id){
        try{

            StudyMaterial::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'))->withInput();
        }

        return redirect()->back()->with(config('naz.del'));
    }

}
