<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DoctorSignature;

class DoctorSignatureController extends Controller
{
    public function getDoctorSignatureByDoctorId(Request $request,$doctorId){
        try{
            $doctor_obj = new DoctorSignature;
            $signatureDetails=$doctor_obj->getDoctorSignatureByDoctorId($doctorId);
            $result['Success']='Success';
            $result['signatureDetails']=$signatureDetails;
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
}
