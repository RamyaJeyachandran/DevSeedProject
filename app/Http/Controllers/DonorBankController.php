<?php

namespace App\Http\Controllers;

use URL;
use App\Models\User;
use App\Models\donorBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class DonorBankController extends Controller
{
    public function index()
    {
        return View("pages.donorBank");
    }
    public function getAllDonorBank(Request $request)
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

            $donor_obj = new donorBank;
            $donorBankList=$donor_obj->getAllDonorBank($decrpt_hospitalId,$decrpt_branchId,$pagination);
            
            $result['last_page']=$donorBankList['last_page'];
            $result['data']=$donorBankList['donorBankList'];
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
    public function addDonorBank(Request $request)
    {
        try{
            $result=array();
            DB::beginTransaction();
            $validateUser=Validator::make($request->all(), [
                'name'=>'required',
                'address'=>'required',
            ]);
            if($validateUser->fails()){
                $result['ShowModal']=1;
                $result['Success']='Failure';
                $result['Message']="Validation failed. Please fill the required field marked as *";
                return response()->json($result,200);
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
            
            $mode=$request->mode;
            $donor_obj = new donorBank;
            if($mode==1){
                $donorBank =  $donor_obj->addDonorBank($request,$decrpt_hospitalId,$decrpt_branchId,$decrypt_userId); 
                if($donorBank->id>0){
                    $result['ShowModal']=1;
                    $result['Success']='Success';
                    $result['Message']="Donor Bank registered successfully";
                    DB::commit();
                }
                else{
                    $result['ShowModal']=1;
                    $result['Success']='Failure';
                    $result['Message']="Donor Bank registered Failed";
                    DB::rollback();
                }
            }else if($mode==2)
            {
                $donorBank =  $donor_obj->updateDonorBank($request,$decrypt_userId); 
                $result['ShowModal']=1;
                $result['Success']='Success';
                $result['Message']="Donor Bank updated successfully";
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
    public function deleteDonorBank(Request $request,$id,$userId){
        try{
            $donor_obj = new donorBank;
            $donorBankDetails=$donor_obj->deleteDonorBankById($id,$userId);
            $result['Success']='Success';
            $result['ShowModal']= 1;
            $result['donorBankDetails']=$donorBankDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }   
}
