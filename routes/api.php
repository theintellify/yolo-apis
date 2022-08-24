<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Admin'], function () {


	Route::get('getenviromentUrl/{id}','EnviromentController@getenviromentUrl')->name('getenviromentUrl');
});

