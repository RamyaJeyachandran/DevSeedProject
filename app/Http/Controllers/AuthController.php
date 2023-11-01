<?php

namespace App\Http\Controllers;

use App\Models\HospitalSettings;
use Carbon\Carbon;
use App\Models\User;
use App\Models\doctor;
use Illuminate\Http\Request;
use App\Models\HospitalBranch;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DashboardController;
use URL;

class AuthController extends Controller
{
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return redirect()->action(
                    [AuthController::class, 'login'], ['errorMsg' =>  'Validation Error. Please enter the valid Email & Password.']
                );
            }
            $credetials = [
                'email' => $request->email,
                'password' => $request->password,
                'is_active' => 1,
            ];
            if (!Auth::attempt($credetials)) {
                return redirect()->action(
                    [AuthController::class, 'login'], ['errorMsg' =>  'Email & Password does not match with our record.']
                );
            }
            
            $user=new User;
            $user_type_id= Auth::user()->user_type_id;
            $id=Auth::user()->id;
            $userId=$user->getEncryptedId($id);
            $request->session()->put('userType',$user_type_id);
            $request->session()->put('userId', $userId);
            $request->session()->put('userName',Auth::user()->name);

            $token_name="Token".$id."-".Carbon::now()->rawFormat("m/d/Y H:i:s");
            $decrypt_token_name=Hash::make($token_name, ['rounds' => 12,]);

            $token = $request->user()->createToken($token_name,expiresAt:now()->addMonth())->plainTextToken;
            $request->session()->put('prjtoken',$token);
            $request->session()->put('prjTokenName',$decrypt_token_name);
            $url = URL::to("/");
            $logo=$url."/dist/images/logo.svg";
            $request->session()->put('logo',$logo);

            switch(Auth::user()->user_type_id){
                case 1: //Admin
                    $hospitalId=$user->getEncryptedId(0);
                    $branchId=$user->getEncryptedId(0);
                    $request->session()->put('hospitalId', $hospitalId);
                    $request->session()->put('branchId',$branchId);
                    break;
                case 2: //Hospital
                    $hospitalId=$user->getEncryptedId(Auth::user()->user_id);
                    $branchId=$user->getEncryptedId(0);
                    $hospital_obj=new HospitalSettings;
                    $hospital_details=$hospital_obj->getHospitalSettingsById(Auth::user()->user_id);
                    if($hospital_details!=null){
                        $request->session()->put('logo', $hospital_details->logo);
                    }
                    $request->session()->put('hospitalId', $hospitalId);
                    $request->session()->put('branchId',$branchId);
                    break;
                case 4: //Branch
                    $branch_obj=new HospitalBranch;
                    $branch_details=$branch_obj->getHospitalBranchById(Auth::user()->user_id);
                    if($branch_details!=NULL){
                        $request->session()->put('hospitalId', $branch_details->hospitalId);
                        $request->session()->put('branchId',$branch_details->branchId);
                        $request->session()->put('logo', $branch_details->logo);
                    }
                    break;
                case 5: //Doctors
                    $doctor_obj=new doctor;
                    $id=Auth::user()->user_id;
                    $doctor_details=$doctor_obj->getLogoByHospitalId($id);
                    if($doctor_details!=NULL){
                        $request->session()->put('hospitalId', $doctor_details->hospitalId);
                        $request->session()->put('branchId',$doctor_details->branchId);
                        $request->session()->put('profileImage',$doctor_details->profileImage);
                        $request->session()->put('logo',$doctor_details->logo);
                        $request->session()->put('userName',$doctor_details->name);
                    }
                    break;
            }
            return redirect()->action([DashboardController::class, 'index']);
        } catch (\Throwable $th) {
            return redirect()->action(
                [AuthController::class, 'login'], ['errorMsg' =>   $th->getMessage()]
            );
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $token = PersonalAccessToken::findToken($request->session()->get('prjtoken'));
        $token->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function login(Request $request, $errorMsg)
    {     
        return view('pages.login')->with('errorMsg', $errorMsg);
    }
}