<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\Payment;
use App\Models\TeacherProfile;
use App\Models\TimeLog;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TeacherController extends Controller
{

    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = User::orderBy('id', 'DESC')->where('user_type', 'Teacher')->get();
        $students = User::orderBy('name')->where('user_type', 'Student')->get();
        return view('teachers.teachers')->with(['table' => $table, 'students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users',
            'password' => 'required|alpha_num|min:8|confirmed',
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

            $table = new User();
            $table->name = $request->name;
            $table->email = $request->email;
            $table->user_type = 'Teacher';
            $table->password = bcrypt($request->password);

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

            TeacherProfile::updateOrCreate(
                ['user_id' => $user_id],
                [
                    'dob' => date('Y-m-d',  strtotime($request->dob)),
                    'contact' => $request->contact,
                    'address' => $request->address,
                    'zip' => $request->zip,
                    'city' => $request->city,
                    'grade' => $request->grade,
                    'working_hour' => $request->working_hour,
                    'gender' => $request->gender
                ]
            );

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $table = User::find($id);
        return view('teachers.show')->with(['table' => $table]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $table = TimeLog::find($id);
        return view('frontend.teacher.overview')->with(['table' => $table]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|min:4|max:191|unique:users,email,'.$id.',id',
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
            $table->email = $request->email;
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

            TeacherProfile::updateOrCreate(
                ['user_id' => $id],
                [
                    'dob' => date('Y-m-d',  strtotime($request->dob)),
                    'contact' => $request->contact,
                    'address' => $request->address,
                    'zip' => $request->zip,
                    'city' => $request->city,
                    'grade' => $request->grade,
                    'working_hour' => $request->working_hour,
                    'gender' => $request->gender
                ]
            );

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.edit'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->back()->with(config('naz.del'));
    }

    public function payments(Request $request, $id){
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'paid_hour' => 'required|numeric',
            'is_travel' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new Payment();
            $table->amount = $request->amount;
            $table->paid_hour = $request->paid_hour;
            $table->description = $request->description;
            $table->is_travel = $request->is_travel;
            $table->user_id = $id;
            $table->save();

        }catch (\Exception $ex) {
            //dd($ex);
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }

    public function pay_update(Request $request, $id){
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'paid_hour' => 'required|numeric',
            'is_travel' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = Payment::find($id);
            $table->amount = $request->amount;
            $table->paid_hour = $request->paid_hour;
            $table->description = $request->description;
            $table->is_travel = $request->is_travel;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }

    public function del_payment($id){
        Payment::destroy($id);
        return redirect()->back()->with(config('naz.del'));
    }

    public function assign_student(Request $request, $id){
        //dd($request->all());

        try{
            AssignStudent::where('teacher_id', $id)->delete();

            if(isset($request->assign)){
                $assign = $request->assign;
                foreach ($assign as $row){
                    $table = new AssignStudent();
                    $table->teacher_id = $id;
                    $table->student_id = $row;
                    $table->save();
                }
            }

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.edit'));

    }
}
