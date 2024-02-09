<?php

namespace App\Http\Controllers;

use URL;
use Carbon\Carbon;
use App\Models\User;
use config\constants;
use App\Models\doctor;
use App\Models\loginLog;
use Illuminate\Http\Request;
use App\Models\HospitalBranch;
use App\Models\HospitalSettings;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DashboardController;

class AuthController extends Controller
{
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required',
                    'companyId' => 'required',
                ]
            );
            $companyId = $request->companyId;
            if ($validateUser->fails()) {
                return redirect()->action(
                    [AuthController::class, 'login'],
                    ['errorMsg' => 'Validation Error. Please enter the valid Email & Password.', 'companyId' => $companyId]
                );
            }
            /* Handle Session --- BEGIN */
            $request->session()->regenerateToken();
            $sessionId = session()->getId();
            $request->session()->put('user_sessionId', $sessionId);
            /* Handle Session --- END */
            if ($request->companyId == 1) {
                $request->session()->put('dbName', config('constant.seed_db_name'));
                DB::disconnect();
                Config::set('database.default', 'mysql');
                DB::reconnect();
            } else if ($request->companyId == 2) {
                $request->session()->put('dbName', config('constant.stech_db_name'));
                DB::disconnect();
                Config::set('database.default', 'mysql_stech');
                DB::reconnect();
            }
            $request->session()->put('companyId', $companyId);
            $credetials = [
                'email' => $request->email,
                'password' => $request->password,
                'is_active' => 1,
            ];
            if (!Auth::attempt($credetials)) {
                return redirect()->action(
                    [AuthController::class, 'login'],
                    ['errorMsg' => 'Email & Password does not match with our record.', 'companyId' => $companyId]
                );
            }

            $user_type_id = Auth::user()->user_type_id;
            $id = Auth::user()->id;

            /* Handle Session --- BEGIN */
            Auth::user()->updateSessionDetails($id, $sessionId);
            /* Handle Session --- END */
            $username = $companyId == 1 ? 'SEED' : 'STECH IVF SOLUTIONS';
            $user = new User;
            $user->setMenuSession($request,$user_type_id);
            $userId = $user->getEncryptedId($id);
            $request->session()->put('userType', $user_type_id);
            $request->session()->put('userId', $userId);
            $request->session()->put('userName', $username);

            /*Theme ---BEGIN */
            $request->session()->put('colorId', config('constant.default_colorRbg'));
            if (Auth::user()->colorId != null) {
                $color_array = $user->hexToRgbMethod1(Auth::user()->colorId);
                if (count($color_array) == 3) {
                    $rgbColor = $color_array[0] . ' ' . $color_array[1] . ' ' . $color_array[2];
                    $request->session()->put('colorId', $rgbColor);
                }
            }
            /*Theme ---END */
            $token_name = "Token" . $id . "-" . Carbon::now()->rawFormat("m/d/Y H:i:s");
            $decrypt_token_name = Hash::make($token_name, ['rounds' => 12,]);

            $token = $request->user()->createToken($token_name, expiresAt: now()->addMonth())->plainTextToken;
            $request->session()->put('prjtoken', $token);
            $request->session()->put('prjTokenName', $decrypt_token_name);
            $url = request()->getSchemeAndHttpHost(); // URL::to("/");
            $logo = $url . config('constant.imageStoreLocation') . "dist/images/logo.svg";
            if ($companyId == 2) {
                $logo = $url . config('constant.imageStoreLocation') . "dist/images/logo_stech.png";
            }
            $request->session()->put('logo', $logo);
            $request->session()->put('branchLimit', '1');

            $loginLog = new loginLog;
            $loginLog->addLoginLog($id, 'Logged In');

            switch (Auth::user()->user_type_id) {
                case 1: //Admin
                    $hospitalId = $user->getEncryptedId(Auth::user()->defaultHospitalId == null ? 0 : Auth::user()->defaultHospitalId);
                    $branchId = $user->getEncryptedId(Auth::user()->defaultBranchId == null ? 0 : Auth::user()->defaultBranchId);
                    $request->session()->put('hospitalId', $hospitalId);
                    $request->session()->put('branchId', $branchId);
                    break;
                case 2: //Hospital
                    $hospitalId = $user->getEncryptedId(Auth::user()->user_id);
                    $branchId = $user->getEncryptedId(Auth::user()->defaultBranchId == null ? 0 : Auth::user()->defaultBranchId);
                    $hospital_obj = new HospitalSettings;
                    $hospital_details = $hospital_obj->getHospitalSettingsById(Auth::user()->user_id);

                    if ($hospital_details != null) {
                        $request->session()->put('logo', $hospital_details->logo);
                        //Branch details                        
                        $branch_limit = $hospital_details->branchLimit;
                        if ($branch_limit == 0) //No branch
                        {
                            $request->session()->put('branchLimit', '2');
                        } else {
                            $branch_count = $hospital_obj->getBranchCountByHospitalId(Auth::user()->user_id);
                            if ($branch_count > $branch_limit) // Exceeds Branch Limit
                            {
                                $request->session()->put('branchLimit', '0');
                            }
                        }
                    }
                    $request->session()->put('hospitalId', $hospitalId);
                    $request->session()->put('branchId', $branchId);
                    break;
                case 4: //Branch
                    $branch_obj = new HospitalBranch;
                    $branch_details = $branch_obj->getHospitalBranchById(Auth::user()->user_id);
                    if ($branch_details != NULL) {
                        $request->session()->put('hospitalId', $branch_details->hospitalId);
                        $request->session()->put('branchId', $branch_details->branchId);
                        $request->session()->put('logo', $branch_details->logo);
                    }
                    break;
                case 5: //Doctors
                    $doctor_obj = new doctor;
                    $id = Auth::user()->user_id;
                    $doctor_details = $doctor_obj->getLogoByHospitalId($id);
                    if ($doctor_details != NULL) {
                        $request->session()->put('hospitalId', $doctor_details->hospitalId);
                        $request->session()->put('branchId', $doctor_details->branchId);
                        $request->session()->put('profileImage', $doctor_details->profileImage);
                        $request->session()->put('logo', $doctor_details->logo);
                        $request->session()->put('userName', $doctor_details->name);
                    }
                    break;
            }
            return redirect()->action([DashboardController::class, 'index']);
        } catch (\Throwable $th) {
            return redirect()->action(
                //config('constant.error_msg')
                [AuthController::class, 'login'],
                ['errorMsg' => $th->getMessage(), 'companyId' => $companyId]
            );
        }
    }
    public function logout(Request $request)
    {
        $companyId = $request->session()->get('companyId');
        $log_obj = new loginLog;
        $log_obj->setDatabaseByCompanyId($companyId);

        $user = new User;
        $user->updateIsLogin(Auth::user()->id);
        Auth::logout();
        $token = PersonalAccessToken::findToken($request->session()->get('prjtoken'));
        $token->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $view_name = 'pages.login';
        if ($companyId == 2) {
            $view_name = 'pages.stechLogin';
        }
        return view($view_name)->with('errorMsg', '');
    }
    public function login(Request $request, $errorMsg, $companyId = 1)
    {
        $view_name = 'pages.login';
        if ($companyId == 2) {
            $view_name = 'pages.stechLogin';
        }
        return view($view_name)->with('errorMsg', $errorMsg);
    }
    public function forgetPassword(Request $request, $companyId)
    {
        $url = request()->getSchemeAndHttpHost();
        $logo = $url . config('constant.imageStoreLocation') . "dist/images/logoUI.png";
        if ($companyId == 2) {
            $logo = $url . config('constant.imageStoreLocation') . "dist/images/stechLogo.jpeg";
        }
        return view('pages.forgetPassword')->with('logo', $logo)->with('companyId', $companyId);
    }
}