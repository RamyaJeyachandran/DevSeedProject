<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HospitalBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use config\constants;
use URL;

class HospitalBranchController extends Controller
{
    public function index()
    {
        return view('pages.addBranch');
    }
    public function searchIndex()
    {
        return View("pages.searchBranch");
    }
    public function saveHospitalBranch(Request $request)
    {
        try {
            $result = array();
            DB::beginTransaction();
            $validateUser = Validator::make($request->all(), [
                'branchName' => 'required',
                'hospitalId'=>'required',
                'phoneNo' => 'required',
                'email' => 'required',
                'address' => 'required',
                'contactPerson' => 'required',
                'contactPersonPhNo' => 'required',
                'password'=>'required',
            ]);
            if ($validateUser->fails()) {
                $result['ShowModal'] = 1;
                $result['Success'] = 'Failure';
                $result['Message'] = "Validation failed. Please fill the required field marked as *";
                return response()->json($result, 200);
            }
            //----------------Store Image ---Begin 
            $url = URL::to("/");
            $logo =$url ."/".config('constant.hospital_default_logo');
            if($request->hasfile('logo')){
                $img_location="images/hospitals/";
                $img_name =config('constant.prefix_hospital_logo').'_'.time().'.'.$request->logo->getClientOriginalExtension();
                $request->logo->move(public_path($img_location), $img_name);

                $logo =$img_location.$img_name;
                $logo=$url ."/". $logo;
            }
            
            //-------------------Store Image ---End
            $branch_obj = new HospitalBranch;
            $chkPhoneNo = $branch_obj->getBranchByEmailorPhnNo($request);
            if ($chkPhoneNo != NULL) {
                $result['ShowModal'] = 1;
                $result['Success'] = "Please enter another phone no or email id.";
                $result['Message'] = "This Phone No or Email already exists for : " . $chkPhoneNo->branchName;
                return response()->json($result, 200);
            }

            $branch = $branch_obj->addHospitalBranch($request,$logo);
            $branchId=$branch->id;
             //Login creation
             if($branchId>0){
                 
                $login_created=0;
                $password=(isset($request->password) && !empty($request->password)) ?$request->password : NULL;
                if($password!=NULL){
                    $user_obj = new User;
                    $chkEmail=$user_obj->checkEmailId($request->email);
                    if(count($chkEmail)>0){
                        DB::rollback();
                        $result['ShowModal'] = 1;
                        $result['Success'] = 'Email id already exists for another user.';
                        $result['Message'] = "Please change the email id.";
                        return response()->json($result, 200);
                    }else{
                        $user_obj = new User;
                        $user_details=$user_obj->createLogin($request,config('constant.branch_user_type_id'),$branchId,$request->branchName);
                        $login_created=1;
                    }
                }
            }

            $result['ShowModal'] = 1;
            $result['loginCreation']=$login_created;
            $result['Success'] = 'Success';
            $result['Message'] = "Branch created successfully";
            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $result['ShowModal'] = 1;
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function getAllHospitalBranch(Request $request)
    {
        try {
            $pagination['page']=(isset($request->page) && !empty($request->page)) ?$request->page : 1;
            $pagination['size']=(isset($request->size) && !empty($request->size)) ?$request->size : 10;
            $pagination['sorters_field']=(isset($request->sorters[0]['field']) && !empty($request->sorters[0]['field'])) ?$request->sorters[0]['field'] : "id";
            $pagination['sorters_dir']=(isset($request->sorters[0]['dir']) && !empty($request->sorters[0]['dir'])) ?$request->sorters[0]['dir'] : "desc";

            $pagination['filters_field']=(isset($request->filters[0]['field']) && !empty($request->filters[0]['field'])) ?$request->filters[0]['field'] : "";
            $pagination['filters_type']=(isset($request->filters[0]['type']) && !empty($request->filters[0]['type'])) ?$request->filters[0]['type'] : "";
            $pagination['filters_value']=(isset($request->filters[0]['value']) && !empty($request->filters[0]['value'])) ?$request->filters[0]['value'] :"";

            $hospitalId = (isset($request->hospitalId) && !empty($request->hospitalId)) ? $request->hospitalId : NULL;
             //Decrypt --- BEGIN
             $user = new User;
             $decrpt_hospitalId=($hospitalId==NULL?$hospitalId:$user->getDecryptedId($hospitalId));
             //Decrypt --- END
            $branch_obj = new HospitalBranch;
            $branchList = $branch_obj->getAllHospitalBranch($decrpt_hospitalId,$pagination);

            $result['last_page'] = $branchList['lastPage'];
            $result['data'] = $branchList['branchList'];
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
            $branch_obj = new HospitalBranch;
            $branchDetails = $branch_obj->getHospitalBranchById($id_orignal);

            return view('pages.editBranch')->with('branchDetails', $branchDetails);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }

    public function getHospitalBranchById(Request $request, $id)
    {
        try {
            $id_orignal = "AES_DECRYPT(UNHEX('" . $id . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
            $branch_obj = new HospitalBranch;
            $branchDetails = $branch_obj->getHospitalBranchById($id_orignal);
            $result['Success'] = 'Success';
            $result['branchDetails'] = $branchDetails;
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }
    public function updateBranchHospital(Request $request)
    {
        try {
            $result = array();
            DB::beginTransaction();
            $validateUser = Validator::make($request->all(), [
                'branchName' => 'required',
                'hospitalId'=>'required',
                'phoneNo' => 'required',
                'email' => 'required',
                'address' => 'required',
                'contactPerson' => 'required',
                'contactPersonPhNo' => 'required',
            ]);
            if ($validateUser->fails()) {
                $result['ShowModal'] = 1;
                $result['Success'] = 'Failure';
                $result['Message'] = "Validation failed. Please fill the required field marked as *";
                return response()->json($result, 200);
            }
             //----------------Store Image ---Begin 
             $logo ="";
             if($request->isImageChanged==1)
             {
                $url = URL::to("/");
                $logo =$url ."/".config('constant.hospital_default_logo');
                if($request->hasfile('logo')){
                    $img_location="images/hospitals/";
                    $img_name =config('constant.prefix_hospital_logo').'_'.time().'.'.$request->logo->getClientOriginalExtension();
                    $request->logo->move(public_path($img_location), $img_name);
    
                    $logo =$img_location.$img_name;
                    $logo=$url ."/". $logo;
                }
            }
             //-------------------Store Image ---End
             $branch_obj = new HospitalBranch;
             $chkPhoneNo = $branch_obj->checkPhoneNoById($request);
             if ($chkPhoneNo != NULL) {
                 $result['ShowModal'] = 1;
                 $result['Success'] = "Please enter another phone no or email id.";
                 $result['Message'] = "This Phone No or Email already exists for : " . $chkPhoneNo->branchName;
                 return response()->json($result, 200);
             }
           
            $branch = $branch_obj->updateHospitalBranch($request,$logo);
             
            $result['ShowModal'] = 1;
            $result['Success'] = 'Success';
            $result['Message'] = "Branch updated successfully";
            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $result['ShowModal'] = 1;
            $result['Success'] = 'failure';
            $result['Message'] = $th->getMessage();
            return response()->json($result, 200);
        }
    }

    public function getHospitalList(Request $request)
    {
        try{
            $branch_obj = new HospitalBranch;
            $hospitalList =  $branch_obj->getHospitalList(); 

                $result['hospitalList']=$hospitalList;
                $result['Success']='Success';
                $result['Message']="Fetched Successfully";
                return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function deleteBranch(Request $request,$id,$userId){
        try{
            $branch_obj = new HospitalBranch;
            $branchDetails=$branch_obj->deleteHospitalBranchById($id,$userId);
            $user_obj = new User;
            $user_login=$user_obj->deleteLogin($id,config("constant.branch_user_type_id"),$userId);

            $result['Success']='Success';
            $result['ShowModal']= 1;
            $result['hospitalDetails']=$branchDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    } 
}