@extends('layouts.main')
@section('title','Patient Information')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />

@endsection 
@section('content')
    @include('layouts.mobileSideMenu')
    <div id="divPatient" class="flex mt-[4.7rem] md:mt-0">
    @include('layouts.sideMenu')
                <!-- BEGIN: Content -->
                <div class="content">
                    @include('layouts.topBar')
                    <form id="frmPatient">
                    <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    
                    <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}" type="hidden" class="form-control">
                    <input id="txtBranch" name="branchId" value="{{ session('branchId') }}" type="hidden" class="form-control">
                    <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                            <div id="my_camera"></div>
                        <br/>
                        <input id="btnSnapshot" type=button value="Take Patient Picture" class="btn btn-primary shadow-md mr-2">
                        <input id="btnCapturedImg" type="hidden" name="profileImage" class="image-tag">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-4 form-control"><img id="imgProfileImage">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-4 form-control"><div id="results">
                    
                    </div></div>
                    @can('isAdmin')
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="ddlHospital" class="form-label">Hospital </label>
                                <select id="ddlHospital" name="hospitalId" class="form-select">
                                    <option value='0'>Select Hospital</option>
                                </select>
                            </div>
                    @endcan
                    @can('isAdminHospital')
                            <div id="divBranchddl" class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="ddlBranch" class="form-label">Branch </label>
                                <select id="ddlBranch" name="branchId" class="form-select">
                                    <option value='0'>Select Branch</option>
                                </select>
                            </div>
                        @endcan

                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtName" class="form-label">Patient Name <span class="text-danger mt-2"> *</span></label>
                                <input id="txtName" name="name" type="text" class="form-control" required>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtPhoneNo" class="form-label">Phone No <span class="text-danger mt-2"> *</span></label>
                                <input id="txtPhoneNo" name="phoneNo" type="text" class="form-control" required>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtEmail" class="form-label">Email Id <span class="text-danger mt-2"> *</span></label>
                                <input id="txtEmail" name="email" type="email" class="form-control" placeholder="example@gmail.com" required>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtDOB" class="form-label">Date of Birth</label>
                                <input id="txtDOB"name="dob" type="text" class="datepicker form-control " data-single-mode="true"> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtAge" class="form-label">Age</label>
                                <input id="txtAge" name="age" type="number" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlGender" class="form-label">Gender</label>
                                <select id="ddlGender" name="gender" class="form-select" required>
                                    <option value='0'>Select Gender</option>
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlBloodGrp" class="form-label">Blood Group</label>
                                <select id="ddlBloodGrp" name="bloodGrp" class="form-select">
                                    <option value='0'>Select Blood Group</option>
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlmartialStatus" class="form-label">Martial Status</label>
                                <select id="ddlmartialStatus" name="martialStatus" class="form-select">
                                    <option value='0'>Select Martial Status</option>
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtWeight" class="form-label">Patient Weight</label>
                                <input id="txtWeight" name="weight" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtHeight" class="form-label">Patient Height</label>
                                <input id="txtHeight" name="height" type="text" class="form-control">
                            </div>                            
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtAddress" class="form-label">Address</label>
                                <textarea id="txtAddress" name="address" class="form-control" minlength="10"></textarea>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtCity" class="form-label">City</label>
                                <input id="txtCity" name="city" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlState" class="form-label">State</label>
                                <select id="ddlState" name="state" class="form-select">
                                    <option value='0'>Select State</option>
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtPincode" class="form-label">Pincode</label>
                                <input id="txtPincode" name="pincode" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtSpouseName" class="form-label">Spouse Name</label>
                                <input id="txtSpouseName" name="spouseName" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtSpousePhNo" class="form-label">Spouse Phone No</label>
                                <input id="txtSpousePhNo" name="spousePhNo" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtReason" class="form-label">Reason For Vist</label>
                                <textarea id="txtReason" name="reason" class="form-control" minlength="10"></textarea>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlRefferedBy" class="form-label">Reffered By</label>
                                <select id="ddlRefferedBy" name="refferedBy" class="form-select">
                                    <option value='0'>Select Reffered By</option>
                                </select>
                            </div>
                            <div id="divDocName" class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtDocName" class="form-label">Doctor Name</label>
                                <input id="txtDocName" name="docName" type="text" class="form-control">
                            </div>   
                            <div id="divDocHpName" class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtDocHpName" class="form-label">Doctor Hospital Name</label>
                                <input id="txtDocHpName" name="docHpName" type="text" class="form-control">
                            </div>                      
                            
                           
                            <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <button id="btnSavePatient" type=submit class="btn btn-primary w-24 ml-2">Register</button>
                                <button id="btnCancelPatient" type="reset" class="btn btn-dark w-24">Cancel</button> 
                            </div>
                        </div></div></div>
                        </div></div>
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
        <div id="divPatientSuccessModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true" data-tw-backdrop="static"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divMsg" class="text-3xl mt-5"><span></span></div> <div id="divHcNo" class="text-slate-500 mt-2"><span></span></div> </div>
                  <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 
 <!-- BEGIN: Error Modal Content --> 
 <div id="divPatientErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
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



