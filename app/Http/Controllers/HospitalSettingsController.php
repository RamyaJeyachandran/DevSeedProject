<?php

namespace App\Http\Controllers;

use URL;
use App\Models\User;
use config\constants;
use App\Models\pageSettings;
use Illuminate\Http\Request;
use App\Models\HospitalSettings;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class HospitalSettingsController extends Controller
{
    public function index()
    {
        return view('pages.hospitalSettings');
    }
    public function searchHospital()
    {
        return view('pages.searchHospital');
    }
    public function saveHospitalSettings(Request $request)
    {
        try {
            $result = array();
            DB::beginTransaction();
            $validateUser = Validator::make($request->all(), [
                'hospitalName' => 'required',
                'phoneNo' => 'required|numeric|digits:10',
                'email' => 'required',
                'password' => 'required',
                'address' => 'required',
                'inChargePerson' => 'required',
                'inChargePhoneNo' => 'required|numeric|digits:10'
            ]);
            if ($validateUser->fails()) {
                $result['ShowModal'] = 1;
                $result['Success'] = 'Failure';
                $result['Message'] = "Validation failed. Please fill the required field marked as *";
                return response()->json($result, 200);
            }

            //----------------Store Image ---Begin 
            $url = request()->getSchemeAndHttpHost();//URL::to("/");
            $logo = $url . "/" . config('constant.hospital_default_logo');
            if ($request->hasfile('logo')) {
                $img_location =config('constant.hospitalLogLocation');
                $img_name = config('constant.prefix_hospital_logo') . '_' . time() . '.' . $request->logo->getClientOriginalExtension();
                $request->logo->move(public_path($img_location), $img_name);

                $logo = $img_location . $img_name;
                $logo = $url . config('constant.imageStoreLocation'). $logo; //$url . "/seed/public/" . $logo;
            }

            //-------------------Store Image ---End

            $hospitalSettings_obj = new HospitalSettings;
            $chkHospital = $hospitalSettings_obj->getHospitalByEmailOrPhoneNo($request);
            if ($chkHospital != NULL) {
                $result['ShowModal'] = 1;
                $result['Success'] = 'Phone No or Email already exists.';
                $result['Message'] = "Phone No or Email already exists for : " . $chkHospital->hospitalName;
                return response()->json($result, 200);
            }

            $hospitalSettings = $hospitalSettings_obj->addHospitalSettings($request, $logo);
            $hospitalId = $hospitalSettings->id;
            //Login creation Begin
            if ($hospitalId > 0) {
                $user_obj = new User;
                $login_created = 0;
                $password = (isset($request->password) && !empty($request->password)) ? $request->password : NULL;
                if ($password != NULL) {
                    $chkEmail = $user_obj->checkEmailId($request->email);
                    if (count($chkEmail) > 0) {
                        $result['ShowModal'] = 1;
                        $result['Success'] = 'Email id already exists for another user.';
                        $result['Message'] = "Please change the email id.";
                        return response()->json($result, 200);
                    } else {
                        $user_details = $user_obj->createLogin($request, config('constant.hospital_user_type_id'), $hospitalId, $request->hospitalName);
                        if ($user_details->id > 0) {
                            $page_obj=new pageSettings;
                            $page_result=$page_obj->addPageSettings($user_details->id, config('constant.pageSetting.marginRight'),config('constant.pageSetting.marginLeft'),config('constant.pageSetting.marginBottom'),config('constant.pageSetting.marginTop'));
                            if ($page_result->id > 0) {
                                $login_created = 1;
                            }
                        }
                    }
                }
                //Create Consent form 
                $userId=$user_obj->getDecryptedId($request->userId);
                $user_obj->addConsentForm($hospitalId,0,$userId);
            }
            //Login creation End

            $result['ShowModal'] = 1;
            $result['loginCreation'] = $login_created;
            $result['Success'] = 'Success';
            $result['Message'] = "Hospital Settings created successfully";
            $result['logo'] = $logo;
            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['ShowModal'] = 1;
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function getAllHospitalSettings(Request $request)
    {
        try {
            $pagination['page'] = (isset($request->page) && !empty($request->page)) ? $request->page : 1;
            $pagination['size'] = (isset($request->size) && !empty($request->size)) ? $request->size : 10;
            $pagination['sorters_field'] = (isset($request->sorters[0]['field']) && !empty($request->sorters[0]['field'])) ? $request->sorters[0]['field'] : "id";
            $pagination['sorters_dir'] = (isset($request->sorters[0]['dir']) && !empty($request->sorters[0]['dir'])) ? $request->sorters[0]['dir'] : "desc";

            $pagination['filters_field'] = (isset($request->filters[0]['field']) && !empty($request->filters[0]['field'])) ? $request->filters[0]['field'] : "";
            $pagination['filters_type'] = (isset($request->filters[0]['type']) && !empty($request->filters[0]['type'])) ? $request->filters[0]['type'] : "";
            $pagination['filters_value'] = (isset($request->filters[0]['value']) && !empty($request->filters[0]['value'])) ? $request->filters[0]['value'] : "";


            $hospitalsettings_obj = new HospitalSettings;
            $hospitalList = $hospitalsettings_obj->getAllHospitalSettings($pagination);

            $result['last_page'] = $hospitalList['last_page'];
            $result['data'] = $hospitalList['hospitalSettingsList'];

            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function showEdit(Request $request, $id)
    {
        try {
            $id_orignal = "AES_DECRYPT(UNHEX('" . $id . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
            $hospitalsettings_obj = new HospitalSettings;
            $hospitalDetails = $hospitalsettings_obj->getHospitalSettingsById($id_orignal);

            return view('pages.editHospitalSettings')->with('hospitalDetails', $hospitalDetails);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }

    public function getHospitalSettingsById(Request $request, $id)
    {
        try {
            $id_orignal = "AES_DECRYPT(UNHEX('" . $id . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
            $hospitalsettings_obj = new HospitalSettings;
            $hospitalDetails = $hospitalsettings_obj->getHospitalSettingsById($id_orignal);
            $result['Success'] = 'Success';
            $result['hospitalDetails'] = $hospitalDetails;
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function updateHospitalSetings(Request $request)
    {
        try {
            $result = array();
            DB::beginTransaction();
            $validateUser = Validator::make($request->all(), [
                'hospitalName' => 'required',
                'phoneNo' => 'required|numeric|digits:10',
                'email' => 'required',
                'address' => 'required',
                'inChargePerson' => 'required',
                'inChargePhoneNo' => 'required|numeric|digits:10'
            ]);
            if ($validateUser->fails()) {
                $result['ShowModal'] = 1;
                $result['Success'] = 'Failure';
                $result['Message'] = "Validation failed. Please fill the required field marked as *";
                return response()->json($result, 200);
            }
            //----------------Store Image ---Begin 
            $logo = "";
            if ($request->isImageChanged == 1) {
                $url = request()->getSchemeAndHttpHost();//URL::to("/");
                $logo = $url . "/" . config('constant.hospital_default_logo');
                if ($request->hasfile('logo')) {
                    $img_location = config('constant.hospitalLogLocation');
                    $img_name = config('constant.prefix_hospital_logo') . '_' . time() . '.' . $request->logo->getClientOriginalExtension();
                    $request->logo->move(public_path($img_location), $img_name);

                    $logo = $img_location . $img_name;
                    $logo = $url . config('constant.imageStoreLocation') . $logo;
                }
            }
            //-------------------Store Image ---End

            $hospitalsettings_obj = new HospitalSettings;
            $chkPhoneNo = $hospitalsettings_obj->checkPhoneNoById($request);
            if ($chkPhoneNo != NULL) {
                $result['ShowModal'] = 1;
                $result['Success'] = 'Phone No already exists.';
                $result['Message'] = "Phone No already exists for : " . $chkPhoneNo->hospitalname;
                return response()->json($result, 200);
            }
            $user_obj = new User;
            $chkEmail = $user_obj->checkEmailIdForEdit($request->email,$request->hospitalId);
            if (count($chkEmail) > 0) {
                $result['ShowModal'] = 1;
                $result['Success'] = 'Email id already exists for another user.';
                $result['Message'] = "Please change the email id.";
                return response()->json($result, 200);
            } else {
                $user_obj->updateLogin($request->hospitalId,$request->userId,$request->hospitalName,$request->email,config('constant.hospital_user_type_id'));
            }

            $hospitalsettings_obj->updateHospitalSettings($request, $logo);

            $result['ShowModal'] = 1;
            $result['Success'] = 'Success';
            $result['Message'] = "Hospital Settings updated successfully";
            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['ShowModal'] = 1;
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function deleteHospital(Request $request, $id, $userId)
    {
        try {
            $hospital_obj = new HospitalSettings;
            $hospitalDetails = $hospital_obj->deleteHospitalSettingsById($id, $userId);
            $user_obj = new User;
            $user_login = $user_obj->deleteLogin($id, config("constant.hospital_user_type_id"), $userId);

            $result['Success'] = 'Success';
            $result['ShowModal'] = 1;
            $result['hospitalDetails'] = $hospitalDetails;
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }

}