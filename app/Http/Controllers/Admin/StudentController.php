<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return response()->json(['students' => $students], 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'department_id' => 'required',
            'course_id' => 'required',
            'age' => 'required',
            'phone_no' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'semester' => 'required',
         ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $course = Student::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'course_id' => $request->course_id,
            'age' => $request->age,
            'phone_no' => $request->phone_no,
            'gender' => $request->gender,
            'address' => $request->address,
            'semester' => $request->semester,
        ]);
        

        return response()->json(['message' => 'Student created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required',
            'department_id' => 'required',
            'course_id' => 'required',
            'age' => 'required',
            'phone_no' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'semester' => 'required',
        ]);

        $student->update($validatedData);
        

        return response()->json(['message' => 'Student information updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
    
    
        $student->delete();
    
        return response()->json(['message' => 'Student deleted successfully']);
    }
}
