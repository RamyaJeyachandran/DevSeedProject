@extends('layouts.main')
@section('title','Semen Analysis')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" /> @endsection @section('content')
    @include('layouts.mobileSideMenu') <div class="flex mt-[4.7rem] md:mt-0"> @include('layouts.sideMenu') 
        <!-- BEGIN: Content --> 
    <div class="content"> @include('layouts.topBar') 
        <form id="frmSemenAnalysis">
            <div class="mt-3"> 
                <button id="btnSavesemenanalysis" type="submit" class="btn btn-primary w-24 ml-2">Save</button>
                <button id="btnCancelanalysis" type="reset" class="btn btn-dark w-24">Cancel</button>
            </div>
<div class="intro-y box mt-5">
    <div id="boxed-tab" class="p-5">
            <ul class="nav nav-boxed-tabs" role="tablist">
                <li id="" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#tabPatientInfoContent"
                        type="button" role="tab" aria-controls="tabPatientInfoContent" aria-selected="true">PATIENT INFORMATION</button>
                </li>
                <li id="tabDoctorInfo" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#tabDoctorInfoContent"
                        type="button" role="tab" aria-controls="tabDoctorInfoContent" aria-selected="false">DOCTOR INFORMATION</button>
                </li>
            </ul>
<div class="tab-content mt-5">
<!--Tab1-->
<div id="tabPatientInfoContent" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="tabPatientInfo">
        <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}"
        type="hidden" class="form-control"> <input id="txtBranch" name="branchId" value="{{ session('branchId') }}"
        type="hidden" class="form-control">
        <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">

        @can('isAdmin')
        <div class="intro-y col-span-12 sm:col-span-4 form-control">
            <label for="ddlHospital" class="form-label">Hospital <span class="text-danger mt-2"> *</span></label>
            <select id="ddlHospital" name="hospitalId" class="form-select">
                <option value='0'>Select Hospital</option>
                </select>
        </div>
    @endcan
    @can('isAdminHospital')
    <div id="divBranchddl" class="intro-y col-span-12 sm:col-span-4 form-control">
        <label for="ddlBranch" class="form-label">Branch <span class="text-danger mt-2"> *</span></label>
        <select id="ddlBranch" name="branchId" class="form-select">
        <option value='0'>Select Branch</option>
        </select>
    </div>
        @endcan
        <div id="divPatientddl" class="intro-y col-span-12 sm:col-span-4 form-control">
        <label for="ddlPatient" class="form-label">Patient <span class="text-danger mt-2"> *</span></label>
        <select id="ddlPatient" name="patientId" class="form-select" required>
            <option value='0'>Select Patient</option>
            </select>
    </div>
    <div id="divSpouse" class="intro-y col-span-12 sm:col-span-4 form-control">
        <label for="txtSpouseName" class="form-label">Spouse Name </label>
        <input id="txtSpouseName" name="spouseName" class="w-full" disabled>
    </div>
    <div id="divDoctorddl" class="intro-y col-span-12 sm:col-span-4 form-control">
        <label for="ddlDoctor" class="form-label">Prescribed By <span class="text-danger mt-2"> *</span></label>
        <select id="ddlDoctor" name="doctorId" class="form-select" required>
            <option value='0'>Select Doctor</option>
        </select>
    </div>
</div>
<!-- Tab 2 -->
<div id="tabDoctorInfoContent" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="tabDoctorInfo">
                <div class="mt-3">
                    <label for="ddlScientist1" class="form-label">Scientist <span class="text-danger mt-2"> *</span></label>
                        <select id="ddlScientist1" name="leftScientistId" class="form-select" required>
                            <option value='0'>Select Doctor</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="divLeftSignature" class="form-label">Left Signature</label>
                        <div id="divLeftSignature" class="flex">

                        </div>
                    </div>
                    <div class="mt-3">
                    <label for="ddlScientist2" class="form-label">Scientist <span class="text-danger mt-2"> *</span></label>
                        <select id="ddlScientist2" name="centerScientistId" class="form-select" required>
                            <option value='0'>Select Doctor</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="divCenterSignature" class="form-label">Center Signature</label>
                        <div id="divCenterSignature" class="flex">

                        </div>
                    </div>
                    <div class="mt-3">
                    <label for="ddlMedicalDirector" class="form-label">Medical Director <span class="text-danger mt-2"> *</span></label>
                        <select id="ddlMedicalDirector" name="rightMedicalDirectorId" class="form-select" required>
                            <option value='0'>Select Doctor</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="divRightSignature" class="form-label">Right Signature</label>
                        <div id="divRightSignature" class="flex">

                        </div>
                    </div>
</div>
</div></div>
</div>
<div class="intro-y box mt-5">
    <div id="boxed-tab" class="p-5">
        <div class="preview">
            <ul class="nav nav-boxed-tabs" role="tablist">
                <li id="tabPhysicalExamination" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-1"
                        type="button" role="tab" aria-controls="example-tab-1" aria-selected="true"> PHYSICAL
                        EXAMINATION </button>
                </li>
                <li id="tabMicroExamination" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-2"
                        type="button" role="tab" aria-controls="example-tab-2" aria-selected="false">MICROSCOPIC
                        EXAMINATION</button>
                </li>
                <li id="tabSpermMotility" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-3"
                        type="button" role="tab" aria-controls="example-tab-3" aria-selected="false">SPERM
                        MOTILITY</button>
                </li>
                <li id="tabSpermMorphology" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-4"
                        type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">SPERM
                        MORPHOLOGY</button>
                </li>
                <li id="tabCellularElements" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-5"
                        type="button" role="tab" aria-controls="example-tab-5" aria-selected="false">CELLULAR
                        ELEMENTS</button>
                </li>
            </ul>
            <div class="tab-content mt-5">
                <div id="example-tab-1" class="tab-pane leading-relaxed active" role="tabpanel"
                    aria-labelledby="tabPhysicalExamination">

                    <div>
                        <label for="ddlliquefaction" class="form-label">Liquefaction</label>
                        <select id="ddlliquefaction" name="liquefaction" class="form-select">
                            <option value='0'>Select Liquefaction</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="ddlappearance" class="form-label">Appearance</label>
                        <select id="ddlappearance" name="appearance" class="form-select">
                            <option value='0'>Select Appearance</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="ddlph" class="form-label">PH</label>
                        <select id="ddlph" name="ph" class="form-select">
                            <option value='0'>Select ph</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="txtvolume" class="form-label">Volume / Spill</label>
                        <div class="input-group">
                            <input id="txtvolume" name="volume" class="form-control" placeholder="Enter Volume / Spill"
                                aria-describedby="txtvolumeGroup">
                            <div id="txtvolumeGroup" class="input-group-text">ml</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="ddlviscosity" class="form-label">Viscosity</label>
                        <select id="ddlviscosity" name="viscosity" class="form-select">
                            <option value='0'>Select Viscosity</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="ddlabstinence" class="form-label">Abstinence</label>
                        <select id="ddlabstinence" name="abstinence" class="form-select">
                            <option value='0'>Select Abstinence</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="txtmedication" class="form-label">Medication</label>
                        <div class="input-group">
                            <input id="txtmedication" name="medication" type="textbox" placeholder="Enter Medication"
                                class="form-control" aria-describedby="txtmedicationGroup">
                            <div id="txtmedicationGroup" class="input-group-text"></div>
                        </div>
                    </div>
                </div>
                <div id="example-tab-2" class="tab-pane leading-relaxed" role="tabpanel"
                    aria-labelledby="tabMicroExamination">
                    <div class="mt-3">
                        <label for="txtspermconcentration" class="form-label">Sperm Concentration</label>
                        <div class="input-group">
                            <input id="txtspermconcentration" name="spermconcentration" class="form-control"
                                placeholder="Enter Sperm Concentration" aria-describedby="txtspermconcentrationGroup">
                            <div id="txtspermconcentrationGroup" class="input-group-text">mil/ml</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="ddlagglutination" class="form-label">Agglutination</label>
                        <select id="ddlagglutination" name="agglutination" class="form-select">
                            <option value='0'>Select Agglutination</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="ddlclumping" class="form-label">Clumping</label>
                        <select id="ddlclumping" name="clumping" class="form-select">
                            <option value='0'>Select Clumping</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="ddlgranulardebris" class="form-label">Granular Debris</label>
                        <select id="ddlgranulardebris" name="granulardebris" class="form-select">
                            <option value='0'>Select Granular Debris</option>
                        </select>
                    </div>
                </div>
                <div id="example-tab-3" class="tab-pane leading-relaxed" role="tabpanel"
                    aria-labelledby="tabSpermMotility">
                    <div class="mt-3">
                        <label for="txttotalmotility" class="form-label">Total Motility</label>
                        <div class="input-group">
                            <input id="txttotalmotility" name="totalmotility" class="form-control"
                                placeholder="Enter Motility" aria-describedby="txttotalmotilityGroup">
                            <div id="txttotalmotilityGroup" class="input-group-text">%</div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="txtrapidprogressivemovement" class="form-label">Rapid Progressive Movement</label>
                        <div class="input-group">
                            <input id="txtrapidprogressivemovement" name="rapidprogressivemovement" class="form-control"
                                placeholder="Enter Rapid Progressive Movement"
                                aria-describedby="txtrapidprogressivemovementGroup">
                            <div id="txtrapidprogressivemovementGroup" class="input-group-text">%</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="txtsluggishprogressivemovement" class="form-label">Sluggish Progressive
                            Movement</label>
                        <div class="input-group">
                            <input id="txtsluggishprogressivemovement" name="sluggishprogressivemovement"
                                class="form-control" placeholder="Enter Sluggish Progressive Movement"
                                aria-describedby="txtsluggishprogressivemovementGroup">
                            <div id="txtsluggishprogressivemovementGroup" class="input-group-text">%</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="txtnonprogressive" class="form-label">Non Progressive</label>
                        <div class="input-group">
                            <input id="txtnonprogressive" name="nonprogressive" class="form-control"
                                placeholder="Enter Non Progressive" aria-describedby="txtnonprogressiveGroup">
                            <div id="txtnonprogressiveGroup" class="input-group-text">%</div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="txtnonmotile" class="form-label">Non Motile</label>
                        <div class="input-group">
                            <input id="txtnonmotile" name="nonmotile" class="form-control"
                                placeholder="Enter Non Motile" aria-describedby="txtnonmotileGroup">
                            <div id="txtnonmotileGroup" class="input-group-text">%</div>
                        </div>
                    </div>
                </div>
                <div id="example-tab-4" class="tab-pane leading-relaxed" role="tabpanel"
                    aria-labelledby="tabSpermMorphology">
                    <div class="mt-3">
                        <label for="txtnormalsperms" class="form-label">Normal Sperms</label>
                        <div class="input-group">
                            <input id="txtnormalsperms" name="normalsperms" class="form-control"
                                placeholder="Enter Normal Sperms" aria-describedby="txtnormalspermsGroup">
                            <div id="txtnormalspermsGroup" class="input-group-text">%</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="txtheaddefects" class="form-label">Head Defects</label>
                        <div class="input-group">
                            <input id="txtheaddefects" name="headdefects" class="form-control"
                                placeholder="Enter Head Defects" aria-describedby="txtheaddefectsGroup">
                            <div id="txtheaddefectsGroup" class="input-group-text">%</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="txtneckandmidpiecedefects" class="form-label">Neck and Mid Piece Defects</label>
                        <div class="input-group">
                            <input id="txtneckandmidpiecedefects" name="neckandmidpiecedefects" class="form-control"
                                placeholder="Enter Neck and Mid Piece Defects"
                                aria-describedby="txtneckandmidpiecedefectsGroup">
                            <div id="txtneckandmidpiecedefectsGroup" class="input-group-text">%</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="txttaildefects" class="form-label">Tail Defects</label>
                        <div class="input-group">
                            <input id="txttaildefects" name="taildefects" class="form-control"
                                placeholder="Enter Tail Defects" aria-describedby="txttaildefectsGroup">
                            <div id="txttaildefectsGroup" class="input-group-text">%</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="txtcytoplasmicdroplets" class="form-label">Cytoplasmic Droplets</label>
                        <div class="input-group">
                            <input id="txtcytoplasmicdroplets" name="cytoplasmicdroplets" class="form-control"
                                placeholder="Enter Cytoplasmic Droplets" aria-describedby="txtcytoplasmicdroplets">
                            <div id="txtcytoplasmicdropletsGroup" class="input-group-text">%</div>
                        </div>
                    </div>
                </div>
               
                <div id="example-tab-5" class="tab-pane leading-relaxed" role="tabpanel"
                    aria-labelledby="tabCellularElements">
                    <div class="mt-3">
                        <label for="ddlepithelialcells" class="form-label">Epithelial Cells</label>
                        <select id="ddlepithelialcells" name="epithelialcells" class="form-select">
                            <option value='0'>Epithelial Cells</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="ddlpuscells" class="form-label">Pus Cells</label>
                        <select id="ddlpuscells" name="puscells" class="form-select">
                            <option value='0'>Pus Cells</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="txtrbc" class="form-label">Rbc</label>
                        <div class="input-group">
                            <input id="txtrbc" name="rbc" class="form-control" placeholder="Enter Rbc"
                                aria-describedby="txtrbcGroup">
                            <div id="txtrbcGroup" class="input-group-text"></div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="txtimpression" class="form-label">Impression</label>
                        <div class="input-group">
                            <input id="txtimpression" name="impression" class="form-control"
                                placeholder="Enter Impression" aria-describedby="txtimpressionGroup">
                            <div id="txtimpressionGroup" class="input-group-text"></div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="txtcomments" class="form-label">Comments</label>
                        <div class="input-group">
                            <input id="txtcomments" name="comments" class="form-control" placeholder="Enter Comments"
                                aria-describedby="txtcommentsGroup">
                            <div id="txtcommentsGroup" class="input-group-text"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

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
                    <input id="txtId" type="hidden" class="form-control"> 
                        <button  data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
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
<script type="module" src="{{ asset('dist/js/patient.js')}}"></script>
@endpush