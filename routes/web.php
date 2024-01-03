<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonorBankController;
use App\Http\Controllers\RefferedByController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ConsentFromController;
use App\Http\Controllers\PageSettingsController;
use App\Http\Controllers\SemenAnalysisController;
use App\Http\Controllers\HospitalBranchController;
use App\Http\Controllers\ReportSignatureController;
use App\Http\Controllers\HospitalSettingsController;

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
Route::get('ForgetPassword', [AuthController::class, 'forgetPassword']);

Route::get('login/{errorMsg}', [AuthController::class, 'login']);
 //Payment - Phonepe
 Route::get('phonepe',[PaymentController::class,'phonePe']);
 Route::any('phonepe-response',[PaymentController::class,'response'])->name('response');


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
    Route::get('RefferedBy', [RefferedByController::class, 'index']);
    Route::get('viewRefferedBy/{id}', [RefferedByController::class, 'showRefferedBy']);

    //Appointment
    Route::get('PatientAppointment', [AppointmentController::class, 'index']);
    Route::get('AllAppointments', [AppointmentController::class, 'searchIndex']);
    Route::get('showAppointment/{id}/{type}', [AppointmentController::class, 'showEdit']);
    Route::get('TodayAppointments', [AppointmentController::class, 'showToday']);
    
    //Consent Form
    Route::get('ConsentForm/{patientConsentId?}', [ConsentFromController::class, 'index']);
    Route::get('SearchConsent', [ConsentFromController::class, 'searchIndex']);
    Route::get('ViewConsent', [ConsentFromController::class, 'viewIndex']);

    Route::get('ResetPassword/{id}', [DashboardController::class, 'ResetPassword']);
    Route::get('Profile/{id}', [DashboardController::class, 'userProfile']);
    Route::get('ColourTheme/{id}', [DashboardController::class, 'getUserColourTheme']);
    
    //SemenAnalysis
    Route::get('SemenAnalysis', [SemenAnalysisController::class, 'index']);
    Route::get('PrintSemenAnalysis/{id}', [SemenAnalysisController::class, 'showPrint']);
    Route::get('SearchSemenAnalysis', [SemenAnalysisController::class, 'searchIndex']);
    Route::get('ShowSemenAnalysis/{id}', [SemenAnalysisController::class, 'showEdit']);
    
    //Assign Doctor
    Route::get('AssignDoctor', [DoctorController::class, 'assignIndex']);
    Route::get('ListAssignedDoctor', [DoctorController::class, 'listIndex']);
    Route::get('showAssignEdit/{id}', [DoctorController::class, 'showAssignDoctorEdit']);

    //Report
    Route::get('PatientReport', [ReportController::class, 'index']);
    Route::get('PatientDetails', [ReportController::class, 'patientIndex']);  

    //Payment
    Route::get('subscribe', [PaymentController::class, 'subscribe']);

    Route::get('DonorBank', [DonorBankController::class, 'index']);

    //Settings
    Route::get('PrintSettings', [PageSettingsController::class, 'index']);
    Route::get('ReportSignature', [ReportSignatureController::class, 'index']);

});
// Auth::routes();