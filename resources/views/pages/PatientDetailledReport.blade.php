@extends('layouts.main')
@section('title','Patient Report')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" /> @endsection @section('content')
    @include('layouts.mobileSideMenu')
 <div class="flex mt-[4.7rem] md:mt-0"> @include('layouts.sideMenu')
    <!-- BEGIN: Content -->
    <div class="content"> @include('layouts.topBar')
    <form id="frmPatientDetailReport">
<div class="intro-y box p-5 mt-5">
    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
         <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
            <button id="btnReportGo" type="submit" class="btn btn-primary w-24 ml-2">Go</button>
            <button id="btnReportPatientReset" type="reset" class="btn btn-dark w-24">Reset</button> 
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
            <label for="txtRegisteredDate" class="form-label">Patient Registered Date </label>
            <input id="txtRegisteredDate" name="dateRange" type="text" data-daterange="true" class="datepicker form-control"> 
        </div>
       
    </div>
</div>

</form>
<div id="divPrintPatientButton" class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <button id="btnPrintPatientDetails" type="button" class="btn btn-danger shadow-md mr-2">
            <i data-lucide="printer" class="w-4 h-4 mr-2"></i> 
            Print
        </button>
    </div>
</div> 
<div id="divPrintPatientDetails" class="intro-y box p-5 mt-5">
    <div id="divPrintPatientContent" class="intro-y col-span-12 overflow-auto  p-5">
    <div id="divPrintHeader" class="text-medium text-center font-bold"><span></span></div> 
    <div id="divReportNoRecord" class="text-medium font-bold p-5"><span></span></div> 
        <table id="tbPatientDetails" class="table table-bordered -mt-2 text-xs ">
            <thead>
                <tr>
                    <th >S.No</th>
                    <th>PATIENT NAME</th>
                    <th>REGISTERED DATE</th>
                    <th>PHONE NO</th>
                    <th>EMAIL</th>
                    <th>AGE</th>
                    <th>GENDER</th>
                    <th>BLOOD GROUP</th>
                    <th>HEIGHT / WEIGHT</th>
                    <th>SPOUSE NAME / PHONE NO </th>
                    <th>ASSIGNED DOCTOR</th>
                </tr>           
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
    <div id="divReportPatientErrorModal" class="modal" tabindex="-1" aria-hidden="true">
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
        <script type="module" src="{{asset('dist/js/patient.js')}}"></script> @endpush