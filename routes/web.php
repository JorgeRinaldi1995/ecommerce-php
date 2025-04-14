<?php

$router->get('/', 'ProductController@index');
$router->get('/cart', 'CartController@index');
$router->post('/cart/add', 'CartController@add');
$router->post('/cart/remove', 'CartController@remove');
$router->get('/cart/checkout', 'CartController@checkout');

