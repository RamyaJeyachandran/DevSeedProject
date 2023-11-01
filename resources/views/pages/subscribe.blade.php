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
                        <button type="button" class="btn btn-rounded-primary py-3 px-4 block mx-auto mt-8">BUY NOW</button>
                    </div>
                    <div class="intro-y border-b border-t lg:border-b-0 lg:border-t-0 flex-1 p-5 lg:border-l lg:border-r border-slate-200/60 dark:border-darkmode-400 py-16">
                        <i data-lucide="send" class="block w-12 h-12 text-primary mx-auto"></i> 
                        <div class="text-xl font-medium text-center mt-10">2 Year Plan</div>
                        <!-- <div class="text-slate-600 dark:text-slate-500 text-center mt-5"> 1 Domain <span class="mx-1">•</span> 10 Users <span class="mx-1">•</span> 20 Copies </div> -->
                        <div class="text-slate-500 px-10 text-center mx-auto mt-2">Support / upgrade will be provided</div>
                        <div class="flex justify-center">
                            <div class="relative text-5xl font-semibold mt-8 mx-auto"> <span class="absolute text-2xl top-0 left-0 -ml-4">$</span> 60 </div>
                        </div>
                        <button type="button" class="btn btn-rounded-primary py-3 px-4 block mx-auto mt-8">BUY NOW</button>
                    </div>
                </div>       
                <!-- END: Content -->
                </div>
    </div>
@endsection

        @push('js')
        <script src="{{ asset('dist/js/app.js')}}"></script>
        <script  type="module" src="{{ asset('dist/js/patient.js')}}"></script>
        @endpush