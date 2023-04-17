<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

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
Route::get('/', function () {
    return view('welcome');
});
// Route::get('/', [StudentController::class, 'index']);
Route::post('/store-input-fields', [StudentController::class, 'store']);
Route::post('update', [StudentController::class, 'update']);
Route::get('/view', [StudentController::class, 'getData']);
Route::get('/redirect', [StudentController::class, 'redirect']);
Route::get('/add',[StudentController::class,'add']);
Route::get('/viewsubject',[StudentController::class,'viewsubject']);
Route::get('/delete',[StudentController::class,'delete']);
Route::get('query',[StudentController::class,'query']);

// Route::get('add/{id}/{studentid}',[StudentController::class,'add']);
