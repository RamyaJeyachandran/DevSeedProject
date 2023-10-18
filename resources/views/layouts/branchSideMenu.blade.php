            <!-- BEGIN: Side Menu -->
            <nav class="side-nav">
                <a href="" class="intro-x flex items-center pl-5 pt-4">
                    <img alt="Agnai SEED" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
                    <span class="hidden xl:block text-white text-lg ml-3"> SEED </span> 
                </a>
                <div class="side-nav__devider my-6"></div>
                <ul>
                <li>
                        <a id="lnkDashboard" href="{{url('Home')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="plus-square"></i> </div>
                            <div class="side-menu__title"> Dashboard </div>
                        </a>
                    </li>
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
                        </ul>
                    </li>
                    <li>
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
                                    <div class="side-menu__icon"> <i data-lucide="plus-circle"></i> </div>
                                    <div class="side-menu__title"> Add Patient </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('SearchPatient')}}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-lucide="search"></i> </div>
                                    <div class="side-menu__title"> Search Patient </div>
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
                        </ul>
                    </li>
                    <li>
                
                    <li>
                        <a href="{{url('reportSA')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="settings"></i> </div>
                            <div class="side-menu__title"> Report Settings </div>
                        </a>
                    </li>
                    <li><li>
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
                </ul>
            </nav>
            <!-- END: Side Menu -->
       