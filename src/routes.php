<?php

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

Route::group(['middleware' => ['web']], function () {
	Route::get('/mailpeek', ["uses"=>"\Misma\MailPeek\Controllers\MailPeekController@test"]);
	Route::get('/mailpeek/get_mbox', ["uses"=>"\Misma\MailPeek\Controllers\MailPeekController@get_mailbox_data"]);
	Route::get('/mailpeek/doempty', ["uses"=>"\Misma\MailPeek\Controllers\MailPeekController@empty_mailbox"]);
	Route::get('/mailpeek/message/{id?}', ["uses"=>"\Misma\MailPeek\Controllers\MailPeekController@display_message"]);	
	Route::get('/mailpeek/getfile/{mid?}/{fid?}', ["uses"=>"\Misma\MailPeek\Controllers\MailPeekController@download_file"]);
});
