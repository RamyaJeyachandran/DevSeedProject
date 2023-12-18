@extends('layouts.main')
@section('title','Subscription')
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
                    <div class="intro-y box p-5 mt-5">
    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}" type="hidden" class="form-control">
                    <input id="txtBranch" name="branchId" value="{{ session('branchId') }}" type="hidden" class="form-control">
                    @can('isAdmin')
                    <div class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="ddlSubHospital" class="form-label">Hospital </label>
                                <select id="ddlSubHospital" name="hospitalId" class="form-select">
                                    <option value='0'>Select Hospital</option>
                                </select>
                            </div>
                    @endcan
                    @can('isAdminHospital')
                            <div id="divSubBranchddl" class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="ddlSubBranch" class="form-label">Branch </label>
                                <select id="ddlSubBranch" name="branchId" class="form-select">
                                    <option value='0'>Select Branch</option>
                                </select>
                            </div>
                        @endcan
    </div>
</div>

                    <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control" disabled>
                        <!-- BEGIN: Pricing Layout -->
                <div class="intro-y box flex flex-col lg:flex-row mt-5">
                    <div class="intro-y flex-1 px-5 py-16">
                        <i data-lucide="box" class="block w-12 h-12 text-primary mx-auto"></i> 
                        <div class="text-xl font-medium text-center mt-10">1 Year Plan</div>
                        <!-- <div class="text-slate-600 dark:text-slate-500 text-center mt-5"> 1 Domain <span class="mx-1">•</span> 10 Users <span class="mx-1">•</span> 20 Copies </div> -->
                        <div class="text-slate-500 px-10 text-center mx-auto mt-2">Support / upgrade will be provided</div>
                        <div class="flex justify-center">
                            <div class="relative text-5xl font-semibold mt-8 mx-auto"> <span class="absolute text-2xl top-0 left-0 -ml-4">$</span> 35 </div>
                        </div>
                        <button id="btnPlan1" type="button" class="btn btn-rounded-primary py-3 px-4 block mx-auto mt-8">BUY NOW</button>
                        <!-- onclick="window.location='{{ url("phonepe") }}'" -->
                    </div>
                    <div class="intro-y border-b border-t lg:border-b-0 lg:border-t-0 flex-1 p-5 lg:border-l lg:border-r border-slate-200/60 dark:border-darkmode-400 py-16">
                        <i data-lucide="send" class="block w-12 h-12 text-primary mx-auto"></i> 
                        <div class="text-xl font-medium text-center mt-10">2 Year Plan</div>
                        <!-- <div class="text-slate-600 dark:text-slate-500 text-center mt-5"> 1 Domain <span class="mx-1">•</span> 10 Users <span class="mx-1">•</span> 20 Copies </div> -->
                        <div class="text-slate-500 px-10 text-center mx-auto mt-2">Support / upgrade will be provided</div>
                        <div class="flex justify-center">
                            <div class="relative text-5xl font-semibold mt-8 mx-auto"> <span class="absolute text-2xl top-0 left-0 -ml-4">$</span> 60 </div>
                        </div>
                        <button onclick="window.location='{{ url("phonepe") }}'" class="btn btn-rounded-primary py-3 px-4 block mx-auto mt-8">BUY NOW</button>
                    </div>
                </div>       
                <!-- END: Content -->
                </div>
                 <!-- BEGIN: Success Modal Content --> 
        <div id="divSubscribeSuccessModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true" data-tw-backdrop="static"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divMsg" class="text-3xl mt-5"><span></span>Subscribed Successfully</div>  </div>
                  <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 
 <!-- BEGIN: Error Modal Content --> 
 <div id="divSubscribeErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
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