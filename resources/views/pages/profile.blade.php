@extends('layouts.main')
@section('title','Profile')
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
                    <input id="txtId" name="id" value="{{$profileDetails->id}}" type="hidden" class="form-control">
                    <input id="txtUserType" name="userTypeId" value="{{$profileDetails->id}}" type="hidden" class="form-control">
                    <!-- BEGIN: Profile Info -->
                <div class="intro-y box px-5 pt-5 mt-5">
                <div class="flex flex-col sm:flex-row items-center border-t border-slate-200/60 dark:border-darkmode-400 pt-5" >
                <h2 class="text-3xl text-slate-600 dark:text-slate-500 font-medium leading-none mt-3">
                 @if(Session::has('isBranch') && Session::get('isBranch')) {{ $profileDetails->hospitalName }} - @endif {{ $profileDetails->Name }}
                                    </h2>
                             
                                            <div class="flex sm:ml-auto mt-5 sm:mt-0">
                                            @if(Session::has('isHospital') && Session::get('isHospital'))
                                            <button onclick="window.location='{{ url("showHospital/$profileDetails->id ")}}'" href="javascript:;" class="btn btn-primary w-24"><i data-lucide="edit" class="w-4 h-4 mr-2"></i>Edit</button>
                                            @endif
                                           @if(Session::has('isBranch') && Session::get('isBranch'))
                                            <button onclick="window.location='{{ url("showBranch/$profileDetails->id ")}}'" href="javascript:;" class="btn btn-primary w-24"><i data-lucide="edit" class="w-4 h-4 mr-2"></i>Edit</button>
                                            @endif
                                            @if(Session::has('isDoctor') && Session::get('isDoctor'))
                                            <button onclick="window.location='{{ url("showDoctor/$profileDetails->id ")}}'" href="javascript:;" class="btn btn-primary w-24"><i data-lucide="edit" class="w-4 h-4 mr-2"></i>Edit</button>
                                            @endif
                                            </div>
                                        </div>
                    <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                        <div class="flex flex-1 px-10 items-center justify-center">
                            <div class="ml-5 w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                <img class="rounded full" src="{{ $profileDetails->Image }}">
                            </div>
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                            <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div>
                            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                                <div class="truncate sm:whitespace-normal flex items-center tooltip" title="Phone No"> <i data-lucide="phone" class="w-4 h-4 mr-2"></i> {{ $profileDetails->phoneNo }}</div>
                                <div class="truncate sm:whitespace-normal flex items-center mt-3 tooltip" title="Email Id"> <i data-lucide="mail" class="w-4 h-4 mr-2"></i> {{ $profileDetails->email }} </div>
                                <div class="truncate sm:whitespace-normal flex items-center mt-3 tooltip" title="Address"> <i data-lucide="home" class="w-4 h-4 mr-2"></i> {{ $profileDetails->address }}</div>
                                @if(Session::has('isHospitalBranch') && Session::get('isHospitalBranch'))
                                <div class="truncate sm:whitespace-normal flex items-center mt-3 tooltip" title="Contact Person Name"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> {{ $profileDetails->inChargePerson }}</div>
                                <div class="truncate sm:whitespace-normal flex items-center mt-3 tooltip" title="Contact person phone number"> <i data-lucide="book-open" class=" w-4 h-4 mr-2"></i> {{ $profileDetails->inChargePhoneNo }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                   
                </div>
                <!-- END: Profile Info -->
                @if(Session::has('isDoctor') && Session::get('isDoctor'))
                <div class="tab-content mt-5">
                    <div id="profile" class="tab-pane active" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="grid grid-cols-12 gap-6">
                 <!-- BEGIN: Latest Tasks -->
                 <div class="intro-y box col-span-12 lg:col-span-6">
                                <div class="flex items-center px-5 py-5 sm:py-0 border-b border-slate-200/60 dark:border-darkmode-400">
                                    <h2 class="font-medium text-base mr-auto">
                                        Personal Information
                                    </h2>
                                    <ul class="nav nav-link-tabs w-auto ml-auto hidden sm:flex" role="tablist" >
                                        <li id="latest-tasks-new-tab" class="nav-item" role="presentation"> <a href="javascript:;" class="nav-link py-5 active" data-tw-target="#latest-tasks-new" aria-controls="latest-tasks-new" aria-selected="true" role="tab" >  </a> </li>
                                    </ul>
                                </div>
                                <div class="p-5">
                                    <div class="tab-content">
                                        <div id="latest-tasks-new" class="tab-pane active" role="tabpanel" aria-labelledby="latest-tasks-new-tab">
                                        <div class="flex items-center">
                                                <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">Doctor Code</a> 
                                                </div>
                                                <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"></div> 
                                                <div class="border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">{{ $profileDetails->doctorCodeNo }}</a> 
                                                </div>
                                            </div>
                                            <div class="flex items-center mt-5">
                                                <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">Gender</a> 
                                                </div>
                                                <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"></div> 
                                                <div class="border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">{{ $profileDetails->gender }}</a> 
                                                </div>
                                            </div>
                                            <div class="flex items-center mt-5">
                                                <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">Date Of Birth</a> 
                                                </div>
                                                <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"></div> 
                                                <div class="border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">{{ $profileDetails->dob }}</a> 
                                                </div>
                                            </div>
                                            <div class="flex items-center mt-5">
                                                <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">Blood Group</a> 
                                                </div>
                                                <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"></div> 
                                                <div class="border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">{{ $profileDetails->bloodGroup }}</a> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Latest Tasks -->
                            <!-- BEGIN: Latest Tasks -->
                            <div class="intro-y box col-span-12 lg:col-span-6">
                                <div class="flex items-center px-5 py-5 sm:py-0 border-b border-slate-200/60 dark:border-darkmode-400">
                                    <h2 class="font-medium text-base mr-auto">
                                        Work Information
                                    </h2>
                                    <ul class="nav nav-link-tabs w-auto ml-auto hidden sm:flex" role="tablist" >
                                        <li id="latest-tasks-new-tab" class="nav-item" role="presentation"> <a href="javascript:;" class="nav-link py-5 active" data-tw-target="#latest-tasks-new" aria-controls="latest-tasks-new" aria-selected="true" role="tab" >  </a> </li>
                                    </ul>
                                </div>
                                <div class="p-5">
                                    <div class="tab-content">
                                        <div id="latest-tasks-new" class="tab-pane active" role="tabpanel" aria-labelledby="latest-tasks-new-tab">
                                            <div class="flex items-center">
                                                <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">Eductation</a> 
                                                </div>
                                                <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"></div> 
                                                <div class="border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">{{ $profileDetails->education }}</a> 
                                                </div>
                                            </div>
                                            <div class="flex items-center mt-5">
                                                <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">Designation</a> 
                                                </div>
                                                <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"></div> 
                                                <div class="border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">{{ $profileDetails->designation }}</a> 
                                                </div>
                                            </div>
                                            <div class="flex items-center mt-5">
                                                <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">Department</a> 
                                                </div>
                                                <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"></div> 
                                                <div class="border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">{{ $profileDetails->department }}</a> 
                                                </div>
                                            </div>
                                            <div class="flex items-center mt-5">
                                                <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">Experience</a> 
                                                </div>
                                                <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"></div> 
                                                <div class="border-primary dark:border-primary pl-4">
                                                    <a href="" class="font-medium">{{ $profileDetails->experience }}</a> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Latest Tasks -->
                            @endif
                        </div>  
                    </div>
                </div>    
                </div>
                <!-- END: Content -->
                
                
    </div>
    @endsection

@push('js')
<script src="{{ asset('dist/js/app.js')}}"></script>
<script  type="module" src="{{ asset('dist/js/patient.js')}}"></script>
@endpush
