@extends('layouts.main')
@section('title','Image Capture Settings')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
@endsection 
@section('content')
    @include('layouts.mobileSideMenu')
    <div id="divPatient" class="flex mt-[4.7rem] md:mt-0">
    @include('layouts.sideMenu')
                <!-- BEGIN: Content -->
                <div class="content">
                    @include('layouts.topBar')
                    <form id="frmPrintSettings">
                    <div class="intro-y box p-5 mt-5">
                            <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                           
                        <label>Image Capture</label>
                        <div class="flex flex-col sm:flex-row mt-2">
                            <div class="form-check mr-2"> 
                                <input id="chkImageCapture" class="form-check-input" type="radio" value="1" name="isSet" {{ ( $isSetOn == 1) ? 'checked' : '' }}> <label class="form-check-label" for="radio-switch-4">Yes</label> </div>
                            <div class="form-check mr-2 mt-2 sm:mt-0"> 
                                <input id="chkImageCapture1" class="form-check-input" type="radio" value="0" name="isSet"  {{ ( $isSetOff == 1) ? 'checked' : '' }}> <label class="form-check-label" for="radio-switch-5">No</label> </div>
                        </div>
                    </div>
                          <!-- BEGIN: Success Modal Content --> 
        <div id="divImageSetSuccessModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true" data-tw-backdrop="static"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divMsg" class="text-3xl mt-5"><span></span></div> </div>
                  <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 
                        <!-- BEGIN: Error Modal Content --> 
 <div id="divImageSetErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
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
                        </form>
                </div>
</div>
@endsection

@push('js')
<script type="module" src="{{ asset('dist/js/app.js')}}"></script>
<script  type="module" src="{{ asset('dist/js/settings.js')}}"></script>
@endpush