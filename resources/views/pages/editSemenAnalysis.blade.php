@extends('layouts.main')
@section('title','Semen Analysis')
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
        <form id="frmEditSemenAnalysis">

        <div class="mt-3">
            <button id="btnUpdSemenAnalysis" type="submit" class="btn btn-danger w-24 ml-2"><i data-lucide="edit" class="w-4 h-4 mr-2"></i>Update</button>
        </div>
        <!-- <div class="intro-y box mt-5">
    <div id="boxed-tab" class="p-5"> -->
    <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">   
    <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}"
        type="hidden" class="form-control"> <input id="txtBranch" name="branchId" value="{{ session('branchId') }}"
        type="hidden" class="form-control">
        <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
            <label for="txtPatientName" class="form-label">Patient Name</label>
            <input id="txtPatientName" value="{{ $semenanalysisDetails->name }}" type="text" class="form-control" disabled>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
            <label for="txtSeqNo" class="form-label">Patient Sequence No</label>
            <input id="txtSeqNo" value="{{ $semenanalysisDetails->patientSeqNo }}" type="number" class="form-control" disabled>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
            <label for="txtHcNo" class="form-label">Patient Register No </label>
            <input id="txtHcNo"  value="{{ $semenanalysisDetails->hcNo }}" type="text" class="form-control" disabled>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
            <label for="txtPhoneNo" class="form-label">Patient Phone No </label>
            <input id="txtPhoneNo"  value="{{ $semenanalysisDetails->phoneNo }}" type="text" class="form-control" disabled>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
            <label for="txtSpouseName" class="form-label">Spouse Name </label>
            <input id="txtSpouseName"  value="{{ $semenanalysisDetails->spouseName==''?'Not Provided':$semenanalysisDetails->spouseName }}" type="text" class="form-control" disabled>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 form-control">
            <label for="ddlDoctor" class="form-label">Doctor <span class="text-danger mt-2"> *</span></label>
            <select id="ddlDoctor" value="{{$semenanalysisDetails->doctorList}}" name="doctorId" class="form-select">
                <option value='0'>Select Doctor</option>
                    @foreach ($semenanalysisDetails->doctorList as $doctorList)
                        <option value="{{ $doctorList->id }}" {{ ( $doctorList->id == $semenanalysisDetails->doctorId) ? 'selected' : '' }}>
                                {{ $doctorList->name }}
                        </option>
                    @endforeach
            </select>
        </div>
    <!-- </div>
</div> -->
        
</div>
</div>

            <div class="intro-y box mt-5 form-control">

                <div id="boxed-tab" class="p-5">
                    <div class="preview ">
                        <ul class="nav nav-boxed-tabs" role="tablist">
                            <li id="example-1-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-1" type="button" role="tab" aria-controls="example-tab-1" aria-selected="true"> PHYSICAL EXAMINATION </button>
                            </li>
                            <li id="example-2-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-2" type="button" role="tab" aria-controls="example-tab-2" aria-selected="false">MICROSCOPIC EXAMINATION</button>
                            </li>
                            <li id="example-3-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-3" type="button" role="tab" aria-controls="example-tab-3" aria-selected="false">SPERM MOTILITY</button>
                            </li>
                            <li id="example-4-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-4" type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">SPERM MORPHOLOGY</button>
                            </li>
                            <li id="example-5-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-5" type="button" role="tab" aria-controls="example-tab-5" aria-selected="false">CELLULAR ELEMENTS</button>
                            </li>
                            <!-- <li id="tabSignature" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-6"
                                    type="button" role="tab" aria-controls="example-tab-6" aria-selected="false">DOCTOR SIGNATURE</button>
                            </li> -->
                        </ul>
                        <div class="tab-content mt-5">
                            <div id="example-tab-1" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-1-tab">
                                <input id="txtpatientId" name="patientId" value="{{$semenanalysisDetails->patientId}}" type="hidden" class="form-control">
                                <input id="txtSemenAnalysisId" name="semenanalysisId" value="{{$semenanalysisDetails->semenanalysisId}}" type="hidden" class="form-control">
                                <div>
                                    <label for="ddlliquefaction" class="form-label">Liquefaction</label>

                                    <select id="ddlliquefaction" value="{{$semenanalysisDetails->liquefaction}}" name="liquefaction" class="form-select">
                                        <option value='0'>Select liquefaction</option>
                                        @foreach ($semenanalysisDetails->liquefactionList as $liquefaction)
                                        <option value="{{ $liquefaction->name }}" {{ ( $liquefaction->name == $semenanalysisDetails->liquefaction) ? 'selected' : '' }}>
                                            {{ $liquefaction->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label for="ddlappearance" class="form-label">Appearance</label>

                                    <select id="ddlappearance" value="{{$semenanalysisDetails->appearance}}" name="appearance" class="form-select">
                                        <option value='0'>Select appearance</option>
                                        @foreach ($semenanalysisDetails->appearanceList as $appearance)
                                        <option value="{{ $appearance->name }}" {{ ( $appearance->name == $semenanalysisDetails->appearance) ? 'selected' : '' }}>
                                            {{ $appearance->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label for="ddlph" class="form-label">PH</label>
                                    <select id="ddlph" value="{{$semenanalysisDetails->ph}}" name="ph" class="form-select">
                                        <option value='0'>Select ph</option>
                                        @foreach ($semenanalysisDetails->phList as $ph)
                                        <option value="{{ $ph->name }}" {{ ( $ph->name == $semenanalysisDetails->ph) ? 'selected' : '' }}>
                                            {{ $ph->name }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mt-3">
                                    <label for="txtvolume" class="form-label">Volume / Spill</label>
                                    <div class="input-group">
                                    <input id="txtvolume" name="volume" value="{{$semenanalysisDetails->volume}}" class="form-control"  placeholder="Enter Volume / Spill"
                                            aria-describedby="txtvolumeGroup">
                                        <div id="txtvolumeGroup" class="input-group-text">ml</div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="ddlviscosity" class="form-label">Viscosity</label>
                                    <select id="ddlviscosity" value="{{$semenanalysisDetails->viscosity}}" name="viscosity" class="form-select">
                                        <option value='0'>Select Viscosity</option>
                                        @foreach ($semenanalysisDetails->viscosityList as $viscosity)
                                        <option value="{{ $viscosity->name }}" {{ ( $viscosity->name == $semenanalysisDetails->viscosity) ? 'selected' : '' }}>
                                            {{ $viscosity->name }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mt-3">
                                    <label for="ddlabstinence" class="form-label">Abstinence</label>
                                    <select id="ddlabstinence" name="abstinence" class="form-select" value="{{$semenanalysisDetails->abstinence}}">
                                        <option value='0'>Select Abstinence</option>
                                        @foreach ($semenanalysisDetails->abstinenceList as $abstinence)
                                        <option value="{{ $abstinence->name }}" {{ ( $abstinence->name == $semenanalysisDetails->abstinence) ? 'selected' : '' }}>
                                            {{ $abstinence->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label for="txtmedication" class="form-label">Medication</label>
                                    <div class="input-group">
                                    <input id="txtmedication" name="medication" class="form-control" value="{{$semenanalysisDetails->medication}}" placeholder="Enter Medication"
                                aria-describedby="txtmedicationGroup">
                            <div id="txtmedicationGroup" class="input-group-text"></div>
                        </div>
                                </div>
                            </div>
                            <div id="example-tab-2" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-2-tab">
                                <div class="mt-3">
                                    <label for="txtspermconcentration" class="form-label">Sperm Concentration</label>
                                    <div class="input-group">
                                    <input id="txtspermconcentration" name="spermconcentration" class="form-control" value="{{$semenanalysisDetails->spermconcentration}}" placeholder="Enter Volume"
                                aria-describedby="txtspermconcentrationGroup">
                            <div id="txtspermconcentrationGroup" class="input-group-text">mil/ml</div>
                        </div>
                                </div>
                                <div class="mt-3">
                                    <label for="ddlagglutination" class="form-label">Agglutination</label>
                                    <select id="ddlagglutination" name="agglutination" class="form-select" value="{{$semenanalysisDetails->agglutination}}">
                                        <option value='0'>Select Agglutination</option>
                                        @foreach ($semenanalysisDetails->agglutinationList as $agglutination)
                                        <option value="{{ $agglutination->name }}" {{ ( $agglutination->name == $semenanalysisDetails->agglutination) ? 'selected' : '' }}>
                                            {{ $agglutination->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label for="ddlclumping" class="form-label">Clumping</label>
                                    <select id="ddlclumping" name="clumping" class="form-select" value="{{$semenanalysisDetails->clumping}}">
                                        <option value='0'>Select Clumping</option>
                                        @foreach ($semenanalysisDetails->clumpingList as $clumping)
                                        <option value="{{ $clumping->name }}" {{ ( $clumping->name == $semenanalysisDetails->clumping) ? 'selected' : '' }}>
                                            {{ $clumping->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label for="ddlgranulardebris" class="form-label">Granular Debris</label>
                                    <select id="ddlgranulardebris" name="granulardebris" class="form-select" value="{{$semenanalysisDetails->granulardebris}}">
                                        <option value='0'>Select Granular Debris</option>
                                        @foreach ($semenanalysisDetails->agglutinationList as $granulardebris)
                                        <option value="{{ $granulardebris->name }}" {{ ( $granulardebris->name == $semenanalysisDetails->granulardebris) ? 'selected' : '' }}>
                                            {{ $granulardebris->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="example-tab-3" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-3-tab">
                                <div class="mt-3">
                                    <label for="txttotalmotility" class="form-label">Total Motility</label>
                                    <div class="input-group">
                                    <input id="txttotalmotility" name="totalmotility" class="form-control" value="{{$semenanalysisDetails->totalmotility}}"  placeholder="Enter Volume" aria-describedby="txttotalmotilityGroup">
                                        <div id="txttotalmotilityGroup" class="input-group-text">%</div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label for="txtrapidprogressivemovement" class="form-label">Rapid Progressive Movement</label>
                                    <div class="input-group">
                                    <input id="txtrapidprogressivemovement" name="rapidprogressivemovement" class="form-control" value="{{$semenanalysisDetails->rapidprogressivemovement}}" placeholder="Enter Volume" aria-describedby="txtrapidprogressivemovementGroup">
                                        <div id="txtrapidprogressivemovementGroup" class="input-group-text">%</div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="txtsluggishprogressivemovement" class="form-label">Sluggish Progressive Movement</label>
                                    <div class="input-group">
                                    <input id="txtsluggishprogressivemovement" name="sluggishprogressivemovement" class="form-control" value="{{$semenanalysisDetails->sluggishprogressivemovement}}" placeholder="Enter Volume" aria-describedby="txtsluggishprogressivemovementGroup">
                                        <div id="txtsluggishprogressivemovementGroup" class="input-group-text">%</div>
                                    </div>
                                    </div>
                                <div class="mt-3">
                                    <label for="txtnonprogressive" class="form-label">Non Progressive</label>
                                    <div class="input-group">
                                        <input id="txtnonprogressive" name="nonprogressive" class="form-control" value="{{$semenanalysisDetails->nonprogressive}}" placeholder="Enter Volume" aria-describedby="txtnonprogressiveGroup">
                                        <div id="txtnonprogressiveGroup" class="input-group-text">%</div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label for="txtnonmotile" class="form-label">Non Motile</label>
                                    <div class="input-group">
                                    <input id="txtnonmotile" name="nonmotile" class="form-control" value="{{$semenanalysisDetails->nonmotile}}" placeholder="Enter Volume" aria-describedby="txtnonmotileGroup">
                                        <div id="txtnonmotileGroup" class="input-group-text">%</div>
                                    </div>
                                </div>
                            </div>
                            <div id="example-tab-4" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-4-tab">
                                <div class="mt-3">
                                    <label for="txtnormalsperms" class="form-label">Normal Sperms</label>
                                    <div class="input-group">
                                    <input id="txtnormalsperms" name="normalsperms" class="form-control" value="{{$semenanalysisDetails->normalsperms}}"  placeholder="Enter Volume" aria-describedby="txtnormalspermsGroup">
                            <div id="txtnormalspermsGroup" class="input-group-text">%</div>
                        </div>
                                </div>
                                <div class="mt-3">
                                    <label for="txtheaddefects" class="form-label">Head Defects</label>
                                    <div class="input-group">
                                    <input id="txtheaddefects" name="headdefects" class="form-control" value="{{$semenanalysisDetails->headdefects}}"  placeholder="Enter Volume" aria-describedby="txtheaddefectsGroup">
                            <div id="txtheaddefectsGroup" class="input-group-text">%</div>
                        </div>
                                </div>
                                <div class="mt-3">
                                    <label for="txtneckandmidpiecedefects" class="form-label">Neck and Mid Piece Defects</label>
                                    <div class="input-group">
                                    <input id="txtneckandmidpiecedefects" name="neckandmidpiecedefects" class="form-control" value="{{$semenanalysisDetails->neckandmidpiecedefects}}" placeholder="Enter Volume" aria-describedby="txtneckandmidpiecedefectsGroup">
                            <div id="txtneckandmidpiecedefectsGroup" class="input-group-text">%</div>
                        </div>
                                </div>
                                <div class="mt-3">
                                    <label for="txttaildefects" class="form-label">Tail Defects</label>
                                    <div class="input-group">
                                    <input id="txttaildefects" name="taildefects" class="form-control" value="{{$semenanalysisDetails->taildefects}}" placeholder="Enter Volume" aria-describedby="txttaildefectsGroup">
                            <div id="txttaildefectsGroup" class="input-group-text">%</div>
                        </div>
                                </div>
                                <div class="mt-3">
                                    <label for="txtcytoplasmicdroplets" class="form-label">Cytoplasmic Droplets</label>
                                    <div class="input-group">
                                    <input id="txtcytoplasmicdroplets" name="cytoplasmicdroplets" class="form-control" value="{{$semenanalysisDetails->cytoplasmicdroplets}}"  placeholder="Enter Volume" aria-describedby="txtcytoplasmicdropletsGroup">
                            <div id="txtcytoplasmicdropletsGroup" class="input-group-text">%</div>
                        </div>
                                </div>
                            </div>
                            
                            <div id="example-tab-5" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-5-tab">
                                <div class="mt-3">
                                    <label for="ddlepithelialcells" class="form-label">Epithelial Cells</label>
                                    <select id="ddlepithelialcells" name="epithelialcells" class="form-select" value="{{$semenanalysisDetails->epithelialcells}}">
                                        <option value='0'>Select Epithelial Cells</option>
                                        @foreach ($semenanalysisDetails->clumpingList as $epithelialcells)
                                        <option value="{{ $epithelialcells->name }}" {{ ( $epithelialcells->name == $semenanalysisDetails->epithelialcells) ? 'selected' : '' }}>
                                            {{ $epithelialcells->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label for="ddlpuscells" class="form-label">Pus Cells</label>
                                    <select id="ddlpuscells" name="puscells" class="form-select" value="{{$semenanalysisDetails->puscells}}">
                                        <option value='0'>Select Pus Cells</option>
                                        @foreach ($semenanalysisDetails->puscellsList as $puscells)
                                        <option value="{{ $puscells->name }}" {{ ( $puscells->name == $semenanalysisDetails->puscells) ? 'selected' : '' }}>
                                            {{ $puscells->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label for="txtrbc" class="form-label">Rbc</label>
                                    <div class="input-group">
                                    <input id="txtrbc" name="rbc" class="form-control" value="{{$semenanalysisDetails->rbc}}" placeholder="Enter Volume" aria-describedby="txtrbcGroup">
                            <div id="txtrbcGroup" class="input-group-text"></div>
                        </div>
                                </div>
                                <div class="mt-3">
                                    <label for="txtimpression" class="form-label">Impression</label>
                                    <textarea id="txtImpression" name="impression" class="form-control">{{ $semenanalysisDetails->impression }}</textarea>
                                </div>
                                <div class="mt-3">
                                    <label for="txtcomments" class="form-label">Comments</label>
                                    <textarea id="txtcomments" name="comments" class="form-control">{{ $semenanalysisDetails->comments }}</textarea>
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
    <input id="txtReportSignId" name="reportSignId" value="{{ $semenanalysisDetails->reportSignId }}"  type="hidden" class="form-control">
        <div class="intro-y col-span-12 sm:col-span-4 form-control">
            <label id="lblLeftSign" for="txtLeftSign" class="form-label">Left Signature: {{ $semenanalysisDetails->leftDoctor }}</label>
            <div id="txtLeftSign" class="box">
                 <img id="ïmgLeftSign" src="{{ $semenanalysisDetails->leftSignature }}">
            </div>
        </div>
        <div class="intro-y col-span-12 sm:col-span-4 form-control">
            <label id="lblCenterSign" for="txtCenterSign" class="form-label">Center Signature: {{ $semenanalysisDetails->centerDoctor }} </label>
            <div id="txtCenterSign" class="box ">
            <img id="imgCenterSign" src="{{ $semenanalysisDetails->centerSignature }}">
            </div>
        </div>
        <div class="intro-y col-span-12 sm:col-span-4 form-control">
            <label id="lblRightSign" for="txtRightSign" class="form-label">Right Signature: {{ $semenanalysisDetails->rightDoctor }} </label>
            <div id="txtRightSign" class="box ">
            <img id="imgRightSign" src="{{ $semenanalysisDetails->rightSignature }}">
            </div>
        </div>
    </div>
</div>
<!-- Image Capture BEGIN-->
@if($semenanalysisDetails->isSetImg==1 || $semenanalysisDetails->imgCount>0)
<div id="divEditImageCaputre" class="intro-y box p-5 mt-5">
<nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active font-medium text-base  mr-auto" aria-current="page"> Capture Images  
                <input id="btnEditOnCam" type="button" value="On Camera" class="btn btn-pending w-24  {{$semenanalysisDetails->isSetImg == 1 ?'':'hidden'}}">

                            </li>
                        </ol>
                    </nav>
                    <!-- BEGIN: Uplaod Images -->
                        <div id="divEditCaptureImage" class="intro-y box p-5 {{$semenanalysisDetails->imgCount>0 ?'':'hidden'}}">
                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                <div class="mt-5">
                                    <div class="form-inline items-start flex-col xl:flex-row mt-10">
                                        <div class="form-label w-full xl:w-64 xl:!mr-10">
                                            <div class="text-left">
                                            <!-- Image capture from camera -- Begin  -->
                                                <div id="edit_my_camera"></div>
                                                <br/>
                                                <input id="btnEditCaptureImg" type=button value="Caputre Images" class="btn btn-primary shadow-md mr-2 hidden">
                                             <!-- Image capture from camera -- END  -->
                                            </div>
                                        </div>
                                        <input id="txtEditImgCount" name="imgCount" value="{{$semenanalysisDetails->imgCount}}" type="hidden" class="form-control">
                                        <input id="txtDelAnalysisImage" name="delAnalysisImage"  type="hidden" class="form-control">
                                        <div id="divEditImg" class="w-full mt-3 xl:mt-0 flex-1 border-2 border-dashed dark:border-darkmode-400 rounded-md pt-4">
                                            <div id="divEditDisplayImg" class="grid grid-cols-10 gap-5 pl-4 pr-5">
                                           
                                            </div>
                                            <div class="px-4 pb-4 mt-5 flex items-center justify-center cursor-pointer relative">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Uplaod Images -->
                       
</div>
@endif
<!-- Image Capture END -->
    </div>

    </form>
    <!-- END: Content -->
</div>
</div>

<!-- BEGIN: Success Modal Content -->
<div id="success-modal-preview" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                    <div id="divMsg" class="text-3xl mt-5"><span></span></div><br>
                    <div class="px-5 pb-8 text-center"> 
                    <input id="txtId" value="{{$semenanalysisDetails->semenanalysisId}}" type="hidden" class="form-control">
                        <button id="btnSemenAnalysisSuccess" type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                        <button id="btnSemenSuccessPrint" type="button" data-tw-dismiss="modal" class="btn btn-danger w-24">Print</button>
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
    <script  type="module" src="{{ asset('dist/js/semenAnalysis.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @endpush