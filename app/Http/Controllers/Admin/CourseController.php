<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return response()->json(['courses' => $courses], 201);
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
            'title' => 'required|string',
            'code' => 'required',
            'department' => 'required',
            'credit_hours' => 'required|integer',
            'semester' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $course = Course::create([
            'title' => $request->title,
            'code' => $request->code,
            'department' => $request->department,
            'credit_hours' => $request->credit_hours,
            'semester' => $request->semester,
        ]);
        

        return response()->json(['message' => 'Course add successfully'], 201);
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
        $course = Course::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'string',
            'code' => 'string',
            'department' => 'string',
            'credit_hours' => 'numeric',
            'semester' => 'string',
        ]);

        $course->update($validatedData);

        return response()->json(['message' => 'Course information updated successfully']);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
    
    
        $course->delete();
    
        return response()->json(['message' => 'Course deleted successfully']);
    }
}
