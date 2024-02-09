<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\NormalValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class NormalValuesController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->get('isSetDefault')==1){
            $user_obj = new User;
            $hospitalId = $user_obj->getDecryptedId($request->session()->get('hospitalId'));
            $branchId = $user_obj->getDecryptedId($request->session()->get('branchId'));
            $value_obj = new NormalValues;
            $normalValueDetails = $value_obj->getNormalValueByHospital($hospitalId,$branchId);
            return view('pages.normalValues')->with('normalValueDetails', $normalValueDetails);
        }
        else{
            return redirect()->action(
                [DashboardController::class, 'getDefaultSetting'], ['id' =>  $request->session()->get('userId')]
            );
        }
    }
    public function updateNormalValue(Request $request)
    {
        try{
            $result=array();
            DB::beginTransaction();
            $value_obj=new NormalValues;
            $normalValueResult =  $value_obj->updateNormalValue($request); 

            $result['ShowModal']=1;
            $result['Success']='Success';
            $result['Message']="Normal Value updated successfully";
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
