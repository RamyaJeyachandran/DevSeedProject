<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\HospitalSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try{
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
        $user_obj=new User;
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
}