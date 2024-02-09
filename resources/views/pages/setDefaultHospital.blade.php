@extends('layouts.main')
@section('title','Set Default Hospital')
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
                    <form id="frmSetDefaultHospital">

                    <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                            <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                            @can('isAdmin')
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="ddlHospital" class="form-label">Hospital <span class="text-danger mt-2"> *</span></label>
                                <select id="ddlHospital"  value="{{$details->defaultHospitalId}}" name="hospitalId" class="form-select" required>
                                    <option value='0'>Select Hospital</option>
                                @foreach ($details->hospitalList as $hospital)
                                    <option value="{{ $hospital->id }}" {{ ( $hospital->id == $details->defaultHospitalId) ? 'selected' : '' }}> 
                                        {{ $hospital->hospitalName }} 
                                    </option>
                                @endforeach    
                                </select>
                            </div>
                            @endcan
                            <div id="divBranchddl" class="intro-y col-span-12 sm:col-span-6">
                                <label for="ddlBranch" class="form-label">Branch</label>
                                <select id="ddlBranch"  value="{{$details->defaultBranchId}}" name="branchId" class="form-select">
                                    <option value='0'>Select Branch</option>
                                @foreach ($details->branchList as $branch)
                                    <option value="{{ $branch->id }}" {{ ( $branch->id == $details->defaultBranchId) ? 'selected' : '' }}> 
                                        {{ $branch->branchName }} 
                                    </option>
                                @endforeach    
                                </select>
                            </div>
                            <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <button id="btnUpdDefault" type=submit class="btn btn-primary w-24 ml-2">Set</button>
                            </div>
                        </div></div>
                        </form>
                        </div>
                        
                    </div>
                    </div>
                      
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
        <div id="divDefaultSuccessModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true" data-tw-backdrop="static"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divMsg" class="text-3xl mt-5"><span></span></div> </div>
                  <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 
  
 <!-- BEGIN: Error Modal Content --> 
 <div id="divDefaultErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
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
        <script  type="module" src="{{ asset('dist/js/settings.js')}}"></script>
        @endpush



