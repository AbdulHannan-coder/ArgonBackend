<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return response()->json(['permissions' => $permissions], 200);
    }

    public function parentPermission()
    {
        $parentPermissions = Permission::whereNull('parent_id')->get();
        return response()->json(['parentPermissions' => $parentPermissions]);
    }

    public function childPermission()
    {
        $childrenPermissions = Permission::whereNotNull('parent_id')->get();
        return response()->json(['childrenPermissions' => $childrenPermissions]);
    }

    public function storeParentPermission(Request $request){
        $parentPermission = new Permission();
        $parentPermission->name = $request->input('name');
        $parentPermission->description = $request->input('description');
        $parentPermission->parent_id = null; // Set parent_id as null for parent permission
        $parentPermission->save();

        return response()->json(['message' => 'Parent permission created successfully'], 201);
    }

    public function storeChildPermission(Request $request){
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'parent_id' => 'required|exists:permissions,id',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 400);
        }

        // Create the child permission
        $childPermission = new Permission();
        $childPermission->name = $request->input('name');
        $childPermission->description = $request->input('description');
        $childPermission->parent_id = $request->input('parent_id');
        $childPermission->save();

        // Return success response
        return response()->json([
            'message' => 'Child permission created successfully.',
            'childPermission' => $childPermission,
        ], 201);

    }

    public function updateParentPermission(Request $request, $parentId)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        try {
            $parentPermission = Permission::findOrFail($parentId);
            $parentPermission->name = $request->input('name');
            $parentPermission->description = $request->input('description');
            $parentPermission->save();

            return response()->json(['message' => 'Parent permission updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update parent permission'], 500);
        }
    }

    public function deleteParentPermission($parentId)
    {
        try {
            $parentPermission = Permission::findOrFail($parentId);

            // Check if there are any associated child permissions
            $hasChildren = Permission::where('parent_id', $parentId)->exists();
            if ($hasChildren) {
                return response()->json(['message' => 'Cannot delete parent permission. It has associated child permissions'], 400);
            }

            $parentPermission->delete();

            return response()->json(['message' => 'Parent permission deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete parent permission'], 500);
        }
    }

    public function updateChildPermission(Request $request, $childId)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'parent_id' => 'required'
        ]);

        try {
            $childId = Permission::findOrFail($childId);
            $childId->name = $request->input('name');
            $childId->description = $request->input('description');
            $childId->parent_id = $request->input('parent_id');
            $childId->save();

            return response()->json(['message' => 'Child permission updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update child permission'], 500);
        }
    }

    public function deleteChildPermission($childId)
    {
        try {
            $childPermission = Permission::findOrFail($childId);
            $childPermission->delete();

            return response()->json(['message' => 'Child permission deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete child permission'], 500);
        }
    }
}
