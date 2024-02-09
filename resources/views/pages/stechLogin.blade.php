<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('dist/images/logo.svg')}}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>STECH IVF Solutions</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('dist/css/app.css')}}" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <!-- <a href="" class="-intro-x flex items-center pt-5">
                        <img alt="Agnai SEED" class="w-1/2" src="{{ asset('dist/images/stechLogo.jpeg')}}">
                        <span class="text-white text-lg ml-3"> SEED </span> 
                    </a> -->
                    <div class="my-auto">
                        <img alt="Agnai SEED" class="-intro-x w-1/2 -mt-16" src="{{ asset('dist/images/stechLogo.jpeg')}}">
                    </div>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                    <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                            Sign In
                        </h2>
                        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                      <form method="post" action='{{ url("login") }}' class="validate-form">
                      @csrf
                      <input id="txtCompany" name="companyId" value="2" type="hidden" class="form-control">
                      <div class="intro-x mt-2 xl:mt-10 text-danger dark:text-slate-500 text-center xl:text-left"> {{$errorMsg}} </div>
                        <div class="intro-x mt-8 input-form">
                            <input type="text" class="form-control" name="email" placeholder="user name" minlength="10" maxlength="100" required>
                        </div>
                        <div class="intro-x mt-8 input-form">
                            <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" name="password" minlength="5" maxlength="15" placeholder="Password" required>
                        </div>
                        <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
                            <div class="flex items-center mr-auto">
                                <input id="remember-me" type="checkbox" class="form-check-input border mr-2">
                                <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                            </div>
                            <a href='{{ url("ForgetPassword/2") }}'>Forgot Password?</a> 
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Login</button>
                        </div>
                      </form>
                      <!-- BEGIN: Success Notification Content -->
                      <div id="success-notification-content" class="toastify-content hidden flex" >
                                        <i class="text-success" data-lucide="check-circle"></i> 
                                        <div class="ml-4 mr-4">
                                            <div class="font-medium">Login success!</div>
                                        </div>
                                    </div>
                                    <!-- END: Success Notification Content -->
                      <!-- BEGIN: Failed Notification Content -->
                      <div id="failed-notification-content" class="toastify-content hidden flex" >
                                        <i class="text-danger" data-lucide="x-circle"></i> 
                                        <div class="ml-4 mr-4">
                                            <div class="font-medium">Login failed!</div>
                                            <div class="text-slate-500 mt-1"> Please enter the correct user name and password. </div>
                                        </div>
                                    </div>
                                    <!-- END: Failed Notification Content -->
                    </div>
                </div>
                <!-- END: Login Form -->
            </div>
        </div>
    </body>
</html>