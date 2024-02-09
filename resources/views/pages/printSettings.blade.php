@extends('layouts.main')
@section('title','Print Settings')
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
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                                <button id="btnEditPrintSetting" type=button class="btn btn-danger w-24 ml-2"><i data-lucide="edit" class="w-4 h-4 mr-2"></i>Edit</button>
                                </div>
                            </div>
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                             <input id="txtPageSettingId" name="pageSettingId" type="hidden" value="{{$printSettingDetails->id}}" class="form-control">
                            <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                            <!-- <input id="colorId" name="colorId" value="{{ session('colorId') }}" type="hidden" class="form-control"> -->
                            <div class="intro-y col-span-12 sm:col-span-3">
                                <label for="txtMarginRight" class="form-label">Margin Right <span class="text-danger mt-2"> *</span></label>
                                <div class="input-group">
                                    <input type="number" id="txtMarginRight" name="marginRight" value="{{$printSettingDetails->marginRight}}" min="0" max="150" step="1" class="form-control" title="Please fill Margin Right" aria-describedby="txtRightGroup" disabled required/> 
                                    <div id="txtRightGroup" class="input-group-text">cm</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-3">
                                <label for="txtMarginLeft" class="form-label">Margin Left <span class="text-danger mt-2"> *</span></label>
                                <div class="input-group">
                                    <input type="number" id="txtMarginLeft" name="marginLeft" value="{{$printSettingDetails->marginLeft}}" min="0" max="150" step="1" class="form-control" title="Please fill Margin Left" aria-describedby="txtLeftGroup" disabled required/> 
                                    <div id="txtLeftGroup" class="input-group-text">cm</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-3">
                                <label for="txtMarginBottom" class="form-label">Margin Bottom <span class="text-danger mt-2"> *</span></label>
                                <div class="input-group">
                                <input type="number" id="txtMarginBottom" name="marginBottom" value="{{$printSettingDetails->marginBottom}}" min="0" max="150" step="1" class="form-control" title="Please fill Margin Bottom" aria-describedby="txtBottomGroup"disabled required/> 
                                <div id="txtBottomGroup" class="input-group-text">cm</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-3">
                                <label for="txtMarginTop" class="form-label">Margin Top <span class="text-danger mt-2"> *</span></label>
                                <div class="input-group">
                                <input type="number" id="txtMarginTop" name="marginTop" value="{{$printSettingDetails->marginTop}}" min="0" max="150" step="1"class="form-control" title="Please fill Margin Top" aria-describedby="txttopGroup" disabled required/> 
                                <div id="txttopGroup" class="input-group-text">cm</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-12"> 
                                <div class="form-check mr-2">
                                     <input id="chkHeader" class="form-check-input" name="isHeaderDisplay" type="checkbox" value="1" disabled {{$printSettingDetails->isHeaderDisplay==1?'checked':''}} > 
                                     <label class="form-check-label" for="chkHeader">Display header on report print
                                     </label> 
                                </div>
                            </div>
                            <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <button id="btnUpdPrintSetting" type=submit class="btn btn-primary w-24 ml-2"><i data-lucide="edit" class="w-4 h-4 mr-2"></i>Update</button>
                                <button id="btnCancelPrintSetting" type="reset" class="btn btn-dark w-24"><i data-lucide="x-circle" class="w-4 h-4 mr-2"></i>Cancel</button> 
                            </div>
                        </div></div>
                          <!-- BEGIN: Success Modal Content --> 
        <div id="divPrintSetSuccessModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true" data-tw-backdrop="static"> 
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
 <div id="divPrintSetErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
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