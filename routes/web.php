<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LoginAJIController;
use App\Http\Controllers\auth\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuggestionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

 
Route::group(['namespace' => 'App\Http\Controllers'], function()
{

   /*
    |--------------------------------------------------------------------------
    | Awal routes web portal utama AJI
    |--------------------------------------------------------------------------
    |
    |
    */

    Route::group(['middleware' => ['guest']], function () {
      // register
      Route::get('/register', 'RegisterController@show')->name('register.show');
      Route::post('/signup', 'RegisterController@register')->name('register.perform');
    
      // forgot password
      Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
      Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
      Route::get('reset-password/{token}/{email}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
      Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    });

        // home
    Route::get('/', 'LoginController@show')->name('home.index');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('home.dashboard')->middleware(['auth']);

    Route::post('/loginPortalAJI', [LoginAJIController::class, 'loginPortalAJI'])->name('EHS.Patrol.loginPortalAJI');
    Route::get('/to-portal', [UsersController::class, 'toPortal'])->name('to.portal');

    /*
    |--------------------------------------------------------------------------
    | Suggestion System Routes
    |--------------------------------------------------------------------------
    |
    |
    */
    Route::prefix('ss')->middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('ss.user_admin.dashboardadmin');
        })->name('ss.dashboardadmin');

        // Route untuk tampilkan form Submit SS
        Route::get('/submit', [SuggestionController::class, 'showSubmitForm'])->name('ss.submitadmin');
        
        // Route untuk menyimpan data form
        Route::post('/submit', [SuggestionController::class, 'store'])->name('ss.submitadmin.store');

               // Rute untuk autocomplete
       Route::get('/departments', [SuggestionController::class, 'getDepartments'])->name('ss.departments');
       Route::get('/detail-departments', [SuggestionController::class, 'getDetailDepartments'])->name('ss.detail-departments');
        
    });


});