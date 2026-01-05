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

$routes->group('spark', ['namespace' => 'Sparkhizb\Controllers'], static function($routes) {
    $routes->group('syshab', ['namespace' => 'Sparkhizb\Controllers\Syshab'], static function($routes) {
        $routes->group('mcp_report', function($routes) {
            $routes->group('dashboard', function ($routes) {
                // $routes->get('/', 'DashboardController::index');
                $routes->get('show_siteProject', 'McpReport\DashboardController::show_siteProject');
                $routes->get('show_summary_ob', 'McpReport\DashboardController::show_summary_ob');
                $routes->get('show_plan_ob_daily', 'McpReport\DashboardController::show_plan_ob_daily');
                $routes->get('show_summary_ob_daily', 'McpReport\DashboardController::show_summary_ob_daily');
                $routes->get('show_summary_coalore_daily', 'McpReport\DashboardController::show_summary_coalore_daily');
                $routes->get('show_hauling_daily', 'McpReport\DashboardController::show_hauling_daily');
                $routes->get('show_V_MCC_TR_HPRODUCTIONB_CL', 'McpReport\DashboardController::show_V_MCC_TR_HPRODUCTIONB_CL');
            });

            $routes->group('ob', function ($routes) {
                $routes->group('hourly_monitoring', ['namespace' => 'App\Controllers\Admin\McpReport\OB'], static function ($routes) {
                    $routes->get('/', 'HourlyMonitoringController::index');
                    $routes->get('show', 'HourlyMonitoringController::show_hourly_ob_monitoring');
                    $routes->get('show_all', 'HourlyMonitoringController::show_hourly_ob_monitoring_all');
                    $routes->get('show_modif', 'HourlyMonitoringController::modif_hourly_ob_monitoring');
                    $routes->get('show_modif/(:any)', 'HourlyMonitoringController::modif_hourly_ob_monitoring/$1');
                });

                // $routes->group('daily-monitoring', ['namespace' => 'App\Controllers\Admin\McpReport\OB'], static function ($routes) {
                //     $routes->get('/', 'HourlyMonitoringController::report_daily_production');
                //     $routes->get('pit/search', 'HourlyMonitoringController::search');
                //     $routes->get('equipment/search', 'HourlyMonitoringController::equipment_search');
                //     $routes->get('fuel-info', 'HourlyMonitoringController::fuel_info');
                //     $routes->get('plan-target', 'HourlyMonitoringController::plan_target');
                //     $routes->get('plan-target/month-year-date', 'HourlyMonitoringController::month_year_date');
                // });
            });

            $routes->group('daily_monitoring', function($routes) {
                $routes->group('production_result', function($routes) {
                    // $routes->get('/', 'McpReport\DailyMonitoring\ProductionResultController::index');
                    $routes->get('show_all', 'McpReport\DailyMonitoring\ProductionResultController::show_all');
                    $routes->get('show_ob', 'McpReport\DailyMonitoring\ProductionResultController::show_ob');
                    $routes->get('show_coalhauling_perlocation', 'McpReport\DailyMonitoring\ProductionResultController::show_coalhauling_perlocation');
                    $routes->get('show_hauling', 'McpReport\DailyMonitoring\ProductionResultController::show_hauling');
                    $routes->get('show_getting', 'McpReport\DailyMonitoring\ProductionResultController::show_getting');
                });

                $routes->group('equipment_performance', function ($routes) {
                    // $routes->get('/', 'EquipmentPerformanceController::index');
                    $routes->get('show_all_daily', 'McpReport\DailyMonitoring\EquipmentPerformanceController::show_equipment_performance_all_daily');
                    $routes->get('show_all_summary', 'McpReport\DailyMonitoring\EquipmentPerformanceController::show_equipment_performance_all_summary');

                    $routes->get('show_ob_perloc', 'McpReport\DailyMonitoring\EquipmentPerformanceController::show_equipment_performance_ob');
                    $routes->get('show_ob_pertgl', 'McpReport\DailyMonitoring\EquipmentPerformanceController::show_equipment_performance_ob_pertgl');
                    $routes->get('show_ob_perunit', 'McpReport\DailyMonitoring\EquipmentPerformanceController::show_equipment_performance_ob_perunit');

                    $routes->get('show_hauling_perloc', 'McpReport\DailyMonitoring\EquipmentPerformanceController::show_equipment_performance_hauling');
                    $routes->get('show_hauling_pertgl', 'McpReport\DailyMonitoring\EquipmentPerformanceController::show_equipment_performance_hauling_pertgl');
                    $routes->get('show_hauling_perunit', 'McpReport\DailyMonitoring\EquipmentPerformanceController::show_equipment_performance_hauling_perunit');

                    $routes->get('show_getting_perloc', 'McpReport\DailyMonitoring\EquipmentPerformanceController::show_equipment_performance_getting');
                    $routes->get('show_getting_pertgl', 'McpReport\DailyMonitoring\EquipmentPerformanceController::show_equipment_performance_getting_pertgl');
                    $routes->get('show_getting_perunit', 'McpReport\DailyMonitoring\EquipmentPerformanceController::show_equipment_performance_getting_perunit');
                });
            });
        });
    });
});