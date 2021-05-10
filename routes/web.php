<?php

Route::get('/', 'BlogViewController@index');
Route::get('blogs/{blog}', 'BlogViewController@show')->name('blog.show');
Route::get('signup','SignUpController@index')->name('signup');
Route::post('signup','SignUpController@store')->name('signup.post');