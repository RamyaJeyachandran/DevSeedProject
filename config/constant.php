<?php

return [

    'api_response' =>[
        'success_code' => 200,
        'success_msg'=> 'Success',
        'failure_code' => 100,
        'failure_msg'=>'Failure',
        'param_failure_code'=>422,
        'Unauthenticated'=>401,
        'Unauthenticated_msg'=>'Unauthenticated api access'
    ],
    'doctor_user_type_id'=>5,
    'hospital_user_type_id'=>2,
    'branch_user_type_id'=>4,
    'genderTableId'=>1,
    'martialStatusTableId'=>5,
    'refferedByTableId'=>9,
    'bloodGrpTableId'=>14,
    'mysql_custom_encrypt_key'=>'seedproject',    
    'prefix_doctor_profile_image'=>'dr_',
    'prefix_doctor_signature'=>'sign_',
    'prefix_patient_profile_image'=>'p_',
    'doctor_default_profileImage'=>"images/doctors/defaultProfileImage.png",
    'hospital_default_logo'=>"images/doctors/defaultProfileImage.png",
    'prefix_hospital_logo'=>'hs_',
];
