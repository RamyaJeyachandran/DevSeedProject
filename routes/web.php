<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HospitalSettingsController;
use App\Http\Controllers\HospitalBranchController;
use App\Http\Controllers\ConsentFromController;
use App\Http\Controllers\AppointmentController;

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
    return view('pages.login')->with('errorMsg', '');
});

Route::post('login', [AuthController::class, 'loginUser']);
Route::get('login/{errorMsg}', [AuthController::class, 'login']);

Route::group(['middleware' => 'customAuth'], function () {
    // Logout
    Route::get('logout', [AuthController::class, 'logout']);
    //Dashboard
    Route::get('Home', [DashboardController::class, 'index']);

    //Hospital
    Route::get('Hospital', [HospitalSettingsController::class, 'index']);
    Route::get('SearchHospital', [HospitalSettingsController::class, 'searchHospital']);
    Route::get('showHospital/{id}', [HospitalSettingsController::class, 'showEdit']);

    //Branch
    Route::get('Branch', [HospitalBranchController::class, 'index']);
    Route::get('SearchBranch', [HospitalBranchController::class, 'searchIndex']);
    Route::get('showBranch/{id}', [HospitalBranchController::class, 'showEdit']);

    //Doctor
    Route::get('Doctor', [DoctorController::class, 'index']);
    Route::get('SearchDoctor', [DoctorController::class, 'searchIndex']);
    Route::get('showDoctor/{id}', [DoctorController::class, 'showEdit']);

    //Patient
    Route::get('Patient', [PatientController::class, 'index']);
    Route::get('SearchPatient', [PatientController::class, 'searchIndex']);
    Route::get('showPatient/{id}', [PatientController::class, 'showEdit']);

    //Appointment
    Route::get('PatientAppointment', [AppointmentController::class, 'index']);
    Route::get('AllAppointments', [AppointmentController::class, 'searchIndex']);

    //Consent Form
    Route::get('ConsentForm/{patientConsentId?}', [ConsentFromController::class, 'index']);
    Route::get('SearchConsent', [ConsentFromController::class, 'searchIndex']);
    Route::get('ViewConsent', [ConsentFromController::class, 'viewIndex']);

    Route::get('subscribe', [DashboardController::class, 'subscribe']);
    Route::get('ResetPassword', [DashboardController::class, 'ResetPassword']);

});
// Auth::routes();