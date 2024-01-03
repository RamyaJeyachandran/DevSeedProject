<!-- BEGIN: Side Menu -->
<nav class="side-nav">
<a href="" class="intro-x flex items-center pl-5 pt-4">
    <img alt="Agnai SEED" class="w-10 rounded-full" src="{{ session('logo') }}">
    <span class="hidden xl:block text-white text-lg ml-3">@can('isAdmin') SEED @endcan @can('isNotAdmin') {{session('userName')}} @endcan</span>
</a>
<div class="side-nav__devider my-6"></div>
<ul>
<li>
    <a id="lnkDashboard" href="{{url('Home')}}" class="side-menu">
    <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
    <div class="side-menu__title"> Dashboard </div>
    </a>
    </li>
    @can('isAdmin')
    <li>
    <a id="lnkHospital" href="javascript:;.html" class="side-menu">
    <div class="side-menu__icon"> <i data-lucide="folder-plus"></i> </div>
    <div class="side-menu__title">
    Hospital Settings
    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
    </div>
    </a>
    <ul id="ulHospital" class=""> <!--side-menu__sub-open-->
        <li>
        <a href="{{ url('Hospital') }}" class="side-menu "><!-- side-menu--active -->
        <div class="side-menu__icon"> <i data-lucide="plus-circle"></i> </div>
        <div class="side-menu__title"> Add Hospital </div>
        </a>
</li>
<li>
<a href="{{ url('SearchHospital') }}" class="side-menu">
<div class="side-menu__icon"> <i data-lucide="search"></i> </div>
<div class="side-menu__title"> Search Hospital </div>
</a>
</li>
</ul>
</li>
@endcan
@can('isAdminHospital')
<li>
<a id="lnkBranch" href="javascript:;.html" class="side-menu">
    <div class="side-menu__icon"> <i data-lucide="layers"></i> </div>
    <div class="side-menu__title">
    Branches
    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
    </div>
</a>
<ul id="ulBranch" class="">
<li>
<a href="{{ url('Branch') }}" class="side-menu">
    <div class="side-menu__icon"> <i data-lucide="plus-circle"></i> </div>
    <div class="side-menu__title"> Add Branch </div>
</a>
</li>
<li>
<a href="{{ url('SearchBranch') }}" class="side-menu">
    <div class="side-menu__icon"> <i data-lucide="search"></i> </div>
    <div class="side-menu__title"> Search Branch </div>
</a>
</li>
</ul>
</li>
@endcan
@can('isAdminHospitalBranch')
<li>
    <a id="lnkDoctor" href="javascript:;" class="side-menu">
    <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
    <div class="side-menu__title">
        Doctors
        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
    </div>
    </a>
    <ul id="ulDoctor" class="">
        <li>
            <a href="{{ url('Doctor') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="plus-circle"></i> </div>
                <div class="side-menu__title"> Add Doctor </div>
            </a>
        </li>
        <li>
            <a href="{{url('SearchDoctor')}}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="search"></i> </div>
                <div class="side-menu__title"> Search Doctor </div>
            </a>
        </li>
        <li>
            <a href="{{url('AssignDoctor')}}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="user-check"></i> </div>
                <div class="side-menu__title"> Assign Doctor </div>
            </a>
        </li>        
    </ul>
</li>
@endcan
<li>
    <a id="lnkPatient" href="javascript:;.html" class="side-menu">
        <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
        <div class="side-menu__title">
            Patients
            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
        </div>
    </a>
    <ul id="ulPatient" class="">
        <li>
            <a href="{{ url('Patient') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="user-plus"></i> </div>
                <div class="side-menu__title"> Add Patient </div>
            </a>
        </li>
        <li>
            <a href="{{url('SearchPatient')}}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="search"></i> </div>
                <div class="side-menu__title"> Search Patient </div>
            </a>
        </li> 
        <li>
            <a href="{{url('RefferedBy')}}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="external-link"></i> </div>
                <div class="side-menu__title"> Reffered By </div>
            </a>
        </li>      
    </ul>
</li>
<li>
    <a id="lnkAppointment" href="javascript:;" class="side-menu">
        <div class="side-menu__icon"> <i data-lucide="calendar"></i> </div>
        <div class="side-menu__title">
            Appointment
            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
        </div>
    </a>
    <ul id="ulAppointment" class="">
        <li>
            <a href="{{ url('PatientAppointment') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="plus-circle"></i> </div>
                <div class="side-menu__title"> Add Appointment </div>
            </a>
        </li>
        <li>
            <a href="{{url('AllAppointments')}}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="search"></i> </div>
                <div class="side-menu__title"> All Appointments </div>
            </a>
        </li>
        <li>
            <a href="{{url('TodayAppointments')}}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="archive"></i> </div>
                <div class="side-menu__title"> Today Appointments </div>
            </a>
        </li>
    </ul>
</li>
<li>
@can('isNotAdmin')
<li>
    <a id="lnkSemen" href="javascript:;" class="side-menu">
        <div class="side-menu__icon"> <i data-lucide="link-2"></i> </div>
        <div class="side-menu__title">
            Semen Analysis
            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
        </div>
    </a>
    <ul id="ulSemenAnalysis" class="">
        <li>
            <a  href="{{url('SemenAnalysis')}}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="plus-circle"></i> </div>
                <div class="side-menu__title">Add Semen Analysis </div>
            </a>
        </li>
        <li>
            <a  href="{{url('SearchSemenAnalysis')}}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="search"></i> </div>
                <div class="side-menu__title"> Search Semen Analysis  </div>
            </a>
        </li>
        <li>
            <a href="{{ url('ReportSignature') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="pen-tool"></i> </div>
                <div class="side-menu__title">Report Signature</div>
            </a>
        </li>
    </ul>

</li>
@endcan
<li>
    <a id="lnkReport" href="javascript:;" class="side-menu">
        <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
        <div class="side-menu__title">
            Report 
            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
        </div>
    </a>
    <ul id="ulReport" class="">
                        <li>
                        <a id="lnkPatientReport" href="{{url('PatientReport')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                            <div class="side-menu__title"> Patient / Doctor Report </div>
                        </a>
                        </li>
                        <li>
                        <a id="lnkPatientDetails" href="{{url('PatientDetails')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="user-check"></i> </div>
                            <div class="side-menu__title"> Patient Detail Report </div>
                        </a>
                        </li>
                        </ul>

</li>
<li>
    <a id="lnkConsentForm" href="javascript:;" class="side-menu">
        <div class="side-menu__icon"> <i data-lucide="book"></i> </div>
        <div class="side-menu__title">
            Consent Form
            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
        </div>
    </a>
    <ul id="ulConsentForm" class="">
        <li>
            <a href="{{ url('ConsentForm') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="plus-circle"></i> </div>
                <div class="side-menu__title"> Generate Consent Form </div>
            </a>
        </li>
        <li>
            <a href="{{url('SearchConsent')}}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="search"></i> </div>
                <div class="side-menu__title"> Search Consent Form </div>
            </a>
        </li>
        <li>
            <a href="{{url('ViewConsent')}}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                <div class="side-menu__title"> Consent Forms </div>
            </a>
        </li>
    </ul>
</li>
<li>
    <a id="lnkDonor" href="{{url('DonorBank')}}" class="side-menu">
        <div class="side-menu__icon"> <i data-lucide="droplet"></i> </div>
        <div class="side-menu__title"> Donor Bank </div>
    </a>
</li>
<!-- @can('isAdminHospitalBranch') -->
<!-- <li>
    <a id="lnkSubscribe" href="{{url('subscribe')}}" class="side-menu">
        <div class="side-menu__icon"> <i data-lucide="plus-square"></i> </div>
        <div class="side-menu__title"> Subscribe </div>
    </a>
</li> -->
<!-- @endcan -->
@can('isNotAdmin')
<li>
    <a id="lnkPrintSettings" href="javascript:;" class="side-menu">
        <div class="side-menu__icon"> <i data-lucide="settings"></i> </div>
        <div class="side-menu__title">
            Settings
            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
        </div>
    </a>
   
    <ul id="ulPrintSettings" class="">
        <li>
            <a href="{{ url('PrintSettings') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="printer"></i> </div>
                <div class="side-menu__title"> Print Settings</div>
            </a>
        </li>      
    </ul>
</li>
@endcan

</ul>
</nav>
<!-- END: Side Menu -->