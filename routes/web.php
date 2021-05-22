<?php

Route::get('/', 'BlogViewController@index');
Route::get('blogs/{blog}', 'BlogViewController@show')->name('blog.show');
Route::get('signup','SignUpController@index')->name('signup');
Route::post('signup','SignUpController@store')->name('signup.post');
Route::get('mypage/login','Mypage\UserLoginController@index')->name('login');
Route::post('mypage/login','Mypage\UserLoginController@login');

Route::middleware('auth')->group(function () {
  Route::get('mypage/blogs', 'Mypage\BlogMypageController@index');
  Route::get('mypage/blogs/create', 'Mypage\BlogMypageController@create');
  Route::get('mypage/blogs/edit/{blog}', 'Mypage\BlogMypageController@edit');
  Route::post('mypage/blogs/create', 'Mypage\BlogMypageController@store');
  Route::post('mypage/logout', 'Mypage\UserLoginController@logout');
});