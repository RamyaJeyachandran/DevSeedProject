<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonorBankController;
use App\Http\Controllers\RefferedByController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ConsentFromController;
use App\Http\Controllers\SemenAnalysisController;
use App\Http\Controllers\HospitalBranchController;
use App\Http\Controllers\DoctorSignatureController;
use App\Http\Controllers\HospitalSettingsController;

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
  Route::post('updateRefferedBy', [RefferedByController::class, 'updatePatient']);
  //Doctor    
  Route::post('addDoctor', [DoctorController::class, 'registerDoctor']);
  Route::get('doctorList', [DoctorController::class, 'getAllDoctor']);
  Route::get('getDoctorCommonData', [CommonController::class, 'getDoctorddl']);
  Route::get('doctorInfo/{id}', [DoctorController::class, 'getDoctorById']);
  Route::post('updateDoctor', [DoctorController::class, 'updateDoctor']);
  Route::get('deleteDoctor/{id}/{userId}', [DoctorController::class, 'deleteDoctor']);
  Route::get('doctorByDepartment/{hospitalId}/{branchId}/{departId}', [DoctorController::class, 'getDoctorByDepartment']);
  Route::get('doctorSignature/{doctorId}', [DoctorSignatureController::class, 'getDoctorSignatureByDoctorId']);
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
  Route::get('patientAppointmentInfo/{id}', [AppointmentController::class, 'getPatientAppointmentInfo']);
  Route::get('deleteAppointment/{id}/{userId}', [AppointmentController::class, 'deleteAppointment']);
  Route::post('updateAppointment', [AppointmentController::class, 'updateAppointment']);
  Route::post('updateStatus', [AppointmentController::class, 'updateAppointmentStatus']);
  
  //Common api
  Route::get('getCommonData', [CommonController::class, 'getPatientddl']);
  Route::get('listCity', [CommonController::class, 'getCities']);
  Route::get('listBloodGroup', [CommonController::class, 'getBloodGroup']);
  Route::get('listAppointmentDDl', [CommonController::class, 'getAppointmentddl']);
  Route::get('loadHospital', [CommonController::class, 'loadHospital']);
  Route::get('loadBranch/{hospitalId}', [CommonController::class, 'loadBranchByHospital']);

  Route::post('resetPassword', [DashboardController::class, 'updatePassword']);
  Route::get('appointmentStatusChart/{doctorId}', [DashboardController::class, 'getAppointmentStatus']);
  
  //Report - Semen Analysis
  Route::post('addSemenAnalysis', [SemenAnalysisController::class, 'saveSemenAnalysis']);
  Route::post('updateSemenAnalysis', [SemenAnalysisController::class, 'updateSemenAnalysis']);
  Route::get('getSemenAnalysisCommonData', [CommonController::class, 'getSemenAnalysisddl']);
  Route::get('getPatientDoctor/{hospitalId}/{branchId}', [SemenAnalysisController::class, 'getPatientDoctor']);
  Route::get('SemenAnalysisList', [SemenAnalysisController::class, 'getAllSemenAnalysis']);
  Route::get('deleteSemenAnalysis/{id}/{userId}', [SemenAnalysisController::class, 'deleteSemenAnalysis']);

  //Report
  Route::post('reportPatientWise', [ReportController::class, 'getReportPatientWise']);
  Route::post('reportPatientDetails', [ReportController::class, 'getPatientDetailReport']);

  //Assign Doctor
  Route::post('addAssignDoctor', [DoctorController::class, 'addAssignDoctor']);
  Route::get('assignedPatientList', [DoctorController::class, 'getAllAssignedPatient']);
  Route::get('deleteAssignedDoctor/{id}/{userId}', [DoctorController::class, 'deleteAssignDoctor']);
  Route::post('updateAssignDoctor', [DoctorController::class, 'updateAssignDoctor']);
  Route::get('loadUnAssigned/{hospitalId}/{branchId}', [DoctorController::class, 'getUnAssignedPatientDoctor']);

  //Donor Bank
  Route::get('donorBankList', [DonorBankController::class, 'getAllDonorBank']);
  Route::post('addDonorBank', [DonorBankController::class, 'addDonorBank']);
  Route::get('deleteDonorBank/{id}/{userId}', [DonorBankController::class, 'deleteDonorBank']);
});

// Route::get('convertToHash/{id}',[loginController::class,'convertToHash']);
// Route::get('getCrypId',[loginController::class,'getCrypId']);
