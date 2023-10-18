@extends('layouts.main')
@section('title','Reset Password')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />

@endsection 
@section('content')
    @include('layouts.mobileSideMenu')
    <div class="flex mt-[4.7rem] md:mt-0">
    @can('isAdmin')
            @include('layouts.sideMenu')
        @endcan
        @can('isHospital')
            @include('layouts.hospitalSideMenu')
        @endcan
        @can('isBranch')
            @include('layouts.branchSideMenu')
        @endcan
        @can('isDoctor')
            @include('layouts.doctorSideMenu')
        @endcan
                <!-- BEGIN: Content -->
                <div class="content">
                    @include('layouts.topBar')
                    <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse"></div>
                    <div class="col-span-12 lg:col-span-4 2xl:col-span-9 ">
                        <!-- BEGIN: Change Password -->
                        <form id="frmRestPwd">
                        <div class="intro-y box bg-primary text-white lg:mt-5">
                            <div class="p-5">
                            <div>
                                    <label for="change-password-form-4" class="form-label">User Name</label>
                                    <input id="change-password-form-4" type="text" class="form-control" disabled>
                                </div>
                                <div class="mt-3">
                                    <label for="change-password-form-1" class="form-label">Old Password</label>
                                    <input id="change-password-form-1" type="password" class="form-control" >
                                </div>
                                <div class="mt-3">
                                    <label for="change-password-form-2" class="form-label">New Password</label>
                                    <input id="change-password-form-2" type="password" class="form-control" >
                                </div>
                                <div class="mt-3">
                                    <label for="change-password-form-3" class="form-label">Confirm New Password</label>
                                    <input id="change-password-form-3" type="password" class="form-control" >
                                </div>
                                <button type="submit" class="btn btn-danger mt-4">Change Password</button>
                            </div>
                        </div>
                        </form>
                        <!-- END: Change Password -->
                    </div>
                </div></div>
                <!-- END: Content -->
    </div>
@endsection

        @push('js')
        <script src="{{ asset('dist/js/app.js')}}"></script>
        <script  type="module" src="{{ asset('dist/js/patient.js')}}"></script>
        @endpush



