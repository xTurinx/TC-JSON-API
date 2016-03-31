<?php

/**
 * This file is temporary. 
 * It contains the old API routes which are using controller actions now
 **/

Route::get('/search/item', "World\\ItemController@oldSearchFunction");
Route::get('/item/template/{id}', "World\\ItemController@get");
