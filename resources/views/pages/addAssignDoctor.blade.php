@extends('layouts.main')
@section('title','Assign Doctor')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" /> @endsection @section('content')
    @include('layouts.mobileSideMenu') 
    <div class="flex mt-[4.7rem] md:mt-0">
         @include('layouts.sideMenu') 
        <!-- BEGIN:
    Content --> 
    <div class="content"> 
        @include('layouts.topBar') 
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                        <button onclick="window.location='{{ url("ListAssignedDoctor") }}'" class="btn btn-primary shadow-md mr-2">Show Assigned Patients</button>
                    </div>
                </div>
        <form id="frmAssignDoctor">
        <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
<input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}" type="hidden" class="form-control"> <input
    id="txtBranch" name="branchId" value="{{ session('branchId') }}" type="hidden" class="form-control"> <input
    id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
    
<div id="divPatientddl" class="intro-y col-span-12 sm:col-span-4 form-control"> 
    <label for="ddlAssignPatient" class="form-label">Patient <span class="text-danger mt-2"> *</span></label> 
    <select id="ddlAssignPatient" name="patientId" class="form-select" required>
    <option value='0'>Select Patient</option> 
    </select> 
</div>
                <div id="divDoctorddl" class="intro-y col-span-12 sm:col-span-4 form-control"> 
                    <label for="ddlAssignDoctor" class="form-label">Attending Doctor <span class="text-danger mt-2"> *</span></label> 
                    <select id="ddlAssignDoctor" name="doctorId" class="form-select" required>
                        <option value='0'>Select Doctor</option>
                    </select>
                </div>
                <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
            <button id="btnAssignSave" type="submit" class="btn btn-primary w-24 ml-2">Save</button>
            <button id="btnAssignCancel" type="reset" class="btn btn-dark w-24">Cancel</button> 
        </div>
        </div> 
</div> 
</div> 
</div> 
 <!-- BEGIN: Error Modal Content -->
 <div id="divAssignErrorModal" class="modal" tabindex="-1" aria-hidden="true">
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
     <!-- BEGIN: Success Modal Content --> 
     <div id="divAssignSuccessModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true" data-tw-backdrop="static"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divMsg" class="text-3xl mt-5"><span></span></div></div>
                  <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 

@endsection 
@push('js') 
<script src="{{ asset('dist/js/app.js')}}"></script>
<script type="module" src="{{ asset('dist/js/patient.js')}}"></script>
@endpush