<!DOCTYPE html>
<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('dist/images/logo.svg')}}" rel="shortcut icon">
        <title>Forget Password</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('dist/css/app.css')}}" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Register Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a href="" class="-intro-x flex items-center pt-5">
                        @if($companyId==1)
                        <img alt="SEED" class="w-6" src="{{ asset('dist/images/logo.svg')}}">
                        <span class="text-white text-lg ml-3"> SEED </span> 
                        @endif
                    </a>
                    <div class="my-auto">
                    <img alt="Agnai SEED" class="-intro-x w-1/2 -mt-16" src="{{$logo}}">
                    </div>
                </div>
                <!-- END: Register Info -->
                <!-- BEGIN: Register Form -->
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                    <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                        <form id="frmForgetPassword">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                           Forget Password
                        </h2>
                        <div class="intro-x mt-8">
                        <input id="txtCompany" name="companyId" value="2" type="hidden" class="form-control">
                            <input id="txtEmail" name="emailId" type="email" class="intro-x login__input form-control py-3 px-4 block" placeholder="example@gmail.com">
                            <input id="txtPassword" name="newPassword" type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="New Password">
                            <input id="txtConfirmPassword" name="confirmPassword" type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Confirm Password">
                        </div>
                        
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button type="submit" class="btn btn-primary align-top">Reset Password</button>
                            <a href='{{$companyId==2 ? url("/stech") : url("/") }}' class="btn btn-outline-secondary  align-top">Sign in</a>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- END: Register Form -->
            </div>
        </div>
        <!-- BEGIN: Success Modal Content --> 
        <div id="divForgetPassSuccessModal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true" data-tw-backdrop="static"> 
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
 <div id="divForgetPassErrorModal" class="modal" tabindex="-1" aria-hidden="true"> 
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
        <!-- BEGIN: JS Assets-->
        <script src="{{ asset('dist/js/app.js')}}"></script>
        <script  type="module" src="{{ asset('dist/js/forgetPassword.js')}}"></script>
        <!-- END: JS Assets-->
    </body>
</html>
