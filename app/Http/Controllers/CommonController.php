<?php

namespace App\Http\Controllers;

use App\Models\User;
use config\constants;
use App\Models\Cities;
use App\Models\MixedTables;
use Illuminate\Http\Request;
use App\Models\HospitalBranch;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function getCities(Request $request)
    {
        try {
            $cities = new Cities;
            $city_list = $cities->getCities();
            if ($city_list != null) {
                $result['cities'] = $city_list;
                $result['Success'] = 'Success';
                $result['Message'] = "Fetched Cities";
                return response()->json($result, 200);
            }
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
        $result['Success'] = 'failure';
        $result['Message'] = "No cities found";
        return response()->json($result, 200);
    }

    public function getPatientddl(Request $request)
    {
        try {
            $cities = new Cities;
            $city_list = $cities->getCities();

            $mixedTable = new MixedTables;
            $genderList = $mixedTable->getGender();
            $maritalStatusList = $mixedTable->getMartialStatus();
            $refferedByList = $mixedTable->getRefferedBy();
            $bloodGrp = $mixedTable->getBloodGrp();

            $result['cities'] = $city_list;
            $result['gender'] = $genderList;
            $result['martialStatus'] = $maritalStatusList;
            $result['refferedBy'] = $refferedByList;
            $result['bloodGrp'] = $bloodGrp;
            $result['Success'] = 'Success';
            $result['Message'] = "Fetched Successfully";
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function getDoctorddl(Request $request)
    {
        try {
            $mixedTable = new MixedTables;
            $genderList = $mixedTable->getGender();
            $departmentList = $mixedTable->getDepartment();
            $bloodGrp = $mixedTable->getBloodGrp();

            $result['gender'] = $genderList;
            $result['department'] = $departmentList;
            $result['bloodGrp'] = $bloodGrp;
            $result['Success'] = 'Success';
            $result['Message'] = "Fetched Successfully";
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function getAppointmentddl(Request $request)
    {
        try {
            $mixedTable = new MixedTables;
            $genderList = $mixedTable->getGender();
            $departmentList = $mixedTable->getDepartment();

            $result['gender'] = $genderList;
            $result['department'] = $departmentList;
            $result['Success'] = 'Success';
            $result['Message'] = "Fetched Successfully";
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function loadHospital(Request $request)
    {
        try {
            $branch_obj = new HospitalBranch;
            $hospitalList = $branch_obj->getHospitalList();
            $result['hospitalList'] = $hospitalList;
            $result['Success'] = 'Success';
            $result['Message'] = "Fetched Successfully";
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function loadBranchByHospital(Request $request, $hospitalId)
    {
        try {
            $branch_obj = new HospitalBranch;
            $branchList = $branch_obj->getBranchListByHospitalId($hospitalId);
            $result['branchList'] = $branchList;
            $result['Success'] = 'Success';
            $result['Message'] = "Fetched Successfully";
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
}