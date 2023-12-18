@extends('layouts.main')
@section('title','Consent Form')
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
                    <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}" type="hidden" class="form-control">
                    <input id="txtBranch" name="branchId" value="{{ session('branchId') }}" type="hidden" class="form-control">
                <div id="loading"></div>
                    
                    <div id="divRegPanel" class="intro-y box p-5 mt-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                            <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Patient Registered Number </label>
                                <input id="txtRegNo" type="number" value="{{$hcNo}}" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0">
                            </div>
                            <div class="mt-2 xl:mt-0">
                                <button id="btnGo" type="button" class="btn btn-primary w-full sm:w-16" >Go</button>
                                <button id="btnRegNoClear" type="button" class="btn btn-dark w-full sm:w-16" >Clear</button>
                            </div>
                    </div>                    
                </div>
                <div id="divNewPanel" class="intro-y box p-5 mt-5">
                    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                        <button id="btnNewConsent"  type="button" class="btn btn-primary shadow-md mr-2">Consent Form</button>
                    </div>
                </div>

                    <!-- BEGIN: Profile Info -->
                <div id="divProfile" class=" hidden intro-y box px-5 pt-5 mt-5">
                    <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                            <div class="ml-5">
                                <div id="divName" class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg"><span></span></div>
                                <div id="divRegNo" class="truncate sm:whitespace-normal flex items-center"><label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Registered No :</label><span></span></div>
                                <div id="divEmail" class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="mail" class="w-4 h-4 mr-2"></i><span></span>  </div>
                                <div id="divPhoneNo" class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="phone" class="w-4 h-4 mr-2"></i><span></span>  </div>
                                <div id="divAddress" class="truncate sm:whitespace-normal flex items-center mt-3"><i data-lucide="home" class="w-4 h-4 mr-2"></i><span></span>  </div>
                                <div id="divState" class="truncate sm:whitespace-normal flex items-center mt-3"><span></span>  </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                                <div id="divAadharCardNo" class="truncate sm:whitespace-normal flex items-center "><label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold"> Aadhar Card No  : </label><span></span></div>
                                <div id="divGender" class="truncate sm:whitespace-normal flex items-center mt-3"><label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Gender  :</label> <span></span>  </div>
                                <div id="divDob" class="truncate sm:whitespace-normal flex items-center mt-3"><label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold"> DOB  : </label><span></span></div>
                                <div id="divAge" class="truncate sm:whitespace-normal flex items-center mt-3"><label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Age : </label><span></span></div>
                                <div  id= "divBloodGrp" class="truncate sm:whitespace-normal flex items-center mt-3"><label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Blood Group :</label> <span></span>  </div>
                                <div  id= "divHeight" class="truncate sm:whitespace-normal flex items-center mt-3"><label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Height :</label> <span></span></div>
                                <div  id= "divWeight" class="truncate sm:whitespace-normal flex items-center mt-3"><label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Weight :</label> <span></span></div>
                                <div id="divSpouseName" class="truncate sm:whitespace-normal flex items-center  mt-3"><label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Spouse Name :</label> <span></span></div>
                                <div id="divSpousePhoneNo" class="truncate sm:whitespace-normal flex items-center mt-3"><label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Spouse PhoneNo :</label> <span></span> </div>
                              
                            </div>
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 px-5 border-t lg:border-0 border-slate-200/60 dark:border-darkmode-400 pt-5 lg:pt-0">
                            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                                <div id="divReason" class="truncate sm:whitespace-normal flex items-center "> <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Reason for vist :</label> <span></span>  </div>
                                <div id="divReferedBy" class="truncate sm:whitespace-normal flex items-center mt-3"> <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Refered By :</label> <span></span>  </div>
                                <div id="divAttendingDoctor" class="truncate sm:whitespace-normal flex items-center mt-3"> <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Attending Doctor:</label> <span></span>  </div>
                                <div id="divWitnessHospital" class="truncate sm:whitespace-normal flex items-center mt-3"> <label  class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Witness From Hospital :</label> <span></span>  </div>
                                <div id="divWitnessBank" class="truncate sm:whitespace-normal flex items-center mt-3"><label  class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Witness From Bank :</label> <span></span>  </div>
                                <div id="divDonorBankName" class="truncate sm:whitespace-normal flex items-center mt-3"><label  class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Donor Bank Name :</label> <span></span>  </div>
                                <div id="divDonorBankAddress" class="truncate sm:whitespace-normal flex items-center mt-3"><label  class="w-12 flex-none xl:w-auto xl:flex-initial mr-2 font-bold">Donor Bank Address :</label> <span></span>  </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Profile Info -->
                <form id="frmPatientConsentForm">
                <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                <input id="txtPatientId" name="patientId" type="hidden" class="form-control">
                <div id="divFormList" class="hidden intro-y chat grid grid-cols-12 gap-5 mt-5">
                    <!-- BEGIN: Side Menu -->
                    <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                    <div class="intro-x cursor-pointer box relative flex items-center p-5 ">
                                    <div class="ml-2 overflow-hidden">
                                        <button id="btnSaveConsent" type="submit" class="btn btn-primary" ><i data-lucide="save" class="w-4 h-4 mr-2"></i>Save</button>
                                            <button id="btnPrintConsent" type="button" class="btn btn-primary" ><i data-lucide="printer" class="w-4 h-4 mr-2"></i>Print</button>
                                            <!-- <button id="btnPrintAllConsent" type="button" class="btn btn-primary" ><i data-lucide="printer" class="w-4 h-4 mr-2"></i>Print All</button> -->
                                        </div>
                                    </div>
                        <div class="tab-content">
                            <div id="chats" class="tab-pane active" role="tabpanel" aria-labelledby="chats-tab">
                                <div id="divFormNameList" class="chat__chat-list overflow-y-auto scrollbar-hidden pr-1 pt-1 mt-4" style="height: auto;">
                                    <!-- Consent Form list begin -->
                                   
                                    <!-- Consent Form list End -->
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
                    <!-- END:  Side Menu -->
                    <!-- BEGIN: Chat Content -->
                    <div id="divFormContent" class="intro-y col-span-12 lg:col-span-8 2xl:col-span-9">
                        <div class="chat__box box">
                            <!-- BEGIN: Form Active -->
                            <div id="divHideForm" class="hidden h-full flex flex-col">
                                <div class="flex flex-col sm:flex-row border-b border-slate-200/60 dark:border-darkmode-400 px-5 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 sm:w-12 sm:h-12 flex-none image-fit relative">
                                            <i data-lucide="file" class="w-8 h-8 sm:w-10 sm:h-10 block bg-primary text-white rounded-full flex-none flex items-center justify-center mr-5"></i> 
                                        </div>
                                        <div class="ml-3 mr-auto">
                                            <div id="divConsentHeader" class="font-medium text-base"><span></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="divConsentContent" class="overflow-y-scroll scrollbar px-5 pt-5 flex-1">
                                   <!-- consent Form content -->
                                  
                                   <!--consent form end-->
                                </div>
                            </div>
                            <!-- END: Chat Active -->
                            <!-- BEGIN: Chat Default -->
                            <div id="divDefaultForm" class="h-full flex items-center">
                                <div class="mx-auto text-center">
                                    <div class="w-16 h-16 flex-none image-fit rounded-full overflow-hidden mx-auto">
                                    <i data-lucide="file" class="w-8 h-8 sm:w-10 sm:h-10 block bg-primary text-white rounded-full flex-none flex items-center justify-center mr-5"></i> 
                                    </div>
                                    <div class="mt-3">
                                        <div class="font-medium">Please click the form to view</div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Chat Default -->
                        </div>
                    </div>
                    <!-- END: Chat Content -->
                </div>
            </div>
            <!-- END: Content -->
                <!-- BEGIN: Success Modal Content --> 
        <div id="divSuccessModal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divMsg" class="text-3xl mt-5"><span></span></div> 
                  </div>
                  <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 

                        <!-- BEGIN: Error Modal Content --> 
 <div id="divConsentErrorModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true"> 
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

            </div>
@endsection

        @push('js')
        <script src="{{ asset('dist/js/app.js')}}"></script>
        <script  type="module" src="{{ asset('dist/js/patient.js')}}"></script>
        @endpush
