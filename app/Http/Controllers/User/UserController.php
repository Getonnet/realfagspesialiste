<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = User::orderBy('id', 'DESC')->where('user_type', 'Admin')->get();
        $roles = Role::orderBy('name')->get();
        return view('users.users')->with(['table' => $table, 'roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:191',
            'email' => 'required|string|email|min:4|max:191|unique:users,email',
            'password' => 'required|string|min:8|max:191|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new User();
            $table->name = $request->name;
            $table->email = $request->email;
            $table->user_type = 'Admin';
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

            $table->assignRole($request->role_id);


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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:191',
            'email' => 'required|string|email|min:4|max:191|unique:users,email,'.$id.',id',
            'password' => 'sometimes|nullable|min:8|max:191|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = User::find($id);
            $table->name = $request->name;
            $table->email = $request->email;
            $table->user_type = 'Admin';

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

            $table->syncRoles($request->role_id);

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
}
