@extends('layouts.main')
@section('title','Patient Information')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />

@endsection 
@section('content')
    @include('layouts.mobileSideMenu')
    <div id="divPatient" class="flex mt-[4.7rem] md:mt-0">
    @can('isAdmin')
            @include('layouts.sideMenu')
        @endcan
        @can('isHospital')
            @include('layouts.hospitalSideMenu')
        @endcan
        @can('isBranch')
            @include('layouts.branchSideMenu')
        @endcan
        @can('isDoctor')
            @include('layouts.doctorSideMenu')
        @endcan
                <!-- BEGIN: Content -->
                <div class="content">
                    @include('layouts.topBar')
                     <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                        <button onclick="window.location='{{ url("Patient") }}'" class="btn btn-primary shadow-md mr-2">Add Patient</button>
                        <button onclick="window.location='{{ url("SearchPatient") }}'" class="btn btn-dark shadow-md mr-2">Go Back</button>
                    </div>
                    <form id="frmEditPatient" method="POST" action="">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                    <input id="txtPatientId" name="patientId" value="{{$patientDetails->patientId}}" type="hidden" class="form-control">
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                            <div id="my_camera"></div>
                        <br/>
                        <input id="btnSnapshot" type=button value="Take Patient Picture" class="btn btn-primary shadow-md mr-2">
                        <input id="btnCapturedImg" type="hidden" name="profileImage" value="{{$patientDetails->profileImage}}" class="image-tag">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-4 form-control"><img id="imgProfileImage" src="{{$patientDetails->profileImage}}">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                         <input id="txtImageChanged" name="isImageChanged" value="0" type="hidden" class="form-control">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtHcNo" class="form-label">Registered No <span class="text-danger mt-2"> *</span></label>
                                <input id="txtHcNo" name="hcNo" value="{{$patientDetails->hcNo}}" type="text" class="form-control" disabled>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtName" class="form-label">Patient Name <span class="text-danger mt-2"> *</span></label>
                                <input id="txtName" name="name" value="{{$patientDetails->name}}" type="text" class="form-control" required>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtDOB" class="form-label">Date of Birth</label>
                                <input id="txtDOB"name="dob" value="{{$patientDetails->dob}}" type="text" class="datepicker form-control " data-single-mode="true"> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtAge" class="form-label">Age</label>
                                <input id="txtAge" name="age" value="{{$patientDetails->age}}" type="number" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlGender" class="form-label">Gender</label>
                                <select id="ddlGender"  value="{{$patientDetails->gender}}" name="gender" class="form-select" required>
                                    <option value='0'>Select Gender</option>
                                @foreach ($patientDetails->genderList as $gender)
                                    <option value="{{ $gender->name }}" {{ ( $gender->name == $patientDetails->gender) ? 'selected' : '' }}> 
                                        {{ $gender->name }} 
                                    </option>
                                @endforeach    
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlBloodGrp" class="form-label">Blood Group</label>
                                <select id="ddlBloodGrp" name="bloodGrp" value="{{$patientDetails->bloodGroup}}" class="form-select">
                                    <option value='0'>Select Blood Group</option>
                                    @foreach ($patientDetails->bloodGrp as $bloodType)
                                    <option value="{{ $bloodType->name }}" {{ ( $bloodType->name == $patientDetails->bloodGroup) ? 'selected' : '' }}> 
                                        {{ $bloodType->name }} 
                                    </option>
                                @endforeach  
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlmartialStatus" class="form-label">Martial Status</label>
                                <select id="ddlmartialStatus" name="martialStatus" value="{{$patientDetails->martialStatus}}" class="form-select">
                                    <option value='0'>Select Martial Status</option>
                                    @foreach ($patientDetails->maritalStatusList as $martialStaus)
                                    <option value="{{ $martialStaus->name }}" {{ ( $martialStaus->name == $patientDetails->martialStatus) ? 'selected' : '' }}> 
                                        {{ $martialStaus->name }} 
                                    </option>
                                @endforeach  
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtWeight" class="form-label">Patient Weight</label>
                                <input id="txtWeight" name="weight" value="{{$patientDetails->weight}}" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtHeight" class="form-label">Patient Height</label>
                                <input id="txtHeight" name="height" value="{{$patientDetails->height}}" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtPhoneNo" class="form-label">Phone No <span class="text-danger mt-2"> *</span></label>
                                <input id="txtPhoneNo" name="phoneNo" value="{{$patientDetails->phoneNo}}" type="text" class="form-control" required>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtEmail" class="form-label">Email Id <span class="text-danger mt-2"> *</span></label>
                                <input id="txtEmail" name="email"  value="{{$patientDetails->email}}" type="email" class="form-control" placeholder="example@gmail.com" required>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtAddress" class="form-label">Address</label>
                                <textarea id="txtAddress" name="address" value="{{$patientDetails->address}}" class="form-control" minlength="10">{{$patientDetails->address}}</textarea>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtCity" class="form-label">City</label>
                                <input id="txtCity" name="city" value="{{$patientDetails->city}}" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlState" class="form-label">State</label>
                                <select id="ddlState" name="state" value="{{$patientDetails->state}}" class="form-select">
                                    <option value='0'>Select State</option>
                                    @foreach ($patientDetails->city_list as $cities)
                                    <option value="{{ $cities->city_state }}" {{ ( $cities->city_state == $patientDetails->state) ? 'selected' : '' }}> 
                                        {{ $cities->city_state }} 
                                    </option>
                                @endforeach  
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtPincode" class="form-label">Pincode</label>
                                <input id="txtPincode" name="pincode" value="{{$patientDetails->pincode}}" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtSpouseName" class="form-label">Spouse Name</label>
                                <input id="txtSpouseName" name="spouseName" value="{{$patientDetails->spouseName}}" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtSpousePhNo" class="form-label">Spouse Phone No</label>
                                <input id="txtSpousePhNo" name="spousePhNo" value="{{$patientDetails->spousePhnNo}}" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlStatus" class="form-label">Status</label>
                                <select id="ddlStatus" name="status" value="{{$patientDetails->status}}" class="form-select">
                                    <option value='1' {{ $patientDetails->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value='0' {{ $patientDetails->status == 0 ? 'selected' : '' }}>In Active</option>
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtReason" class="form-label">Reason For Vist</label>
                                <textarea id="txtReason" name="reason" value="{{$patientDetails->reason}}" class="form-control" minlength="10">{{$patientDetails->reason}}</textarea>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlRefferedBy" class="form-label">Reffered By</label>
                                <select id="ddlRefferedBy" value="{{$patientDetails->refferedBy}}" name="refferedBy" class="form-select">
                                    <option value='0'>Select Reffered By</option>
                                    @foreach ($patientDetails->refferedByList as $refferedBy)
                                    <option value="{{ $refferedBy->name }}" {{ ( $refferedBy->name == $patientDetails->refferedBy) ? 'selected' : '' }}> 
                                        {{ $refferedBy->name }} 
                                    </option>
                                @endforeach 
                                </select>
                            </div>
                            <div id="divDocName" class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtDocName" class="form-label">Doctor Name</label>
                                <input id="txtDocName" value="{{$patientDetails->refDoctorName}}" name="docName" type="text" class="form-control">
                            </div>   
                            <div id="divDocHpName" class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtDocHpName" class="form-label">Doctor Hospital Name</label>
                                <input id="txtDocHpName" value="{{$patientDetails->refDrHospitalName}}" name="docHpName" type="text" class="form-control">
                            </div>                      
                            
                           
                            <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <button id="btnUpdPatient" type=submit class="btn btn-primary w-24 ml-2">Update</button>
                            </div>
                        </div>
                        </form>
                      
                      <div id="failed-notification-content" class="toastify-content hidden flex" >
                                        <i class="text-danger" data-lucide="x-circle"></i> 
                                        <div class="ml-4 mr-4">
                                            <div class="font-medium">Error</div>
                                            <div class="text-slate-500 mt-1"> Please enter the required field marked as *. </div>
                                        </div>
                                    </div>
                                    <!-- END: Failed Notification Content -->
</div>
                <!-- END: Content -->
    </div>
    <!-- BEGIN: Success Modal Content --> 
        <div id="success-redirect-modal-preview" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divMsg" class="text-3xl mt-5"><span></span></div> <div id="divHcNo" class="text-slate-500 mt-2"><span></span></div> </div>
                  <div class="px-5 pb-8 text-center"> <button id="btnRedirect" onclick="window.location='{{ url("SearchPatient") }}'" type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 
 <!-- BEGIN: Error Modal Content --> 
 <div id="divEditPatientErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i> 
                <div id="divErrorHead"class="text-3xl mt-5"><span></span></div> 
                <div id="divErrorMsg" class="text-slate-500 mt-2"><span></span></div> </div> 
                <div class="px-5 pb-8 text-center"> 
                    <button type="button" data-tw-dismiss="modal" class="btn w-24 btn-primary">Ok</button> 
                </div> 
            </div> 
        </div> 
    </div> 
</div> <!-- END: Error Modal Content --> 
@endsection

        @push('js')
        <script type="module" src="{{ asset('dist/js/app.js')}}"></script>
        <script  type="module" src="{{ asset('dist/js/patient.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        @endpush



