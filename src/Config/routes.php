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

$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // $routes->get('/', 'Admin\DashboardController::index');

    // $routes->get('dashboard_hazardreport', 'Admin\DashboardController::hazard_report');

    // $routes->group('config_profile', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    //     $routes->get('/', 'ProfileController::index');
    //     // $routes->get('show', 'HazardReportController::she_hazard_report_achievement_show');
    //     // // $routes->get('show/(:any)', 'HazardReportController::show/$1');
    //     // $routes->post('create', 'HazardReportController::create');
    //     $routes->post('sync_to_herp', 'ProfileController::sync_to_herp');
    //     $routes->post('update_profile', 'ProfileController::update_profile');
    //     // $routes->put('release', 'HazardReportController::release');
    //     // $routes->put('approve', 'HazardReportController::approve');
    //     // $routes->put('reject', 'HazardReportController::reject');
    //     // $routes->delete('delete', 'HazardReportController::delete');
    //     $routes->get('session', 'ProfileController::session');
    //     $routes->get('session_get', 'ProfileController::session_get');
    // });

    // $routes->group('dashboard', function ($routes) {
    //     $routes->get('approval_sum', 'Admin\DashboardController::approval_sum');
    // });

    // $routes->group('inventory_itr', ['namespace' => 'App\Controllers\Admin\ITR'], static function ($routes) {
    //     $routes->get('/', 'ItrController::index');
    //     $routes->get('tambah', 'ItrController::tambah');
    // });

    // $routes->addRedirect('approval_itr', 'admin/approval/itr');
    // $routes->addRedirect('approval_ur', 'admin/approval/ur');
    // $routes->addRedirect('approval_mr', 'admin/approval/mr');
    // $routes->addRedirect('approval_pr', 'admin/approval/pr');
    // $routes->addRedirect('approval_po', 'admin/approval/po');
    // $routes->addRedirect('approval_doc', 'admin/approval/doc');
    // $routes->addRedirect('fonts/(:any)', 'fonts/$1');

    // $routes->group('approval', ['namespace' => 'App\Controllers\Admin\Approval'], static function ($routes) {
    //     $routes->get('sum', 'ApprovalController::sum');
    //     $routes->group('itr', function ($routes) {
    //         $routes->get('/', 'ItrController::index');
    //         $routes->get('show', 'ItrController::show');
    //         $routes->get('show/(:any)', 'ItrController::show/$1');
    //         $routes->put('approve', 'ItrController::approve');
    //         $routes->put('approve/(:any)', 'ItrController::approve/$1');
    //         $routes->get('show_jumlah', 'ItrController::show_jumlah');
    //         $routes->get('sum', 'ItrController::sum');
    //     });
    //     $routes->group('ur', function ($routes) {
    //         $routes->get('/', 'UrController::index');
    //         $routes->get('show', 'UrController::show');
    //         $routes->get('show/(:any)', 'UrController::show/$1');
    //         $routes->put('approve', 'UrController::approve');
    //         $routes->put('approve/(:any)', 'UrController::approve/$1');
    //         $routes->get('show_jumlah', 'UrController::show_jumlah');
    //         $routes->get('sum', 'UrController::sum');
    //     });

    //     $routes->group('mr', function ($routes) {
    //         $routes->get('/', 'MrController::index');
    //         $routes->get('show', 'MrController::show');
    //         $routes->get('show/(:any)', 'MrController::show/$1');
    //         $routes->put('approve', 'MrController::approve');
    //         $routes->put('approve/(:any)', 'MrController::approve/$1');
    //         $routes->get('show_jumlah', 'MrController::show_jumlah');
    //         $routes->get('sum', 'MrController::sum');
    //     });

    //     $routes->group('pr', function ($routes) {
    //         $routes->get('/', 'PrController::index');
    //         $routes->get('show', 'PrController::show');
    //         $routes->get('show/(:any)', 'PrController::show/$1');
    //         $routes->put('approve', 'PrController::approve');
    //         $routes->put('approve/(:any)', 'PrController::approve/$1');
    //         $routes->get('show_jumlah', 'PrController::show_jumlah');
    //         $routes->get('sum', 'PrController::sum');
    //     });

    //     $routes->group('po', function ($routes) {
    //         $routes->get('/', 'PoController::index');
    //         $routes->get('show', 'PoController::show');
    //         $routes->get('show/(:any)', 'PoController::show/$1');
    //         $routes->put('approve', 'PoController::approve');
    //         $routes->put('approve/(:any)', 'PoController::approve/$1');
    //         $routes->get('show_jumlah', 'PoController::show_jumlah');
    //         $routes->get('sum', 'PoController::sum');
    //     });

    //     $routes->group('doc', function ($routes) {
    //         $routes->get('/', 'DocController::index');
    //         $routes->get('show', 'DocController::show');
    //         $routes->get('show/(:any)', 'DocController::show/$1');
    //         $routes->put('approve', 'DocController::approve');
    //         $routes->put('approve/(:any)', 'DocController::approve/$1');
    //         $routes->get('show_jumlah', 'DocController::show_jumlah');
    //         $routes->get('sum', 'DocController::sum');
    //     });
    // });

    // $routes->group('payroll', ['namespace' => 'App\Controllers\Admin\Payroll'], static function ($routes) {
    //     $routes->group('employee_salary', function ($routes) {
    //         $routes->get('/', 'EmployeeSalaryController::index');
    //         $routes->get('show', 'EmployeeSalaryController::show');
    //         $routes->post('import', 'EmployeeSalaryController::import');
    //         $routes->get('show_payslip_periode', 'EmployeeSalaryController::show_payslip_periode');
    //         $routes->delete('delete/(:num)', 'EmployeeSalaryController::delete/$1');
    //         $routes->delete('delete', 'EmployeeSalaryController::delete');
    //     });

    //     $routes->group('payslip', function ($routes) {
    //         $routes->get('/', 'PayslipController::index');
    //         $routes->get('show', 'PayslipController::show');
    //         $routes->get('show_periode', 'PayslipController::show_periode');
    //         // $routes->get('show/(:any)', 'PayslipController::show/$1');
    //     });
    // });

    // $routes->group('payslip_periode', function ($routes) {
    //     $routes->get('/', 'Admin\Payroll\PayslipPeriodeController::index');
    //     $routes->get('show', 'Admin\Payroll\PayslipPeriodeController::show');
    //     // $routes->get('show/(:any)', 'PayslipController::show/$1');
    //     $routes->post('create', 'Admin\Payroll\PayslipPeriodeController::create');
    // });

    // $routes->group('employee_salary', function ($routes) {
    //     $routes->get('/', 'Admin\Payroll\EmployeeSalaryController::index');
    //     $routes->get('show', 'Admin\Payroll\EmployeeSalaryController::show');
    //     $routes->delete('delete/(:num)', 'EmployeeSalaryController::delete/$1');
    //     $routes->delete('delete', 'EmployeeSalaryController::delete');

    //     $routes->post('import', 'Admin\Payroll\EmployeeSalaryController::import');
    //     $routes->get('show_payslip_periode', 'Admin\Payroll\EmployeeSalaryController::show_payslip_periode');
    //     $routes->get('create_pdf/(:num)', 'Admin\Payroll\EmployeeSalaryController::create_pdf/$1');
    // });

    // $routes->group('payslip', function ($routes) {
    //     $routes->get('/', 'Admin\Payroll\PayslipController::index');
    //     $routes->get('show', 'Admin\Payroll\PayslipController::show');
    //     // $routes->get('show/(:num)', 'Admin\Payroll\PayslipController::show/$1');
    //     // $routes->get('print', 'Admin\Payroll\PayslipController::print');
    //     // $routes->get('print/(:num)', 'Admin\Payroll\PayslipController::print/$1');
    //     // $routes->get('download_pdf', 'Admin\Payroll\PayslipController::download_pdf');
    //     // $routes->get('download_pdf/(:num)', 'Admin\Payroll\PayslipController::download_pdf/$1');
    //     // $routes->get('delete_pdf', 'Admin\Payroll\PayslipController::delete_pdf');
    //     // $routes->get('delete_pdf/(:num)', 'Admin\Payroll\PayslipController::delete_pdf/$1');
    //     $routes->get('show_periode', 'Admin\Payroll\PayslipController::show_periode');
    //     $routes->get('create_pdf', 'Admin\Payroll\PayslipController::create_pdf');
    // });

    // $routes->group('employee_account', ['namespace' => 'App\Controllers\Admin\Config'], static function ($routes) {
    //     $routes->get('/', 'EmployeeAccountController::index');
    //     $routes->get('show', 'EmployeeAccountController::show');
    //     $routes->post('create', 'EmployeeAccountController::create');
    //     $routes->post('import', 'EmployeeAccountController::import');
    //     $routes->delete('delete', 'EmployeeAccountController::delete');
    //     $routes->put('update/(:num)', 'EmployeeAccountController::update/$1');
    // });

    // $routes->group('she_hazard_report', ['namespace' => 'App\Controllers\Admin\SHE'], static function ($routes) {
    //     $routes->get('/', 'HazardReportController::index');
    //     $routes->get('show', 'HazardReportController::show');
    //     $routes->get('kosong', 'HazardReportController::kosong');
    //     // $routes->get('show/(:any)', 'HazardReportController::show/$1');
    //     $routes->post('create', 'HazardReportController::create');
    //     $routes->put('update/(:num)', 'HazardReportController::update/$1');
    //     $routes->put('release', 'HazardReportController::release');
    //     $routes->put('approve', 'HazardReportController::approve');
    //     $routes->put('reject', 'HazardReportController::reject');
    //     $routes->delete('delete', 'HazardReportController::delete');

    //     $routes->get('number', 'HazardReportController::number');
    // });

    // $routes->group('she_safety_config', ['namespace' => 'App\Controllers\Admin\SHE'], static function ($routes) {
    //     $routes->get('/', 'SafetyConfigController::index');
    //     $routes->get('show', 'SafetyConfigController::show');
    //     // $routes->get('show/(:any)', 'SafetyConfigController::show/$1');
    //     $routes->post('create', 'SafetyConfigController::create');
    //     $routes->put('update/(:num)', 'SafetyConfigController::update/$1');
    //     $routes->delete('delete', 'SafetyConfigController::delete');
    //     $routes->put('update_email_laporan_bahaya', 'SafetyConfigController::update_email_laporan_bahaya');
    // });

    // $routes->group('saham_endofday', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    //     $routes->get('/', 'SahamController::endofday_index');
    //     $routes->get('show', 'SahamController::endofday_show');
    //     // $routes->get('show/(:any)', 'SahamController::show/$1');
    //     $routes->post('create', 'SahamController::endofday_create');
    //     // $routes->put('release', 'HazardReportController::release');
    //     // $routes->put('approve', 'HazardReportController::approve');
    //     // $routes->put('reject', 'HazardReportController::reject');
    //     // $routes->delete('delete', 'HazardReportController::delete');
    // });

    // $routes->group('she_hazard_report_achievement', ['namespace' => 'App\Controllers\Admin\SHE'], static function ($routes) {
    //     $routes->get('/', 'HazardReportController::she_hazard_report_achievement');
    //     $routes->get('show', 'HazardReportController::she_hazard_report_achievement_show');
    //     // // $routes->get('show/(:any)', 'HazardReportController::show/$1');
    //     // $routes->post('create', 'HazardReportController::create');
    //     // $routes->put('release', 'HazardReportController::release');
    //     // $routes->put('approve', 'HazardReportController::approve');
    //     // $routes->put('reject', 'HazardReportController::reject');
    //     // $routes->delete('delete', 'HazardReportController::delete');
    // });

    // $routes->group('she_investigation', ['namespace' => 'App\Controllers\Admin\SHE'], static function ($routes) {
    //     $routes->get('/', 'InvestigationController::index');
    //     $routes->get('tambah', 'InvestigationController::add');
    //     $routes->get('ubah/(:num)', 'InvestigationController::edit/$1');
    //     $routes->post('search', 'InvestigationController::search');
    //     $routes->get('detail/(:num)', 'InvestigationController::detail/$1');
    //     $routes->get('show/(:num)', 'InvestigationController::show/$1');
    //     $routes->get('show/lpi/(:alphanum)', 'InvestigationController::lpi/$1');
    //     $routes->get('tipe-penyebab', 'InvestigationController::getTipePenyebab');
    //     $routes->get('detail-penyebab', 'InvestigationController::getDetailPenyebab');
    //     $routes->get('export/pdf/lpa/(:num)', 'InvestigationController::pdfLpaView/$1');
    //     $routes->get('export/pdf/lpi/(:any)', 'InvestigationController::pdfLpiView/$1');
    // });

    // $routes->group('she_investigation_lpa_approval_matrix', ['namespace' => 'App\Controllers\Admin\SHE'], static function ($routes) {
    //     $routes->get('/', 'InvestigationApprovalMatrixController::lpa_index');
    //     $routes->get('show', 'InvestigationApprovalMatrixController::lpa_show');
    //     $routes->get('show/(:num)', 'InvestigationApprovalMatrixController::lpa_show/$1');
    //     $routes->post('create', 'InvestigationApprovalMatrixController::lpa_create');
    //     $routes->post('update/(:num)', 'InvestigationApprovalMatrixController::lpa_update/$1');
    //     $routes->post('delete', 'InvestigationApprovalMatrixController::lpa_delete');

    //     $routes->get('show_site_project', 'InvestigationApprovalMatrixController::show_site_project');
    //     $routes->get('show_users', 'InvestigationApprovalMatrixController::show_users');
    // });

    // $routes->group('she_investigation_lpi_approval_matrix', ['namespace' => 'App\Controllers\Admin\SHE'], static function ($routes) {
    //     $routes->get('/', 'InvestigationApprovalMatrixController::lpi_index');
    //     // $routes->get('show', 'InvestigationApprovalMatrixController::lpa_show');
    //     // $routes->get('show/(:num)', 'InvestigationApprovalMatrixController::lpa_show/$1');
    //     // $routes->post('create', 'InvestigationApprovalMatrixController::lpa_create');
    //     // $routes->post('update/(:num)', 'InvestigationApprovalMatrixController::lpa_update/$1');
    //     // $routes->post('delete', 'InvestigationApprovalMatrixController::lpa_delete');

    //     // $routes->get('show_site_project', 'InvestigationApprovalMatrixController::show_site_project');
    //     // $routes->get('show_users', 'InvestigationApprovalMatrixController::show_users');
    // });

    // $routes->group('approval_investigasi', ['namespace' => 'App\Controllers\Admin\Approval'], static function ($routes) {
    //     $routes->get('/', 'ApprovalInvestigasiController::index');
    //     $routes->post('search', 'ApprovalInvestigasiController::search');
    // });

    // $routes->group('she_prakualifikasi_csms', ['namespace' => 'App\Controllers\Admin\SHE'], static function ($routes) {
    //     $routes->get('/', 'PraKualifikasiController::index');
    //     $routes->get('tambah', 'PraKualifikasiController::add');
    //     $routes->get('ubah/(:any)', 'PraKualifikasiController::update/$1');
    // });

    // $routes->group('she_kunjungan_klinik', ['namespace' => 'App\Controllers\Admin\SHE'], static function ($routes) {
    //     $routes->get('/', 'KunjunganKlinikController::index');
    //     $routes->get('show', 'KunjunganKlinikController::show');
    //     // $routes->get('kosong', 'HazardReportController::kosong');
    //     // $routes->get('show/(:any)', 'HazardReportController::show/$1');
    //     $routes->post('create', 'KunjunganKlinikController::create');
    //     $routes->put('update/(:num)', 'KunjunganKlinikController::update/$1');
    //     // $routes->put('release', 'HazardReportController::release');
    //     // $routes->put('approve', 'HazardReportController::approve');
    //     // $routes->put('reject', 'HazardReportController::reject');
    //     $routes->delete('delete', 'HazardReportController::delete');

    //     $routes->get('show_icd', 'KunjunganKlinikController::show_icd');
    //     $routes->get('show_obat', 'KunjunganKlinikController::show_obat');
    //     $routes->get('show_employee', 'KunjunganKlinikController::show_employee');
    // });

    // $routes->group('she_stok_obat', ['namespace' => 'App\Controllers\Admin\SHE'], static function ($routes) {
    //     $routes->get('/', 'StokObatController::index');
    //     $routes->get('show', 'StokObatController::show');
    //     $routes->post('create', 'StokObatController::create');
    //     $routes->put('update/(:num)', 'StokObatController::update/$1');
    //     $routes->delete('delete', 'StokObatController::delete');

    //     $routes->get('show_material', 'StokObatController::show_material');
    //     $routes->get('show_material/(:any)', 'StokObatController::show_material/$1');
    //     $routes->get('show_uom', 'StokObatController::show_uom');
    //     $routes->get('show_satuan', 'StokObatController::show_satuan');
    //     $routes->get('show_trx/(:num)', 'StokObatController::show_trx/$1');
    //     $routes->get('part_number/(:any)', 'StokObatController::part_number/$1');
    // });

    // // $routes->addRedirect('pm_workorder_sap', 'admin/pm/work_order_sap');
    // // $routes->addRedirect('pm_mechanic_activity', 'admin/pm/mechanic_activity');

    // $routes->group('pm', ['namespace' => 'App\Controllers\Admin\PlantMaintenance'], static function ($routes) {
    //     $routes->group('mechanic_activity', function ($routes) {
    //         $routes->get('/', 'MechanicActivityController::index');
    //         $routes->get('show', 'MechanicActivityController::show');
    //         $routes->get('create', 'MechanicActivityController::create');
    //     });
    //     $routes->group('work_order_sap', function ($routes) {
    //         $routes->get('/', 'WorkorderSapController::index');
    //         $routes->get('show', 'WorkorderSapController::show');
    //     });
    // });

    // $routes->group('payment_request', ['namespace' => 'App\Controllers\Admin\PaymentRequest'], static function ($routes) {
    //     $routes->group('cash', function ($routes) {
    //         $routes->get('/', 'CashController::index');
    //         $routes->get('show', 'WorkorderSapController::show');
    //         $routes->get('show_supplier', 'CashController::show_supplier');
    //         $routes->get('show_affiliation', 'CashController::show_affiliation');
    //         $routes->get('usp_0202_SHB_0004', 'CashController::usp_0202_SHB_0004');
    //         $routes->get('usp_0101_SHB_0009_kas', 'CashController::usp_0101_SHB_0009_kas');
    //     });

    //     // $routes->group('mechanic_activity', function ($routes) {
    //     //     $routes->get('/', 'MechanicActivityController::index');
    //     //     $routes->get('show', 'MechanicActivityController::show');
    //     //     $routes->get('create', 'MechanicActivityController::create');
    //     // });
    // });

    // // $routes->addRedirect('(:any)', '$1');
    // $routes->group('photos', function ($routes) {
    //     $routes->get('/', 'Admin\PhotosController::index');
    //     $routes->get('show', 'Admin\PhotosController::show');
    // });

    // $routes->group('gallery_photos', function ($routes) {
    //     $routes->get('/', 'Admin\PhotosController::index');
    //     $routes->get('show', 'Admin\PhotosController::show');
    // });

    // $routes->group('hcm_applicants', ['namespace' => 'App\Controllers\Admin\HCM'], function ($routes) {
    //     $routes->get('/', 'ApplicantsController::index');
    //     $routes->get('show', 'ApplicantsController::show');
    //     // $routes->get('show_payslip_periode', 'EmployeeSalaryController::show_payslip_periode');
    //     // $routes->delete('delete/(:num)', 'EmployeeSalaryController::delete/$1');
    //     // $routes->delete('delete', 'EmployeeSalaryController::delete');
    //     // $routes->put('update/(:num)', 'ApplicantsController::update/$1');
    //     $routes->put('approve', 'ApplicantsController::approve');
    //     $routes->put('reject', 'ApplicantsController::reject');
    // });

    // $routes->group('hcm_positions', ['namespace' => 'App\Controllers\Admin\HCM'], function ($routes) {
    //     $routes->get('/', 'PositionController::index');
    //     $routes->get('show', 'PositionController::show');
    //     $routes->post('create', 'PositionController::create');
    //     $routes->put('update/(:num)', 'PositionController::update/$1');
    //     $routes->delete('delete/(:num)', 'PositionController::delete/$1');
    //     $routes->delete('delete', 'PositionController::delete');
    //     $routes->get('show_depart', 'PositionController::show_depart');
    // });

    // $routes->group('hcm_test_location', ['namespace' => 'App\Controllers\Admin\HCM'], function ($routes) {
    //     $routes->get('/', 'TestLocationController::index');
    //     $routes->get('show', 'TestLocationController::show');
    //     $routes->post('create', 'TestLocationController::create');
    //     // $routes->delete('delete/(:num)', 'TestLocationController::delete/$1');
    //     // $routes->delete('delete', 'TestLocationController::delete');
    // });

    // $routes->group('event_recruitment', ['namespace' => 'App\Controllers\Admin\HCM'], function ($routes) {
    //     $routes->get('/', 'EventRecruitmentController::index');
    //     $routes->get('show', 'EventRecruitmentController::show');
    //     $routes->post('create', 'EventRecruitmentController::create');
    //     $routes->put('update/(:num)', 'EventRecruitmentController::update/$1');
    //     $routes->delete('delete/(:num)', 'EventRecruitmentController::delete/$1');
    //     $routes->delete('delete', 'EventRecruitmentController::delete');

    //     $routes->get('show_positions', 'EventRecruitmentController::show_positions');
    //     $routes->post('posting/(:num)', 'EventRecruitmentController::posting/$1');
    //     $routes->post('unposting', 'EventRecruitmentController::unposting');
    // });

    // // $routes->group('pm_workorder_sap', ['namespace' => 'App\Controllers\Admin\PlantMaintenance'], static function ($routes) {
    // //     $routes->get('/', 'WorkorderSapController::index');
    // //     $routes->get('show', 'WorkorderSapController::show');
    // //     $routes->post('create', 'WorkorderSapController::create');
    // //     $routes->put('update/(:num)', 'WorkorderSapController::update/$1');
    // //     $routes->delete('delete', 'WorkorderSapController::delete');
    // // });

    // $routes->group('pm_mechanic_activity', ['namespace' => 'App\Controllers\Admin\PlantMaintenance'], static function ($routes) {
    //     $routes->get('/', 'MechanicActivityController::index');
    //     $routes->get('show', 'MechanicActivityController::show');
    //     $routes->post('create', 'MechanicActivityController::create');
    //     $routes->put('update/(:num)', 'MechanicActivityController::update/$1');
    //     $routes->delete('delete', 'MechanicActivityController::delete');

    //     $routes->get('show_wosap', 'MechanicActivityController::show_wosap');
    //     $routes->get('show_reason', 'MechanicActivityController::show_reason');
    //     $routes->get('show_employee', 'MechanicActivityController::show_employee');
    //     $routes->get('show_mechanic', 'MechanicActivityController::show_mechanic');
    //     $routes->get('show_operation', 'MechanicActivityController::show_operation');
    //     $routes->get('show_notif', 'MechanicActivityController::show_notif');
    // });

    // $routes->group('fekb', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    //     $routes->get('/', 'FekbController::index');
    //     $routes->get('show', 'FekbController::show');
    //     $routes->post('create', 'FekbController::create');
    //     $routes->put('update/(:num)', 'FekbController::update/$1');
    //     $routes->delete('delete', 'FekbController::delete');

    //     $routes->get('show_po', 'FekbController::show_po');
    // });

    // $routes->group('goods_evaluation', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    //     $routes->get('/', 'GoodsevalController::index');
    //     $routes->get('show', 'GoodsevalController::show');
    //     $routes->post('create', 'GoodsevalController::create');
    //     $routes->put('update/(:num)', 'GoodsevalController::update/$1');
    //     $routes->post('update/(:num)', 'GoodsevalController::update/$1');
    //     $routes->delete('delete', 'GoodsevalController::delete');

    //     $routes->get('show_po', 'GoodsevalController::show_po');
    //     $routes->get('show_po_detail', 'GoodsevalController::show_po_detail');
    // });

    // $routes->group('goods_evaluation_create', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    //     $routes->get('/', 'GoodsevalController::zonecreate_index');
    //     $routes->get('show', 'GoodsevalController::zonecreate_show');
    //     $routes->post('create', 'GoodsevalController::zonecreate_create');
    //     // $routes->put('update/(:num)', 'GoodsevalController::zonecreate_update/$1');
    //     $routes->post('update/(:num)', 'GoodsevalController::zonecreate_update/$1');
    //     $routes->delete('delete', 'GoodsevalController::zonecreate_delete');

    //     $routes->get('show_po', 'GoodsevalController::show_po');
    //     $routes->get('show_po_detail', 'GoodsevalController::show_po_detail');
    // });

    // $routes->group('goods_evaluation_process', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    //     $routes->get('/', 'GoodsevalController::zoneprocess_index');
    //     $routes->get('show', 'GoodsevalController::zoneprocess_show');
    //     // $routes->put('update/(:num)', 'GoodsevalController::zoneprocess_update/$1');
    //     $routes->post('update/(:num)', 'GoodsevalController::zoneprocess_update/$1');
    //     // $routes->post('update/(:num)', 'GoodsEvalProcessController::update/$1');
    // });

    // $routes->group('goods_evaluation_monitoring', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    //     $routes->get('/', 'GoodsevalController::monitoring_index');
    //     $routes->get('show', 'GoodsevalController::monitoring_show');
    // });

    // $routes->group('site_project', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    //     $routes->get('/', 'SiteProjectController::index');
    //     $routes->get('show', 'SiteProjectController::show');
    //     // $routes->post('create', 'SiteProjectController::create');
    //     $routes->put('update/(:num)', 'SiteProjectController::update/$1');
    //     $routes->post('update/(:any)', 'SiteProjectController::update/$1');
    //     // $routes->delete('delete', 'SiteProjectController::delete');
    // });

    // $routes->group('surat_tugas', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    //     $routes->get('/', 'SuratTugasController::index');
    //     $routes->get('show', 'SuratTugasController::show');
    //     $routes->post('create', 'SuratTugasController::create');
    //     $routes->put('update/(:num)', 'SuratTugasController::update/$1');
    //     $routes->delete('delete', 'SuratTugasController::delete');

    //     $routes->get('show_site_project', 'SuratTugasController::show_site_project');
    // });

    // $routes->group('syshab', ['namespace' => 'App\Controllers\Admin\HCM'], static function ($routes) {
    //     $routes->get('/', 'EmployeeController::index');
    //     // $routes->get('show', 'SuratTugasController::show');
    //     // $routes->post('create', 'SuratTugasController::create');
    //     // $routes->put('update/(:num)', 'SuratTugasController::update/$1');
    //     // $routes->delete('delete', 'SuratTugasController::delete');
    // });

    // $routes->group('hcm_employee', ['namespace' => 'App\Controllers\Admin\HCM'], static function ($routes) {
    //     $routes->get('/', 'EmployeeController::index');
    //     $routes->get('show', 'EmployeeController::show');
    //     // $routes->post('create', 'EmployeeController::zonecreate_create');
    //     // $routes->put('update/(:num)', 'GoodsevalController::zonecreate_update/$1');
    //     // $routes->post('update/(:num)', 'GoodsevalController::zonecreate_update/$1');
    //     // $routes->delete('delete', 'GoodsevalController::zonecreate_delete');
    // });

    // $routes->group('mcp', ['namespace' => 'App\Controllers\Admin\MCP'], static function ($routes) {
    //     $routes->group('dashboard', function ($routes) {
    //         $routes->get('approval_sum', 'Admin\DashboardController::approval_sum');
    //     });
    // });

    $routes->group('mcp_report', function ($routes) {
        // $routes->group('dashboard', ['namespace' => 'App\Controllers\Admin\McpReport'], static function ($routes) {
        //     $routes->get('/', 'DashboardController::index');
        //     $routes->get('show_siteProject', 'DashboardController::show_siteProject');
        // });

        // $routes->group('ob', function ($routes) {
        //     $routes->group('hourly_monitoring', ['namespace' => 'App\Controllers\Admin\McpReport\OB'], static function ($routes) {
        //         $routes->get('/', 'HourlyMonitoringController::index');
        //         $routes->get('show', 'HourlyMonitoringController::show_hourly_ob_monitoring');
        //         $routes->get('show_all', 'HourlyMonitoringController::show_hourly_ob_monitoring_all');
        //         $routes->get('show_modif', 'HourlyMonitoringController::modif_hourly_ob_monitoring');
        //         $routes->get('show_modif/(:any)', 'HourlyMonitoringController::modif_hourly_ob_monitoring/$1');
        //     });

        //     $routes->group('daily-monitoring', ['namespace' => 'App\Controllers\Admin\McpReport\OB'], static function ($routes) {
        //         $routes->get('/', 'HourlyMonitoringController::report_daily_production');
        //         $routes->get('pit/search', 'HourlyMonitoringController::search');
        //         $routes->get('equipment/search', 'HourlyMonitoringController::equipment_search');
        //         $routes->get('fuel-info', 'HourlyMonitoringController::fuel_info');
        //         $routes->get('plan-target', 'HourlyMonitoringController::plan_target');
        //         $routes->get('plan-target/month-year-date', 'HourlyMonitoringController::month_year_date');
        //     });
        // });

        $routes->group('production', function ($routes) {
            // $routes->group('hourly-monitoring', ['namespace' => 'App\Controllers\Admin\MCP'], static function ($routes) {
            //     $routes->get('/', 'ReportCoalController::haulingMonitoringPage');
            //     $routes->get('fetch-time', 'ReportCoalController::getTimeHourlyMonitoring');
            //     $routes->get('search', 'ReportCoalController::search');
            // });

            // $routes->group('daily-coal', ['namespace' => 'App\Controllers\Admin\MCP'], static function ($routes) {
            //     $routes->get('distribution', 'ReportCoalController::dailyCoalDistributionPage');
            //     $routes->get('distribution/search', 'ReportCoalController::searchDailyCoalDistribution');

            //     $routes->get('distribution-port', 'ReportCoalController::dailyCoalDistributionPortPage');
            //     $routes->get('distribution-port/search', 'ReportCoalController::searchDailyCoalDistributionPort');

            //     $routes->get('getting', 'ReportCoalController::dailyCoalGettingPage');
            //     $routes->get('getting/production', 'ReportCoalController::dailyCoalGettingProduction');
            //     $routes->get('getting/target-date', 'ReportCoalController::dailyCoalGettingTargetDate');
            //     $routes->get('getting/equipment', 'ReportCoalController::dailyCoalGettingEquipment');
            // });

            // $routes->group('weekly-coal', ['namespace' => 'App\Controllers\Admin\MCP'], static function ($routes) {
            //     $routes->get('getting', 'ReportCoalController::weeklyCoalGettingPage');
            //     $routes->get('getting/weather-pit', 'ReportCoalController::weeklyCoalGettingWeatherPit');
            // });

            // $routes->group('monthly-coal', ['namespace' => 'App\Controllers\Admin\MCP'], static function ($routes) {
            //     $routes->get('getting', 'ReportCoalController::monthlyCoalGettingPage');
            //     $routes->get('getting/fetch', 'ReportCoalController::monthlyCoalGettingFetch');
            // });

            // $routes->group('yearly-coal', ['namespace' => 'App\Controllers\Admin\MCP'], static function ($routes) {
            //     $routes->get('getting', 'ReportCoalController::yearlyCoalGettingPage');
            //     $routes->get('getting/fetch', 'ReportCoalController::yearlyCoalGettingFetch');
            // });

            // $routes->group('daily_monitoring', ['namespace' => 'App\Controllers\Admin\McpReport\Production'], static function ($routes) {
            //     $routes->group('production_result', ['namespace' => 'App\Controllers\Admin\McpReport\Production\DailyMonitoring'], static function ($routes) {
            //         $routes->get('/', 'ProductionResultController::index');
            //     });

            //     $routes->group('equipment_performance', ['namespace' => 'App\Controllers\Admin\McpReport\Production\DailyMonitoring'], static function ($routes) {
            //         $routes->get('/', 'EquipmentPerformanceController::index');
            //         // $routes->get('show_all_daily', 'EquipmentPerformanceController::show_equipment_performance_all_daily');
            //         // $routes->get('show_all_summary', 'EquipmentPerformanceController::show_equipment_performance_all_summary');

            //         // $routes->get('show_ob_perloc', 'EquipmentPerformanceController::show_equipment_performance_ob');
            //         // $routes->get('show_ob_pertgl', 'EquipmentPerformanceController::show_equipment_performance_ob_pertgl');
            //         // $routes->get('show_ob_perunit', 'EquipmentPerformanceController::show_equipment_performance_ob_perunit');

            //         // $routes->get('show_hauling_perloc', 'EquipmentPerformanceController::show_equipment_performance_hauling');
            //         // $routes->get('show_hauling_pertgl', 'EquipmentPerformanceController::show_equipment_performance_hauling_pertgl');
            //         // $routes->get('show_hauling_perunit', 'EquipmentPerformanceController::show_equipment_performance_hauling_perunit');

            //         // $routes->get('show_getting_perloc', 'EquipmentPerformanceController::show_equipment_performance_getting');
            //         // $routes->get('show_getting_pertgl', 'EquipmentPerformanceController::show_equipment_performance_getting_pertgl');
            //         // $routes->get('show_getting_perunit', 'EquipmentPerformanceController::show_equipment_performance_getting_perunit');
            //     });

            //     $routes->group('manpower_performance', ['namespace' => 'App\Controllers\Admin\McpReport\Production\DailyMonitoring'], static function ($routes) {
            //         $routes->get('/', 'ManpowerPerformanceController::index');
            //         $routes->get('show_ob', 'ManpowerPerformanceController::show_ob');
            //         $routes->get('show_hauling', 'ManpowerPerformanceController::show_hauling');
            //         $routes->get('show_getting', 'ManpowerPerformanceController::show_getting');
            //     });

            //     $routes->group('hauling_per_contractor', ['namespace' => 'App\Controllers\Admin\McpReport\Production\DailyMonitoring'], static function ($routes) {
            //         $routes->get('/', 'HaulingPerContractorController::index');
            //         $routes->get('show', 'HaulingPerContractorController::show');
            //         // $routes->get('show_hauling', 'ManpowerPerformanceController::show_hauling');
            //         // $routes->get('show_getting', 'ManpowerPerformanceController::show_getting');
            //     });
            // });

            $routes->group('summary_daily_production', ['namespace' => 'Sparkhizb\Controllers\Syshab'], static  function ($routes) {
                $routes->group('stc', function ($routes) {
                    $routes->get('show', 'McpReport\SummaryDailyProductionController::show_stc');
                });

                $routes->group('ssc', function ($routes) {
                    $routes->get('show', 'McpReport\SummaryDailyProductionController::show_ssc');
                });
            });
        });
    });

    // $routes->group('mcp_dashboard', ['namespace' => 'App\Controllers\Admin\McpReport'], static function ($routes) {
    //     $routes->get('/', 'DashboardController::index');
    //     $routes->get('show_siteProject', 'DashboardController::show_siteProject');
    // });
});

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
                $routes->get('show_daily', 'McpReport\DashboardController::show_daily');
                $routes->get('show_plan_ob_daily', 'McpReport\DashboardController::show_plan_ob_daily');
                $routes->get('show_summary_ob_daily', 'McpReport\DashboardController::show_summary_ob_daily');
                $routes->get('show_summary_coalore_daily', 'McpReport\DashboardController::show_summary_coalore_daily');
                $routes->get('show_hauling_daily', 'McpReport\DashboardController::show_hauling_daily');
                $routes->get('show_V_MCC_TR_HPRODUCTIONB_CL', 'McpReport\DashboardController::show_V_MCC_TR_HPRODUCTIONB_CL');
                $routes->get('summary_production', 'McpReport\DashboardController::summary_production');

                $routes->get('total_production', 'McpReport\DashboardController::total_production');
                $routes->get('total_ob', 'McpReport\DashboardController::total_ob');
                $routes->get('total_hauling', 'McpReport\DashboardController::total_hauling');
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

            $routes->group('summary_daily_production', function($routes) {
                $routes->get('show_ssc_summary', 'McpReport\SummaryDailyProductionController::show_ssc_summary');

                $routes->get('getBy_locCode', 'McpReport\SummaryDailyProductionController::getBy_locCode');
                $routes->get('getBy_locCode/(:any)', 'McpReport\SummaryDailyProductionController::getBy_locCode/$1');
                
                // $routes->group('production_result', function($routes) {
                //     // $routes->get('/', 'McpReport\DailyMonitoring\ProductionResultController::index');
                //     $routes->get('show_all', 'McpReport\DailyMonitoring\ProductionResultController::show_all');
                //     $routes->get('show_ob', 'McpReport\DailyMonitoring\ProductionResultController::show_ob');
                //     $routes->get('show_coalhauling_perlocation', 'McpReport\DailyMonitoring\ProductionResultController::show_coalhauling_perlocation');
                //     $routes->get('show_hauling', 'McpReport\DailyMonitoring\ProductionResultController::show_hauling');
                //     $routes->get('show_getting', 'McpReport\DailyMonitoring\ProductionResultController::show_getting');
                // });
            });
        });
    });
});