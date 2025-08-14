<?php

namespace Sparkhizb;

/**
* =============================================
* Author: Ummu
* Website: https://ummukhairiyahyusna.com/
* App: Sparkhizb LIB
* Description: 
* =============================================
*/

$routes->group('ummu', function ($routes) {
    $routes->group('ref', ['namespace' => 'App\Controllers\References'], static function ($routes) {
        $routes->get('show', 'InquiriesController::show');
        $routes->get('show/(:num)', 'InquiriesController::show/$1');
        $routes->post('create', 'InquiriesController::create');
    });

    $routes->group('navbar', ['namespace' => 'App\Controllers\Api\Website'], static function ($routes) {
        $routes->get('show', 'NavbarController::show');
        $routes->get('show/(:num)', 'NavbarController::show/$1');
        $routes->post('create', 'NavbarController::create');
    });

    $routes->group('artikel', ['namespace' => 'App\Controllers\Api\Website'], static function ($routes) {
        $routes->get('show', 'ArtikelController::show');
        $routes->get('show/(:num)', 'ArtikelController::show/$1');
        $routes->post('create', 'ArtikelController::create');
        $routes->put('update/(:num)', 'ArtikelController::update/$1');
        $routes->delete('delete', 'ArtikelController::delete');
        $routes->delete('delete/(:num)', 'ArtikelController::delete/$1');
    });

    $routes->group('content', ['namespace' => 'App\Controllers\Api\Website'], static function ($routes) {
        $routes->get('show', 'ContentController::show');
        $routes->get('show/(:num)', 'ContentController::show/$1');
        $routes->post('create', 'ContentController::create');
        $routes->put('update/(:num)', 'ContentController::update/$1');
        $routes->delete('delete', 'ContentController::delete');
        $routes->delete('delete/(:num)', 'ContentController::delete/$1');
    });
});