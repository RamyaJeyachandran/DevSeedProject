@extends('layouts.main')
@section('title','Dashboard')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" /> @endsection @section('content')
    @include('layouts.mobileSideMenu') 
    <div id="divPatient" class="flex mt-[4.7rem] md:mt-0">
    @include('layouts.sideMenu')
    <!-- BEGIN: Content -->
     <div class="content"> @include('layouts.topBar') 
@if(Session::has('isAdmin') && Session::get('isAdmin'))
     <div class="grid grid-cols-12 gap-6 mt-5">
                                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                        <div class="report-box zoom-in">
                                            <div class="box p-5">
                                                <div class="flex">
                                                    <i data-lucide="folder-plus" class="report-box__icon text-primary"></i> 
                                                </div>
                                                <div class="text-3xl font-medium leading-8 mt-6">{{substr($dashboardDetails['total_hospital'] ,1, Str::length($dashboardDetails['total_hospital'])-2) }}</div>
                                                <div class="text-base text-slate-500 mt-1">Total Hospitals</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                        <div class="report-box zoom-in">
                                            <div class="box p-5">
                                                <div class="flex">
                                                    <i data-lucide="layers" class="report-box__icon text-pending"></i> 
                                                </div>
                                                <div class="text-3xl font-medium leading-8 mt-6">{{substr($dashboardDetails['total_branch'] ,1, Str::length($dashboardDetails['total_branch'])-2) }}</div>
                                                <div class="text-base text-slate-500 mt-1">Total Branches</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                        <div class="report-box zoom-in">
                                            <div class="box p-5">
                                                <div class="flex">
                                                    <i data-lucide="activity" class="report-box__icon text-warning"></i> 
                                                </div>
                                                <div class="text-3xl font-medium leading-8 mt-6">{{substr($dashboardDetails['total_doctor'] ,1, Str::length($dashboardDetails['total_doctor'])-2) }}</div>
                                                <div class="text-base text-slate-500 mt-1">Total Doctors</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                        <div class="report-box zoom-in">
                                            <div class="box p-5">
                                                <div class="flex">
                                                    <i data-lucide="user" class="report-box__icon text-success"></i> 
                                                </div>
                                                <div class="text-3xl font-medium leading-8 mt-6">{{substr($dashboardDetails['total_patient'] ,1, Str::length($dashboardDetails['total_patient'])-2) }}</div>
                                                <div class="text-base text-slate-500 mt-1">Total Patients</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-6 mt-8">
                                <div class="intro-y block sm:flex items-center h-10">
                                    <h2 class="text-lg font-medium truncate mr-5">
                                        @if(count($dashboardDetails['hospitalWise'])>0)
                                            Hospital Information 
                                        @endif
                                    </h2>
                                </div>
                                </div>
                                <div class="grid grid-cols-12 gap-6 mt-5">
                                    <!-- Loop begin -->
                                    @foreach ($dashboardDetails['hospitalWise'] as $hospitalWise)
                                    <div class="intro-y col-span-12 md:col-span-6">
                                        <div class="box zoom-in">
                                            <div class="flex flex-col lg:flex-row items-center p-5">
                                                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                                    <img class="rounded-full" src="{{$hospitalWise->logo}}">
                                                </div>
                                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                    <a href="" class="font-medium">{{$hospitalWise->hospitalName}}</a> 
                                                    <div  class="text-primary block font-medium mt-0.5">Total Branches : {{$hospitalWise->total_branches}}</div>
                                                </div>
                                                <div class="flex mt-4 lg:mt-0">
                                                    <button class="btn btn-rounded-primary py-1 px-2 mr-2"><i data-lucide="activity" class="w-4 h-4 mr-2"></i>Total Doctors : {{$hospitalWise->total_doctors}}</button>
                                                    <button class="btn btn-rounded-pending py-1 px-2"><i data-lucide="users" class="w-4 h-4 mr-2"></i>Total Patients : {{$hospitalWise->total_patients}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <!-- Loop END -->
                            </div>
                    @endif
                    @if(Session::has('isHospital') && Session::get('isHospital'))
                    <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                        <div class="report-box zoom-in">
                                            <div class="box p-5">
                                                <div class="flex">
                                                    <i data-lucide="layers" class="report-box__icon text-primary"></i> 
                                                </div>
                                                <div class="text-3xl font-medium leading-8 mt-6">{{$dashboardDetails['hospitalWiseTotal']==null?0:$dashboardDetails['hospitalWiseTotal']->total_branches}}</div>
                                                <div class="text-base text-slate-500 mt-1">Total Branches</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                        <div class="report-box zoom-in">
                                            <div class="box p-5">
                                                <div class="flex">
                                                    <i data-lucide="activity" class="report-box__icon text-pending"></i> 
                                                </div>
                                                <div class="text-3xl font-medium leading-8 mt-6">{{$dashboardDetails['hospitalWiseTotal']==null?0:$dashboardDetails['hospitalWiseTotal']->total_doctors}}</div>
                                                <div class="text-base text-slate-500 mt-1">Total Doctors</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                        <div class="report-box zoom-in">
                                            <div class="box p-5">
                                                <div class="flex">
                                                    <i data-lucide="user" class="report-box__icon text-warning"></i> 
                                                </div>
                                                <div class="text-3xl font-medium leading-8 mt-6">{{$dashboardDetails['hospitalWiseTotal']==null?0:$dashboardDetails['hospitalWiseTotal']->total_patients}}</div>
                                                <div class="text-base text-slate-500 mt-1">Total Patients</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-6 mt-8">
                                <div class="intro-y block sm:flex items-center h-10">
                                    <h2 class="text-lg font-medium truncate mr-5">
                                        @if(count($dashboardDetails['branchWise'])>0)
                                        Branch Information
                                        @endif
                                    </h2>
                                </div>
                                </div>
                                <div class="grid grid-cols-12 gap-6 mt-5">
                                    <!-- Loop begin -->
                                    @foreach ($dashboardDetails['branchWise'] as $branchWise)
                                    <div class="intro-y col-span-12 md:col-span-6">
                                        <div class="box zoom-in">
                                            <div class="flex flex-col lg:flex-row items-center p-5">
                                                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                                    <img class="rounded-full" src="{{$branchWise->logo}}">
                                                </div>
                                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                    <a href="" class="font-medium">{{$branchWise->branchName}}</a> 
                                                </div>
                                                <div class="flex mt-4 lg:mt-0">
                                                    <button class="btn btn-rounded-primary py-1 px-2 mr-2"><i data-lucide="activity" class="w-4 h-4 mr-2"></i>Total Doctors : {{$branchWise->total_doctors}}</button>
                                                    <button class="btn btn-rounded-pending py-1 px-2"><i data-lucide="users" class="w-4 h-4 mr-2"></i>Total Patients : {{$branchWise->total_patients}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <!-- Loop END -->
                            </div>
                                </div>
                    @endif
                    @if(Session::has('isBranch') && Session::get('isBranch'))
                    <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                        <div class="report-box zoom-in">
                                            <div class="box p-5">
                                                <div class="flex">
                                                    <i data-lucide="activity" class="report-box__icon text-primary"></i> 
                                                </div>
                                                <div class="text-3xl font-medium leading-8 mt-6">{{$dashboardDetails['branchWiseTotal']==null ? 0: $dashboardDetails['branchWiseTotal']->total_doctors}}</div>
                                                <div class="text-base text-slate-500 mt-1">Total Doctors</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                        <div class="report-box zoom-in">
                                            <div class="box p-5">
                                                <div class="flex">
                                                    <i data-lucide="user" class="report-box__icon text-pending"></i> 
                                                </div>
                                                <div class="text-3xl font-medium leading-8 mt-6">{{$dashboardDetails['branchWiseTotal']==null?0:$dashboardDetails['branchWiseTotal']->total_patients}}</div>
                                                <div class="text-base text-slate-500 mt-1">Total Patients</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                        <div class="report-box zoom-in">
                                            <div class="box p-5">
                                                <div class="flex">
                                                    <i data-lucide="calendar" class="report-box__icon text-warning"></i> 
                                                </div>
                                                <div class="text-3xl font-medium leading-8 mt-6">{{$dashboardDetails['branchWiseTotal']==null?0:$dashboardDetails['branchWiseTotal']->total_appointments}}</div>
                                                <div class="text-base text-slate-500 mt-1">Total Appointments</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-6 mt-8">
                                <div class="intro-y block sm:flex items-center h-10">
                                    <h2 class="text-lg font-medium truncate mr-5">
                                        @if(count($dashboardDetails['doctorWiseTotal'])>0)
                                            Doctor Information
                                        @endif
                                    </h2>
                                </div>
                                </div>
                                <div class="grid grid-cols-12 gap-6 mt-5">
                                    <!-- Loop begin -->
                                    @foreach ($dashboardDetails['doctorWiseTotal'] as $doctorWise)
                                    <div class="intro-y col-span-12 md:col-span-6">
                                        <div class="box zoom-in">
                                            <div class="flex flex-col lg:flex-row items-center p-5">
                                                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                                    <img class="rounded-full" src="{{$doctorWise->profileImage}}">
                                                </div>
                                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                    <a href="" class="font-medium">{{$doctorWise->name}}</a> 
                                                    <div  class="text-primary block font-medium mt-0.5">Code: {{$doctorWise->doctorCodeNo}}</div>
                                                </div>
                                                <div class="flex mt-4 lg:mt-0">
                                                    <button class="btn btn-rounded-primary py-1 px-2 mr-2"><i data-lucide="activity" class="w-4 h-4 mr-2"></i>Total Patients : {{$doctorWise->total_patient}}</button>
                                                    <button class="btn btn-rounded-pending py-1 px-2"><i data-lucide="users" class="w-4 h-4 mr-2"></i>Total Appointments : {{$doctorWise->total_appointment}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <!-- Loop END -->
                            </div>
                                </div>
                    @endif
                    @if(Session::has('isDoctor') && Session::get('isDoctor'))
                    <input id="txtType" value="{{ $dashboardDetails['appointmentTotal']->type }}" type="hidden" class="form-control">
                    <input id="txtDoctorId" value="{{ $dashboardDetails['appointmentTotal']->doctorId }}" type="hidden" class="form-control">
                    <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                        <div class="report-box zoom-in">
                                            <div class="box p-5">
                                                <div class="flex">
                                                    <i data-lucide="user" class="report-box__icon text-primary"></i> 
                                                </div>
                                                <div class="text-3xl font-medium leading-8 mt-6">{{$dashboardDetails['appointmentTotal']==null?0:$dashboardDetails['appointmentTotal']->total_patient}}</div>
                                                <div class="text-base text-slate-500 mt-1">Total Patients</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                        <div class="report-box zoom-in">
                                            <div class="box p-5">
                                                <div class="flex">
                                                    <i data-lucide="calendar" class="report-box__icon text-pending"></i> 
                                                </div>
                                                <div class="text-3xl font-medium leading-8 mt-6">{{$dashboardDetails['appointmentTotal']==null?0:$dashboardDetails['appointmentTotal']->total_patient}}</div>
                                                <div class="text-base text-slate-500 mt-1">Total Appointments</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                        <div class="report-box zoom-in">
                                            <div class="box p-5">
                                                <div class="flex">
                                                    <i data-lucide="layout" class="report-box__icon text-warning"></i> 
                                                </div>
                                                <div class="text-3xl font-medium leading-8 mt-6">{{$dashboardDetails['appointmentTotal']==null?0:$dashboardDetails['appointmentTotal']->today_appointment}}</div>
                                                <div class="text-base text-slate-500 mt-1">Today Total Appointments</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-6 mt-8">
                                <div class="intro-y block sm:flex items-center h-10">
                                    <h2 class="text-lg font-medium truncate mr-5">
                                        Today Appointment
                                    </h2>
                                </div>
                                </div>
                                <div class="grid grid-cols-12 gap-6 mt-5">
                                    <div class="intro-y col-span-12 md:col-span-12">
                                        <div class="box">
                                            <div class="flex flex-col lg:flex-row items-center p-5">
                                                
                                            <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th class="whitespace-nowrap">#</th>
                                                <th class="whitespace-nowrap">Appointment Time</th>
                                                <th class="whitespace-nowrap">Patient Name</th>
                                                <th class="whitespace-nowrap">Phone No</th>
                                                <th class="whitespace-nowrap">Email Id</th>
                                                <th class="whitespace-nowrap">Reason for vist</th>
                                                <th class="whitespace-nowrap">Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <!-- Loop begin -->
                                            @if(count($dashboardDetails['appointmentDetails'])>0)
                                                @foreach ($dashboardDetails['appointmentDetails'] as $appointment)
                                                <tr>
                                                    <td>{{$appointment->sNo}}</td>
                                                    <td>{{$appointment->appointmentTime}}</td>
                                                    <td>{{$appointment->name}}</td>
                                                    <td>{{$appointment->phoneNo}}</td>
                                                    <td>{{$appointment->email}}</td>
                                                    <td>{{$appointment->reason}}</td>
                                                    <td>{{$appointment->status}}</td>
                                                </tr>
                                            @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7"><div> No Record Found </div></td>
                                                </tr>
                                            @endif
                                                <!-- Loop END -->
                                            </tbody>
                                        </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                            </div>
                                <div class=" box flex h-[400px]"> <canvas id="pie-chart-appointmentStatus"></canvas> </div>
                                </div>
                    @endif
     
                </div>
     <!-- END: Content --> 
       <!-- BEGIN: Error Modal Content --> 
 <div id="divDashboardErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i> 
                <div id="divBrErrorHead"class="text-3xl mt-5"><span></span></div> 
                <div id="divBrErrorMsg" class="text-slate-500 mt-2"><span></span></div> </div> 
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
<script src="{{ asset('dist/js/patient.js')}}"></script>
@endpush