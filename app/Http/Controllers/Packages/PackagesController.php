<?php

namespace App\Http\Controllers\Packages;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackagesController extends Controller
{

    public function index()
    {
        $table = Package::orderBy('id', 'DESC')->get();
        return view('packages.packages')->with(['table' => $table]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'hours' => 'required|numeric',
            'price' => 'required|numeric',
            'expire' => 'sometimes|nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new Package();
            $table->name = $request->name;
            $table->hours = $request->hours;
            $table->price = $request->price;
            if (isset($request->expire)){
                $table->expire = date('Y-m-d H:i:s', strtotime($request->expire));
            }
            if (isset($request->isCoupon)){
                $table->isCoupon = 1;
            }
            $table->description = $request->description;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'hours' => 'required|numeric',
            'price' => 'required|numeric',
            'expire' => 'sometimes|nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = Package::find($id);
            $table->name = $request->name;
            $table->hours = $request->hours;
            $table->price = $request->price;
            if (isset($request->expire)){
                $table->expire = date('Y-m-d H:i:s', strtotime($request->expire));
            }
            if (isset($request->isCoupon)){
                $table->isCoupon = 1;
            }else{
                $table->isCoupon = 0;
            }
            $table->description = $request->description;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }


    public function destroy($id)
    {
        try{
            Package::destroy($id);
        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.db_error'));
        }
        return redirect()->back()->with(config('naz.del'));
    }
}
