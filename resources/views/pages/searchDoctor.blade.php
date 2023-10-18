@extends('layouts.main')
@section('title','Doctor')
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
                        <button onclick="window.location='{{ url("Doctor") }}'" class="btn btn-primary shadow-md mr-2">Add Doctor</button>
                    </div>
                </div>
                <!-- BEGIN: HTML Table Data -->
                <div class="intro-y box p-5 mt-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="tbDoctor-html-filter-form" class="xl:flex sm:mr-auto" >
                        @csrf
                            <div class="sm:flex items-center sm:mr-4">
                                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
                                <select id="tbDoctor-html-filter-field" class="form-select w-full sm:w-32 2xl:w-full mt-2 sm:mt-0 sm:w-auto">
                                    <option value="doctorCodeNo">Code No</option>
                                    <option value="name">Name</option>
                                    <option value="phoneNo">Phone No</option>
                                </select>
                            </div>
                            <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Type</label>
                                <select id="tbDoctor-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto" >
                                    <option value="like" selected>like</option>
                                    <option value="=">=</option>
                                </select>
                            </div>
                            <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Value</label>
                                <input id="tbDoctor-html-filter-value" type="text" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Search...">
                            </div>
                            <div class="mt-2 xl:mt-0">
                                <button id="tbDoctor-html-filter-go" type="button" class="btn btn-primary w-full sm:w-16" >Go</button>
                                <button id="tbDoctor-html-filter-reset" type="button" class="btn btn-dark w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" >Reset</button>
                            </div>
                        </form>
                        <div class="flex mt-5 sm:mt-0">
                            <button id="tbDoctor-print" class="btn btn-primary w-1/2 sm:w-auto mr-2"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print </button>
                            <div class="dropdown w-1/2 sm:w-auto">
                                <button id="tbDoctor-export-xlsx" class="btn btn-primary w-full sm:w-auto"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export as xlsx </button>
                            </div>
                        </div>
                    </div>
                    <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}" type="hidden" class="form-control">
                    <input id="txtBranch" name="branchId" value="{{ session('branchId') }}"  type="hidden" class="form-control">
                    <div class="overflow-x-auto scrollbar-hidden">
                        <div id="tbDoctor" class="mt-5 table-report table-report--tbDoctor"></div>
                    </div>
                </div>
            </div>
                 <!-- BEGIN: Modal Delete Doctor --> 
                 <div id="delete-modal-preview" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true"> 
                    <div class="modal-dialog"> <div class="modal-content"> 
                        <div class="modal-body p-0"> <div class="p-5 text-center"> 
                            <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i> 
                            <div class="text-3xl mt-5">Do you really want to delete these doctor?</div> 
                            <div id="divDrCodeNo" class="text-slate-500 mt-2">Doctor Code Number : <span></span></div> 
                        </div> 
                        <div class="px-5 pb-8 text-center">
                        <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control" disabled>
                        <input id="txtId" name="id" type="hidden" class="form-control" disabled>
                                <button id="btnDelDoctor" type="button" class="btn btn-danger w-24">Delete</button>
                             <button type="button" data-tw-dismiss="modal" class="btn btn-dark w-24 mr-1">Cancel</button>
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
            <!-- END: Modal Delete Doctor --> 
            <!-- BEGIN: Error Modal Content --> 
 <div id="divDoctorErrorModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true"> 
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
 <!-- BEGIN: Modal View Doctor --> 
 <div id="divViewDoctor" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true"> 
        <div class="modal-dialog" style="width: 1000px"> 
            <div class="modal-content">  
            <!--Close Button-->
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x-circle" class="w-8 h-8 text-danger"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="modal-header"> 
                <h2 class="text-lg font-medium mr-auto">Doctor Information</h2> 
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
                                <img id="imgProfileImage" alt="Profile Picture" class="rounded-full" src="{{ asset('dist/images/profile-5.jpg')}}">
                                </div>
                                <div class="ml-5">
                                <div id="divName" class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg"><span></span></div>
                                <div id="divCode" class="text-info">Code No : <span></span></div>
                                <div id="divPhoneNo" class="truncate sm:whitespace-normal flex items-center"><i data-lucide="phone" class="w-4 h-4 mr-2"></i><span></span> </div>
                                <div id=divEmail class="truncate sm:whitespace-normal flex items-center"><i data-lucide="mail" class="w-4 h-4 mr-2"></i><span></span></div>
                                <div id=divAddress class="truncate sm:whitespace-normal flex items-center"><i data-lucide="home" class="w-4 h-4 mr-2"></i><span></span></div>
                               
                            </div>
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                                <div id="divDob" class="truncate sm:whitespace-normal flex items-center"><b>Date of Birth : </b><span></span> </div>
                                <div id="divGender" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Gender : </b><span></span></div>
                                <div id="divBloodGrp" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Blood Group : </b><span></span> </div>
                                <div id="divEducation" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Education : </b><span></span> </div>
                                <div id="divDesignation" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Designation :</b><span></span> </div>
                                <div id="divDepartment" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Department :</b><span></span> </div>
                                <div id="divExperience" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Experience : </b><span></span></div>
                            </div>
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                        
                        <span class="font-medium text-lg">Signature</span>
                            <img id="imgSignature" alt="Signature" class="rounded-full" src="{{ asset('dist/images/profile-5.jpg')}}">
                           
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
                <!-- END: Modal View Doctor --> 
    </div>
@endsection

        @push('js')
        <script type="module" src="{{ asset('dist/js/app.js')}}"></script>
        <script  type="module" src="{{ asset('dist/js/patient.js')}}"></script>
        @endpush



