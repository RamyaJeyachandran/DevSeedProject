<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HospitalSettingsController;
use App\Http\Controllers\HospitalBranchController;
use App\Http\Controllers\ConsentFromController;
use App\Http\Controllers\AppointmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});
// Route::post('/auth/register', [AuthController::class, 'createUser']);

Route::group(['middleware' => 'auth:sanctum'], function () {
  //Hospital api
  Route::post('addHospital', [HospitalSettingsController::class, 'saveHospitalSettings']);
  Route::get('hospitalList', [HospitalSettingsController::class, 'getAllHospitalSettings']);
  Route::get('deleteHospital/{id}/{userId}', [HospitalSettingsController::class, 'deleteHospital']);
  Route::post('updateHospital', [HospitalSettingsController::class, 'updateHospitalSetings']);
  Route::get('hospitalInfo/{id}', [HospitalSettingsController::class, 'getHospitalSettingsById']);
  //Patient
  Route::get('patientList', [PatientController::class, 'getAllPatient']);
  Route::post('addPatient', [PatientController::class, 'registerPatient']);
  Route::get('patientInfo/{id}', [PatientController::class, 'getPatientById']);
  Route::post('updatePatient', [PatientController::class, 'updatePatient']);
  Route::get('deletePatient/{id}/{userId}', [PatientController::class, 'deletePatient']);
  //Doctor    
  Route::post('addDoctor', [DoctorController::class, 'registerDoctor']);
  Route::get('doctorList', [DoctorController::class, 'getAllDoctor']);
  Route::get('getDoctorCommonData', [CommonController::class, 'getDoctorddl']);
  Route::get('doctorInfo/{id}', [DoctorController::class, 'getDoctorById']);
  Route::post('updateDoctor', [DoctorController::class, 'updateDoctor']);
  Route::get('deleteDoctor/{id}/{userId}', [DoctorController::class, 'deleteDoctor']);
  Route::get('doctorByDepartment/{hospitalId}/{branchId}/{departId}', [DoctorController::class, 'getDoctorByDepartment']);
  //Branch
  Route::get('listAllHospital', [HospitalBranchController::class, 'getHospitalList']);
  Route::post('addBranch', [HospitalBranchController::class, 'saveHospitalBranch']);
  Route::get('branchList', [HospitalBranchController::class, 'getAllHospitalBranch']);
  Route::get('branchInfo/{id}', [HospitalBranchController::class, 'getHospitalBranchById']);
  Route::get('deleteBranch/{id}/{userId}', [HospitalBranchController::class, 'deleteBranch']);
  Route::post('updateBranch', [HospitalBranchController::class, 'updateBranchHospital']);
  //Consent Form
  Route::get('consentFormList/{hospitalId}/{branchId}/{hcNo}', [ConsentFromController::class, 'getFormList']);
  Route::post('savePatientConsent', [ConsentFromController::class, 'saveConsentForm']);
  Route::get('patientConsentList', [ConsentFromController::class, 'getPatientConsentDetails']);
  //Appointment
  Route::get('registeredPatientInfo/{hcNo}/{hospitalId}/{branchId}', [AppointmentController::class, 'getPatientInfo']);
  Route::post('addPatientAppointment', [AppointmentController::class, 'addAppointment']);
  Route::get('appointmentList', [AppointmentController::class, 'getAllAppointment']);

  //Common api
  Route::get('getCommonData', [CommonController::class, 'getPatientddl']);
  Route::get('listCity', [CommonController::class, 'getCities']);
  Route::get('listBloodGroup', [CommonController::class, 'getBloodGroup']);
  Route::get('listAppointmentDDl', [CommonController::class, 'getAppointmentddl']);
  Route::get('loadHospital', [CommonController::class, 'loadHospital']);
  Route::get('loadBranch/{hospitalId}', [CommonController::class, 'loadBranchByHospital']);
});

// Route::get('convertToHash/{id}',[loginController::class,'convertToHash']);
// Route::get('getCrypId',[loginController::class,'getCrypId']);
