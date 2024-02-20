<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\doctor;

use App\Models\Patient;
use App\Models\MixedTables;
use App\Models\NormalValues;
use Illuminate\Http\Request;
use App\Models\semenanalysis;
use App\Models\AnalysisImages;
use App\Models\ReportImageCaputre;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DashboardController;


class SemenAnalysisController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->get('isSetDefault')==1){
            $page_obj = new ReportImageCaputre;
            $SettingsDetails = $page_obj->getImageSettingsByUserId(Auth::user()->id);
            $isSetImg=0;
            if($SettingsDetails!=null)
            {
                $isSetImg=$SettingsDetails->isCaptureImage;
            }
            return view('pages.addSemenAnalysis')->with("isSetImg",$isSetImg);
        }
        else{
            return redirect()->action(
                [DashboardController::class, 'getDefaultSetting'], ['id' =>  $request->session()->get('userId')]
            );
        }
    }
    public function searchIndex()
    {
        return view('pages.searchSemenAnalysis');
    }
    public function showPrint(Request $request,$id)
    {
        try{
            $user_obj = new User;
            $id_orignal = $user_obj->getDecryptedId($id);
            $analysis_obj = new semenanalysis;
            $analysisDetails=$analysis_obj->getSemenAnalysisByIdForPrint($id_orignal);
            $normal_obj=new NormalValues;
            $analysisDetails->normalValues=$normal_obj->getNormalValueByHospital($analysisDetails->hospitalId,$analysisDetails->branchId);
           
            /** Report Image */
            $page_obj = new ReportImageCaputre;
            $SettingsDetails = $page_obj->getImageSettingsByUserId(Auth::user()->id);
            if($SettingsDetails!=null)
            {
                $isSetImg=$SettingsDetails->isCaptureImage;
               
            }
            $analysisImg_obj=new AnalysisImages;
            $analysis_id=$isSetImg==1 ? $analysisDetails->id : 0;
            $analysisImg=$analysisImg_obj->getAnalysisImage($analysis_id);

            return view('pages.reportSA')->with('analysisDetails', $analysisDetails)->with('analysisImg',$analysisImg);
        }catch(\Throwable $th){
            return Redirect::back()->withErrors( config('constant.error_msg'));
        }
    }
    public function getPatientDoctor(Request $request,$hospitalId,$branchId)
    {
        try {
            $patient_obj = new Patient;
            $patientList = $patient_obj->getPatientByHospitalId($hospitalId,$branchId);

            $doctor_obj = new doctor;
            $doctorList = $doctor_obj->getDoctorByHospital($hospitalId,$branchId);
                
            $result['patientList'] = $patientList;
            $result['doctorList'] = $doctorList;
                $result['Success'] = 'Success';
                return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = config('constant.error_msg');
            return response()->json($result, 200);
        }
    }
    public function saveSemenAnalysis(Request $request)
    {
        try {            
            $result = array();
            DB::beginTransaction();
            $validateUser = Validator::make($request->all(), [
                'patientId' => 'required',
                'doctorId'  => 'required',
            ]);
            $chkValidation=($request->patientId==0 || $request->doctorId== 0)?0:1;
            if ($validateUser->fails() || $chkValidation== 0) {
                $result['ShowModal'] = 1;
                $result['Success'] = 'Failure';
                $result['Message'] = "Validation failed. Please fill the required field marked as *";
                return response()->json($result, 200);
            }
            $semenanalysis_obj = new semenanalysis;
            $semenanalysis =  $semenanalysis_obj->addSemenAnalysis($request);
            $id=$semenanalysis->id;
            if($id<=0){
                DB::rollback();
                $result['ShowModal'] = 1;
                $result['Success'] = 'Failure';
                $result['Message'] ="Please try again";
                return response()->json($result, 200);
            }
            $user = new User;
            $encrypt_id = $user->getEncryptedId($id);
/**Image Capture BEGIN */
        if($request->isSetOff==1)
        {
            if($request->analysisImage!=NULL && $request->analysisImage!="")
            {
                $hospitalId=(isset($request->hospitalId) && !empty($request->hospitalId)) ?$request->hospitalId : NULL;
                $branchId=(isset($request->branchId) && !empty($request->branchId)) ?$request->branchId : NULL;
                 //Decrypt --- BEGIN
                $user = new User;
                $decrpt_hospitalId=($hospitalId==NULL?$hospitalId:$user->getDecryptedId($hospitalId));
                $decrpt_branchId=($branchId==NULL?$branchId:$user->getDecryptedId($branchId));
                $decrpt_hospitalId=($decrpt_hospitalId ==0 ? NULL :$decrpt_hospitalId);
                $decrpt_branchId=($decrpt_branchId==0 ? NULL : $decrpt_branchId);
            //Decrypt --- END
                $url = request()->getSchemeAndHttpHost();
                $index=0;
                $semeAnalysis_image=array();
                $analysis_obj = new AnalysisImages;
                $img_array=explode("@",$request->analysisImage);
                    for ($x = 0; $x < count($img_array); $x+=2) {
                        $folderPath = config('constant.analysisImgLocation');
                        $cap_img= $img_array[$x+1];
                        $image_parts = explode(";base64,", $cap_img);
                        $image_base64 = base64_decode($image_parts[1]);
                        $fileName = config('constant.prefix_analysisImg').$decrpt_hospitalId.'_'.uniqid(). '.png';
                        $analysisImg = $folderPath . $fileName;
                        file_put_contents($analysisImg, $image_base64);
                        $semeAnalysis_image[$index]=$url .config('constant.imageStoreLocation') .config('constant.analysisImgLocation'). $fileName;
                        $analysis_result =  $analysis_obj->addAnalysisImages($request->userId,$id,$semeAnalysis_image[$index]);
                        if($analysis_result->id<=0){
                            DB::rollback();
                            $result['ShowModal'] = 1;
                            $result['Success'] = 'Failure';
                            $result['Message'] ="Please try again";
                            return response()->json($result, 200);
                        }
                        $index++;
                    }
            }
        }
/**Image Capture END */
            $result['ShowModal'] = 1;
            $result['Success'] = 'Success';
            $result['semenId'] = $encrypt_id;
            $result['Message'] = "Semen analysis created successfully";

            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $result['ShowModal'] = 1;
            $result['Success'] = 'failure';
            $result['Message'] =  config('constant.error_msg');
            return response()->json($result, 200);
        }
    }
    public function showEdit($id)
    {
        try {
            $id_orignal = "AES_DECRYPT(UNHEX('" . $id . "'), UNHEX(SHA2('" . config('constant.mysql_custom_encrypt_key') . "',512)))";
            $semenanalysis_obj = new semenanalysis;
            $semenanalysisDetails = $semenanalysis_obj->getSemenAnalysisById($id_orignal);

            $mixedTable = new MixedTables;
            $semenanalysisDetails->liquefactionList =  $mixedTable->getConsantValue(config('constant.liquefactionId'));
            $semenanalysisDetails->appearanceList = $mixedTable->getConsantValue(config('constant.appearanceId'));
            $semenanalysisDetails->viscosityList = $mixedTable->getConsantValue(config('constant.viscosityId'));
            $semenanalysisDetails->phList = $mixedTable->getConsantValue(config('constant.phId'));
            $semenanalysisDetails->abstinenceList = $mixedTable->getConsantValue(config('constant.abstinenceId'));
            $semenanalysisDetails->agglutinationList = $mixedTable->getConsantValue(config('constant.agglutinationId'));
            $semenanalysisDetails->clumpingList = $mixedTable->getConsantValue(config('constant.clumpingId'));
            $semenanalysisDetails->puscellsList = $mixedTable->getConsantValue(config('constant.pusCellsId'));

            $doctor_obj=new doctor;
            $semenanalysisDetails->doctorList=$doctor_obj->getDoctorByHospital($semenanalysisDetails->hospitalId,$semenanalysisDetails->branchId);

            /** Report Image */
            $page_obj = new ReportImageCaputre;
            $SettingsDetails = $page_obj->getImageSettingsByUserId(Auth::user()->id);
            if($SettingsDetails!=null)
            {
                $isSetImg=$SettingsDetails->isCaptureImage;
               
            }
            $analysisImg_obj=new AnalysisImages;
            $analysis_id=$semenanalysisDetails->id;
            $analysisImg=$analysisImg_obj->getAnalysisImage($analysis_id);
            
            $semenanalysisDetails->isSetImg=$isSetImg;
            $semenanalysisDetails->imgCount=$analysisImg->count();
            
            return view('pages.editSemenAnalysis')->with('semenanalysisDetails', $semenanalysisDetails);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = config('constant.error_msg');
            return response()->json($result, 200);
        }
    }
    public function updateSemenAnalysis(Request $request)
    {
        try {
            $result = array();
            DB::beginTransaction();
            $validateUser = Validator::make($request->all(), [
                'patientId' => 'required',
                'doctorId'  => 'required',
            ]);
            $chkValidation=($request->patientId==0 || $request->doctorId== 0)?0:1;
            if ($validateUser->fails() || $chkValidation== 0) {
                $result['ShowModal'] = 1;
                $result['Success'] = 'Failure';
                $result['Message'] = "Validation failed. Please fill the required field marked as *";
                return response()->json($result, 200);
            }

            $semenanalysis_obj = new semenanalysis;
            $semenanalysis =  $semenanalysis_obj->updateSemenAnalysis($request);

            /**Image Capture - Add new images BEGIN */
            if($request->newAnalysisImage!=NULL && $request->newAnalysisImage!="")
            {
                $hospitalId=(isset($request->hospitalId) && !empty($request->hospitalId)) ?$request->hospitalId : NULL;
                $branchId=(isset($request->branchId) && !empty($request->branchId)) ?$request->branchId : NULL;
                 //Decrypt --- BEGIN
                $user = new User;
                $decrpt_hospitalId=($hospitalId==NULL?$hospitalId:$user->getDecryptedId($hospitalId));
                $decrpt_branchId=($branchId==NULL?$branchId:$user->getDecryptedId($branchId));
                $decrpt_hospitalId=($decrpt_hospitalId ==0 ? NULL :$decrpt_hospitalId);
                $decrpt_branchId=($decrpt_branchId==0 ? NULL : $decrpt_branchId);
                $id=$user->getDecryptedId($request->semenanalysisId);
            //Decrypt --- END
                $url = request()->getSchemeAndHttpHost();
                $index=0;
                $semeAnalysis_image=array();
                $analysis_obj = new AnalysisImages;
                $img_array=explode("@",$request->newAnalysisImage);
                    for ($x = 0; $x < count($img_array); $x+=2) {
                        $folderPath = config('constant.analysisImgLocation');
                        $cap_img= $img_array[$x+1];
                        $image_parts = explode(";base64,", $cap_img);
                        $image_base64 = base64_decode($image_parts[1]);
                        $fileName = config('constant.prefix_analysisImg').$decrpt_hospitalId.'_'.uniqid(). '.png';
                        $analysisImg = $folderPath . $fileName;
                        file_put_contents($analysisImg, $image_base64);
                        $semeAnalysis_image[$index]=$url .config('constant.imageStoreLocation') .config('constant.analysisImgLocation'). $fileName;
                        $analysis_result =  $analysis_obj->addAnalysisImages($request->userId,$id,$semeAnalysis_image[$index]);
                        if($analysis_result->id<=0){
                            DB::rollback();
                            $result['ShowModal'] = 1;
                            $result['Success'] = 'Failure';
                            $result['Message'] ="Please try again";
                            return response()->json($result, 200);
                        }
                        $index++;
                    }
            }
/**Image Capture- Add new images END */
/**Image Capture- Delete Images BEGIN */
            if($request->delAnalysisImage!=NULL && $request->delAnalysisImage!="")
            {
                $del_img_array=explode(",",$request->delAnalysisImage);
                $del_analysis_obj = new AnalysisImages;
                foreach($del_img_array as $delImg)
                {
                    $del_analysis_obj->deleteAnalysisImage($request->userId,$delImg);
                }
            }
/**Image Capture- Delete Images END */

            $result['ShowModal'] = 1;
            $result['Success'] = 'Success';
            $result['Message'] = "SemenAnalysis Report Updated successfully";

            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['ShowModal'] = 1;
            $result['Success'] = 'failure';
            $result['Message'] =  config('constant.error_msg');
            return response()->json($result, 200);
        }
    }
    public function getAllSemenAnalysis(Request $request)
    {
        try{
            $pagination['page']=(isset($request->page) && !empty($request->page)) ?$request->page : 1;
            $pagination['size']=(isset($request->size) && !empty($request->size)) ?$request->size : 10;
            $pagination['sorters_field']=(isset($request->sorters[0]['field']) && !empty($request->sorters[0]['field'])) ?$request->sorters[0]['field'] : "created_date";
            $pagination['sorters_dir']=(isset($request->sorters[0]['dir']) && !empty($request->sorters[0]['dir'])) ?$request->sorters[0]['dir'] : "desc";

            $pagination['filters_field']=(isset($request->filters[0]['field']) && !empty($request->filters[0]['field'])) ?$request->filters[0]['field'] : "";
            $pagination['filters_type']=(isset($request->filters[0]['type']) && !empty($request->filters[0]['type'])) ?$request->filters[0]['type'] : "";
            $pagination['filters_value']=(isset($request->filters[0]['value']) && !empty($request->filters[0]['value'])) ?$request->filters[0]['value'] :"";

            $hospitalId=(isset($request->hospitalId) && !empty($request->hospitalId)) ?$request->hospitalId : NULL;
            $branchId=(isset($request->branchId) && !empty($request->branchId)) ?$request->branchId : 0;

            //Decrypt --- BEGIN
            $user = new User;
            $decrpt_hospitalId=($hospitalId==NULL?$hospitalId:$user->getDecryptedId($hospitalId));
            $decrpt_branchId=($branchId==NULL?$branchId:$user->getDecryptedId($branchId));
            //Decrypt --- END

            $semenanalysis_obj=new semenanalysis;
            $semenanalysis=$semenanalysis_obj->getAllSemenAnalysis($decrpt_hospitalId,$decrpt_branchId,$pagination);
            
            $result['last_page']=$semenanalysis['last_page'];
            $result['data']=$semenanalysis['SemenAnalysisList'];
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']= config('constant.error_msg');
            return response()->json($result,200);
        }
    }
    public function deleteSemenAnalysis(Request $request,$id,$userId)
    {
        try {
            $semenanalysis_obj=new semenanalysis;
            $semenanalysis_obj->deleteSemenAnalysisById($id,$userId);

            $result['Success']='Success';
            $result['ShowModal']=1;
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = config('constant.error_msg');
            return response()->json($result, 200);
        }
    }
    public function getPatientSequenceNo(Request $request,$patientId)
    {
        try {
            $user = new User;
            $id_orignal = $user->getDecryptedId($patientId);

            $semenanalysis_obj=new semenanalysis;
            $seqNo=$semenanalysis_obj->getPatientSequenceCount($id_orignal);
            $seqNo=$seqNo+1;

            $result['Success'] = 'Success';
            $result['seqNo'] = $seqNo;
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] =  config('constant.error_msg');
            return response()->json($result, 200);
        }
    }
    public function getAnalysisImages(Request $request,$semenId)
    {
        try {
            $user = new User;
            $id_orignal = $user->getDecryptedId($semenId);

            $semenanalysis_obj=new AnalysisImages;
            $analysisImg=$semenanalysis_obj->getAnalysisImage($id_orignal);

            $result['Success'] = 'Success';
            $result['analysisImg'] = $analysisImg;
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result['Success'] = 'failure';
            $result['Message'] = config('constant.error_msg');
            return response()->json($result, 200);
        }
    }
}
