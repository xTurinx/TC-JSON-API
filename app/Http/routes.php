<?php

// the next two lines will be removed after structure changes are done
require_once 'oldRoutes.php';
require_once 'deprecatedRoutes.php';
//

// ITEM BEGIN
Route::get('/item/get/{id}', "World\\ItemController@get");
Route::get('/item/find/{searchPattern}', "World\\ItemController@find");
// ITEM END
