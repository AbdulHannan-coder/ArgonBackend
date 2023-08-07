<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [

            //User Management
            ['name' => 'user_management', 'description' => 'User Management'],
            ['name' => 'user_management.create', 'description' => 'Create User', 'parent' => 'user_management'],
            ['name' => 'user_management.read', 'description' => 'Read User', 'parent' => 'user_management'],
            ['name' => 'user_management.update', 'description' => 'Update User', 'parent' => 'user_management'],
            ['name' => 'user_management.delete', 'description' => 'Delete User', 'parent' => 'user_management'],

            //Course Management
            ['name' => 'course_management', 'description' => 'Course Management'],
            ['name' => 'course_management.create', 'description' => 'Create Course', 'parent' => 'course_management'],
            ['name' => 'course_management.read', 'description' => 'Read Course', 'parent' => 'course_management'],
            ['name' => 'course_management.update', 'description' => 'Update Course', 'parent' => 'course_management'],
            ['name' => 'course_management.delete', 'description' => 'Delete Course', 'parent' => 'course_management'],

        ];

        foreach ($permissions as $permissionData) {
            $parentPermission = null;
            if (isset($permissionData['parent'])) {
                $parentPermission = Permission::where('name', $permissionData['parent'])->first();
            }

            $permission = Permission::create([
                'name' => $permissionData['name'],
                'description' => $permissionData['description'],
                'parent_id' => $parentPermission ? $parentPermission->id : null,
            ]);
        }
    }

}
