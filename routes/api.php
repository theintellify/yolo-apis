<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomApiController;
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

Route::prefix('v1')->group(function () {
	/*Route::post('register', [AuthController::class, 'register']);
	Route::post('login', [AuthController::class, 'login']);	
	Route::get('getlist', [AuthController::class, 'getlist']);*/

	Route::get('create', [CustomApiController::class, 'createApi'])->name('createapi');
	
	Route::post('storeCustomApi', [CustomApiController::class, 'storeCustomApi'])->name('store.customapi');

	Route::post('userservice', [AuthController::class, 'userService']);
	Route::post('userprofileservice', [AuthController::class, 'UserProfileService']);
	Route::post('usersnotification', [AuthController::class, 'usersNotification']);
	Route::post('updateuserfcmtoken', [AuthController::class, 'updateUserFcmToken']);
	Route::post('insurancetype', [AuthController::class, 'insuranceType']);
	Route::post('insurancev2', [AuthController::class, 'insurancev2']);
	Route::post('saveinsurancev2', [AuthController::class, 'saveInsurancev2']);
	Route::post('saveassetmapping', [AuthController::class, 'saveAssetMapping']);
	Route::post('getuserinsurance', [AuthController::class, 'getUserInsurance']);
	Route::post('userinsurancedetail', [AuthController::class, 'userInsuranceDetail']);
	Route::post('admininsurance', [AuthController::class, 'adminInsurance']);
	Route::post('getuserinsuranceabstract', [AuthController::class, 'userInsuranceAbstract']);
	Route::post('getuserinsurancecoverages', [AuthController::class,'getUserInsuranceCoverage']);
	Route::post('getassetvaults', [AuthController::class, 'getAssetVaults']);
	Route::post('deleteassetvaults', [AuthController::class, 'deleteAssetVaults']);
	Route::post('insert-update-user-insurance-coverages', [AuthController::class, 'insertUpdateUserInsuranceCoverages']);

	Route::post('update-user-insurance-abstract', [AuthController::class, 'updateUserInsuranceAbstract']);

	Route::post('insert-user-insurance-abstract', [AuthController::class, 'insertUserInsuranceAbstract']);

	Route::post('update-asset-vaults', [AuthController::class,'updateAssetVaults']);
	Route::post('getcontacts', [AuthController::class,'getContacts']);
	Route::post('updatecontacts', [AuthController::class,'updateContacts']);
	Route::post('datamanager', [AuthController::class,'dataManager']);

	

	
	

});

 

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
