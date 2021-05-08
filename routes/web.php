<?php

Route::get('/', 'BlogViewController@index');
Route::get('blogs/{blog}', 'BlogViewController@show')->name('blog.show');