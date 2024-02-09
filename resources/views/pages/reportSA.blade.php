@extends('layouts.main')
@section('title','Print Semen Analysis')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" /> @endsection @section('content')
    @include('layouts.mobileSideMenu') <div class="flex mt-[4.7rem] md:mt-0">
@include('layouts.sideMenu')
<!-- BEGIN: Content -->
<div class="content">
    @include('layouts.topBar')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">
                    </h2>
                    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                        <button id="btnPrintSemenAnalysis" type="button" class="btn btn-danger shadow-md mr-2"><i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print</button>
                        <div class="dropdown ml-auto sm:ml-0">
                        <button onclick="window.location='{{ url("SemenAnalysis") }}'" class="btn btn-primary shadow-md mr-2">
                        <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i> Add Semen Analysis
                        </button>
                        <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                        </div>
                    </div>
                </div>
                
    <div  class="intro-y box mt-5">
                       
    <div class="intro-y box overflow-hidden mt-5">
        <!-- <center><p class="p-5 text-lg font-bold">SEMEN ANALYSIS REPORT</p> </center> -->
    <div id="divPrintSemenAnalysis" class="px-5 sm:px-16 py-10 sm:py-20">
            <div class="overflow-x-auto">
            <table  class="table table-bordered">
                <tbody> <tr> <td valign="top" width="60">
                    <p class="font-bold">Name </p>
                            <p>{{$analysisDetails->name}}</p>
                                </td>
                        <td valign="top" width="61">
                            <p class="font-bold">Patient#  </p>
                            <p>{{$analysisDetails->hcNo}}</p>
                                </td>
                        <td valign="top" width="10">
                            <p class="font-bold">AGE </p>
                            <p>{{$analysisDetails->age}}</p>
                        </td>
                        <td valign="top" width="61">
                            <p class="font-bold">Gender </p>
                            <p>{{$analysisDetails->gender}}</p>
                        </td>
                        <td valign="top" width="61">
                            <p class="font-bold">Spouse Name</p>
                            <p>{{$analysisDetails->spouseName}}</p>
                        </td>
                        <td valign="top" width="61">
                            <p class="font-bold">Date </p>
                            <p>{{$analysisDetails->created_date}}</p>
                        </td>
                        <td valign="top" width="61">
                            <p class="font-bold">Prescribed By </p>
                            <p>{{$analysisDetails->doctorName}}</p>
                        </td>
                        </tr>
                        </tbody>
            </table>
           <br>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td valign="top" width="200">
                            <p>&nbsp;</p>
                        </td>
                        <td valign="top" width="150">
                            <p class="font-bold">Result</p>
                        </td>
                        <td valign="top" width="150">
                            <p class="font-bold">Normal Range</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" valign="top" width="601">
                            <p class="font-bold">PHYSICAL EXAMINATION</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>LIQUEFACTION</p>
                        </td>
                        <td valign="top" width="150">
                            <p>{{$analysisDetails->liquefaction}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->liquefaction}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>APPEARANCE</p>
                        </td>
                        <td valign="top" width="150">
                            <p>{{$analysisDetails->appearance}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->apperance}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>PH</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->ph}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->ph}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>VOLUME / SPILL</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->volume}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->volume}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>VISCOSITY</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->viscosity}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->viscosity}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>ABSTINENCE</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->abstinence}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->abstinence}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>MEDICATION</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->medication}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->medication}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" valign="top" width="601">
                            <p class="font-bold">MICROSCOPIC EXAMINATION</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>SPERM CONCENTRATION</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->spermconcentration}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->spermConcentration}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>AGGLUTINATION</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->agglutination}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->agglutination}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>CLUMPING</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->clumping}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->clumping}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>GRANULAR DEBRIS</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->granulardebris}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->granularDebris}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" valign="top" width="601">
                            <p class="font-bold">SPERM MOTILITY</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>TOTAL MOTILITY</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->totalmotility}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->totalMotility}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>RAPID PROGRESSIVE MOVEMENT</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->rapidprogressivemovement}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->rapidProgressiveMovement}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>SLUGGISH PROGRESSIVE MOVEMENT</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->sluggishprogressivemovement}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->sluggishProgressiveMovement}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>NON PROGRESSIVE</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->nonprogressive}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->nonProgressive}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>NON MOTILE</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->nonmotile}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->nonMotile}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" valign="top" width="601">
                            <p class="font-bold">SPERM MORPHOLOGY</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>NORMAL SPERMS</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalsperms}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->normalSperms}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>HEAD DEFECTS</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->headdefects}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->headDefects}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>NECK AND MID PIECE DEFECTS</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->neckandmidpiecedefects}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->neckMidPieceDefects}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>TAIL DEFECTS</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->taildefects}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->tailDeffects}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>CYTOPLASMIC DROPLETS</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->cytoplasmicdroplets}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->cytoplasmicDroplets}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" valign="top" width="601">
                            <p class="font-bold">CELLULAR ELEMENTS</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>EPITHELIAL CELLS</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->epithelialcells}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->epithelialCells}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>PUS CELLS</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->puscells}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->pusCells}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>RBC</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->rbc}}</p>
                        </td>
                        <td valign="top" width="150">
                        <p>{{$analysisDetails->normalValues->RBC}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>IMPRESSION</p>
                        </td>
                        <td colspan="2" valign="top" width="150">
                        <p>{{$analysisDetails->impression}}</p>
                        </td>                        
                    </tr>
                    <tr>
                        <td valign="top" width="200">
                            <p>COMMENTS</p>
                        </td>
                        <td colspan="2" valign="top" width="150">
                        <p>{{$analysisDetails->comments}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50" Height="50">
                            <p class="uppercase font-bold">Scientist</p>
                            @if($analysisDetails->leftSignature != '')
                            <img class="rounded-full image-fit" src="{{$analysisDetails->leftSignature}}">
                            <p>{{$analysisDetails->leftDoctor}}</p>
                            @endif
                        </td>
                        <td valign="top" width="50" Height="50">
                            <p class="uppercase font-bold">Scientist</p>
                            @if($analysisDetails->centerSignature != '')
                            <img class="rounded-full image-fit" src="{{$analysisDetails->centerSignature}}">
                            <p>{{$analysisDetails->centerDoctor}}</p>
                            @endif
                        </td>
                        <td valign="top" width="50" Height="50">
                            <p class="uppercase font-bold">Medical Director</p>
                            @if($analysisDetails->rightSignature != '')
                            <img class="rounded-full image-fit" src="{{$analysisDetails->rightSignature}}">
                            <p>{{$analysisDetails->rightDoctor}}</p>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
</div>
</div>
</div>
</div>
</div>

</div>
   <!-- BEGIN: Error Modal Content --> 
   <div id="divPrintSAErrorModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true"> 
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
@endsection

@push('js')
<script src="{{ asset('dist/js/app.js')}}"></script>
<script type="module" src="{{ asset('dist/js/semenAnalysis.js')}}"></script>
@endpush