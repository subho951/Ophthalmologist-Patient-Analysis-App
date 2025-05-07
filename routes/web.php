<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('landing-page');
});
Route::get('/env-test', function () {
    // return env('APP_NAME', 'Default Name');
    return env('DB_DATABASE', 'Default Name');
    // return env('DB_USERNAME', 'Default Name');
});
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is successful!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
Route::match(['get', 'post'], 'page/{id}', 'App\Http\Controllers\FrontController@page');
Route::match(['get', 'post'], '/delete-account', 'App\Http\Controllers\FrontController@deleteaccountview');
Route::match(['get', 'post'], '/delete-account-update', 'App\Http\Controllers\FrontController@deleteaccount')->name('delete-account.store');
/* Admin Panel */
    Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
        Route::match(['get', 'post'], '/', 'UserController@login');
        Route::match(['get','post'],'/forgot-password', 'UserController@forgotPassword');
        Route::match(['get','post'],'/validateOtp/{id}', 'UserController@validateOtp');
        Route::match(['get','post'],'/resendOtp/{id}', 'UserController@resendOtp');
        Route::match(['get','post'],'/changePassword/{id}', 'UserController@changePassword');
        Route::group(['middleware' => ['admin']], function(){
            Route::get('dashboard', 'UserController@dashboard');
            Route::get('logout', 'UserController@logout');
            Route::get('email-logs', 'UserController@emailLogs');
            Route::match(['get','post'],'/email-logs/details/{email}', 'UserController@emailLogsDetails');
            Route::get('login-logs', 'UserController@loginLogs');
            Route::match(['get','post'], '/common-delete-image/{id1}/{id2}/{id3}/{id4}/{id5}', 'UserController@commonDeleteImage');
            /* setting */
                Route::get('settings', 'UserController@settings');
                Route::post('profile-settings', 'UserController@profile_settings');
                Route::post('general-settings', 'UserController@general_settings');
                Route::post('change-password', 'UserController@change_password');
                Route::post('email-settings', 'UserController@email_settings');
                Route::post('email-template', 'UserController@email_template');
                Route::post('sms-settings', 'UserController@sms_settings');
                Route::post('application-settings', 'UserController@sms_settings');
                Route::post('color-settings', 'UserController@color_settings');
                Route::post('seo-settings', 'UserController@seo_settings');
                // Route::post('footer-settings', 'UserController@footer_settings');
                // Route::post('payment-settings', 'UserController@payment_settings');
                // Route::post('signature-settings', 'UserController@signature_settings');
            /* setting */
            /* access & permission */
                /* module */
                    Route::get('modules/list', 'ModuleController@list');
                    Route::match(['get', 'post'], 'modules/add', 'ModuleController@add');
                    Route::match(['get', 'post'], 'modules/edit/{id}', 'ModuleController@edit');
                    Route::get('modules/delete/{id}', 'ModuleController@delete');
                    Route::get('modules/change-status/{id}', 'ModuleController@change_status');
                /* module */
                /* role */
                    Route::get('roles/list', 'RoleController@list');
                    Route::match(['get', 'post'], 'roles/add', 'RoleController@add');
                    Route::match(['get', 'post'], 'roles/edit/{id}', 'RoleController@edit');
                    Route::get('roles/delete/{id}', 'RoleController@delete');
                    Route::get('roles/change-status/{id}', 'RoleController@change_status');
                /* module */
                /* sub users */
                    Route::get('sub-users/list', 'SubUserController@list');
                    Route::match(['get', 'post'], 'sub-users/add', 'SubUserController@add');
                    Route::match(['get', 'post'], 'sub-users/edit/{id}', 'SubUserController@edit');
                    Route::get('sub-users/delete/{id}', 'SubUserController@delete');
                    Route::get('sub-users/change-status/{id}', 'SubUserController@change_status');
                /* sub users */
                /* sale operator */
                    Route::get('sale-operators/list', 'SaleOperatorController@list');
                    Route::match(['get', 'post'], 'sale-operators/add', 'SaleOperatorController@add');
                    Route::match(['get', 'post'], 'sale-operators/edit/{id}', 'SaleOperatorController@edit');
                    Route::get('sale-operators/delete/{id}', 'SaleOperatorController@delete');
                    Route::get('sale-operators/change-status/{id}', 'SaleOperatorController@change_status');
                /* sale operator */
            /* access & permission */
            /* masters */
                /* comorbidities */
                    Route::get('comorbidities/list', 'ComorbiditiesController@list');
                    Route::match(['get', 'post'], 'comorbidities/add', 'ComorbiditiesController@add');
                    Route::match(['get', 'post'], 'comorbidities/edit/{id}', 'ComorbiditiesController@edit');
                    Route::get('comorbidities/delete/{id}', 'ComorbiditiesController@delete');
                    Route::get('comorbidities/change-status/{id}', 'ComorbiditiesController@change_status');
                /* comorbidities */
                /* test tabs */
                    Route::get('test-tabs/list', 'TestTabController@list');
                    Route::match(['get', 'post'], 'test-tabs/add', 'TestTabController@add');
                    Route::match(['get', 'post'], 'test-tabs/edit/{id}', 'TestTabController@edit');
                    Route::get('test-tabs/delete/{id}', 'TestTabController@delete');
                    Route::get('test-tabs/change-status/{id}', 'TestTabController@change_status');
                /* test tabs */
                /* test parameters */
                    Route::get('test-parameters/list', 'TestParameterController@list');
                    Route::match(['get', 'post'], 'test-parameters/add', 'TestParameterController@add');
                    Route::match(['get', 'post'], 'test-parameters/edit/{id}', 'TestParameterController@edit');
                    Route::get('test-parameters/delete/{id}', 'TestParameterController@delete');
                    Route::get('test-parameters/change-status/{id}', 'TestParameterController@change_status');
                /* test parameters */
            /* masters */
            /* doctor */
                Route::get('doctors/list', 'DoctorController@list');
                // Route::match(['get', 'post'], 'doctors/add', 'DoctorController@add');
                Route::match(['get', 'post'], 'doctors/edit/{id}', 'DoctorController@edit');
                Route::get('doctors/delete/{id}', 'DoctorController@delete');
                Route::get('doctors/change-status/{id}', 'DoctorController@change_status');
                Route::get('doctors/doctors-tests/{id}', 'DoctorController@doctorTests');
            /* doctor */
            /* patients */
                Route::get('patients/list', 'PatientController@list');
                // Route::match(['get', 'post'], 'patients/add', 'PatientController@add');
                Route::get('/get-states/{country_id}', 'PatientController@getStates');
                Route::match(['get', 'post'], 'patients/edit/{id}', 'PatientController@edit');
                Route::get('patients/delete/{id}', 'PatientController@delete');
                Route::get('patients/change-status/{id}', 'PatientController@change_status');
                Route::get('patients/patients-tests/{id}', 'PatientController@patientTests');
            /* patients */
            /* tests */
                Route::get('tests/list', 'TestController@list');
                // Route::match(['get', 'post'], 'tests/add', 'TestController@add');
                // Route::match(['get', 'post'], 'tests/edit/{id}', 'TestController@edit');
                Route::get('tests/delete/{id}', 'TestController@delete');
                Route::get('tests/change-status/{id}', 'TestController@change_status');
                Route::get('tests/test-details/{id}', 'TestController@testDetails');
            /* tests */
            /* page */
                Route::get('page/list', 'PageController@list');
                Route::match(['get', 'post'], 'page/add', 'PageController@add');
                Route::match(['get', 'post'], 'page/edit/{id}', 'PageController@edit');
                Route::get('page/delete/{id}', 'PageController@delete');
                Route::get('page/change-status/{id}', 'PageController@change_status');
            /* page */
            /* reports */
                Route::match(['get', 'post'], 'report/test-report', 'ReportController@testReport');
            /* reports */
        });
    });
/* Admin Panel */
/* API */
    Route::prefix('/api')->namespace('App\Http\Controllers')->group(function(){
        Route::match(['get'], 'get-app-setting', 'ApiController@getAppSetting');
        Route::match(['post'], 'get-static-pages', 'ApiController@getStaticPages');
        Route::match(['post'], 'signup', 'ApiController@signup');
        Route::match(['post'], 'signup-verify-otp', 'ApiController@signupVerifyOTP');
        Route::match(['post'], 'signin', 'ApiController@signin');
        Route::match(['post'], 'signin-with-email', 'ApiController@signinWithEmail');
        Route::match(['post'], 'signin-verify-otp-with-email', 'ApiController@signinValidateEmail');
        Route::match(['post'], 'forgotPassword', 'ApiController@forgotPassword');
        Route::match(['post'], 'validateOtp', 'ApiController@validateOtp');        
        Route::match(['post'], 'resendOtp', 'ApiController@resendOtp');
        Route::match(['post'], 'resetPassword', 'ApiController@resetPassword');

        Route::match(['get'], 'signout', 'ApiController@signout');        
        Route::match(['get'], 'get-profile', 'ApiController@getProfile');
        Route::match(['post'], 'update-profile', 'ApiController@updateProfile'); 
        Route::match(['post'], 'upload-profile-image', 'ApiController@uploadProfileImage');
        Route::match(['get'], 'dashboard', 'ApiController@dashboard'); 
        Route::match(['post'], 'change-password', 'ApiController@changePassword'); 
        Route::match(['get'], 'delete-account', 'ApiController@deleteAccount');
        
        Route::match(['get'], 'get-co-morbidities', 'ApiController@getcomorbidities');
        Route::match(['get'], 'get-patient', 'ApiController@getpatient');
        Route::match(['get'], 'get-test-parameters', 'ApiController@gettest_parameters');
    });
/* API */