<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\StudyMaterial;
use App\Models\Subject;
use App\Models\TeacherProfile;
use App\Models\TimeLog;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FrontTeacherController extends Controller
{
    use UploadTrait;
    public function index(){
        return view('frontend.teacher.index');
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
        return view('frontend.teacher.profile')->with(['table' => $table]);
    }

    public function update_profile(Request $request, $id){
        //dd($request->all());

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
            'gender' => 'required|in:Male,Female,Other'
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

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.edit'));

    }


    public function reports(){
        return view('frontend.teacher.reports');
    }

    public function events(){
        $subjects = Subject::orderBy('name')->get();
        $students = User::orderBy('name')->where('user_type', 'Student')->get();
        $table = TimeLog::orderBy('Id', 'DESC')->where('teacher_id', Auth::id())->get();
        return view('frontend.teacher.events')->with(['subjects' => $subjects, 'students' => $students, 'table' => $table]);
    }

    public function event_save(Request $request){
        //dd($request->all());

        $validator = Validator::make($request->all(), [
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
       // dd($request->all());

        $validator = Validator::make($request->all(), [
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
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'motivational' => 'required|numeric|min:1|max:10',
            'understanding' => 'required|numeric|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = TimeLog::find($id);
            $table->end_time = date('Y-m-d H:i:s');
            $table->understanding = $request->understanding;
            $table->motivational = $request->motivational;
            $table->description = $request->description;
            $table->summery = $request->summery;
            $table->status = 'End';
            $table->save();

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

}
