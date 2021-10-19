<?php

Route::group([
    'prefix' => 'menus',
    'middleware' => ['menu']
], function () {
    Route::module('menuItems');
});
Route::module('menus');

