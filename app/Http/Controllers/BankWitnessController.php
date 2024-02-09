<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BankWitness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BankWitnessController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->get('isSetDefault')==1){
            return View("pages.wittnessFromBank");
        }
        else{
            return redirect()->action(
                [DashboardController::class, 'getDefaultSetting'], ['id' =>  $request->session()->get('userId')]
            );
        }
    }
    public function getAllBankWitness(Request $request)
    {
        try{
            $pagination['page']=(isset($request->page) && !empty($request->page)) ?$request->page : 1;
            $pagination['size']=(isset($request->size) && !empty($request->size)) ?$request->size : 10;
            $pagination['sorters_field']=(isset($request->sorters[0]['field']) && !empty($request->sorters[0]['field'])) ?$request->sorters[0]['field'] : "created_date";
            $pagination['sorters_dir']=(isset($request->sorters[0]['dir']) && !empty($request->sorters[0]['dir'])) ?$request->sorters[0]['dir'] : "desc";
           
            $hospitalId=(isset($request->hospitalId) && !empty($request->hospitalId)) ?$request->hospitalId : NULL;
            $branchId=(isset($request->branchId) && !empty($request->branchId)) ?$request->branchId : 0;

            //Decrypt --- BEGIN
            $user = new User;
            $decrpt_hospitalId=($hospitalId==NULL?$hospitalId:$user->getDecryptedId($hospitalId));
            $decrpt_branchId=($branchId==NULL?$branchId:$user->getDecryptedId($branchId));
            //Decrypt --- END

            $witness_obj = new BankWitness;
            $witnessList=$witness_obj->getAllBankWitness($decrpt_hospitalId,$decrpt_branchId,$pagination);
            
            $result['last_page']=$witnessList['last_page'];
            $result['data']=$witnessList['witnessList'];
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function addBankWitness(Request $request)
    {
        try{
            $result=array();
            DB::beginTransaction();
            $validateUser=Validator::make($request->all(), [
                'name'=>'required',
                'hospitalName'=>'required',
                'phoneNo'=>'required',
                'email'=>'required',
                'address'=>'required',
                'mode'=>'required',
                'userId'=>'required',
            ]);
            if($validateUser->fails()){
                $result['ShowModal']=1;
                $result['Success']='Failure';
                $result['Message']="Validation failed. Please fill the required field marked as *";
                return response()->json($result,200);
            }
            $mode=$request->mode;
            if($mode==1){
                $validateUser=Validator::make($request->all(), [
                    'hospitalId'=>'required',
                ]);
                if($validateUser->fails()){
                    $result['ShowModal']=1;
                    $result['Success']='Failure';
                    $result['Message']="Validation failed.Please try again";
                    return response()->json($result,200);
                }
            }

            $hospitalId=(isset($request->hospitalId) && !empty($request->hospitalId)) ?$request->hospitalId : NULL;
            $branchId=(isset($request->branchId) && !empty($request->branchId)) ?$request->branchId : NULL;
            //Decrypt --- BEGIN
            $user = new User;
            $decrpt_hospitalId=($hospitalId==NULL?$hospitalId:$user->getDecryptedId($hospitalId));
            $decrpt_branchId=($branchId==NULL?$branchId:$user->getDecryptedId($branchId));
            $decrpt_hospitalId=($decrpt_hospitalId ==0 ? NULL :$decrpt_hospitalId);
            $decrpt_branchId=($decrpt_branchId==0 ? NULL : $decrpt_branchId);
            $decrypt_userId=$user->getDecryptedId($request->userId);
            //Decrypt --- END
            
            $witness_obj = new BankWitness;
            if($mode==1){                
                $witness =  $witness_obj->addWitness($request,$decrpt_hospitalId,$decrpt_branchId,$decrypt_userId); 
                if($witness->id>0){
                    $result['ShowModal']=1;
                    $result['Success']='Success';
                    $result['Message']="Bank witness registered successfully";
                    DB::commit();
                }
                else{
                    $result['ShowModal']=1;
                    $result['Success']='Failure';
                    $result['Message']="Bank witness registered Failed";
                    DB::rollback();
                }
            }else if($mode==2)
            {
                $validateUser=Validator::make($request->all(), [
                    'witnessId'=>'required',
                ]);
                if($validateUser->fails()){
                    $result['ShowModal']=1;
                    $result['Success']='Failure';
                    $result['Message']=$request->witnessId;//"Validation failed.Please try again";
                    return response()->json($result,200);
                }

                $witness =  $witness_obj->updateWitness($request,$decrypt_userId); 
                $result['ShowModal']=1;
                $result['Success']='Success';
                $result['Message']="Bank witness updated successfully";
                DB::commit();
            }
           
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            DB::rollback();
            return response()->json($result,200);
        }
    }
    public function deleteWitness(Request $request,$id,$userId){
        try{
            $donor_obj = new BankWitness;
            $witnessDetails=$donor_obj->deleteWitnessById($id,$userId);
            $result['Success']='Success';
            $result['ShowModal']= 1;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    } 
}
