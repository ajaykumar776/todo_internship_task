<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/add','Tcontroller@add');
Route::post('/update_task/{id}','Tcontroller@update_task');
Route::get('/list','Tcontroller@index');
Route::post('/task_delete/{id}','Tcontroller@delete_Task');

Route::post('/subtask_add/{id}','SubTController@add');
Route::post('/update_sub_task/{id}','SubTController@update_sub_task');
Route::post('/subtask_delete/{id}','SubTController@delete_subTask');