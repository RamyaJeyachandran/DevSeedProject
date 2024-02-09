@extends('layouts.main')
@section('title','Report Signature')
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
                    <form id="frmReportSignBank">

                    <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <input id="txtMode" name="mode" value="1" type="hidden" class="form-control">
                    <input id="txtReportSignId" name="reportSignId" type="hidden" class="form-control">
                            <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                            <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}" type="hidden" class="form-control">
                    <input id="txtBranch" name="branchId" value="{{ session('branchId') }}"  type="hidden" class="form-control">
                            <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <button type="button" class="btn btn-outline-primary w-full py-1 px-2">Left Signature</button>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlDepartmentLeft" class="form-label">Department</label>
                                <select id="ddlDepartmentLeft" name="departmentLeftId" class="form-select">
                                    <option value='0'>Select Department</option>
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlDoctorLeft" class="form-label">Doctor <span class="text-danger mt-2"> *</span></label>
                                <select id="ddlDoctorLeft" name="doctorLeftId" class="form-select">
                                    <option value='0'>Select Doctor</option>
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="divLeftSignature" class="form-label"> Signature <span class="text-danger mt-2"> *</span></label>
                                <div id="divLeftSignature" class="flex">

                                </div>
                            </div>
                            <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <button type="button" class="btn btn-outline-primary w-full py-1 px-2">Right Signature</button>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlDepartmentRight" class="form-label">Department</label>
                                <select id="ddlDepartmentRight" name="departmentRightId" class="form-select">
                                    <option value='0'>Select Department</option>
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlDoctorRight" class="form-label">Doctor <span class="text-danger mt-2"> *</span></label>
                                <select id="ddlDoctorRight" name="doctorRightId" class="form-select">
                                    <option value='0'>Select Doctor</option>
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="divRightSignature" class="form-label"> Signature <span class="text-danger mt-2"> *</span></label>
                                <div id="divRightSignature" class="flex">

                                </div>
                            </div>
                            <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <button type="button" class="btn btn-outline-primary w-full py-1 px-2">Center Signature</button>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlDepartmentcenter" class="form-label">Department</label>
                                <select id="ddlDepartmentcenter" name="departmentcenterId" class="form-select">
                                    <option value='0'>Select Department</option>
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlDoctorcenter" class="form-label">Doctor <span class="text-danger mt-2"> *</span></label>
                                <select id="ddlDoctorcenter" name="doctorcenterId" class="form-select">
                                    <option value='0'>Select Doctor</option>
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="divcenterSignature" class="form-label"> Signature <span class="text-danger mt-2"> *</span></label>
                                <div id="divcenterSignature" class="flex">

                                </div>
                            </div>
                            <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <div class="form-check form-switch"> 
                                    <input id="chkSetDefault" name="isDefault" class="form-check-input" type="checkbox"> 
                                    <label class="form-check-label" for="checkbox-switch-7">Set as default report signature</label> 
                                </div>
                            </div>
                            <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <button id="btnSaveReportSign" type=submit class="btn btn-primary w-24 ml-2"><i data-lucide="save" class="w-4 h-4 mr-2"></i>Save</button>
                                <button id="btnCancelReportSign" type="reset" class="btn btn-dark w-24"><i data-lucide="x-circle" class="w-4 h-4 mr-2"></i>Cancel</button> 
                            </div>
                        </div></div>
                        </form>
                          <!-- View ReportSign Bank BEGIN -->
                        
                    <div class="intro-y box p-5 mt-5">
                    <nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active font-medium text-base  mr-auto" aria-current="page">Report Signature List</li>
                        </ol>
                    </nav>
                        <div class="overflow-x-auto scrollbar-hidden">
                            <div id="tbReportSign" class="mt-5 table-report table-report--tabulator"></div>
                        </div>
                        </div>
                     <!-- View ReportSign Bank END -->
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
        <div id="divReportSignSuccessModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true" data-tw-backdrop="static"> 
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
 <div id="divReportSignErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
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



