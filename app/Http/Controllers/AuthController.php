<?php

namespace App\Http\Controllers;

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

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User 
     */
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

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
            // $request->session()->put('id', $id);
            $request->session()->put('userName',Auth::user()->name);

            $token_name="Token".$id."-".Carbon::now()->rawFormat("m/d/Y H:i:s");
            $decrypt_token_name=Hash::make($token_name, ['rounds' => 12,]);

            $token = $request->user()->createToken($token_name,expiresAt:now()->addMonth())->plainTextToken;
            $request->session()->put('prjtoken',$token);
            $request->session()->put('prjTokenName',$decrypt_token_name);

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
                    $request->session()->put('hospitalId', $hospitalId);
                    $request->session()->put('branchId',$branchId);
                    break;
                case 4: //Branch
                    $branch_obj=new HospitalBranch;
                    $branch_details=$branch_obj->getHospitalBranchById(Auth::user()->user_id);
                    if($branch_details!=NULL){
                        $request->session()->put('hospitalId', $branch_details->hospitalId);
                        $request->session()->put('branchId',$branch_details->branchId);
                    }
                    break;
                case 5: //Doctors
                    $doctor_obj=new doctor;
                    $doctor_details=$doctor_obj->getDoctorById(Auth::user()->user_id);
                    if($doctor_details!=NULL){
                        $hospitalId=$user->getEncryptedId($doctor_details->hospitalId);
                        $branchId=$user->getEncryptedId($doctor_details->branchId);
                        $request->session()->put('hospitalId', $hospitalId);
                        $request->session()->put('branchId',$branchId);
                    }
                    break;
            }

            return redirect('/Home');

        } catch (\Throwable $th) {
            return redirect()->action(
                [AuthController::class, 'login'], ['errorMsg' =>   $th->getLine()]
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