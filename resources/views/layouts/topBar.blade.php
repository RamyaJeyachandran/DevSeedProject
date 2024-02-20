 <!-- BEGIN: Top Bar -->
 <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active font-medium text-base  mr-auto" aria-current="page">@yield('title')</li>
                        </ol>
                    </nav>
                    <!-- END: Breadcrumb -->
                    <!-- BEGIN: Account Menu -->
                    <div class="intro-x dropdown w-8 h-8">
                        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false" data-tw-toggle="dropdown">
                            <img src="{{ asset('dist/images/profile-5.jpg')}}">
                        </div>
                        <div class="dropdown-menu w-56">
                            <ul class="dropdown-content bg-primary text-white">
                                <li class="p-2">
                                    <a href="javascript:;.html" class="intro-x flex items-center">
                                        @if(Session::has('isDoctor') && Session::get('isDoctor'))
                                        <img class="w-10 rounded-full" src="{{ session('profileImage') }}">
                                        @endif
                                        @if(Session::has('isAdminHospitalBranch') && Session::get('isAdminHospitalBranch'))
                                        <img class="w-10 rounded-full" src="{{ session('logo') }}">
                                        @endif
                                        <span class="hidden xl:block text-white text-lg ml-3"> {{session('userName')}} </span>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider border-white/[0.08]">
                                </li>
                                @if(Session::has('isNotAdmin') && Session::get('isNotAdmin'))
                                <li>
                                    <a href="{{ url('Profile') }}/{{ session('userId')}}" class="dropdown-item hover:bg-white/5"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> Profile </a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{ url('ResetPassword') }}/{{ session('userId')}}" class="dropdown-item hover:bg-white/5"> <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>
                                </li>
                                @if(Session::has('isAdminHospital') && Session::get('isAdminHospital'))
                                @if(session('branchLimit') < 2)
                                <li>
                                    <a href="{{ url('SefDefaultHospital') }}/{{ session('userId')}}" class="dropdown-item hover:bg-white/5"> <i data-lucide="git-branch" class="w-4 h-4 mr-2"></i> Set Default Hospital </a>
                                </li>
                                @endif
                                @endif
                                <li>
                                    <a href="{{ url('ColourTheme') }}/{{ session('userId')}}" class="dropdown-item hover:bg-white/5"> <i data-lucide="zap" class="w-4 h-4 mr-2"></i>Color Theme </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider border-white/[0.08]">
                                </li>
                                <li>
                                    <a href="{{ url('logout') }}" class="dropdown-item hover:bg-white/5"> <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END: Account Menu -->
                    <input id="txtToken" value="{{ session('prjtoken') }}" type="hidden" class="form-control">
                </div>
                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <!-- END: Top Bar -->
               