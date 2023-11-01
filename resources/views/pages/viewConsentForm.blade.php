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
                    <div id="divFormList" class="intro-y chat grid grid-cols-12 gap-5 mt-5">
                    <!-- BEGIN: Side Menu -->
                    <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                        <div class="tab-content">
                            <div id="chats" class="tab-pane active" role="tabpanel" aria-labelledby="chats-tab">
                                <div id="divFormNameList" class="chat__chat-list overflow-y-auto scrollbar-hidden pr-1 pt-1 mt-4">
                                    <!-- Consent Form list begin -->
                                   
                                    <!-- Consent Form list End -->
                            </div>
                        </div>
                    </div>
                    </div>
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
                    </div></div>
                 <!-- END: Content -->
@endsection
</div>
        @push('js')
        <script src="{{ asset('dist/js/app.js')}}"></script>
        <script  type="module" src="{{ asset('dist/js/patient.js')}}"></script>
        @endpush
