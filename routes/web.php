<?php

$router->get('/', 'ProductController@index');
$router->get('/cart', 'CartController@index');
$router->post('/cart/add', 'CartController@add');
$router->post('/cart/remove', 'CartController@remove');
$router->get('/cart/checkout', 'CartController@checkout');

$router->post('/register', 'AuthController@register');
$router->post('/login/submit', 'AuthController@login');
$router->get('/me', 'AuthController@me');
$router->get('/user/login', 'AuthController@showLoginForm');
$router->get('/customer/register', 'AuthController@showRegisterForm');
$router->get('/restaurant/register', 'AuthController@showRegisterForm');

$router->get('/users/{id}', 'UserController@show');

$router->get('/dashboard', 'DashboardController@index');

$router->get('/restaurant/products', 'ProductController@index');        // Listar produtos do restaurante logado
$router->post('/restaurant/products', 'ProductController@store');       // Criar novo produto
$router->get('/restaurant/products/{id}', 'ProductController@show');    // Ver produto específico
// $router->put('/restaurant/products/{id}', 'ProductController@update');  // Editar produto
// $router->delete('/restaurant/products/{id}', 'ProductController@delete'); // Deletar produto