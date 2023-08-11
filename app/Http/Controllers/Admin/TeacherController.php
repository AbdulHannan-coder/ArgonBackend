<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = Teacher::all();
        return response()->json(['teacher' => $teacher], 201);

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
            'name' => 'required|string',
            'email' => 'required|email|unique:teachers', // Assuming the unique rule should be on the teachers table
            'department' => 'required',
            'courses' => 'required',
            'contact_no' => 'required',
            'image' => 'required',
            'designation' => 'required', // Make sure this corresponds to the name attribute in the <select> tag
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $teacher = Teacher::create([
            'name' => $request->name,
            'email' => $request->email,
            'department' => $request->department,
            'courses' => json_encode($request->courses), // Convert array to JSON
            'contact_no' => $request->contact_no,
            'image' => $request->image,
        ]);

        // Assuming 'designation' is the name attribute of the <select> tag
        $designationIds = $request->input('designation');
        $teacher->designations()->attach($designationIds);

        return response()->json(['message' => 'Registration successful'], 201);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
