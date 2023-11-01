@extends('layouts.main')
@section('title','Today Appointments')
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
                <!-- BEGIN: HTML Table Data -->
                <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control" disabled>
                <div class="intro-y box p-5 mt-5">
                    
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="tbAppointment-html-filter-form" class="xl:flex sm:mr-auto" >
                        @csrf
                            <div class="sm:flex items-center sm:mr-4">
                                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
                                <select id="tbAppointment-html-filter-field" class="form-select w-full sm:w-32 2xl:w-full mt-2 sm:mt-0 sm:w-auto">
                                    <option value="hcNo">Register No</option>
                                    <option value="patientName">Patient Name</option>
                                    <option value="phoneNo">Phone No</option>
                                    <option value="doctorName">Doctor Name</option>
                                </select>
                            </div>
                            <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Type</label>
                                <select id="tbAppointment-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto" >
                                    <option value="like" selected>like</option>
                                    <option value="=">=</option>
                                </select>
                            </div>
                            <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Value</label>
                                <input id="tbAppointment-html-filter-value" type="text" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Search...">
                            </div>
                            <div class="mt-2 xl:mt-0">
                                <button id="tbAppointment-html-filter-go" type="button" class="btn btn-primary w-full sm:w-16" >Go</button>
                                <button id="tbAppointment-html-filter-reset" type="button" class="btn btn-dark w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" >Reset</button>
                            </div>
                        </form>
                        <div class="flex mt-5 sm:mt-0">
                            <button id="tbAppointment-print" class="btn btn-primary w-1/2 sm:w-auto mr-2"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print </button>
                            <div class="dropdown w-1/2 sm:w-auto">
                                <button id="tbAppointment-export-xlsx" class="btn btn-primary w-full sm:w-auto"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export as xlsx </button>
                            </div>
                        </div>
                    </div>
                    <input id="txtHospital" name="hostpialId" value="{{ session('hospitalId') }}" type="hidden" class="form-control">
                    <input id="txtType" name="hostpialId" value="2" type="hidden" class="form-control">
                    <input id="txtBranch" name="branchId" value="{{ session('branchId') }}"  type="hidden" class="form-control">
                    <div class="overflow-x-auto scrollbar-hidden">
                        <div id="tbAppointment" class="mt-5 table-report table-report--tabulator"></div>
                    </div>
                </div>
            </div>
                <!-- BEGIN: Modal Delete Patient --> 
                <div id="divDeleteAppointment" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true"> 
                    <div class="modal-dialog"> <div class="modal-content"> 
                        <div class="modal-body p-0"> <div class="p-5 text-center"> 
                            <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i> 
                            <div class="text-3xl mt-5">Do you really want to delete these appointment?</div> 
                        </div> 
                        <div class="px-5 pb-8 text-center">
                        <input id="txtId" name="id" type="hidden" class="form-control" disabled>
                                <button id="btnDelAppointment" type="button" class="btn btn-danger w-24">Delete</button>
                             <button type="button" data-tw-dismiss="modal" class="btn btn-dark w-24 mr-1">Cancel</button>
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
            <!-- END: Modal Delete Patient --> 
            <!-- BEGIN: Error Modal Content --> 
 <div id="divAppointmentErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
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
                <!-- BEGIN: Modal View Appointment --> 
 <div id="divViewAppointment" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true"> 
        <div class="modal-dialog" style="width: 1000px"> 
            <div class="modal-content">  
            <!--Close Button-->
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x-circle" class="w-8 h-8 text-danger"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="modal-header"> 
                <h2 class="text-lg font-medium mr-auto">Patient Appointment Information</h2> 
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
                                <div id="lblName" class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg"><span></span></div>
                                     <div id="lblStatus" class="text-info">Status :  <mark class="p-1 bg-dark rounded-full"><span></span></mark></div>
                                <div id="lblHcNo" class="text-info">Code No : <span></span></div>
                                <div id="lblPhoneNo" class="truncate sm:whitespace-normal flex items-center"><i data-lucide="phone" class="w-4 h-4 mr-2"></i><span></span> </div>
                                <div id=lblEmail class="truncate sm:whitespace-normal flex items-center"><i data-lucide="mail" class="w-4 h-4 mr-2"></i><span></span></div>
                                <div id=lblAddress class="truncate sm:whitespace-normal flex items-center"><i data-lucide="home" class="w-4 h-4 mr-2"></i><span></span></div>
                            </div>
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                                <div id="lblAppointmentDate" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Appointment Date : </b><span></span></div>
                                <div id="lblAppointmentTime" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Appointment Time : </b><span></span></div>
                                <div id="lblDoctorName" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Doctor Name : </b><span></span></div>
                                <div id="lblDepartment" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Doctor Department : </b><span></span></div>
                                <div id="lblReason" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Reason : </b><span></span></div>
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                                <div id="lblGender" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Gender : </b><span></span> </div>
                                <div id="lblBloodGrp" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Blood Group : </b><span></span> </div>
                                <div id="lblMartialStatus" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Martial Status :</b><span></span> </div>
                                <div id="lblHeight" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Height :</b><span></span> </div>
                                <div id="lblWeight" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Weight : </b><span></span></div>
                                <div id="lblSpouseName" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Spouse Name : </b><span></span></div>
                                <div id="lblSpousePhNo" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Spouse Phone No : </b><span></span></div>
                            </div>
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
                <!-- Update the appointment status view BEGIN -->
 <!-- BEGIN: Modal Content --> 
 <div id="divStatusModal"  data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true"> 
    <div class="modal-dialog" style="width: 250px"> <div class="modal-content"> 
        <!-- BEGIN: Modal Header --> 
        <div class="modal-header">
             <h2 class="font-medium text-base mr-auto">Appointment Status</h2>
             <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-400"></i> </a>  
        </div> 
        <!-- END: Modal Header -->
        <form id="frmUpdAppointmentStatus">
         <!-- BEGIN: Modal Body --> 
         <div class="modal-body grid grid-cols-6 gap-4 gap-y-3"> 
         <div> 
         <div class="col-span-12 sm:col-span-6">
         <input id="txtAppointmentId" name="appointmentId" type="hidden" class="form-control">
            <div class="form-check mt-2"> <input id="rdCreated" class="form-check-input" type="radio" name="status" value="Created">
                 <label class="form-check-label" for="rdCreated">Created</label> 
            </div>
            <div class="form-check mt-2"> <input id="rdStarted" class="form-check-input" type="radio" name="status" value="Started"> 
                <label class="form-check-label" for="rdStarted">Started</label> 
            </div> 
            <div class="form-check mt-2"> <input id="rdFinished" class="form-check-input" type="radio" name="status" value="Finished"> 
                <label class="form-check-label" for="rdFinished">Finished</label> 
            </div>
            <div class="form-check mt-2"> <input id="rdDelayed" class="form-check-input" type="radio" name="status" value="Delayed" > 
                <label class="form-check-label" for="rdDelayed">Delayed</label> 
            </div>
            <div class="form-check mt-2"> <input id="rdCancelled" class="form-check-input" type="radio" name="status" value="Cancelled"> 
                <label class="form-check-label" for="rdCancelled">Cancelled</label> 
            </div>
            <div class="form-check mt-2"> <input id="rdPending" class="form-check-input" type="radio" name="status" value="Pending"> 
                <label class="form-check-label" for="rdPending">Pending</label> 
            </div>
            <div class="form-check mt-2"> <input id="rdReSchedule" class="form-check-input" type="radio" name="status" value="ReSchedule"> 
                <label class="form-check-label" for="rdReSchedule">ReSchedule</label> 
            </div>
            <div class="form-check mt-2"> <input id="rdOnGoing" class="form-check-input" type="radio" name="status" value="OnGoing"> 
                <label class="form-check-label" for="rdOnGoing">OnGoing</label> 
            </div>
            <div class="form-check mt-2"> <input id="rdNone" class="form-check-input" type="radio" name="status" value="None"> 
                <label class="form-check-label" for="rdNone">None</label> 
            </div>
                        </div>
        </div>
            </div>
             <!-- END: Modal Body -->
              <!-- BEGIN: Modal Footer -->
               <div class="modal-footer"> 
                <button type="button" data-tw-dismiss="modal" class="btn btn-dark w-20 mr-1">Cancel</button> 
                <button type="submit" class="btn btn-primary w-20">Save</button> 
            </div> 
            </from>
            <!-- END: Modal Footer --> 
        </div> </div> </div> <!-- END: Modal Content --> 
                <!-- Update the appointment status view END -->
                
    </div>
@endsection

        @push('js')
        <script type="module" src="{{ asset('dist/js/app.js')}}"></script>
        <script type="module"  src="{{ asset('dist/js/patient.js')}}"></script>
        @endpush



