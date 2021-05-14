<?php

Route::get('/', 'BlogViewController@index');
Route::get('blogs/{blog}', 'BlogViewController@show')->name('blog.show');
Route::get('signup','SignUpController@index')->name('signup');
Route::post('signup','SignUpController@store')->name('signup.post');
Route::get('mypage/login','Mypage\UserLoginController@index')->name('login');
Route::post('mypage/login','Mypage\UserLoginController@login');

Route::middleware('auth')->group(function () {
  Route::get('mypage/blogs', 'Mypage\BlogMypageController@index');
  Route::post('mypage/logout', 'Mypage\UserLoginController@logout');
});