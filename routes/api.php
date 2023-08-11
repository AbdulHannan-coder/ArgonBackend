<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Role_Permission\RolePermissionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);

//Role
Route::get('/roles', [RoleController::class, 'index']);
Route::post('/roles/store', [RoleController::class, 'store']);
Route::put('/role/{roleId}', [RoleController::class,'update']);
Route::delete('role/{id}', [RoleController::class, 'destroy']);

//Permission
Route::get('/permissions', [PermissionController::class,'index']);

//Permission->Parent
Route::get('/permissions/parent-permissions', [PermissionController::class,'parentPermission']);
Route::post('/permissions/store/parent-permission', [PermissionController::class,'storeParentPermission']);
Route::put('/permissions/update-parent/{parentId}', [PermissionController::class,'updateParentPermission']);
Route::delete('/permissions/delete-parent/{parentId}', [PermissionController::class,'deleteParentPermission']);

//Permission->Child
Route::get('/permissions/children-permissions', [PermissionController::class,'childPermission']);
Route::post('/permissions/store/child-permission', [PermissionController::class,'storeChildPermission']);
Route::put('/permissions/update-child/{childId}', [PermissionController::class,'updateChildPermission']);
Route::delete('/permissions/delete-child/{chilId}', [PermissionController::class,'deleteChildPermission']);

//Role-Permission
Route::get('/roles-permissions', [RolePermissionController::class,'index']);
Route::post('/save-role-permissions', [RolePermissionController::class,'store']);

Route::delete('/roles-permissions/{roleId}/{permissionId}', [RolePermissionController::class, 'destroy']);

//Teacher

Route::post('/admin/teacher/store', [TeacherController::class, 'store']);
Route::get('/admin/teachers',[TeacherController::class,'index']);


//Course

Route::post('/admin/course/store', [CourseController::class, 'store']);
Route::get('/admin/courses',[CourseController::class,'index']);

//Department

Route::post('/admin/department/store', [DepartmentController::class, 'store']);
Route::get('/admin/departments',[DepartmentController::class,'index']);

//Designation

Route::get('/admin/designations',[DesignationController::class,'index']);
