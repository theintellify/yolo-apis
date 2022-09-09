<?php
Route::get('/otp', 'Admin\OTPController@showOtp')->name('otp');

Route::post('/verifyOtp', 'Admin\OTPController@verifyOtp')->name('verifyOtp');
Route::redirect('/', '/login');


Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});
 


Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth','otp']], function () {
    
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Enviroment
    Route::delete('enviroments/destroy', 'EnviromentController@massDestroy')->name('enviroments.massDestroy');
    Route::resource('enviroments', 'EnviromentController');

    // Yolo Api
    Route::get('/yolo-apis/try/{id}','YoloApiController@tryApi')->name('yolo-apis.try');
    Route::post('/yolo-apis/try','YoloApiController@tryCustomApi')->name('yolo-apis.try');
    Route::delete('yolo-apis/destroy', 'YoloApiController@massDestroy')->name('yolo-apis.massDestroy');
    Route::resource('yolo-apis', 'YoloApiController');

    Route::get('/encrypt','YoloEncryptController@index')->name('encrypt');
    Route::post('/encrypt','YoloEncryptController@executeEncryption')->name('execute.encryption');
    Route::post('/decrypt','YoloEncryptController@executeDecryption')->name('execute.decryption');


 
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth','otp']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});


