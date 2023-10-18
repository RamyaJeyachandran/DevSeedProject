<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
            <div class="mobile-menu-bar">
                <a href="" class="flex mr-auto">
                    <img alt="SEED" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
                </a>
                <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2" class="w-8 h-8 text-white"></i> </a>
                <!-- transform -rotate-90 -->
            </div>
            <div class="scrollable">
                <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle" class="w-8 h-8 text-white"></i> </a>  
                <!-- transform -rotate-90 -->
                <ul class="scrollable__content py-2">
                <li>
                        <a  id="lnkMobileDashboard" href="{{url('Home')}}" class="menu">
                            <div class="menu__icon"> <i data-lucide="plus-square"></i> </div>
                            <div class="menu__title"> Dashboard </div>
                        </a>
                    </li>
                    <li>
                        <a id="lnkMobileHospital" href="javascript:;.html" class="menu">
                            <div class="menu__icon"> <i data-lucide="home"></i> </div>
                            <div class="menu__title"> Hospital Settings <i data-lucide="chevron-down" class="menu__sub-icon"></i> </div>
                        </a>
                        <ul id="ulMobileHospital" class="">
                            <li>
                                <a id="aMobileHospital" href="{{ url('Hospital') }}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="plus-circle"></i> </div>
                                    <div class="menu__title"> Add Hospital </div>
                                </a>
                            </li>
                            <li>
                                <a id="aMobileHpSearch" href="{{ url('SearchHospital') }}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="plus-circle"></i> </div>
                                    <div class="menu__title"> Search Hospital </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a  id="lnkMobileBranch" href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="layers"></i> </div>
                            <div class="menu__title"> Branches <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
                        </a>
                        <ul  id="ulMobileBranch" class="">
                            <li>
                                <a  id="aMobileBranch" href="{{ url('Branch') }}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="plus-circle"></i> </div>
                                    <div class="menu__title"> Add Branch</div>
                                </a>
                            </li>
                            <li>
                                <a id="aMobileBrSearch" href="{{ url('SearchBranch') }}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="search"></i> </div>
                                    <div class="menu__title"> Search Branch </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a  id="lnkMobileDoctor" href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> Doctors <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
                        </a>
                        <ul  id="ulMobileDoctor" class="">
                            <li>
                                <a  id="aMobileDoctor" href="{{ url('Doctor') }}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="plus-circle"></i> </div>
                                    <div class="menu__title"> Add Doctor</div>
                                </a>
                            </li>
                            <li>
                                <a id="aMobileDrSearch" href="{{url('SearchDoctor')}}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="search"></i> </div>
                                    <div class="menu__title"> Search Doctor </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a  id="lnkMobilePatient" href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> Patients <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
                        </a>
                        <ul  id="ulMobilePatient" class="">
                            <li>
                                <a  id="aMobilePatients" href="{{ url('Patient') }}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="plus-circle"></i> </div>
                                    <div class="menu__title"> Add Patient</div>
                                </a>
                            </li>
                            <li>
                                <a id="aMobilePatientSearch" href="{{url('SearchPatient')}}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="search"></i> </div>
                                    <div class="menu__title"> Search Patient </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a  id="lnkMobileAppointment" href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> Appointment <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
                        </a>
                        <ul  id="ulMobileAppointment" class="">
                            <li>
                                <a  id="aMobileAppointment" href="{{ url('PatientAppointment') }}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="plus-circle"></i> </div>
                                    <div class="menu__title"> Add Appointment</div>
                                </a>
                            </li>
                            <li>
                                <a id="aMobileAppointmentSearch" href="{{url('AllAppointments')}}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="search"></i> </div>
                                    <div class="menu__title"> All Appointment </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a  id="lnkMobileReport" href="{{url('subscribe')}}" class="menu">
                            <div class="menu__icon"> <i data-lucide="plus-square"></i> </div>
                            <div class="menu__title">  Report Settings </div>
                        </a>
                    </li>
                    <li>
                        <a  id="lnkMobileConsent" href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title">  Generate Consent Form  <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
                        </a>
                        <ul  id="ulMobileConsent" class="">
                            <li>
                                <a  id="aMobileConsent" href="{{ url('ConsentForm') }}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="plus-circle"></i> </div>
                                    <div class="menu__title"> Consent Form</div>
                                </a>
                            </li>
                            <li>
                                <a id="aMobilePatientConsent" href="{{url('SearchConsentForm')}}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="search"></i> </div>
                                    <div class="menu__title"> Search Consent Form </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a  id="lnkMobileSubscribe" href="{{url('subscribe')}}" class="menu">
                            <div class="menu__icon"> <i data-lucide="plus-square"></i> </div>
                            <div class="menu__title"> Subscribe </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END: Mobile Menu -->
