<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\JobController;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    echo "This is Home Page";
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::get('/category/all', [CategoryController::class, 'index'])->name('all.categories');
Route::post('/category/add', [CategoryController::class, 'store'])->name('store.category');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit']);
Route::post('/category/update/{id}', [CategoryController::class, 'update']);
Route::get('/delete/category/{id}', [CategoryController::class, 'delete']);
Route::get('/category/restore/{id}', [CategoryController::class, 'restore']);
Route::get('/category/forceDelete/{id}', [CategoryController::class, 'fullDelete']);

Route::get('/brand/all', [BrandController::class, 'index'])->name('all.brands');
Route::post('/brand/add', [BrandController::class, 'store'])->name('store.brand');
Route::get('/brand/edit/{id}', [BrandController::class, 'edit']);
Route::post('/brand/update/{id}', [BrandController::class, 'update']);
Route::get('/delete/brand/{id}', [BrandController::class, 'delete']);

Route::get('/multipictures/all', [BrandController::class, 'multiPicture'])->name('all.multipictures');
Route::post('/multipictures/add', [BrandController::class, 'storeMultiplePictures'])->name('store.multipictures');

Route::get('/jobs', [JobController::class, 'index'])->name('jobs');
Route::post('category/job', [JobController::class, 'category'])->name('category/job');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // $users = DB::table('users')->get();
    // $users = User::all();
    return view('admin.index');
})->name('dashboard');
Route::get('/user/logout', [BrandController::class, 'logout'])->name('user.logout');
