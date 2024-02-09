<?php

namespace App\Http\Controllers;

use App\Models\HospitalBranch;
use App\Models\HospitalSettings;
use App\Models\pageSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class PageSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_obj = new pageSettings;
        $pageSettingsDetails = $page_obj->getPageSettingsByUserId(Auth::user()->id);
        return view('pages.printSettings')->with('printSettingDetails', $pageSettingsDetails);
    }
    public function getPrintMarginByUserId(Request $request,$userId){
        try{
            $user_obj = new User;
            $decrypt_userId = $user_obj->getDecryptedId($userId);
            $page_obj = new pageSettings;
            $pageSettingsDetails = $page_obj->getPageSettingsByUserId($decrypt_userId);

            //Hospital details
            $user_obj = new User;
            $hospitalId = $user_obj->getDecryptedId($request->session()->get('hospitalId'));
            $branchId = $user_obj->getDecryptedId($request->session()->get('branchId'));
            $pageSettingsDetails->isHospital=1;
            if($branchId==null)
            {
                $branch_obj=new HospitalBranch;
                $pageSettingsDetails->branchAddress=$branch_obj->getHospitalBranchById($branchId);
                $pageSettingsDetails->isHospital=0;
            }else{
                $hospital_obj=new HospitalSettings;
                $pageSettingsDetails->hospitalAddress=$hospital_obj->getHospitalSettingsById($hospitalId);
            }
            

            $result['Success']='Success';
            $result['pageSettingsDetails']=$pageSettingsDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function updatePageSettings(Request $request)
    {
        try{
            $result=array();
            DB::beginTransaction();
            $validateUser=Validator::make($request->all(), [
                'marginRight'=>'required',
                'marginLeft'=>'required',
                'marginBottom'=>'required',
                'marginTop'=>'required',
                'userId'=>'required',
                'pageSettingId'=>'required'
            ]);
            if($validateUser->fails()){
                $result['ShowModal']=1;
                $result['Success']='Failure';
                $result['Message']="Validation failed. Please fill the required field marked as *";
                return response()->json($result,200);
            }
            $page_obj=new pageSettings;
            $pageSettings_result =  $page_obj->updatePageSettings($request); 

            $result['ShowModal']=1;
            $result['Success']='Success';
            $result['Message']="Print Settings updated successfully";
            DB::commit();

            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            DB::rollback();
            return response()->json($result,200);
        }
    }

}
