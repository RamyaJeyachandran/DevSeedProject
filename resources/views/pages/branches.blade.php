@extends('layouts.main')
@section('title','Branches')
@section ('style')
<link rel="stylesheet" href="{{ asset('css/app.css') }}" />
@endsection 
@section('content')
@include('layouts.mobileSideMenu')
<div class="flex mt-[4.7rem] md:mt-0">
@include('layouts.sideMenu')
            <!-- BEGIN: Content -->
            <div class="content">
                @include('layouts.topBar')
            </div>
            <!-- END: Content -->
        </div>
        @endsection

        @push('js')
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>
        <script src="{{ asset('js/app.js')}}"></script>
        @endpush
