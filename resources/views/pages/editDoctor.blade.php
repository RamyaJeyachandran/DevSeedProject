@extends('layouts.main')
@section('title','Doctor Information')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />

@endsection 
@section('content')
    @include('layouts.mobileSideMenu')
    <div class="flex mt-[4.7rem] md:mt-0">
    @can('isAdmin')
            @include('layouts.sideMenu')
        @endcan
        @can('isHospital')
            @include('layouts.hospitalSideMenu')
        @endcan
        @can('isBranch')
            @include('layouts.branchSideMenu')
        @endcan
        @can('isDoctor')
            @include('layouts.doctorSideMenu')
        @endcan
                <!-- BEGIN: Content -->
                <div class="content">
                    @include('layouts.topBar')
                    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                        <button onclick="window.location='{{ url("Doctor") }}'" class="btn btn-primary shadow-md mr-2">Add Doctor</button>
                        <button onclick="window.location='{{ url("SearchDoctor") }}'" class="btn btn-dark shadow-md mr-2">Go Back</button>
                    </div>
                    <form id="frmEditDoctor" method="POST" enctype="multipart/form-data">
                    <div class="intro-y box p-5 mt-5">
                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <input id="txtUser" name="userId" value="1" type="hidden" class="form-control">
                    <input id="txtDoctorId" name="doctorId" value="{{$doctorDetails->doctorId}}" type="hidden" class="form-control">
                    <input id="txtHospital" name="hospitalId" value="{{ $doctorDetails->hospitalId }}" type="hidden" class="form-control">
                    <input id="txtBranch" name="branchId" value="{{ $doctorDetails->branchId }}"  type="hidden" class="form-control">
                    <div class="intro-y col-span-12 sm:col-span-4   form-control">
                    <input id="txtImageChanged" name="isImageChanged" value="0" type="hidden" class="form-control">
                                <label for="txtProfileImage" class="form-label">Profile Image </label>
                                <div class="w-20 h-20  flex-none lg:w-32 lg:h-32 image-fit relative">
                                    <img id="imgProfileImage" class="rounded-full" src="{{$doctorDetails->profileImage}}">
                                </div>
                                <input id="txtProfileImage" name="profileImage" type="file" accept="image/*" class="form-control">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-4 form-control">
                                <label for="txtSignature" class="form-label">Doctor Signature </label>
                                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                    <img id="imgSignature" class="rounded-full" src="{{$doctorDetails->signature}}">
                                </div>
                                <input id="txtSignature" name="signature" accept="image/*" type="file" class="form-control">
                            </div>
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
                                                       
                            <div class="intro-y col-span-12 justify-center sm:justify-end mt-5">
                                <button id="btnEditDoctor" type=submit class="btn btn-primary w-24 ml-2">Update</button>
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
                  <div class="px-5 pb-8 text-center"> <button id="btnDrRedirect" type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
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



