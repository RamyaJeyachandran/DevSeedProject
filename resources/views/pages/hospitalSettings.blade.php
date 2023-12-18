@extends('layouts.main')
@section('title','Hospital Information')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" /> 
@endsection 
@section('content')
    @include('layouts.mobileSideMenu')
    <div class="flex mt-[4.7rem] md:mt-0">
    @include('layouts.sideMenu')
                <!-- BEGIN: Content -->
                <div class="content">
                    @include('layouts.topBar')
                    <form id="frmHospital" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                    <label for="txtLogo" class="form-label">Hospital logo </label>
                        <input id="txtLogo" name="logo" accept="image/*" type="file" class="form-control">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                    <label for="txtHospitalName" class="form-label">Hospital Name <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtHospitalName" type="text" name="hospitalName"  maxlength="150" class="form-control" required>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                    <label for="txtPhoneNo" class="form-label">Phone No <span class="text-danger mt-2"> *</span></label>
                    <input id="txtPhoneNo" type="text" name="phoneNo"  class="form-control"  pattern="(0|91)?(-)?[6-9][0-9]{9}" maxlength="13" title="Phone No format 9999999999 or 91-9999999999" required>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                    <label for="txtEmail" class="form-label">Email Id <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtEmail" type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
                        
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                    <label for="txtPassword" class="form-label">Password <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtPassword" name="password"  type="password" minlength="5" maxlength="15" class="form-control" required>
                          
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                    <label for="txtAddress" class="form-label">Address <span class="text-danger mt-2"> *</span></label>
                                        <textarea id="txtAddress" name="address" class="form-control" minlength="10" required></textarea>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                    <label for="txtContact" class="form-label">Contact Person <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtContact" name="inChargePerson" maxlength="150" type="text" class="form-control" required>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                    <label for="txtContactPhNo" class="form-label">Contact Person Phone No <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtContactPhNo" name="inChargePhoneNo"  type="text"  pattern="(0|91)?(-)?[6-9][0-9]{9}" maxlength="13" title="Phone number format 9999999999 or 91-9999999999" class="form-control" required>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                    </div>

                    <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                    <button id="btnSavePatient" type=submit class="btn btn-primary w-24 ml-2">Register</button>
                                        <button type=reset class="btn btn-dark w-24 ">Cancel</button> 
                    </div>
                    </div>
                    </div>
                </div>
</form>
                <!-- END: Content -->
                <!-- BEGIN: Error Modal Content --> 
 <div id="divHospitalErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i> 
                <div id="divDrErrorHead"class="text-3xl mt-5"><span></span></div> 
                <div id="divDrErrorMsg" class="text-slate-500 mt-2"><span></span></div> </div> 
                <div class="px-5 pb-8 text-center"> 
                    <button type="button" data-tw-dismiss="modal" class="btn w-24 btn-primary">Ok</button> 
                </div> 
            </div> 
        </div> 
    </div> 
</div> <!-- END: Error Modal Content --> 
 <!-- BEGIN: Success Modal Content --> 
 <div id="divHospitalSuccessModal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divDrMsg" class="text-3xl mt-5"><span></span></div> 
                 <div id="divDrLogin" class="text-slate-500 mt-2"><span></span></div> </div>
                  <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 
    </div></div>
@endsection
@push('js')
<script  type="module" src="{{ asset('dist/js/app.js')}}"></script>
<script  type="module" src="{{ asset('dist/js/patient.js')}}"></script>
@endpush



