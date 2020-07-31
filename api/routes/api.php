<?php

use Illuminate\Routing\Router;

$g = function ($prefix, $routes, ...$args) {
    Route::group(array_merge(compact('prefix'), $args), $routes);
};

$g('auth', function (Router $r) {
    $r->get('me', 'AuthController@me');
    $r->get('faceit', 'AuthController@faceit');
});

$g('hub', function (Router $r) {
    $r->get('/', 'HubController@index');
});

$g('store', function (Router $r) {
    $r->get('/', 'StoreController@index');
});

$g('callback', function (Router $r) {
    $r->post('faceit', 'CallbackController@faceit');
});
