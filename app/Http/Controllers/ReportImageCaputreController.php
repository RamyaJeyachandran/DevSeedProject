<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ReportImageCaputre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportImageCaputreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_obj = new ReportImageCaputre;
        $SettingsDetails = $page_obj->getImageSettingsByUserId(Auth::user()->id);
        $isSetOn=$SettingsDetails->isCaptureImage==1?1:0;
        $isSetOff=($SettingsDetails->isCaptureImage==1 && $SettingsDetails->id>0) ? 0 :($SettingsDetails->id>0?1:0);
        
        return View("pages.imageCaptureSettings")->with('isSetOn', $isSetOn)->with('isSetOff', $isSetOff);
    }
    public function setDefaultImageCapture(Request $request,$userId,$isSet)
    {
        try{
            $result=array();
            $report_obj = new ReportImageCaputre;
            $user_obj = new User;
            $user_id = $user_obj->getDecryptedId($userId);
            $chkData=$report_obj->getImageSettingsByUserId($user_id);
            if($chkData->id==0)
            {
                $reportSign =  $report_obj->addImageSettings($user_id,$isSet); 
                $reportId=$reportSign->id;
                
                if($reportId>0){
                    $result['ShowModal']=1;
                    $result['Success']='Success';
                    $result['Message']="Report Image Capture Settings Done Successfully";
                    return response()->json($result,200);
                }else{
                    $result['ShowModal']=1;
                    $result['Success']='Failure';
                    $result['Message']="Report Image Capture Settings Failed";
                    return response()->json($result,200);
                }
            }else{
                $reportSign =  $report_obj->updateImageSettings($user_id,$isSet);

                $result['ShowModal']=1;
                $result['Success']='Success';
                $result['Message']="Report Image Capture Settings Updated Successfully";
                return response()->json($result,200);
            }
        }catch(\Throwable $th){
            $result['ShowModal']=1;
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
  
}
