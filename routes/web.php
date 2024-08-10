<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\SearchController;
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


Route::get('/operation/', [OperationController::class,'index'])->middleware('auth');


Route::post('/admin/operation/create', [OperationController::class,'save_title'])->middleware('admin');

Route::get('/admin/operation/create', function () {
    return Inertia::render('Admin/Operation/Create');
})->middleware('admin')->name('admin.operation.create');

Route::get('/operation/{id}/show', [OperationController::class,'show'])->middleware('auth')->name('operation.show');





Route::get('/admin/users', [UserController::class,'all_user'])->middleware('admin');

Route::get('/admin/menu/create', [MenuController::class,'create'])->middleware('admin');
Route::post('/admin/menu/save', [MenuController::class,'save'])->middleware('admin');
Route::get('/admin/menu/', [MenuController::class,'index'])->middleware('admin');
Route::post('/admin/menu/{id}/', [MenuController::class,'update'])->middleware('admin');
Route::delete('/admin/menu/{id}/', [MenuController::class,'destroy'])->middleware('admin');


Route::post('/admin/item/save', [ItemController::class,'save'])->middleware('admin');

 

Route::get('/admin/report/create', function () {
    return Inertia::render('Admin/Report/Create');
})->middleware('admin')->name('admin.report.create');



Route::get('/report/', [ItemController::class,'index'])->middleware('auth');
Route::get('/admin/report/', [ItemController::class,'index'])->middleware('auth');


Route::get('/admin/report/show', function () {
    return Inertia::render('Admin/Report/Show');
})->middleware('admin');


Route::put('/admin/report/{id}/adder', [ItemController::class,'update_adder'])->middleware('auth','adder');
Route::put('/admin/report/{id}/verifier', [ItemController::class,'update_verifier'])->middleware('auth','verifier');


Route::get('/search/user/name', [UserController::class,'search_name']);

Route::post('/search/select/{user_search_id}',[SearchController::class,'select_user'] );
Route::get('/search/frequest',[SearchController::class,'frequest_search'] );


Route::get('/user/upload',[FileController::class,'upload_form']);
Route::post('/user/upload',[FileController::class,'store']);

Route::get('/login', function () {
    return Inertia::render('Login');
})->name('login');
Route::get('/admin/login', function () {
    return Inertia::render('Login');
});
 
Route::post('/login', [AuthController::class,'login_check']);
Route::get('/logout', [AuthController::class,'logout']);
 
