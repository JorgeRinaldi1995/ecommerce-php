<?php

$router->get('/', 'ProductController@index');
$router->get('/cart', 'CartController@index');
$router->post('/cart/add', 'CartController@add');
$router->post('/cart/remove', 'CartController@remove');
$router->get('/cart/checkout', 'CartController@checkout');

$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');
$router->get('/me', 'AuthController@me');
