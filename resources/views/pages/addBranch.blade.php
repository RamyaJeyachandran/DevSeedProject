@extends('layouts.main')
@section('title','Branch Information')
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
                    <form id="frmBranch" method="POST" enctype="multipart/form-data">
                    <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                    <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}" type="hidden" class="form-control">
                        <div class="intro-y col-span-12 sm:col-span-4 form-control">
                        <label for="txtLogo" class="form-label">Logo</label>
                        <input id="txtLogo" name="logo" accept="image/*" type="file" class="form-control">
                        </div>
                        @can('isAdmin')
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">

                            <label for="ddlHospital" class="form-label">Hospital Name</label>
                                            <select id="ddlHospital" name="hospitalId" class="form-select" required>
                                                <option value='0'>Select Hospital</option>
                                            </select>
                            </div>
                        @endcan
                        <div class="intro-y col-span-12 sm:col-span-4 form-control">
                        <label for="txtHospitalName" class="form-label">Branch Hospital Name <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtHospitalName" type="text" name="branchName" class="form-control" required>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-4 form-control">
                        <label for="txtPhoneNo" class="form-label">Phone No <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtPhoneNo" type="text" name="phoneNo" class="form-control" required>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-4 form-control">
                        <label for="txtEmail" class="form-label">Email Id <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtEmail" type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-4 form-control">
                        <label for="txtPassword" class="form-label">Password <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtPassword" name="password"  type="password" class="form-control" required>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-4 form-control">
                        <label for="txtAddress" class="form-label">Address <span class="text-danger mt-2"> *</span></label>
                                        <textarea id="txtAddress" name="address" class="form-control" minlength="10" required></textarea>
                              
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-4 form-control">
                        <label for="txtContact" class="form-label">Contact Person <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtContact" name="contactPerson" type="text" class="form-control" required>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-4 form-control">
                        <label for="txtContactPhNo" class="form-label">Contact Person Phone No <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtContactPhNo" name="contactPersonPhNo" type="text" class="form-control" required>
                        </div>
                        
                        <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                        <button id="btnSaveBranch" type=submit class="btn btn-primary w-24 ml-2">Register</button>
                                        <button type=reset class="btn btn-dark w-24 ">Cancel</button> 
                        </div>
                    </div>
                    </div>
                
</form></div>
                <!-- END: Content -->
                <!-- BEGIN: Error Modal Content --> 
 <div id="divBranchErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i> 
                <div id="divBrErrorHead"class="text-3xl mt-5"><span></span></div> 
                <div id="divBrErrorMsg" class="text-slate-500 mt-2"><span></span></div> </div> 
                <div class="px-5 pb-8 text-center"> 
                    <button type="button" data-tw-dismiss="modal" class="btn w-24 btn-primary">Ok</button> 
                </div> 
            </div> 
        </div> 
    </div> 
</div> <!-- END: Error Modal Content --> 
 <!-- BEGIN: Success Modal Content --> 
 <div id="divBranchSuccessModal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divBrMsg" class="text-3xl mt-5"><span></span></div> 
                 <div id="divBrLogin" class="text-slate-500 mt-2"><span></span></div> </div>
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
        <script src="{{ asset('dist/js/app.js')}}"></script>
        <script  type="module" src="{{ asset('dist/js/patient.js')}}"></script>
        @endpush



