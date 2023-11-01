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
                    <form id="frmEditBranch" method="POST" enctype="multipart/form-data">
                    <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-6">
                    <div class="intro-y box">
                            <div id="input" class="p-5">
                                <div class="preview">
                                <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                    <input id="txtHospitalId" name="hospitalId" value="{{$branchDetails->hospitalId}}" type="hidden" class="form-control">
                    <input id="txtBranchId" name="branchId" value="{{$branchDetails->branchId}}" type="hidden" class="form-control">
                                    <div>
                                        <label for="txtHospitalName" class="form-label">Hospital Name</label>
                                        <input id="txtHospitalName" type="text" value="{{$branchDetails->hospitalName}}" name="hospitalName" class="form-control" disabled>
                                    </div>
                                    <div>
                                        <label for="txtBranchName" class="form-label">Branch Name</label>
                                        <input id="txtBranchName" type="text" value="{{$branchDetails->branchName}}" name="branchName" class="form-control">
                                    </div>
                                    <div class="mt-3">
                                        <label for="txtPhoneNo" class="form-label">Phone No <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtPhoneNo" type="text" value="{{$branchDetails->phoneNo}}" name="phoneNo" class="form-control" required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="txtEmail" class="form-label">Email Id <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtEmail" type="email" value="{{$branchDetails->email}}" name="email" class="form-control" placeholder="example@gmail.com" required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="txtAddress" class="form-label">Address <span class="text-danger mt-2"> *</span></label>
                                        <textarea id="txtAddress" name="address" value="{{$branchDetails->address}}" class="form-control" minlength="10" required>{{$branchDetails->address}}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label for="txtContact" class="form-label">Contact Person <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtContact" name="contactPerson" value="{{$branchDetails->contactPerson}}" type="text" class="form-control" required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="txtContactPhNo" class="form-label">Contact Person Phone No <span class="text-danger mt-2"> *</span></label>
                                        <input id="txtContactPhNo" name="contactPersonPhNo" value="{{$branchDetails->contactPersonPhNo}}" type="text" class="form-control" required>
                                    </div>
                                    <div class="mt-3">
                                        <button id="btnEditBranch" type="submit" class="btn btn-danger w-24 ml-2"><i data-lucide="edit" class="w-4 h-4 mr-2"></i>Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Input -->
                        
                    </div>
                    <div class="intro-y col-span-12 lg:col-span-6">
                        <!-- BEGIN: Login Form -->
                        <div class="intro-y box">
                            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                <h2 class="font-medium text-base mr-auto">
                                    Logo
                                </h2>
                            </div>
                            <div id="vertical-form" class="p-5">
                                <div class="preview">
                                        <div class="intro-y col-span-12  form-control">
                                        <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                            <img id="imgLogo" class="rounded-full" src="{{$branchDetails->logo}}">
                                        </div>
                                        <input id="txtLogo" name="logo" accept="image/*" type="file" class="form-control" src="{{$branchDetails->logo}}">
                                        <input id="txtImageChanged" name="isImageChanged" value="0" type="hidden" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Vertical Form -->
                    </div>
                </div>
</form>
                <!-- END: Content -->
                 <!-- BEGIN: Success Modal Content --> 
        <div id="divSuccessEditHospital" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divMsg" class="text-3xl mt-5"><span></span></div>  </div>
                  <div class="px-5 pb-8 text-center">
                    @if(session('userType')==1 ||  session('userType')==2)
                        <button id="btnbrRedirect" type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                    @else
                         <button onclick="window.location='{{ url("Profile") }}/{{ session("userId")}}'" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                    @endif
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 
  <!-- BEGIN: Error Modal Content --> 
  <div id="divErrorEditHospital" class="modal" tabindex="-1" aria-hidden="true"> 
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

    </div></div>
@endsection

        @push('js')
        <script src="{{ asset('dist/js/app.js')}}"></script>
        <script  type="module" src="{{ asset('dist/js/patient.js')}}"></script>
        @endpush



