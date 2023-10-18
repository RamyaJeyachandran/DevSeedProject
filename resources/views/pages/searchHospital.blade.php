@extends('layouts.main')
@section('title','Hospital')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />

@endsection 
@section('content')
    @include('layouts.mobileSideMenu')
    <div class="flex mt-[4.7rem] md:mt-0">
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
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                        <button onclick="window.location='{{ url("Hospital") }}'" class="btn btn-primary shadow-md mr-2">Add Hospital</button>
                    </div>
                </div>
                <!-- BEGIN: HTML Table Data -->
                <div class="intro-y box p-5 mt-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="tbHospital-html-filter-form" class="xl:flex sm:mr-auto" >
                        @csrf
                            <div class="sm:flex items-center sm:mr-4">
                                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
                                <select id="tbHospital-html-filter-field" class="form-select w-full sm:w-32 2xl:w-full mt-2 sm:mt-0 sm:w-auto">
                                    <option value="hospitalName">Name</option>
                                    <option value="phoneNo">Phone No</option>
                                    <option value="email">Email</option>
                                </select>
                            </div>
                            <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Type</label>
                                <select id="tbHospital-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto" >
                                    <option value="like" selected>like</option>
                                    <option value="=">=</option>
                                </select>
                            </div>
                            <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Value</label>
                                <input id="tbHospital-html-filter-value" type="text" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Search...">
                            </div>
                            <div class="mt-2 xl:mt-0">
                                <button id="tbHospital-html-filter-go" type="button" class="btn btn-primary w-full sm:w-16" >Go</button>
                                <button id="tbHospital-html-filter-reset" type="button" class="btn btn-dark w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" >Reset</button>
                            </div>
                        </form>
                        <div class="flex mt-5 sm:mt-0">
                            <button id="tbHospital-print" class="btn btn-primary w-1/2 sm:w-auto mr-2"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print </button>
                            <div class="dropdown w-1/2 sm:w-auto">
                                <button id="tbHospital-export-xlsx" class="btn btn-primary w-full sm:w-auto"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export as xlsx </button>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto scrollbar-hidden">
                        <div id="tbHospital" class="mt-5 table-report table-report--tabulator"></div>
                    </div>
                </div>
            </div>
                 <!-- BEGIN: Modal Delete hospital --> 
                 <div id="divDeleteHospital" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true"> 
                    <div class="modal-dialog"> <div class="modal-content"> 
                        <div class="modal-body p-0"> <div class="p-5 text-center"> 
                            <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i> 
                            <div class="text-3xl mt-5">Do you really want to delete these Hospital?</div> 
                            <div id="divHospitalName" class="text-slate-500 mt-2">Hospital Name : <span></span></div> 
                        </div> 
                        <div class="px-5 pb-8 text-center">
                        <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control" disabled>
                        <input id="txtId" name="id" type="hidden" class="form-control" disabled>
                                <button id="btnDelHospital" type="button" class="btn btn-danger w-24">Delete</button>
                             <button type="button" data-tw-dismiss="modal" class="btn btn-dark w-24 mr-1">Cancel</button>
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
            <!-- END: Modal Delete Hospital --> 
            <!-- BEGIN: Error Modal Content --> 
 <div id="divHospitalErrorModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true"> 
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
 <!-- BEGIN: Modal View Hospital --> 
 <div id="divViewHospital" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true"> 
        <div class="modal-dialog" > 
            <div class="modal-content">  
            <!--Close Button-->
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x-circle" class="w-8 h-8 text-danger"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="modal-header"> 
                <h2 class="text-lg font-medium mr-auto">Hospital Information</h2> 
                <!-- <button id="tbPrintPatient" class="btn btn-primary w-1/2 sm:w-auto mr-2"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print </button> -->
                </div> 
                <!-- END: Modal Header -->
                 <!-- BEGIN: Modal Body --> 
                 <div class="modal-body box p-5">
                   <!-- BEGIN: Profile Info -->
                <div class="intro-y box px-5">
                    <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                <img id="imgLogo" alt="Profile Picture" class="rounded-full" src="{{ asset('dist/images/profile-5.jpg')}}">
                            </div>
                            <div class="ml-5">
                                <div id="divName" class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg"><span></span></div>
                                <div id="divContactPerson" class="text-info">Contact Person : <span></span></div>
                                <div id="divPhoneNo" class="truncate sm:whitespace-normal flex items-center"><i data-lucide="phone" class="w-4 h-4 mr-2"></i><span></span> </div>
                                <div id=divEmail class="truncate sm:whitespace-normal flex items-center"><i data-lucide="mail" class="w-4 h-4 mr-2"></i><span></span></div>
                                <div id=divAddress class="truncate sm:whitespace-normal flex items-center"><i data-lucide="home" class="w-4 h-4 mr-2"></i><span></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Profile Info -->
                
                 </div> 
                 <!-- END: Modal Body -->
              </div> 
            </div> 
        </div>
                <!-- END: Modal View Hospital --> 
    </div>
@endsection

        @push('js')
        <script type="module" src="{{ asset('dist/js/app.js')}}"></script>
        <script  type="module" src="{{ asset('dist/js/patient.js')}}"></script>
        @endpush



