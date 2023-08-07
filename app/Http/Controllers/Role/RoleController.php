<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * Index Roles
     */
    public function index()
    {
        $roles = Role::all();
        return response()->json(['roles' => $roles]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'description' => 'nullable',
        ]);

        // Create the new role
        $newRole = new Role();
        $newRole->name = $request->input('name');
        $newRole->description = $request->input('description');
        $newRole->save();

        // Return a response indicating success
        return response()->json(['message' => 'Role created successfully']);
    }

    public function update(Request $request, $roleId)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'description' => 'required',
        ]);

        try {
            $role = Role::findOrFail($roleId);
            $role->name = $request->input('name');
            $role->description = $request->input('description');
            $role->save();

            return response()->json(['message' => 'Role updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update role'], 500);
        }
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }

}
