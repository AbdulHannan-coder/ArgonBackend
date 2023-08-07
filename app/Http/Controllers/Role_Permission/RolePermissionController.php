<?php

namespace App\Http\Controllers\Role_Permission;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index(){
        $rolePermissions = RolePermission::with('role','permission')->get();
        return response()->json(['rolePermissions' => $rolePermissions], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'roleId' => 'required|exists:roles,id',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $roleId = $request->input('roleId');
        $permissions = $request->input('permissions');

        $role = Role::findOrFail($roleId);

        // Filter out the existing permissions from the input
        $newPermissions = collect($permissions)->filter(function ($permission) use ($role) {
            return !$role->permissions->contains('id', $permission);
        });

        if ($newPermissions->isEmpty()) {
            // Return a response indicating that no new permissions were added
            return response()->json(['message' => 'No new permissions were added'], 500);
        }

        // Sync the selected permissions
        $role->permissions()->sync($permissions);

        // Return a response indicating success
        return response()->json(['message' => 'Role and permissions saved successfully']);
    }

    public function destroy($roleId, $permissionId)
    {
        $role = Role::find($roleId);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }
        info(json_encode($role->permissions()));

        $role->permissions()->detach($permissionId);

        return response()->json(['message' => 'Role permission deleted successfully']);
    }
}
