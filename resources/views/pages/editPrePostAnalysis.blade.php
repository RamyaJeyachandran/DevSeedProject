@extends('layouts.main')
@section('title','Pre Wash And Post Wash Analysis')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" /> @endsection @section('content')
    @include('layouts.mobileSideMenu') <div class="flex mt-[4.7rem] md:mt-0"> @include('layouts.sideMenu') 
        <!-- BEGIN: Content --> 
    <div class="content"> @include('layouts.topBar') 
        <form id="frmEditPrePost">
           
<!-- <div class="intro-y box mt-5">
    <div id="boxed-tab" class="p-5"> -->
    <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">   
        <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}"
        type="hidden" class="form-control"> <input id="txtBranch" name="branchId" value="{{ session('branchId') }}"
        type="hidden" class="form-control">
        <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
        <input id="txtSemenAnalysisId" name="prePostId" value="{{$prePostDetails->prePostId}}" type="hidden" class="form-control">
        <input id="txtpatientId" name="patientId" value="{{$prePostDetails->patientId}}" type="hidden" class="form-control">
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
            <label for="txtPatientName" class="form-label">Patient Name</label>
            <input id="txtPatientName" value="{{ $prePostDetails->name }}" type="text" class="form-control" disabled>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
            <label for="txtSeqNo" class="form-label">Patient Sequence No </label>
            <input id="txtSeqNo"  value="{{ $prePostDetails->patientSeqNo }}"  type="text" class="form-control" disabled>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
            <label for="txtHcNo" class="form-label">Patient Register No </label>
            <input id="txtHcNo"  value="{{ $prePostDetails->hcNo }}"  type="text" class="form-control" disabled>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
            <label for="txtPhoneNo" class="form-label">Patient Phone No </label>
            <input id="txtPhoneNo"  value="{{ $prePostDetails->phoneNo }}"  type="text" class="form-control" disabled>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
            <label for="txtSpouseName" class="form-label">Spouse Name </label>
            <input id="txtSpouseName"  value="{{ $prePostDetails->spouseName==''?'Not Provided':$prePostDetails->spouseName }}"  type="text" class="form-control" disabled>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
            <label for="ddlDoctor" class="form-label">Doctor <span class="text-danger mt-2"> *</span></label>
            <select id="ddlDoctor" value="{{$prePostDetails->doctorList}}" name="doctorId" class="form-select">
                <option value='0'>Select Doctor</option>
                    @foreach ($prePostDetails->doctorList as $doctorList)
                        <option value="{{ $doctorList->id }}" {{ ( $doctorList->id == $prePostDetails->doctorId) ? 'selected' : '' }}>
                                {{ $doctorList->name }}
                        </option>
                    @endforeach
            </select>
        </div>
</div>

<!-- </div></div> -->
</div>
<div class="intro-y box mt-5">
    <div id="boxed-tab" class="p-5">
        <div class="preview">
            <ul class="nav nav-boxed-tabs" role="tablist">
                <li id="tabPreWash" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#tabPreWash"
                        type="button" role="tab" aria-controls="tabPreWash" aria-selected="true"> 
                        PRE WASH
                    </button>
                </li>
                <li id="tabPostWash" class="nav-item flex-1" role="presentation">
                    <button  class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#tabPostWash"
                        type="button" role="tab" aria-controls="tabPostWash" aria-selected="false">
                        POST WASH
                    </button>
                </li>
            </ul>
            <div class="tab-content mt-5">
                <div id="tabPreWash" class="tab-pane leading-relaxed active" role="tabpanel"
                    aria-labelledby="tabPhysicalExamination">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtVolume" class="form-label">Volume</label>
                                <div class="input-group">
                                <input id="txtVolume" name="volume" type="text" value="{{ $prePostDetails->volume }}" class="form-control" aria-describedby="txtVolumeGroup">
                                <div id="txtVolumeGroup" class="input-group-text">ml</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtViscosity" class="form-label">Viscosity</label>
                                <input id="txtViscosity" name="viscosity" type="text" value="{{ $prePostDetails->viscosity }}" class="form-control" aria-describedby="txtViscosity">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtLiquefaction" class="form-label">Liquefaction</label>
                                <div class="input-group">
                                <input id="txtLiquefaction" name="liquefaction" type="text" value="{{ $prePostDetails->liquefaction }}" class="form-control" aria-describedby="txtLiquefactionGroup">
                                <div id="txtLiquefactionGroup" class="input-group-text">Minutes</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtPh" class="form-label">Ph</label>
                                <input id="txtPh" name="ph" type="text" value="{{ $prePostDetails->ph }}" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtWBC" class="form-label">WBC</label>
                                <div class="input-group">
                                <input id="txtWBC" name="wbc" type="text" value="{{ $prePostDetails->wbc }}" class="form-control" aria-describedby="txtWBCGroup">
                                <div id="txtWBCGroup" class="input-group-text">million</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtSpermConcentration" class="form-label">Sperm Concentration</label>
                                <div class="input-group">
                                <input id="txtSpermConcentration" name="preSpermConcentration" value="{{ $prePostDetails->preSpermConcentration }}" type="text" class="form-control" aria-describedby="txtSpermConcentrationGroup">
                                <div id="txtSpermConcentrationGroup" class="input-group-text">million/ml</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtSpermCount" class="form-label">Sperm Count</label>
                                <div class="input-group">
                                <input id="txtSpermCount" name="preSpermCount" value="{{ $prePostDetails->preSpermCount }}" type="text" class="form-control" aria-describedby="txtSpermCountGroup">
                                <div id="txtSpermCountGroup" class="input-group-text">million</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtMotility" class="form-label">Motility</label>
                                <div class="input-group">
                                <input id="txtMotility" name="preMotility" value="{{ $prePostDetails->preMotility }}"  type="text" class="form-control" aria-describedby="txtMotilityGroup">
                                <div id="txtMotilityGroup" class="input-group-text">%</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtRapid" class="form-label">Rapid Progressive (A)</label>
                                <div class="input-group">
                                <input id="txtRapid" name="preRapidProgressive" value="{{ $prePostDetails->preRapidProgressive }}"   type="text" class="form-control" aria-describedby="txtRapidGroup">
                                <div id="txtRapidGroup" class="input-group-text">%</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtSlow" class="form-label">Slow Progressive (B)</label>
                                <div class="input-group">
                                <input id="txtSlow" name="preSlowProgressive" value="{{ $prePostDetails->preSlowProgressive }}"  type="text" class="form-control" aria-describedby="txtSlowGroup">
                                <div id="txtSlowGroup" class="input-group-text">%</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtNonProgressive" class="form-label">Non-Progressive (C)</label>
                                <div class="input-group">
                                <input id="txtNonProgressive" name="preNonProgressive" value="{{ $prePostDetails->preNonProgressive }}" type="text" class="form-control" aria-describedby="txtNonProgressiveGroup">
                                <div id="txtNonProgressiveGroup" class="input-group-text">%</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtImmotile" class="form-label">Immotile (D)</label>
                                <div class="input-group">
                                <input id="txtImmotile" name="preImmotile" value="{{ $prePostDetails->preImmotile }}" type="text" class="form-control" aria-describedby="txtImmotileGroup">
                                <div id="txtImmotileGroup" class="input-group-text">%</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtMedia" class="form-label">Media</label>
                                <input id="txtMedia" name="media" type="text"  value="{{ $prePostDetails->media }}" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="txtMethodUsed" class="form-label">Method Used</label>
                                <textarea id="txtMethodUsed" name="methodUsed" class="form-control">{{ $prePostDetails->methodUsed }}</textarea>
                            </div>
                    </div>   
                    
                </div>
                <div id="tabPostWash" class="tab-pane leading-relaxed" role="tabpanel"
                    aria-labelledby="tabMicroExamination">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                            <div class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="txtCountIn" class="form-label">Count IN 0.5 ml</label>
                                <div class="input-group">
                                    <input id="txtCountIn" name="countInMl" value="{{ $prePostDetails->countInMl }}" type="text" class="form-control" aria-describedby="txtCountInGroup">
                                    <div id="txtCountInGroup" class="input-group-text">million/ml</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="txtPostMotility" class="form-label">Motility</label>
                                <div class="input-group">
                                <input id="txtPostMotility" name="postMotility" value="{{ $prePostDetails->postMotility }}" type="text" class="form-control" aria-describedby="txtPostMotilityGroup">
                                <div id="txtPostMotilityGroup" class="input-group-text">%</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="txtPostRapid" class="form-label">Rapid Progressive (A)</label>
                                <div class="input-group">
                                    <input id="txtPostRapid" name="postRapidProgressive" value="{{ $prePostDetails->postRapidProgressive }}" type="text" class="form-control" aria-describedby="txtPostRapidGroup">
                                    <div id="txtPostRapidGroup" class="input-group-text">million/ml</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="txtPostSlow" class="form-label">Slow Progressive (B)</label>
                                <div class="input-group">
                                <input id="txtPostSlow" name="postSlowProgressive" value="{{ $prePostDetails->postSlowProgressive }}" type="text" class="form-control" aria-describedby="txtPostSlowGroup">
                                <div id="txtPostSlowGroup" class="input-group-text">%</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="txtPostNonProgressive" class="form-label">Non-Progressive (C)</label>
                                <div class="input-group">
                                    <input id="txtPostNonProgressive" name="postNonProgressive"  value="{{ $prePostDetails->postNonProgressive }}" type="text" class="form-control" aria-describedby="txtPostNonProgressiveGroup">
                                    <div id="txtPostNonProgressiveGroup" class="input-group-text">%</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 form-control">
                                <label for="txtPostImmotile" class="form-label">Immotile (D)</label>
                                <div class="input-group">
                                <input id="txtPostImmotile" name="postImmotile" value="{{ $prePostDetails->postImmotile }}" type="text" class="form-control" aria-describedby="txtPostImmotileGroup">
                                <div id="txtPostImmotileGroup" class="input-group-text">%</div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-12 form-control">
                                <label for="txtImpression" class="form-label">Impression</label>
                                <textarea id="txtImpression" name="impression" class="form-control">{{ $prePostDetails->impression }}</textarea>
                            </div>
                    </div>    
            </div>
        </div>
    </div>

</div>
<div class="intro-y box p-5 mt-5">
<nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active font-medium text-base  mr-auto" aria-current="page">Report Signature</li>
                        </ol>
                    </nav>
    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
    <input id="txtReportSignId" name="reportSignId"  type="hidden" class="form-control">
        <div class="intro-y col-span-12 sm:col-span-4 form-control">
            <label id="lblLeftSign" for="txtLeftSign" class="form-label">Left Signature: {{ $prePostDetails->leftDoctor }} </label>
            <div id="txtLeftSign" class="box">
                 <img id="ïmgLeftSign" src="{{ $prePostDetails->leftSignature }}">
            </div>
        </div>
        <div class="intro-y col-span-12 sm:col-span-4 form-control">
            <label id="lblCenterSign" for="txtCenterSign" class="form-label">Center Signature: {{ $prePostDetails->centerDoctor }} </label>
            <div id="txtCenterSign" class="box ">
            <img id="imgCenterSign" src="{{ $prePostDetails->centerSignature }}">
            </div>
        </div>
        <div class="intro-y col-span-12 sm:col-span-4 form-control">
            <label id="lblRightSign" for="txtRightSign" class="form-label">Right Signature: {{ $prePostDetails->rightDoctor }} </label>
            <div id="txtRightSign" class="box ">
            <img id="imgRightSign" src="{{ $prePostDetails->rightSignature }}">
            </div>
        </div>
    </div>
</div>
<div class="mt-3"> 
<button type="submit" class="btn btn-danger w-24 ml-2"><i data-lucide="edit" class="w-4 h-4 mr-2"></i>Update</button>
            </div>
</div>


</form>
<!-- END: Content -->
</div>
</div>

<!-- BEGIN: Success Modal Content -->
<div id="success-modal-preview" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true"
    data-tw-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="check-circle"
                        class="w-16 h-16 text-success mx-auto mt-3"></i>
                    <div id="divMsg" class="text-3xl mt-5"><span></div><br>
                    <div class="px-5 pb-8 text-center"> 
                    <input id="txtId" value="{{$prePostDetails->prePostId}}" type="hidden" class="form-control"> 
                        <button id="btnPrePostSuccess"  data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                        <button id="btnPrePostPrint" type="button" data-tw-dismiss="modal" class="btn btn-danger w-24">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Success Modal Content -->
<!-- BEGIN: Error Modal Content -->
<div id="warning-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i>
                    <div id="divErrorHead" class="text-3xl mt-5"><span></span></div>
                    <div id="divErrorMsg" class="text-slate-500 mt-2"><span></span></div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn w-24 btn-primary">Ok</button>
                </div>
            </div>
        </div>
    </div>
</div> <!-- END: Error Modal Content -->
@endsection

@push('js')
<script src="{{ asset('dist/js/app.js')}}"></script>
<script type="module" src="{{ asset('dist/js/prePost.js')}}"></script>
@endpush