<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherProfile;
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
            dd($ex);
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.edit'));

    }

}
