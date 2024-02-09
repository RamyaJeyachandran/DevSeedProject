    <div id="ddlMainChat" class="dropdown inline-block fixed bottom-0 right-0 box  border rounded-full  w-12 h-12 flex items-center justify-center z-50 mb-10 mr-10" data-tw-placement="right-end"> 
        <button id="btnChatGPT" class="dropdown-toggle btn btn-primary border rounded-full " aria-expanded="false" data-tw-toggle="dropdown">
            <i id='iMsgIcon' data-lucide="message-circle" class="w-8 h-8"></i> 
        </button> 
        <div class="dropdown-menu"> 
        <div class="dropdown-header box" >
                <div class="flex flex-col sm:flex-row border-b border-slate-200/60 dark:border-darkmode-400 px-5 py-4 bg-primary text-white">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 sm:w-12 sm:h-12 flex-none image-fit relative">
                                        <img alt="SEED IUI Software" class="w-10 rounded-full" src="{{ asset('dist/images/logo.svg') }}">
                                        </div>
                                        <div class="ml-3 mr-auto">
                                            <div class="font-medium text-white">SEED IUI</div>
                                            <div class="text-white text-xs sm:text-sm">Your virtual assistant</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center sm:ml-auto mt-5 sm:mt-0 border-t sm:border-0 border-slate-200/60 pt-3 sm:pt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                                        <a id="btnClose" href="javascript:;" class="w-5 h-5 text-white ml-5"> <i data-lucide="x" class="w-5 h-5"></i> </a>
                                    </div>
                                </div>
<!-- </div>  -->
            <div id="divChatContent" class="dropdown-content overflow-y-auto" style="height:350px;width:350px"> 
       
                              <!-- BEGIN: Chat Content -->
                        <div class="chat__box box">
                            <!-- BEGIN: Chat Active -->
                            <div class="h-full flex flex-col">
                                <div id="divChatContentDetails" class="overflow-y-scroll scrollbar-hidden px-5 pt-5 flex-1">
                                   
                                </div>
                                <div id="divLoading" class="chat__box__text-box hidden flex items-end float-left mb-4"><div class="w-10 h-10 hidden sm:block flex-none image-fit relative mr-5">
                                    <img alt="SEED" class="rounded-full" src="{{asset('dist/images/profile-6.jpg')}}"></div><div class="bg-slate-100 dark:bg-darkmode-400 px-4 py-3 text-slate-500 rounded-r-md rounded-t-md"><span class="typing-dots ml-1"> <span>.</span> <span>.</span> <span>.</span> </span></div></div>

                            </div>
                            <!-- END: Chat Active -->
                        </div>
                    </div>
                    <!-- END: Chat Content -->
                    <div class="pt-4 pb-10 sm:py-4 flex items-center border-t border-slate-200/60 dark:border-darkmode-400">
                                    <textarea id='txtChat' class="chat__box__input form-control dark:bg-darkmode-600 h-16 resize-none border-transparent px-5 py-3 shadow-none focus:border-transparent focus:ring-0" rows="1" placeholder="Type your message..."></textarea>
                                    <a id="lnkSend" href="javascript:;" class="w-8 h-8 sm:w-10 sm:h-10 block bg-primary text-white rounded-full flex-none flex items-center justify-center mr-5"> <i data-lucide="send" class="w-4 h-4"></i> </a>
                                    </div>
                                    
                                </div>
            </div>
            <!-- END: Content -->
       
            </div> 
        </div> 
    </div> 