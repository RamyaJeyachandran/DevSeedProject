@extends('layouts.main')
@section('title','Patient Appointment')
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
                    <form id="frmAppointment" method="POST">
                    <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}" type="hidden" class="form-control">
                    <input id="txtBranch" name="branchId" value="{{ session('branchId') }}" type="hidden" class="form-control">
                    <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                    <input id="txtTabNo" name="tabNo"  type="hidden" class="form-control">
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                        <button id="btnSaveAppointment" type=submit class="btn btn-primary shadow-md mr-2"><i data-lucide="save" class="w-4 h-4 mr-2"></i>Save</button>
                        <button id="btnCancelAppointment" type="reset" class="btn btn-dark w-24">Cancel</button>
                    </div>
                   <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    @can('isAdmin')
                    <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="ddlHospital" class="form-label">Hospital </label>
                                <select id="ddlHospital" name="hospitalId" class="form-select">
                                    <option value='0'>Select Hospital</option>
                                </select>
                            </div>
                    @endcan
                    @can('isAdminHospital')
                            <div id="divBranchddl" class="intro-y col-span-12 sm:col-span-6">
                                <label for="ddlBranch" class="form-label">Branch </label>
                                <select id="ddlBranch" name="branchId" class="form-select">
                                    <option value='0'>Select Branch</option>
                                </select>
                            </div>
                        @endcan

                    <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtAppointmentDate" class="form-label">Appointment Date <span class="text-danger mt-2"> *</span></label>
                                <input id="txtAppointmentDate" name="appointmentDate" type="text" class="datepicker form-control " data-single-mode="true" required> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                            <label for="txtAppointmentTime" class="form-label">Appointment Time <span class="text-danger mt-2"> *</span></label>
                                <input id="txtAppointmentTime" name="appointmentTime" type="time" class="form-control" required>
                            </div>
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="ddlDepartment" class="form-label">Department</label>
                                    <select id="ddlDepartment" name="departmentId" class="form-select">
                                        <option value='0'>Select Department</option>
                                    </select>
                            </div>
                                <div class="intro-y col-span-12 sm:col-span-6">
                                    <label for="ddlDoctor" class="form-label">Doctor <span class="text-danger mt-2"> *</span></label>
                                    <select id="ddlDoctor" name="doctorId"  class="form-select">
                                        <option value='0'>Select Doctor</option>
                                    </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-12">
                                <label for="txtReason" class="form-label">Reason For Vist <span class="text-danger mt-2"> *</span></label>
                                <textarea id="txtReason" name="reason" class="form-control" minlength="10"></textarea>
                            </div>
                    </div>                    
                </div>

                    <div class="intro-y box p-5">
                         <ul id="divPatientTab" class="nav nav-boxed-tabs" role="tablist">
                             <li id="divPatientTab1" class="nav-item flex-1" role="presentation"> 
                                <button id="btnTab1" class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-3" type="button" role="tab" aria-controls="example-tab-3" aria-selected="true" >
                                     Registered Patient
                                    </button> 
                                </li>
                                 <li id="divPatientTab2" class="nav-item flex-1" role="presentation">
                                     <button id="btnTab2" class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-4" type="button" role="tab" aria-controls="example-tab-4" aria-selected="false" > 
                                        UnRegistered Patient
                                    </button> 
                                </li> 
                            </ul>
                             <div class="tab-content mt-5"> 
                                <!-- Tab 1 Begin  !-->
                                <div id="example-tab-3" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-3-tab">
                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                        <div class="form-label xl:w-64 xl:!mr-10">
                                            <div class="text-left">
                                                <div class="flex items-center">
                                                    <div class="font-medium">Patient Registered No <span class="text-danger mt-2"> *</span></div>
                                                </div>
                                            </div>
                                        <div class="px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">After entered the Registered number. Please press the enter key to display patient information.</div>
                                       
                                        </div>
                                        <div class="w-full mt-3 xl:mt-0 flex-1">
                                            <input id="txtHcNo" name="name" type="number" class="form-control">
                                            <input id="txtPatientId" name="patientId" type="hidden" class="form-control">
                                        </div>
                                    </div> 
                                     <!-- ---------------------------------------Patient Information Begin---------------------------------------------------------- -->
                                     <div id="divPatientInfo" class="intro-y box px-5">
                    <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                <img id="imgProfileImage" alt="Profile Picture" class="rounded-full" src="{{ asset('dist/images/profile-5.jpg')}}">
                                </div>
                                <div class="ml-5">
                                <div id="lblName" class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg"><span></span></div>
                                <div id="lblHcNo" class="text-info">Code No : <span></span></div>
                                <div id="lblPhoneNo" class="truncate sm:whitespace-normal flex items-center"><i data-lucide="phone" class="w-4 h-4 mr-2"></i><span></span> </div>
                                <div id=lblEmail class="truncate sm:whitespace-normal flex items-center"><i data-lucide="mail" class="w-4 h-4 mr-2"></i><span></span></div>
                                <div id=lblAddress class="truncate sm:whitespace-normal flex items-center"><i data-lucide="home" class="w-4 h-4 mr-2"></i><span></span></div>
                                <div id=lblCity class="truncate sm:whitespace-normal flex items-center"><span></span></div>
                                <div id=lblState class="truncate sm:whitespace-normal flex items-center"></i><span></span></div>
                                <div id=lblPincode class="truncate sm:whitespace-normal flex items-center"></i><span></span></div>
                               
                            </div>
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                                <div id="lblDob" class="truncate sm:whitespace-normal flex items-center"><b>Date of Birth : </b><span></span> </div>
                                <div id="lblAge" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Age : </b><span></span></div>
                                <div id="lblGender" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Gender : </b><span></span> </div>
                                <div id="lblBloodGrp" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Blood Group : </b><span></span> </div>
                                <div id="lblMartialStatus" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Martial Status :</b><span></span> </div>
                                <div id="lblHeight" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Height :</b><span></span> </div>
                                <div id="lblWeight" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Weight : </b><span></span></div>
                            </div>
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                                <div id="lblSpouseName" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Spouse Name : </b><span></span></div>
                                <div id="lblSpousePhNo" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Spouse Phone No : </b><span></span></div>
                                <div id="lblReason" class="truncate sm:whitespace-normal flex items-center mt-3"><b>Reason : </b><span></span></div>
                        </div>
                        </div>
                    </div>
                </div>
               <!-- -------------------------------------------------------Patient Information End ---------------------------------------------------- -->
                                    <!-- Tab 1 End !-->
                                <div id="example-tab-4" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-4-tab">
                                <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtName" class="form-label">Patient Name <span class="text-danger mt-2"> *</span></label>
                                <input id="txtName" name="patientName" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtPhoneNo" class="form-label">Phone No <span class="text-danger mt-2"> *</span></label>
                                <input id="txtPhoneNo" name="phoneNo" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtEmail" class="form-label">Email Id <span class="text-danger mt-2"> *</span></label>
                                <input id="txtEmail" name="email" type="email" class="form-control" placeholder="example@gmail.com">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlGender" class="form-label">Gender</label>
                                <select id="ddlGender" name="gender" class="form-select">
                                    <option value='0'>Select Gender</option>
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtAddress" class="form-label">Address</label>
                                <textarea id="txtAddress" name="address" class="form-control" minlength="10"></textarea>
                            </div>  
                            
                    </div> 
                                </div> 
                                    </div> 
                                </div> 
                    </div>
                    
                    
                   
                </div>
</form>
                <!-- END: Content -->
                 <!-- BEGIN: Success Modal Content --> 
        <div id="divSuccessAppointment" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divMsg" class="text-3xl mt-5"><span></span></div>  </div>
                 <div id="divPatientMsg" class="text-slate-500 mt-2"><span></span></div>  </div>
                  <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 
  <!-- BEGIN: Error Modal Content --> 
  <div id="divErrorAppointment" class="modal" tabindex="-1" aria-hidden="true"> 
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i> 
                <div id="divAppErrorHead"class="text-3xl mt-5"><span></span></div> 
                <div id="divAppErrorMsg" class="text-slate-500 mt-2"><span></span></div> </div> 
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



