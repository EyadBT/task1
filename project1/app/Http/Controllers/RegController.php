<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class RegController extends Controller
{
    function create(Request $request){
        $request->validate([
            'name' => 'required | string',
            'email' => 'required | email',
            'phone_number' => 'required | string',
            'birth_date' => 'required | date',
            'id_image' => 'required | file | mimes:png,jpg,jpeg'
        ]);
        $pic_name = time().'.'.uniqid().'.'.$request->id_image->extension();
        $img =  $request->id_image->storeAs('student_id', $pic_name, 'public');
        $path = URL::asset('storage/student_id/'.$pic_name);
        Student::create([
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'imgURL' => $path,
            'status' => 0
        ]);
        return response()->json([
            'respone' => 'OK'
        ]);
    }

    function update(Request $request){
        $request->validate([
            'id' => 'required | integer',
            'status' => 'required | integer | between:1,2'
        ]);
        DB::table('students')->where('id', $request->id)->update([
            'status' => $request->status
        ]);
        return response()->json([
            'response' => 'OK'
        ]);
    }

    function list(Request $request){
        $request->validate([
            'status' => 'required | integer | between:0,2'
        ]);
        return response()->json([
            'response' => 'OK',
            'data' => DB::table('students')->select(
                'id', 'name',
                'phone_number', 'email',
                'birth_date', 'imgURL'
            )->where('status', $request->status)->get()
            ]);
    }
}
