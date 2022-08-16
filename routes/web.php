<?php

use Illuminate\Support\Facades\Route;

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
if (!defined('OA_BASEURL_API')) {
    define('OA_BASEURL_API', url('api/v1'));
}
Route::get('/', function () {
    return view('welcome');
});
