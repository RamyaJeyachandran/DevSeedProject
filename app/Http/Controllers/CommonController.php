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
            $genderList = $mixedTable->getConsantValue(config('constant.genderTableId'));
            $maritalStatusList = $mixedTable->getConsantValue(config('constant.martialStatusTableId'));
            $refferedByList = $mixedTable->getConsantValue(config('constant.refferedByTableId'));
            $bloodGrp = $mixedTable->getConsantValue(config('constant.bloodGrpTableId'));

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
            $genderList = $mixedTable->getConsantValue(config('constant.genderTableId'));
            $departmentList = $mixedTable->getDepartment();
            $bloodGrp = $mixedTable->getConsantValue(config('constant.bloodGrpTableId'));

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
            $genderList = $mixedTable->getConsantValue(config('constant.genderTableId'));
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
    public function getSemenAnalysisddl(Request $request)
    {
        try {
            $mixedTable = new MixedTables;
            $liquefaction =  $mixedTable->getConsantValue(config('constant.liquefactionId'));
            $appearance = $mixedTable->getConsantValue(config('constant.appearanceId'));
            $ph =  $mixedTable->getConsantValue(config('constant.phId'));
            $viscosity =$mixedTable->getConsantValue(config('constant.viscosityId'));
            $agglutination =$mixedTable->getConsantValue(config('constant.agglutinationId'));
            $abstinence = $mixedTable->getConsantValue(config('constant.abstinenceId'));
            $clumping =$mixedTable->getConsantValue(config('constant.clumpingId'));
            $pusCells =$mixedTable->getConsantValue(config('constant.pusCellsId'));

            $result['liquefaction'] = $liquefaction;
            $result['appearance'] = $appearance;
            $result['ph'] = $ph;
            $result['viscosity'] = $viscosity;
            $result['agglutination'] = $agglutination;
            $result['abstinence'] = $abstinence;
            $result['clumping'] = $clumping;
            $result['pusCells'] = $pusCells;

            $result['Success'] = 'Success';
            $result['Message'] = "Fetched Successfully";
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }

    }
    public function loadDepartment(Request $request)
    {
        try {
            $mixedTable = new MixedTables;
            $departmentList = $mixedTable->getDepartment();
            $result['departmentList'] = $departmentList;
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