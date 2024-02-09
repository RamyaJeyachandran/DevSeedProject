@extends('layouts.main')
@section('title','Department')
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
                    <form id="frmDepartBank">

                    <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <input id="txtMode" name="mode" value="1" type="hidden" class="form-control">
                    <input id="txtDepartId" name="DepartId" type="hidden" class="form-control">
                            <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                            <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}" type="hidden" class="form-control">
                    <input id="txtBranch" name="branchId" value="{{ session('branchId') }}"  type="hidden" class="form-control">
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtName" class="form-label">Department Name <span class="text-danger mt-2"> *</span></label>
                                <input id="txtName" name="name" type="text" class="form-control" required>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 justify-center mt-5">
                                <button id="btnSaveDepart" type=submit class="btn btn-primary w-24 ml-2"><i data-lucide="save" class="w-4 h-4 mr-2"></i>Save</button>
                                <button id="btnCancelDepart" type="reset" class="btn btn-dark w-24"><i data-lucide="x-circle" class="w-4 h-4 mr-2"></i>Cancel</button> 
                            </div>
                        </div></div>
                        </form>
                          <!-- View Depart Bank BEGIN -->
                    <div class="intro-y box p-5 mt-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                            <button id="tbDepart-print" class="btn btn-danger w-1/2 sm:w-auto mr-2"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print </button>
                            <div class="dropdown w-1/2 sm:w-auto">
                                <button id="tbDepart-export-xlsx" class="btn btn-primary w-full sm:w-auto"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export as xlsx </button>
                            </div>
                        </div>
                        </div>
                     
                        <div class="overflow-x-auto scrollbar-hidden">
                            <div id="tbDepart" class="mt-5 table-report table-report--tabulator"></div>
                        </div>
                        </div>
                     <!-- View Depart Bank END -->
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
        <div id="divDepartSuccessModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true" data-tw-backdrop="static"> 
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
   <!-- BEGIN: Modal Delete Branch --> 
   <div id="divDeleteDepartBank" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true"> 
                    <div class="modal-dialog"> <div class="modal-content"> 
                        <div class="modal-body p-0"> <div class="p-5 text-center"> 
                            <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i> 
                            <div class="text-3xl mt-5">Do you really want to delete these Depart Bank?</div> 
                            <div id="divDepartBank" class="text-slate-500 mt-2">Name : <span></span></div> 
                        </div> 
                        <div class="px-5 pb-8 text-center">
                        <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control" disabled>
                                <button id="btnDelDepartBank" type="button" class="btn btn-danger w-24">Delete</button>
                             <button type="button" data-tw-dismiss="modal" class="btn btn-dark w-24 mr-1">Cancel</button>
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
            <!-- END: Modal Delete Branch --> 
 <!-- BEGIN: Error Modal Content --> 
 <div id="divDepartErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
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
        @endpush



