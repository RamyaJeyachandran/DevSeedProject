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
<div class="content"> @include('layouts.topBar')
    <form id="frmEditAppointment" method="POST">
        <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}" type="hidden"
            class="form-control">
        <input id="txtBranch" name="branchId" value="{{ session('branchId') }}" type="hidden" class="form-control">
        <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
        <input id="txtAppointmentId" name="appointmentId" value="{{$appointmentDetails->id}}" type="hidden"
            class="form-control">
        <input id="txtPatient" name="patientId" value="{{$appointmentDetails->patientId}}" type="hidden"
            class="form-control">
        <input id="txtType" name="type" value="{{$appointmentDetails->type}}" type="hidden" class="form-control">
        <div class="intro-y box p-5 mt-5">
            <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="txtAppointmentDate" class="form-label">Appointment Date <span class="text-danger mt-2">
                            *</span></label>
                    <input id="txtAppointmentDate" name="appointmentDate"
                        value="{{$appointmentDetails->appointmentDate}}" type="text" class="datepicker form-control "
                        data-single-mode="true" required>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="txtAppointmentTime" class="form-label">Appointment Time <span class="text-danger mt-2">
                            *</span></label>
                    <input id="txtAppointmentTime" name="appointmentTime"
                        value="{{$appointmentDetails->appointmentTime}}" type="time" class="form-control" required>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="ddlDepartment" class="form-label">Department</label>
                    <select id="ddlDepartment" value="{{$appointmentDetails->departmentId}}" name="departmentId"
                        class="form-select">
                        <option value='0'>Select Department</option>
                        @foreach ($appointmentDetails->departmentList as $department)
                        <option value="{{ $department->id }}" {{ ( $department->id == $appointmentDetails->departmentId)
                            ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="ddlDoctor" class="form-label">Doctor <span class="text-danger mt-2"> *</span></label>
                    <select id="ddlDoctor" value="{{$appointmentDetails->doctorId}}" name="doctorId" class="form-select"
                        required>
                        <option value='0'>Select Doctor</option>
                        @foreach ($appointmentDetails->doctorList as $doctor)
                        <option value="{{ $doctor->id }}" {{ ( $doctor->id == $appointmentDetails->doctorId) ?
                            'selected' : '' }}>
                            {{ $doctor->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="txtReason" class="form-label">Reason For Vist <span class="text-danger mt-2">
                            *</span></label>
                    <textarea id="txtReason" name="reason" value="{{$appointmentDetails->reason}}" class="form-control"
                        minlength="10">{{$appointmentDetails->reason}}</textarea>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="ddlStatus" class="form-label">Status</label>
                    <select id="ddlStatus" value="{{$appointmentDetails->status}}" name="status" class="form-select"
                        required>
                        <option value='0'>Select Status</option>
                        @foreach ($appointmentDetails->statusList as $StatusDetails)
                        <option value="{{ $StatusDetails->name }}" {{ ( $StatusDetails->name ==
                            $appointmentDetails->status) ? 'selected' : '' }}>
                            {{ $StatusDetails->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <button id="btnUpdateAppointment" type=submit class="btn btn-danger shadow-md mr-2"><i
                            data-lucide="save" class="w-4 h-4 mr-2"></i>Update</button>
                </div>
            </div>
        </div>

        <div class="intro-y box p-5">
            <!-- ---------------------------------------Patient Information Begin---------------------------------------------------------- -->
            <div id="divPatientInfo" class="intro-y box px-5">
                <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                    <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                            <img id="imgProfileImage" alt="Profile Picture" class="rounded-full"
                                src="{{ $appointmentDetails->profileImage}}">
                        </div>
                        <div class="ml-5">
                            <div id="lblName" class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">
                                <span>{{ $appointmentDetails->patientName}}</span>
                            </div>
                            <div id="lblHcNo" class="text-info">Code No : <span>{{ $appointmentDetails->hcNo}}</span>
                            </div>
                            <div id="lblPhoneNo" class="truncate sm:whitespace-normal flex items-center"><i
                                    data-lucide="phone" class="w-4 h-4 mr-2"></i><span>{{
                                    $appointmentDetails->phoneNo}}</span> </div>
                            <div id=lblEmail class="truncate sm:whitespace-normal flex items-center"><i
                                    data-lucide="mail" class="w-4 h-4 mr-2"></i><span>{{
                                    $appointmentDetails->email}}</span></div>
                            <div id=lblAddress class="truncate sm:whitespace-normal flex items-center"><i
                                    data-lucide="home" class="w-4 h-4 mr-2"></i><span>{{
                                    $appointmentDetails->address}}</span></div>
                        </div>
                    </div>
                    <div
                        class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                        <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                            <div id="lblGender" class="truncate sm:whitespace-normal flex items-center mt-3">
                                <b>Gender : </b><span>{{ $appointmentDetails->gender}}</span>
                            </div>
                            <div id="lblBloodGrp" class="truncate sm:whitespace-normal flex items-center mt-3">
                                <b>Blood Group : </b><span>{{ $appointmentDetails->bloodGroup}}</span>
                            </div>
                            <div id="lblMartialStatus" class="truncate sm:whitespace-normal flex items-center mt-3">
                                <b>Martial
                                    Status
                                    :</b><span>{{ $appointmentDetails->martialStatus}}</span> </div>
                            <div id="lblSpouseName" class="truncate sm:whitespace-normal flex items-center mt-3">
                                <b>Spouse Name : </b><span>{{ $appointmentDetails->spouseName}}</span>
                            </div>
                            <div id="lblSpousePhNo" class="truncate sm:whitespace-normal flex items-center mt-3">
                                <b>Spouse Phone No : </b><span>{{ $appointmentDetails->spousePhnNo}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- -------------------------------------------------------Patient Information End ---------------------------------------------------- -->

</div>

</div>
</form>
<!-- END: Content -->
<!-- BEGIN: Success Modal Content -->
<div id="divSuccessEditAppointment" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="check-circle"
                        class="w-16 h-16 text-success mx-auto mt-3"></i>
                    <div id="divMsg" class="text-3xl mt-5"><span></span></div>
                </div>
            </div>
            <div class="px-5 pb-8 text-center"> <button id="btnAppointmentRedirect" type="button"
                    data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- END: Success Modal Content -->
<!-- BEGIN: Error Modal Content -->
<div id="divErrorEditAppointment" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i>
                    <div id="divAppErrorHead" class="text-3xl mt-5"><span></span></div>
                    <div id="divAppErrorMsg" class="text-slate-500 mt-2"><span></span></div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn w-24 btn-primary">Ok</button>
                </div>
            </div>
        </div>
    </div>
</div> <!-- END: Error Modal Content -->

</div>
</div>
@endsection

@push('js')
<script src="{{ asset('dist/js/app.js')}}"></script>
<script type="module" src="{{ asset('dist/js/patient.js')}}"></script>
@endpush