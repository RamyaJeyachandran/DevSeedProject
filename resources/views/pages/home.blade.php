@extends('layouts.main')
@section('title','Dashboard')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" /> @endsection @section('content')
    @include('layouts.mobileSideMenu') 
    <div id="divPatient" class="flex mt-[4.7rem] md:mt-0">
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
     <div class="content"> @include('layouts.topBar') </div>
     
     <!-- END: Content --> 
    </div>
@endsection
@push('js')
<script src="{{ asset('dist/js/app.js')}}"></script>
<script src="{{ asset('dist/js/patient.js')}}"></script>
@endpush