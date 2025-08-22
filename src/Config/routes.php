<?php
/**
    * =============================================
    * Author:       Ummu Ky
    * Website:      https://openapi2.com/
    * Email :       
    * Create date:  
    * Description:  
    * =============================================
*/

$routes->group('openapi2', function($routes) {
    $routes->get('/', 'Openapi2Controller::index');
    // $routes->get('show', 'AccountsController::show');
    // $routes->get('show/(:num)', 'AccountsController::show/$1');
    // $routes->post('create', 'AccountsController::create');
    // $routes->post('import', 'AccountsController::import');
    // $routes->put('update/(:num)', 'AccountsController::update/$1');
    // $routes->delete('delete/(:num)', 'AccountsController::delete/$1');
    
    // $routes->delete('multiple_delete', 'AccountsController::multiple_delete');
    // $routes->get('show_roles', 'AccountsController::show_roles');
    // // $routes->put('update_by_profile', 'AccountsController::update_by_profile');
});
