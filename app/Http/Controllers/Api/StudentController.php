<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try{



            //
        }catch (\Exception $ex) {
            return response()->json([config('naz.db_error')], 400);
        }

        return response()->json(config('naz.save'));

    }
}
