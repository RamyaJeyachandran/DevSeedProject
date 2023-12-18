@extends('layouts.main')
@section('title','Assigned Patient Information')
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
                    <form id="frmEditAssign" method="POST" enctype="multipart/form-data">
                    <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                    <input id="txtAssignId" name="AssignId" value="{{$AssignDetails->AssignId}}" type="hidden" class="form-control">
                    <input id="txtHospital" name="hospitalId" value="{{ $AssignDetails->hospitalId }}" type="hidden" class="form-control">
                    <input id="txtBranch" name="branchId" value="{{ $AssignDetails->branchId }}"  type="hidden" class="form-control">
                   
                            <div class="intro-y col-span-12 sm:col-span-6 w-24 h-24 image-fit"> 
                                 <img class="rounded-full" src="{{$AssignDetails->profileImage}}">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 form-control">
</div>
                            <div class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="txtRegNo" class="form-label">Patient Reg.No</label>
                                <input id="txtRegNo" name="hcNo" value="{{$AssignDetails->hcNo}}" type="text" class="form-control" disabled>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="txtName" class="form-label">Patient Name </label>
                                <input id="txtName" name="name" value="{{$AssignDetails->name}}" type="text" class="form-control" disabled>
                            </div>
                            
                            <div class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="txtPhoneNo" class="form-label">Phone No </label>
                                <input id="txtPhoneNo" value="{{$AssignDetails->phoneNo}}" name="phoneNo" type="text" class="form-control" disabled>
                            </div>
                            
                            <div class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="txtEmail" class="form-label">Email Id </label>
                                <input id="txtEmail" value="{{$AssignDetails->email}}" name="email" type="email" class="form-control" disabled>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="ddlDoctor" class="form-label">Doctor <span class="text-danger mt-2"> *</span></label>
                                <select id="ddlDoctor" value="{{$AssignDetails->doctorId}}" name="doctorId" class="form-select">
                                    <option value='0'>Select Doctor</option>
                                    @if($AssignDetails->doctorList!=null)
                                    @foreach ($AssignDetails->doctorList as $doctor)
                                    <option value="{{ $doctor->id }}" {{ ( $doctor->id == $AssignDetails->doctorId) ? 'selected' : '' }}> 
                                        {{ $doctor->name }} 
                                    </option>
                                     @endforeach 
                                     @endif
                                </select>
                            </div>
                            <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <button id="btnEditAssign" type=submit class="btn btn-danger w-24 ml-2"><i data-lucide="edit" class="w-4 h-4 mr-2"></i>Update</button>
                                <button id="btnBackAssign" type=button class="btn btn-dark w-24 ml-2"><i data-lucide="skip-back" class="w-4 h-4 mr-2"></i>Back</button>
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
        <div id="divSuccessEditAssign" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divMsg" class="text-3xl mt-5"><span></span></div> <div id="divAssignCodeNo" class="text-slate-500 mt-2"><span></span></div> </div>
                  <div class="px-5 pb-8 text-center"> 
                    <button id="btnAssignRedirect" type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 

 <!-- BEGIN: Error Modal Content --> 
 <div id="divErrorEditAssign" class="modal" tabindex="-1" aria-hidden="true"> 
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i> 
                <div id="divAssignErrorHead"class="text-3xl mt-5"><span></span></div> 
                <div id="divAssignErrorMsg" class="text-slate-500 mt-2"><span></span></div> </div> 
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
        @endpush



