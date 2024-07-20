<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;
use App\Models\Blog;
use App\Models\Menu;
use App\Models\Mobl;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Home');
});
Route::get('/admin', function () {
    return Inertia::render('Admin/Index');
})->middleware('admin');


Route::get('/admin/operation/', [OperationController::class,'index'])->middleware('admin');
Route::post('/admin/operation/create', [OperationController::class,'save_title'])->middleware('admin');

Route::get('/admin/operation/create', function () {
    return Inertia::render('Admin/Operation/Create');
})->middleware('admin')->name('admin.operation.create');

Route::get('/admin/operation/{id}/edit', function ($id) {
    $operation = Operation::find($id) ;
    $menus = Menu::where('operation_id',$id)->OrderBy('id')->get();
    return Inertia::render('Admin/Operation/Edit',['operation'=>$operation,'menus'=>$menus]);
})->middleware('admin')->name('admin.operation.edit');





Route::get('/admin/users', function () {
    return Inertia::render('Admin/Users/Index');
})->middleware('admin');

Route::get('/admin/menu/create', [MenuController::class,'create'])->middleware('admin');
Route::post('/admin/menu/save', [MenuController::class,'save'])->middleware('admin');
Route::get('/admin/menu/', [MenuController::class,'index'])->middleware('admin');
Route::post('/admin/menu/{id}/', [MenuController::class,'update'])->middleware('admin');
Route::delete('/admin/menu/{id}/', [MenuController::class,'destroy'])->middleware('admin');
 

Route::get('/admin/report/create', function () {
    return Inertia::render('Admin/Report/Create');
})->middleware('admin')->name('admin.operation.create');

Route::get('/admin/report/show', function () {
    return Inertia::render('Admin/Report/Show');
})->middleware('admin');


Route::get('/search/user/name', [UserController::class,'search_name']);


Route::get('/user/upload',[FileController::class,'upload_form']);
Route::post('/user/upload',[FileController::class,'store']);

Route::get('/login', function () {
    return Inertia::render('Login');
});
Route::get('/admin/login', function () {
    return Inertia::render('Login');
});
 
Route::post('/login', [AuthController::class,'login_check']);
Route::get('/logout', [AuthController::class,'logout']);
 
