<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\loginLog;
use Illuminate\Http\Request;
use App\Models\HospitalBranch;
use App\Models\HospitalSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try{
            $companyId=$request->session()->get('companyId')==null ? 1 : $request->session()->get('companyId');
        $log_obj=new loginLog;
        $log_obj->setDatabaseByCompanyId($companyId);
        
            $userId = $request->session()->get('userId');
            $user_obj=new User;
            $userDetails=$user_obj->userInformation( $userId );
            $dashboardDetails=array();
            $hospital_obj=new HospitalSettings;

            switch($userDetails->user_type_id){
                case 1:
                    $dashboardDetails=$hospital_obj->getAdminDashboard();
                    break;
                case 2:
                    $dashboardDetails=$hospital_obj->getHospitalDashboard($userDetails->user_id);
                    break;
                case 4:
                    $dashboardDetails=$hospital_obj->getBranchDashboard($userDetails->user_id);
                    break;
                case 5:
                    $dashboardDetails=$hospital_obj->getDoctorDashboard($userDetails->user_id);
                    $result['dashboardDetails']=$dashboardDetails;
                    $result['Success']='Success';
                    // return response()->json($result,200);
                    break;
            }
           
            return view('pages.home')->with('dashboardDetails',$dashboardDetails);
        }catch(\Throwable $th){
            return Redirect::back()->withErrors($th->getMessage());
        }
    }
    public function getAppointmentStatus(Request $request,$doctorId)
    {
        try{
            $user_obj=new User;
            $originalId=$user_obj->getDecryptedId( $doctorId );
            $hospital_obj=new HospitalSettings;
            $appointmentStatus=$hospital_obj->getAppointmentStatus($originalId);
            $labels= array_column($appointmentStatus, 'status');
            $data= array_column($appointmentStatus, 'statusCount');
            $bgColor= array_column($appointmentStatus, 'statuscolor');

            $result['ShowModal']=1;
            $result['chart_labels']=$labels;
            $result['chart_data']=$data;
            $result['chart_bgColor']=$bgColor;
            $result['Success']='Success';
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
  
    public function ResetPassword(Request $request,$userId)
    {   
        try{
            $user_obj=new User;
            $userDetails=$user_obj->getUserInfo( $userId );
            return view('pages.changePassword')->with('userDetails',$userDetails);
        }catch(\Throwable $th){
            return Redirect::back()->withErrors($th->getMessage());
        }
    }
    public function updatePassword(Request $request)
    { try{
        $result=array();
        DB::beginTransaction();
        $validateUser=Validator::make($request->all(), [
            'newPassword'=>'required',
            'confirmNewPassword'=>'required',
            'userId'=>'required',
        ]);
        if($validateUser->fails()){
            $result['ShowModal']=1;
            $result['Success']='Failure';
            $result['Message']="Validation failed. Please fill the required fields";
            return response()->json($result,200);
        }
        if($request->newPassword!= $request->confirmNewPassword){
            $result['ShowModal']=1;
            $result['Success']='Failure';
            $result['Message']="New password and Confirm password doesn't match.";
            return response()->json($result,200);
        }
        $user_obj=new User;
        $userDetails=$user_obj->updatePassword($request);
            
            $result['ShowModal']=1;
            $result['userDetails']=$userDetails;
            $result['Success']='Success';
            $result['Message']="Password changed successfully.";
            DB::commit();
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }   
    public function userProfile(Request $request,$id)
    {
        try{
            $user_obj=new User;
            $profileDetails=$user_obj->userProfile($id);
            return view('pages.profile')->with('profileDetails',$profileDetails);
        }catch(\Throwable $th){
            return Redirect::back()->withErrors($th->getMessage());
        }
    } 
    public function forgetPassword(Request $request)
    { try{
        $result=array();
        DB::beginTransaction();
        $validateUser=Validator::make($request->all(), [
            'newPassword'=>'required',
            'confirmPassword'=>'required',
            'emailId'=>'required',
            'companyId'=>'required'
        ]);
        if($validateUser->fails()){
            $result['ShowModal']=1;
            $result['Success']='Failure';
            $result['Message']="Validation failed. Please fill the required fields";
            return response()->json($result,200);
        }
        if($request->newPassword!= $request->confirmPassword){
            $result['ShowModal']=1;
            $result['Success']='Failure';
            $result['Message']="New password and Confirm password doesn't match.";
            return response()->json($result,200);
        }
        if($request->companyId==1)
        {
            $request->session()->put('dbName',config('constant.seed_db_name'));
            DB::disconnect();
            Config::set('database.default','mysql');
            DB::reconnect();
        }else if($request->companyId==2)
        {
            $request->session()->put('dbName',config('constant.stech_db_name'));
            DB::disconnect();
            Config::set('database.default','mysql_stech');
            DB::reconnect();
        }
        
         $user_obj=new User;
        $chkEmail=$user_obj->checkEmailId($request->emailId);
        if(count($chkEmail)>0){
            $userId=$chkEmail[0]->id;
            $userDetails=$user_obj->forgetPassword($request,$userId);
        }else{
            DB::rollback();
            $result['ShowModal']=1;
            $result['Success']='Failure';
            $result['Message']="Email Id doesn't exists";
            return response()->json($result,200);
        }
            $result['ShowModal']=1;
            $result['userDetails']=$userDetails;
            $result['Success']='Success';
            $result['Message']="Password changed successfully.";
            DB::commit();
            return response()->json($result,200);   
        }catch(\Throwable $th){
            DB::rollback();
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }   
    public function getUserColourTheme(Request $request,$userId)
    {   
        try{
            $user_obj=new User;
            $userDetails=$user_obj->getUserInfo( $userId );
            return view('pages.colourTheme')->with('userDetails',$userDetails);
        }catch(\Throwable $th){
            return Redirect::back()->withErrors($th->getMessage());
        }
    }
    public function setColorTheme(Request $request)
    { try{
        $result=array();
        $validateUser=Validator::make($request->all(), [
            'colorId'=>'required',
            'userId'=>'required',
        ]);
        if($validateUser->fails()){
            $result['ShowModal']=1;
            $result['Success']='Failure';
            $result['Message']="Validation failed. Please fill the required fields";
            return response()->json($result,200);
        }
        $user_obj=new User;
        $userDetails=$user_obj->setColorId($request);

                $color_array=$user_obj->hexToRgbMethod1($request->colorId);
                if(count($color_array)==3)
                {
                    $rgbColor=$color_array[0].' '.$color_array[1].' '.$color_array[2];
                    $request->session()->put('colorId', $rgbColor);
                }

            $result['ShowModal']=1;
            $result['data']=$userDetails;
            $result['Success']='Success';
            $result['Message']="Theme changed successfully.";
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    } 
    public function getDefaultSetting(Request $request,$userId)
    {   
        try{
            $user_obj=new User;
            $userDetails=$user_obj->getUserInfo( $userId );
            $hospitalId=$userDetails->user_type_id==1?($userDetails->defaultHospitalId==null?0:$userDetails->defaultHospitalId):$userDetails->user_id;
            $branch_obj = new HospitalBranch;
            $userDetails->hospitalList = $branch_obj->getHospitalList();
            $userDetails->branchList = $branch_obj->getBranchListByHospitalId($hospitalId);
            return view('pages.setDefaultHospital')->with('details',$userDetails);
        }catch(\Throwable $th){
            // return Redirect::back()->withErrors($th->getMessage());
            $result['ShowModal']=$hospitalId;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function setDefaultHospital(Request $request)
    { try{
        $result=array();
        $validateUser=Validator::make($request->all(), [
            'userId'=>'required',
        ]);
        if($validateUser->fails()){
            $result['ShowModal']=1;
            $result['Success']='Failure';
            $result['Message']="Validation failed. Please fill the required fields";
            return response()->json($result,200);
        }
        // $hospitalId=(isset($request->hospitalId) && !empty($request->hospitalId));
        $user_obj=new User;
        $userDetails=$user_obj->updateDefaultHospital($request);
        $branchId= ($request->branchId==0|| $request->branchId==null) ?$user_obj->getEncryptedId(0): $request->branchId;
        $hosptialId= (isset($request->hosptialId) && !empty($request->hosptialId)) ? 1:0;
        if($hosptialId>0)
        {
            $request->session()->put('hospitalId', $request->hospitalId);
        }
        $request->session()->put('branchId', $branchId);
             
            $result['ShowModal']=1;
            $result['Success']='Success';
            $result['Message']="Default Hospital/Branch changed successfully.";
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }  
}