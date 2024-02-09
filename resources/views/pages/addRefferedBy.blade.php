@extends('layouts.main')
@section('title','Patient Reffered By')
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
                    <form id="frmRefferedBy">
                    <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    
                    <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                    <input id="txtPatientId" name="patientId" value="{{$patientDetails->patientId}}" type="hidden" class="form-control">
                    
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlRefferedBy" class="form-label">Reffered By  <span class="text-danger mt-2"> *</span></label>
                                <select id="ddlRefferedBy" name="refferedByDoctorId" class="form-select" required>
                                    <option value='0'>Select Doctor</option>
                                    @foreach ($patientDetails->refferedByList as $refferedBy)
                                    <option value="{{ $refferedBy->id }}" {{ ( $refferedBy->id == $patientDetails->refferedByDoctorId) ? 'selected' : '' }}> 
                                        {{ $refferedBy->name }} 
                                    </option>
                                    @endforeach   
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlWitnessHospital" class="form-label">Witness from Hospital</label>
                                <select id="ddlWitnessHospital" name="witnessHospitalId" class="form-select">
                                    <option value='0'>Select Witness</option>
                                    @foreach ($patientDetails->refferedByList as $witnessHospital)
                                    <option value="{{ $witnessHospital->id }}" {{ ( $witnessHospital->id == $patientDetails->witnessHospitalId) ? 'selected' : '' }}> 
                                        {{ $witnessHospital->name }} 
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlWitnessBank" class="form-label">Witness from Bank</label>
                                <select id="ddlWitnessBank" name="witnessBankId" class="form-select">
                                    <option value='0'>Select Witness</option>
                                    @foreach ($patientDetails->bankWitnessList as $witnessBank)
                                    <option value="{{ $witnessBank->id }}" {{ ( $witnessBank->id == $patientDetails->witnessBankId) ? 'selected' : '' }}> 
                                        {{ $witnessBank->name.'- '.$witnessBank->hospitalName}} 
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlDonorBank" class="form-label">Donor Bank</label>
                                <select id="ddlDonorBank" name="donorBankId" class="form-select">
                                    <option value='0'>Select Donor Bank</option>
                                    @foreach ($patientDetails->donorBankList as $donorBank)
                                    <option value="{{ $donorBank->id }}" {{ ( $donorBank->id == $patientDetails->donorBankId) ? 'selected' : '' }}> 
                                        {{ $donorBank->name }} 
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <button id="btnSaveRefferedBy" type=submit class="btn btn-primary w-24 ml-2">Save</button>
                                <button id="btnCancelRefferedBy" type="reset" class="btn btn-dark w-24">Cancel</button> 
                            </div>
                        </div></div></div>
                        </div></div>
                        </form>
                      
                      <div id="failed-notification-content" class="toastify-content hidden flex" >
                                        <i class="text-danger" data-lucide="x-circle"></i> 
                                        <div class="ml-4 mr-4">
                                            <div class="font-medium">Error</div>
                                            <div class="text-slate-500 mt-1"> Please enter the required field marked as *. </div>
                                        </div>
                                    </div>
                                    <!-- END: Failed Notification Content -->
</div>
                <!-- END: Content -->
    </div>
    <!-- BEGIN: Success Modal Content --> 
        <div id="divRefferedBySuccessModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true" data-tw-backdrop="static"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divMsg" class="text-3xl mt-5"><span></span></div> </div>
                  <div class="px-5 pb-8 text-center"> <button id="btnRefRedirect" type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 
 <!-- BEGIN: Error Modal Content --> 
 <div id="divRefferedByErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
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
        <script type="module" src="{{ asset('dist/js/app.js')}}"></script>
        <script  type="module" src="{{ asset('dist/js/patient.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        @endpush



