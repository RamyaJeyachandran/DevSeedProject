@extends('layouts.main')
@section('title','Theme')
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
                    <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse"></div>
                    <div class="col-span-12 lg:col-span-4 2xl:col-span-9 ">
                        <!-- BEGIN: Theme -->
                        <form id="frmColor" class="validate-form">
                        @csrf
                        <input id="txtUserId" name="userId" value="{{$userDetails->id}}" type="hidden" class="form-control">
                        <div class="intro-y box lg:mt-5">
                        <!-- bg-blue-800 text-white -->
                            <div class="p-5">
                            <div>
                                    <label for="txtColor" class="form-label">Website Colour</label>
                                    <input id="txtColor" name="colorId" type="color" value="{{$userDetails->colorId}}" class="form-control" required>
                                </div>
                                <button id="btnColorPreview" type="button" class="btn btn-primary mt-4">Preview</button>
                                <button type="submit" class="btn btn-danger mt-4">Apply</button>
                            </div>
                        </div>
                        </form>
                        <!-- END: Theme -->
                    </div>
                </div></div>
                <!-- END: Content -->
    </div>
    <!-- BEGIN: Success Modal Content --> 
    <div id="divColorSuccessModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true" data-tw-backdrop="static"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divMsg" class="text-3xl mt-5"><span></span></div>  </div>
                  <div class="px-5 pb-8 text-center"> <button id="btnColorSuccess" type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 
    <!-- BEGIN: Error Modal Content --> 
 <div id="divColorErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
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
 <!-- BEGIN: Success Notification Content -->
 <div id="success-notification-content" class="toastify-content hidden flex" >
                                        <i class="text-success" data-lucide="check-circle"></i> 
                                        <div class="ml-4 mr-4">
                                            <div class="font-medium">Color changed successfully!</div>
                                        </div>
                                    </div>
                                    <!-- END: Success Notification Content -->
 <!-- BEGIN: Failed Notification Content -->
 <div id="failed-notification-content" class="toastify-content hidden flex">
   <i class="text-danger" data-lucide="x-circle"></i>
   <div class="ml-4 mr-4">
     <div class="font-medium">color change failed!</div>
   </div>
 </div>
 <!-- END: Failed Notification Content -->

@endsection

        @push('js')
        <script src="{{ asset('dist/js/app.js')}}"></script>
        <script  type="module" src="{{ asset('dist/js/settings.js')}}"></script>
        @endpush



