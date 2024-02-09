@extends('layouts.main')
@section('title','Set Normal Values')
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
                    <form id="frmNormalValues">
                    <div class="intro-y box p-5 mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                                <button id="btnEditNormalValue" type=button class="btn btn-danger w-24 ml-2"><i data-lucide="edit" class="w-4 h-4 mr-2"></i>Edit</button>
                                </div>
                            </div>
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                             <input id="txtNormalValueId" name="normalValueId" value="{{ $normalValueDetails->normalValueId }}"  type="hidden"  class="form-control">
                            <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                            <input id="txtHospital" name="hospitalId" value="{{ session('hospitalId') }}" type="hidden" class="form-control">
                            <input id="txtBranch" name="branchId" value="{{ session('branchId') }}" type="hidden" class="form-control">
                   
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtliquefaction" class="form-label">LIQUEFACTION</label>
                                    <input type="text" id="txtliquefaction" name="liquefaction" value="{{ $normalValueDetails->liquefaction }}"  class="form-control" title="Please fill Margin Right" aria-describedby="txtRightGroup" disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtapperance" class="form-label">APPEARANCE </label>
                                    <input type="text" id="txtapperance" name="apperance" value="{{ $normalValueDetails->apperance }}"  class="form-control" title="Please fill Margin Left" aria-describedby="txtLeftGroup" disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtph" class="form-label">PH </label>
                                <input type="text" id="txtph" name="ph" value="{{ $normalValueDetails->ph }}"  class="form-control" title="Please fill Margin Bottom" aria-describedby="txtBottomGroup"disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtvolume" class="form-label">VOLUME / SPILL</label>
                                <input type="text" id="txtvolume" name="volume" value="{{ $normalValueDetails->volume }}" class="form-control" title="Please fill Margin Top" aria-describedby="txttopGroup" disabled /> 
                            </div>
                            
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtviscosity" class="form-label">VISCOSITY</label>
                                    <input type="text" id="txtviscosity" name="viscosity" value="{{ $normalValueDetails->viscosity }}"  class="form-control" title="Please fill Margin Right" aria-describedby="txtRightGroup" disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtabstinence" class="form-label">ABSTINENCE </label>
                                    <input type="text" id="txtabstinence" name="abstinence" value="{{ $normalValueDetails->abstinence }}"  class="form-control" title="Please fill Margin Left" aria-describedby="txtLeftGroup" disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtmedication" class="form-label">MEDICATION </label>
                                <input type="text" id="txtmedication" name="medication" value="{{ $normalValueDetails->medication }}" class="form-control" title="Please fill Margin Bottom" aria-describedby="txtBottomGroup"disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtspermConcentration" class="form-label">SPERM CONCENTRATION</label>
                                <input type="text" id="txtspermConcentration" name="spermConcentration" value="{{ $normalValueDetails->spermConcentration }}" class="form-control" title="Please fill Margin Top" aria-describedby="txttopGroup" disabled /> 
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtagglutination" class="form-label">AGGLUTINATION</label>
                                    <input type="text" id="txtagglutination" name="agglutination" value="{{ $normalValueDetails->agglutination }}" class="form-control" title="Please fill Margin Right" aria-describedby="txtRightGroup" disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtclumping" class="form-label">CLUMPING </label>
                                    <input type="text" id="txtclumping" name="clumping" value="{{ $normalValueDetails->clumping }}"  class="form-control" title="Please fill Margin Left" aria-describedby="txtLeftGroup" disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtgranularDebris" class="form-label">GRANULAR DEBRIS </label>
                                <input type="text" id="txtgranularDebris" name="granularDebris" value="{{ $normalValueDetails->granularDebris }}"  class="form-control" title="Please fill Margin Bottom" aria-describedby="txtBottomGroup"disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txttotalMotility" class="form-label">TOTAL MOTILITY</label>
                                <input type="text" id="txttotalMotility" name="totalMotility" value="{{ $normalValueDetails->totalMotility }}" class="form-control" title="Please fill Margin Top" aria-describedby="txttopGroup" disabled /> 
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtrapidProgressiveMovement" class="form-label">RAPID PROGRESSIVE MOVEMENT</label>
                                    <input type="text" id="txtrapidProgressiveMovement" name="rapidProgressiveMovement" value="{{ $normalValueDetails->rapidProgressiveMovement }}" class="form-control" title="Please fill Margin Right" aria-describedby="txtRightGroup" disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtsluggishProgressiveMovement" class="form-label">SLUGGISH PROGRESSIVE MOVEMENT </label>
                                    <input type="text" id="txtsluggishProgressiveMovement" name="sluggishProgressiveMovement" value="{{ $normalValueDetails->sluggishProgressiveMovement }}" class="form-control" title="Please fill Margin Left" aria-describedby="txtLeftGroup" disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtnonProgressive" class="form-label">NON PROGRESSIVE </label>
                                <input type="text" id="txtnonProgressive" name="nonProgressive" value="{{ $normalValueDetails->nonProgressive }}" class="form-control" title="Please fill Margin Bottom" aria-describedby="txtBottomGroup"disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtnonMotile" class="form-label">NON MOTILE</label>
                                <input type="text" id="txtnonMotile" name="nonMotile" value="{{ $normalValueDetails->nonMotile }}" class="form-control" title="Please fill Margin Top" aria-describedby="txttopGroup" disabled /> 
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtnormalSperms" class="form-label">NORMAL SPERMS</label>
                                    <input type="text" id="txtnormalSperms" name="normalSperms" value="{{ $normalValueDetails->normalSperms }}" class="form-control" title="Please fill Margin Right" aria-describedby="txtRightGroup" disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtheadDefects" class="form-label">HEAD DEFECTS</label>
                                    <input type="text" id="txtheadDefects" name="headDefects" value="{{ $normalValueDetails->headDefects }}" class="form-control" title="Please fill Margin Left" aria-describedby="txtLeftGroup" disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtneckMidPieceDefects" class="form-label">NECK AND MID PIECE DEFECTS</label>
                                <input type="text" id="txtneckMidPieceDefects" name="neckMidPieceDefects" value="{{ $normalValueDetails->neckMidPieceDefects }}"  class="form-control" title="Please fill Margin Bottom" aria-describedby="txtBottomGroup"disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txttailDeffects" class="form-label">TAIL DEFECTS</label>
                                <input type="text" id="txttailDeffects" name="tailDeffects" value="{{ $normalValueDetails->tailDeffects }}" class="form-control" title="Please fill Margin Top" aria-describedby="txttopGroup" disabled /> 
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtcytoplasmicDroplets" class="form-label">CYTOPLASMIC DROPLETS</label>
                                    <input type="text" id="txtcytoplasmicDroplets" name="cytoplasmicDroplets" value="{{ $normalValueDetails->cytoplasmicDroplets }}"  class="form-control" title="Please fill Margin Right" aria-describedby="txtRightGroup" disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtepithelialCells" class="form-label">EPITHELIAL CELLS</label>
                                    <input type="text" id="txtepithelialCells" name="epithelialCells" value="{{ $normalValueDetails->epithelialCells }}" class="form-control" title="Please fill Margin Left" aria-describedby="txtLeftGroup" disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtpusCells" class="form-label">PUS CELLS</label>
                                <input type="text" id="txtpusCells" name="pusCells" value="{{ $normalValueDetails->pusCells }}"  class="form-control" title="Please fill Margin Bottom" aria-describedby="txtBottomGroup"disabled /> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="txtRBC" class="form-label">RBC</label>
                                <input type="text" id="txtRBC" name="RBC" value="{{ $normalValueDetails->RBC }}" class="form-control" title="Please fill Margin Top" aria-describedby="txttopGroup" disabled /> 
                            </div>
                            <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <button id="btnUpdNormalValue" type=submit class="btn btn-primary w-24 ml-2"><i data-lucide="edit" class="w-4 h-4 mr-2"></i>Update</button>
                                <button id="btnCancelNormalValue" type="reset" class="btn btn-dark w-24"><i data-lucide="x-circle" class="w-4 h-4 mr-2"></i>Cancel</button> 
                            </div>
                        </div></div>
                          <!-- BEGIN: Success Modal Content --> 
        <div id="divNormalValueSuccessModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true" data-tw-backdrop="static"> 
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
 <div id="divNormalValueErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
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
<script  type="module" src="{{ asset('dist/js/semenAnalysis.js')}}"></script>
@endpush