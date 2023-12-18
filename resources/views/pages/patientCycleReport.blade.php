@extends('layouts.main')
@section('title','Patient Report')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" /> @endsection @section('content')
    @include('layouts.mobileSideMenu') <div class="flex mt-[4.7rem] md:mt-0"> @include('layouts.sideMenu')
<!-- BEGIN: Content -->
<div class="content"> @include('layouts.topBar')
    <form id="frmPatientReport">
<div class="intro-y box p-5 mt-5">
    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Report <span class="text-danger mt-2"> *</span></label>
                                <select id="ddlReport" name="reportId"  class="form-select" required>
                                        <option value='0'>Select Report</option>
                                        <option value='1'>Date Range Report</option>
                                        <option value='2'>Monthly Report</option>
                                        <option value='3'>Yearly Report</option>
                                    </select>
        </div>
        
                    <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}" type="hidden" class="form-control">
                    <input id="txtBranch" name="branchId" value="{{ session('branchId') }}" type="hidden" class="form-control">
                    @can('isAdmin')
                    <div class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="ddlHospital" class="form-label">Hospital </label>
                                <select id="ddlHospital" name="hospitalId" class="form-select">
                                    <option value='0'>Select Hospital</option>
                                </select>
                            </div>
                    @endcan
                    @can('isAdminHospital')
                            <div id="divBranchddl" class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="ddlBranch" class="form-label">Branch </label>
                                <select id="ddlBranch" name="branchId" class="form-select">
                                    <option value='0'>Select Branch</option>
                                </select>
                            </div>
                        @endcan
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Patient</label>
                                <select id="ddlPatient" name="patientId"  class="form-select">
                                        <option value='0'>ALL</option>
                                    </select>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Doctor</label>
                                <select id="ddlDoctor" name="doctorId"  class="form-select">
                                        <option value='0'>ALL</option>
                                    </select>
        </div>
        <div id="divDateRange" class="intro-y col-span-12 sm:col-span-6 form-control">
            <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Date Range  <span class="text-danger mt-2"> *</span></label>
            <input id="txtDateRange" name="dateRange" type="text" data-daterange="true" class="datepicker form-control"> 
        </div>
        <div id="divMonth" class="intro-y col-span-12 sm:col-span-6 form-control">
        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Month  <span class="text-danger mt-2"> *</span></label>
            <input type="month" id="txtMonthYear" name="monthYear"  min="2000-01" class="form-control tooltip" title="Click the Icon to view month">
        </div>
        <div id="divYear" class="intro-y col-span-12 sm:col-span-6 form-control">
        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Year  <span class="text-danger mt-2"> *</span></label>
             <select id="ddlYear" name="yearId"  class="form-select">
            </select>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
        </div>
        <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
            <button id="btnReportGo" type="submit" class="btn btn-primary w-24 ml-2">Go</button>
            <button id="btnReportReset" type="reset" class="btn btn-dark w-24">Reset</button> 
        </div>
    </div>
</div>

</form>
<!-- <div id="divPrintReport"> -->
<div id="divPrintButton" class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <button id="btnPrintReport" type="button" class="btn btn-danger shadow-md mr-2">
            <i data-lucide="printer" class="w-4 h-4 mr-2"></i> 
            Print
        </button>
    </div>
</div> 

<!-- BEGIN: Data List -->
<div id="divPrintReport" class="intro-y box p-5 mt-5">
<div id="divPrintContent" class="intro-y col-span-12 overflow-auto  p-5">
<div id="divPrintHeader" class="text-medium text-center font-bold"><span></span></div> 
<div id="divPrintSubHeader" class="text-medium text-center font-bold p-5"><span></span></div> 
<div id="divReportNoRecord" class="text-medium font-bold p-5"><span></span></div> 
<div id="divReportPatient" class="overflow-x-auto">
            <table id="tbReportHeader" class="table table-bordered">
                <tbody> <tr> <td valign="top" width="60">
                    <p class="font-bold">Patient Name </p>
                            <div id="divPatientName"><span></span></div>
                                </td>
                        <td valign="top" width="61">
                            <p class="font-bold">Patient#  </p>
                           <div id="divPatientHcNo"><span></span></div>
                                </td>
                        <td valign="top" width="10">
                            <p class="font-bold">Phone No </p>
                            <div id="divPatientPhoneNo"><span></span></div>
                        </td>
                        <td valign="top" width="10">
                            <p class="font-bold">Email </p>
                            <div id="divPatientEmail"><span></span></div>
                        </td>
                        <td valign="top" width="61">
                            <p class="font-bold">Gender </p>
                          <div id="divPatientGender"><span></span></div>
                        </td>
                        <td valign="top" width="61">
                            <p class="font-bold">Spouse Name</p>
                            <div id="divPatientSpouse"><span></span></div>
                        </td>
                        </tr>
                        </tbody>
            </table>
</div>
            <p>&nbsp;</p>
            <table id="tbDoctorHeader" class="table table-bordered">
                <tbody> <tr> <td valign="top" width="60">
                    <p class="font-bold">Doctor Name </p>
                            <div id="divDoctorName"><span></span></div>
                                </td>
                        <td valign="top" width="61">
                            <p class="font-bold">Doctor#  </p>
                           <div id="divDoctorCode"><span></span></div>
                                </td>
                        <td valign="top" width="10">
                            <p class="font-bold">Phone No </p>
                            <div id="divDoctorPhoneNo"><span></span></div>
                        </td>
                        <td valign="top" width="10">
                            <p class="font-bold">Email </p>
                            <div id="divDoctorEmail"><span></span></div>
                        </td>
                        <td valign="top" width="61">
                            <p class="font-bold">Department </p>
                          <div id="divDepartment"><span></span></div>
                        </td>
                        <td valign="top" width="61">
                            <p class="font-bold">Designation</p>
                            <div id="divDesignation"><span></span></div>
                        </td>
                        </tr>
                        </tbody>
            </table>
            <p>&nbsp;</p>
                        <!-- All Patient -->
                        <table id="tbReport" class="table table-bordered -mt-2 text-xs ">
                            <thead>
                               
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
</div>
</div>

        <!-- END: Content -->
        </div>
        <!-- BEGIN: Error Modal Content -->
    <div id="divReportErrorModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i>
                        <div id="divErrorHead" class="text-3xl mt-5"><span></span></div>
                        <div id="divErrorMsg" class="text-slate-500 mt-2"><span></span></div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal" class="btn w-24 btn-primary">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- END: Error Modal Content -->
        @endsection

        @push('js')
        <script src="{{ asset('dist/js/app.js')}}"></script>
        <script type="module" src="{{
    asset('dist/js/patient.js')}}"></script> @endpush