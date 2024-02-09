@extends('layouts.main')
@section('title','Print Pre & Post Wash Analysis')
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
                        <button id="btnPrintPrePostWash" type="button" class="btn btn-danger shadow-md mr-2"><i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print</button>
                        <div class="dropdown ml-auto sm:ml-0">
                        <button onclick="window.location='{{ url("PrePostAnalysis") }}'" class="btn btn-primary shadow-md mr-2">
                        <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i>Add Pre & Post Wash Analysis
                        </button>
                        <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                        </div>
                    </div>
                </div>
                
    <div  class="intro-y box mt-5">
                       
    <div class="intro-y box overflow-hidden mt-5">
        <!-- <center><p class="p-5 text-lg font-bold">SEMEN ANALYSIS REPORT</p> </center> -->
    <div id="divPrintPrePostWash" class="px-5 sm:px-16 py-10 sm:py-20">
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
                        <td colspan="3"><center><p><b>PREWASH</b></p></center></td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p class="font-bold">DESCRIPTION</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                            <p class="font-bold">RESULT / OBSERVATION</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>VOLUME</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->volume}} ml</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>VISCOSITY</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->viscosity}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>LIQUEFACTION</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                            <p>{{$analysisDetails->liquefaction}} minutes</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>PH</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->ph}}</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td valign="top" width="50%">
                            <p>WBC</p>
                        </td>
                        <td valign="top" width="50%" colspan="2"> 
                        <p>{{$analysisDetails->wbc}} million</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>SPERM CONCENTRATION</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->preSpermConcentration}} million</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>SPERM COUNT</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->preSpermCount}} million/ml</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>MOTILITY</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->preMotility}} %</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>RAPID PROGRESSIVE (A)</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->preRapidProgressive}} %</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>SLOW PROGRESSIVE (B)</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->preSlowProgressive}} %</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>NON-PROGRESSIVE (C)</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->preNonProgressive}} %</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>IMMOTILE (D)</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->preImmotile}} %</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%" >
                            <p>METHOD USED</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->methodUsed}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>MEDIA</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->media}}</p>
                        </td>
                    </tr>
                <!-- </table>
                <br>
                <table class="table table-bordered">
                <tbody> -->
                    <tr>
                        <td colspan="3"><center><p><b><br>POSTWASH</b></p></center></td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p class="font-bold">DESCRIPTION</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                            <p class="font-bold">RESULT / OBSERVATION</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>COUNT IN 0.5 ml</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->countInMl}} million/ml</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>MOTILITY</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->postMotility}} %</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>RAPID PROGRESSIVE (A)</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->postRapidProgressive}} %</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>SLOW PROGRESSIVE (B)</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->postSlowProgressive}} %</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>NON-PROGRESSIVE (C)</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->postNonProgressive}} %</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="50%">
                            <p>IMMOTILE (D)</p>
                        </td>
                        <td valign="top" width="50%" colspan="2">
                        <p>{{$analysisDetails->postImmotile}} %</p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" colspan="3">
                            <p>IMPRESSION</p><br>
                        <p>{{$analysisDetails->impression}}</p>
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
   <div id="divPrintPrePostErrorModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true"> 
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
<script type="module" src="{{ asset('dist/js/prePost.js')}}"></script>
@endpush