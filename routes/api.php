<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'API\Auth\AuthController@login');
    // Route::post('login', 'API\Auth\AuthController@login');
    Route::post('signup', 'API\Auth\AuthController@signup');

    Route::get('logout', 'API\Auth\AuthController@logout')->middleware('auth:api');
    // Route::get('user', 'API\Auth\AuthController@user')->middleware(['auth:api', 'scope:isAdmin']);
    Route::get('me', 'API\Auth\AuthController@user')->middleware(['auth:api']);
    Route::post('reset_password', 'API\Auth\AuthController@changePasswordUser')->middleware(['auth:api']);
    Route::post('reset_password_user', 'API\Auth\AuthController@adminPasswordChange')->middleware(['auth:api']);

});


Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'users' => 'API\Auth\UserController',
        'roles' => 'API\Auth\RoleController',
        'permission' => 'API\Auth\PermissionController',
        'department' => 'API\Settings\DepartmentController',
        'employee' => 'API\Employee\EmployeeController',
        'license_type' => 'API\Settings\LicenseTypeController',
        'payment_method' => 'API\Settings\PaymentMethodController',
        'position' => 'API\Settings\PositionController',
        'contract_type' => 'API\ContractType\ContractTypeController',
        'status_employee' => 'API\StatusEmployee\StatusEmployeeController',
        'license' => 'API\Employee\LicenseController',
        'dependent' => 'API\Employee\DependentController',
        'salary_type' => 'API\Settings\SalaryTypeController',
        'status_marital' => 'API\Employee\StatusMaritalController',
        'salary' => 'API\Employee\SalaryController',
        'bank' => 'API\Settings\BankController',
        'license_letter' => 'API\Settings\TypeLicenseController',
        'driving_license' => 'API\Settings\DrivingLicenseController',
        'contract_termination' => 'API\Employee\ContractTerminationController',
        'employee_dni' => 'DniController',
        'type_expense' => 'API\Creditors\TypeExpenseController',
        'creditor' => 'API\Creditors\CreditorController',
        'creditors_module' => 'API\Creditors\CreditorsModuleController',
        'salary_history_module' => 'API\Employee\SalaryHistoryModuleController',
        'creditors_history_module' => 'API\Creditors\CreditorsHistoryModuleController'
    ]);
    Route::post('license_update/{id}', 'API\Employee\LicenseController@update');
    Route::post('driving_license_update/{id}', 'API\Settings\DrivingLicenseController@update');
    Route::post('employee_dni_update/{id}', 'DniController@update');
    Route::post('employee_search', 'API\Employee\EmployeeController@searchEmployee');
    
    Route::post('employeeImage/{id}', 'API\Employee\EmployeeController@imageEmployee');

    //FilteredOut
    Route::post("filtered_out/{id}/{department}/{position}", "API\Employee\FilteredOutController@FilteredOut");
});
    //FilteredOutPDF
    Route::post("filtered_out_pdf/{id}/{department}/{position}", "API\Reports\FilteredOutPDFController@FilteredOutPDF");



Route::get('storage/Image/{filename}', 'API\Employee\EmployeeController@image');
    // mostrar imagen
        // Route::get('employee_dni/{id}', 'DniController@index_dni');
        // Route::post('employee_dni', 'DniController@store_dni');
        // Route::put('employee_dni/{id}', 'DniController@update_dni');
        // Route::delete('employee_dni/{id}', 'DniController@delete_dni');

        
