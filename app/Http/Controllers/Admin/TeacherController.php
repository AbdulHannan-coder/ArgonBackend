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
        $teachers = Teacher::with('designations','departments')->get();
        return response()->json(['teacher' => $teachers], 201);

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
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:teachers',
            'department' => 'required|array',
            'designation' => 'required|array',
            'courses' => 'required',
            'contact_no' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $teacher = Teacher::create([
                'name' => $request->name,
                'email' => $request->email,
                'courses' => json_encode($request->courses),
                'contact_no' => $request->contact_no,
                'image' => $request->image,
            ]);

            $teacher->departments()->attach($request->department);
            $teacher->designations()->attach($request->designation);

            return response()->json(['message' => 'Registration successful'], 201);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['error' => 'An error occurred while saving data'], 500);
        }
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
    public function update(Request $request, $id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
    
            $teacher->update([
                'name' => $request->input('name', $teacher->name),
                'image' => $request->input('image', $teacher->image),
                'contact_no' => $request->input('contact_no', $teacher->contact_no),
                'department' => $request->input('department', $teacher->department),
            ]);
    
            if ($request->has('designation')) {
                $designationId = $request->input('designation');
                $teacher->designations()->sync([$designationId]);
            }
    
            return response()->json(['message' => 'Teacher updated successfully']);
        } catch (\Exception $e) {
            // \Log::error('Update Teacher Exception: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update teacher'], 500);
        }
    }     
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);

            $teacher->designations()->detach();

            $teacher->delete();

            return response()->json(['message' => 'Teacher deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete teacher'], 500);
        }
    }


}
