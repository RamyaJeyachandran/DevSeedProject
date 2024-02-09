@extends('layouts.main')
@section('title','Doctor Information')
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
                    <form id="frmEditDoctor" method="POST" enctype="multipart/form-data">
                    <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <input id="txtUser" name="userId" value="{{ session('userId') }}" type="hidden" class="form-control">
                    <input id="txtDoctorId" name="doctorId" value="{{$doctorDetails->doctorId}}" type="hidden" class="form-control">
                    <input id="txtHospital" name="hospitalId" value="{{ $doctorDetails->hospitalId }}" type="hidden" class="form-control">
                    <input id="txtBranch" name="branchId" value="{{ $doctorDetails->branchId }}"  type="hidden" class="form-control">
                    <input id="txtdeletedSignature" name="deletedSignature" type="hidden" class="form-control">
                    <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <button id="btnEditDoctor" type=submit class="btn btn-danger w-24 ml-2"><i data-lucide="edit" class="w-4 h-4 mr-2"></i>Update</button>
                            </div>
                    <div class="intro-y col-span-12 sm:col-span-4   form-control">
                    <input id="txtImageChanged" name="isImageChanged" value="0" type="hidden" class="form-control">
                                <label for="txtProfileImage" class="form-label">Profile Image </label>
                                <div class="w-20 h-20  flex-none lg:w-32 lg:h-32 image-fit relative">
                                    <img id="imgProfileImage" class="rounded-full" src="{{$doctorDetails->profileImage}}">
                                </div>
                                <input id="txtProfileImage" name="profileImage" type="file" accept="image/*" class="form-control">
                            </div>
                            
                            <div class="intro-y col-span-12 sm:col-span-4 form-control"></div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control"></div>
                            
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtDoctorCodeNo" class="form-label">Doctor Code  <span class="text-danger mt-2"> *</span></label>
                                <input id="txtDoctorCodeNo" name="name" value="{{$doctorDetails->doctorCodeNo}}" type="text" class="form-control" disabled>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtName" class="form-label">Doctor Name <span class="text-danger mt-2"> *</span></label>
                                <input id="txtName" name="name" value="{{$doctorDetails->name}}" type="text" class="form-control" required>
                            </div>
                            
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtPhoneNo" class="form-label">Phone No <span class="text-danger mt-2"> *</span></label>
                                <input id="txtPhoneNo" value="{{$doctorDetails->phoneNo}}" name="phoneNo" type="text" class="form-control" required>
                            </div>
                            
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtEmail" class="form-label">Email Id <span class="text-danger mt-2"> *</span></label>
                                <input id="txtEmail" value="{{$doctorDetails->email}}" name="email" type="email" class="form-control" placeholder="example@gmail.com" required>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                    <label for="ddlAppointmentInterval" class="form-label">Appointment slot interval</label>
                                <select id="ddlAppointmentInterval" name="appointmentInterval" class="form-select" required>
                                    <option value='0' {{ ( '0'== $doctorDetails->appointmentInterval) ? 'selected' : '' }}>Select Appointment Interval</option>
                                    <option value='5' {{ ( '5'== $doctorDetails->appointmentInterval) ? 'selected' : '' }}>5 minutes</option>
                                    <option value='10' {{ ( '10'== $doctorDetails->appointmentInterval) ? 'selected' : '' }}>10 minutes</option>
                                    <option value='15' {{ ( '15'== $doctorDetails->appointmentInterval) ? 'selected' : '' }}>15 minutes</option>
                                    <option value='20' {{ ( '20'== $doctorDetails->appointmentInterval) ? 'selected' : '' }}>20 minutes</option>
                                    <option value='25' {{ ( '25'== $doctorDetails->appointmentInterval) ? 'selected' : '' }}>25 minutes</option>
                                    <option value='30' {{ ( '30'== $doctorDetails->appointmentInterval) ? 'selected' : '' }}>30 minutes</option>
                                    <option value='35' {{ ( '35'== $doctorDetails->appointmentInterval) ? 'selected' : '' }}>35 minutes</option>
                                    <option value='40' {{ ( '40'== $doctorDetails->appointmentInterval) ? 'selected' : '' }}>40 minutes</option>
                                    <option value='45' {{ ( '45'== $doctorDetails->appointmentInterval) ? 'selected' : '' }}>45 minutes</option>
                                    <option value='50' {{ ( '50'== $doctorDetails->appointmentInterval) ? 'selected' : '' }}>50 minutes</option>
                                    <option value='55' {{ ( '55'== $doctorDetails->appointmentInterval) ? 'selected' : '' }}>55 minutes</option>
                                    <option value='60' {{ ( '60'== $doctorDetails->appointmentInterval) ? 'selected' : '' }}>60 minutes</option>
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtDOB" class="form-label">Date of Birth</label>
                                <input id="txtDOB" value="{{$doctorDetails->dob}}"name="dob" type="text" class="datepicker form-control " data-single-mode="true"> 
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlGender" class="form-label">Gender</label>
                                <select id="ddlGender" value="{{$doctorDetails->gender}}" name="gender" class="form-select">
                                    <option value='0'>Select Gender</option>
                                    @foreach ($doctorDetails->genderList as $gender)
                                    <option value="{{ $gender->name }}" {{ ( $gender->name == $doctorDetails->gender) ? 'selected' : '' }}> 
                                        {{ $gender->name }} 
                                    </option>
                                     @endforeach 
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlBloodGrp" class="form-label">Blood Group</label>
                                <select id="ddlBloodGrp" value="{{$doctorDetails->bloodGroup}}" name="bloodGrp" class="form-select">
                                    <option value='0'>Select Blood Group</option>
                                    @foreach ($doctorDetails->bloodGrpList as $bloodGrp)
                                    <option value="{{ $bloodGrp->name }}" {{ ( $bloodGrp->name == $doctorDetails->bloodGroup) ? 'selected' : '' }}> 
                                        {{ $bloodGrp->name }} 
                                    </option>
                                     @endforeach  
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txteducation" class="form-label">Eductation</label>
                                <input id="txteducation" value="{{$doctorDetails->education}}" name="education" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtdesignation" class="form-label">Designation</label>
                                <input id="txtdesignation" value="{{$doctorDetails->designation}}" name="designation" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="ddlDepartment" class="form-label">Department</label>
                                <select id="ddlDepartment" value="{{$doctorDetails->departmentId}}" name="departmentId" class="form-select">
                                    <option value='0'>Select Department</option>
                                    @foreach ($doctorDetails->departmentList as $department)
                                    <option value="{{ $department->id }}" {{ ( $department->id == $doctorDetails->departmentId) ? 'selected' : '' }}> 
                                        {{ $department->name }} 
                                    </option>
                                     @endforeach 
                                </select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtExperience" class="form-label">Experience</label>
                                <input id="txtExperience" value="{{$doctorDetails->experience}}" name="experience" type="text" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4">
                                <label for="txtAddress" class="form-label">Address</label>
                                <textarea id="txtAddress" value="{{$doctorDetails->address}}" name="address" class="form-control" minlength="10">{{$doctorDetails->address}}</textarea>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4   form-control">
                                <input id="txtSignChanged" name="isSignChanged" value="0" type="hidden" class="form-control">
                                <label for="txtSignature" class="form-label">Signature </label>
                                <input id="txtSignature" name="signature[]" accept="image/*" type="file" class="form-control" multiple>
                            </div>
                          
                            <div class="intro-y col-span-12 sm:col-span-6 form-control">
                            <div class="overflow-x-auto">
@if($doctorDetails->signLength > 0)
   <table class="table table-striped">
     <thead>
       <tr>
         <th class="whitespace-nowrap">#</th>
         <th class="whitespace-nowrap">Signature</th>
         <th class="whitespace-nowrap">Delete</th>
       </tr>
     </thead>
     <tbody>
     @foreach ($doctorDetails->signatureList as $signature)
       <tr>
        <td class="nr">{{$signature->sNo}}
        <span class="sign-id" hidden>{{$signature->id}}</span>
        </td>
         <td>
         <div class="grid grid-cols-12">
         <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y"> <div class="box zoom-in">
         <img src="{{$signature->signature}}">
</div></div>
        </td>
         <td>
           <button class="use-sign btn btn-danger mr-1 mb-2 tooltip" title="Delete Signature" type="button">
                <i data-lucide="trash-2" class="w-5 h-5"></i>
            </button>
        </td>
       </tr>
    @endforeach 
     </tbody>
     @endif
   </table>
 </div>
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
        <div id="divSuccessEditDoctor" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true"> 
            <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                 <div id="divMsg" class="text-3xl mt-5"><span></span></div> <div id="divDoctorCodeNo" class="text-slate-500 mt-2"><span></span></div> </div>
                  <div class="px-5 pb-8 text-center"> 
                  @if(session('userType')==1 ||  session('userType')==2 ||  session('userType')==4)
                    <button id="btnDrRedirect" type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                    @else
                         <button onclick="window.location='{{ url("Profile") }}/{{ session("userId")}}'" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                    @endif
                 </div> 
                </div> 
            </div> 
        </div> 
    </div> 
<!-- END: Success Modal Content --> 

 <!-- BEGIN: Error Modal Content --> 
 <div id="divErrorEditDoctor" class="modal" tabindex="-1" aria-hidden="true"> 
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-body p-0"> 
                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i> 
                <div id="divDrErrorHead"class="text-3xl mt-5"><span></span></div> 
                <div id="divDrErrorMsg" class="text-slate-500 mt-2"><span></span></div> </div> 
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
        @endpush



