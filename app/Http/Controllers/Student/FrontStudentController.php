<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Purchase;
use App\Models\StudentProfile;
use App\Models\Subject;
use App\Models\TimeLog;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FrontStudentController extends Controller
{
    use UploadTrait;
    /**
     * View: Package
     */
    public function index(){
        $today = date('Y-m-d H:i:s');
        $table = Package::orderBy('price')->get()->chunk(4);
        return view('frontend.student.index')->with(['table' => $table]);
    }


    /**
     * View: Order List Page
     */
    public function orders(){
        $table = Purchase::orderBy('id', 'DESC')->where('user_id', Auth::id())->get();
        return view('frontend.student.order')->with(['table' => $table]);
    }


    /**
     * Save: Package Order
     */
    public function orders_save(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'coupon' => 'sometimes|nullable|max:191',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $package = Package::find($request->id);

            $table = new Purchase();
            $table->name = $package->name;
            $table->price = $package->price;
            $table->hours = $package->hours;
            $table->coupon = $request->coupon;
            $table->status = 'Pending';
            $table->package_id = $request->id;
            $table->user_id = Auth::id();
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(['message' => 'Order request successfully submitted!!',  'type' => 'success']);



    }

    /**
     * View: Profile
     */
    public function profile(){
        $table = User::find(Auth::id());
        return view('frontend.student.profile')->with(['table' => $table]);
    }


    public function update_profile(Request $request, $id){

       // dd($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'password' => 'sometimes|nullable|alpha_num|min:8|confirmed',
            'address' => 'required|string|max:191',
            'zip' => 'required|string|max:191',
            'city' => 'required|string|max:191',
            'contact' => 'required|string|min:10|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = User::find($id);
            $table->name = $request->name;
            $table->user_type = 'Student';
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

            StudentProfile::updateOrCreate(
                ['user_id' => $user_id],
                [
                    'contact' => $request->contact,
                    'address' => $request->address,
                    'zip' => $request->zip,
                    'city' => $request->city
                ]
            );

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }

    public function dashboard(){
        $table = User::find(Auth::id());
        return view('frontend.student.dashboard')->with(['table' => $table]);
    }


    public function overview($id){
        $table = TimeLog::find($id);
        return view('frontend.student.overview')->with(['table' => $table]);
    }


    public function events(){
        $table = TimeLog::orderBy('Id', 'DESC')->where('student_id', Auth::id())->get();
        return view('frontend.student.events')->with(['table' => $table]);
    }

    public function all_events(){
        $table = TimeLog::where('student_id', Auth::id())->get();

        $data = [];
        foreach ($table as $row){
            $rowData['url'] = route('student.events-overview', ['id' => $row->id]);
            $rowData['title'] = $row->teacher_name;
            $rowData['start'] = $row->event_start;
            $rowData['description'] = $row->description;
            $rowData['end'] = $row->event_start;
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

    public function reports(){
        $subject = Subject::orderBy('name')->get();
        $teacher = TimeLog::orderBy('teacher_name')->groupBy('teacher_id')->having('student_id', Auth::id())->get();
        return view('frontend.student.reports')->with(['subject' => $subject, 'teacher' => $teacher]);
    }

    public function show_reports(Request $request){
        $sp_date = explode(" - ", $request->date_range);

        $dates = [];
        foreach ($sp_date as $row){
            $dates[] = date('Y-m-d', strtotime(str_replace("/","-", $row)));
        }

        $pre_table = TimeLog::where('student_id', Auth::id())->orderBy('id', 'DESC' )->whereBetween('created_at', $dates);
        if(isset($request->subject_id)){
            $pre_table->where('subject_id', $request->subject_id);
        }
        if(isset($request->teacher_id)){
            $pre_table->where('teacher_id', $request->teacher_id);
        }
        $table =  $pre_table->get();
        return view('frontend.student.report_page')->with(['table' => $table]);
    }



}
