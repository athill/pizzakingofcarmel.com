<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
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

Route::get('/pictures', function (Request $request) {
    $path = storage_path() . '/app/public/pictures.json';
	return json_decode(file_get_contents($path), true); 
});	
