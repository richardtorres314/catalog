<?php

Route::get('/', 'IndexController@index');
Route::post('/', 'IndexController@post');
Route::get('/jsonifr', 'IndexController@jsonifr');
Route::get('/pdfr', 'IndexController@pdfr');
Route::get('/xmlr', 'IndexController@xmlr');
Route::get('/page/{page?}', 'IndexController@page');
Route::get('/add', 'IndexController@addCourse');
Route::post('/add', 'IndexController@postCourse');