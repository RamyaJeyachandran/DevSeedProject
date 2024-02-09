import { createIcons, icons } from "lucide";
(function () {
    "use strict";
    window.addEventListener("load", (e) => {
        e.preventDefault();
        loadChatHistory();
    });
    function loadChatHistory(){
        var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/chatHistory';
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success')
            {
                if(data.chatHistory!=null)
                {
                    // var imgLocation="http://127.0.0.1:8000/dist/images/logo.svg";
                    var imgLocation="https://agnaisolutions.com/seed/public//dist/images/logo.svg";
                    var sendImgLocation=$('#imgSideMenu').attr('src');
                    var chatHistory=data.chatHistory;
                    console.log(chatHistory);
                    chatHistory.forEach(function(value, key) {
                        var divClear='<div class="clear-both"></div>';
                        if(value.sNo==1)
                        {
                            var divChatDate='<div class="text-slate-400 dark:text-slate-500 text-xs text-center mb-10 mt-5">'+value.created_date+'</div>';
                            $('#divChatContentDetails').append(divChatDate);
                        }
                        var sendMsg=value.sendMsg;
                        var divSendContent='<div class="chat__box__text-box flex items-end float-left mb-4"><div class="w-10 h-10 hidden sm:block flex-none image-fit relative bg-primary rounded-full mr-5"><img alt="SEED IUI Software" class="rounded-full" src="'+sendImgLocation+'"></div><div class="bg-slate-100 dark:bg-darkmode-400 px-4 py-3 text-slate-500 rounded-r-md rounded-t-md">'+sendMsg+' <div class="mt-1 text-xs text-slate-500">'+value.created_time+'</div></div></div>';
                        $('#divChatContentDetails').append(divSendContent);
                        $('#divChatContentDetails').append(divClear);

                        var replyMsg=value.replyMsg;
                        var divReplyContent='<div class="chat__box__text-box flex items-end float-right mb-4"><div class="bg-primary px-4 py-3 text-white rounded-l-md rounded-t-md">'+replyMsg+'<div class="mt-1 text-xs text-white text-opacity-80">'+value.created_time+'</div></div><div class="w-10 h-10 hidden sm:block flex-none image-fit relative bg-primary rounded-full ml-5"><img alt="SEED IUI Software" class="rounded-full" src="'+imgLocation+'"></div></div>';
                        $('#divChatContentDetails').append(divReplyContent);
                        $('#divChatContentDetails').append(divClear);
                    });
                }
            }
        });
        var messageBody = document.querySelector('#divChatContent');
       messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;
    }
    $( "#lnkSend" ).on( "click", function() {
        $("#divLoading").removeClass("hidden").removeAttr("style");

        var sendMsg=$('#txtChat').val();
        var messageBody = document.querySelector('#divChatContent');
        // var imgLocation="http://127.0.0.1:8000/dist/images/logo.svg";
        var imgLocation="https://agnaisolutions.com/seed/public//dist/images/logo.svg";
        var sendImgLocation=$('#imgSideMenu').attr('src');
       var divSendContent='<div class="chat__box__text-box flex items-end float-left mb-4"><div class="w-10 h-10 hidden sm:block flex-none image-fit relative bg-primary rounded-full mr-5"><img alt="SEED IUI Software" class="rounded-full" src="'+sendImgLocation+'"></div><div class="bg-slate-100 dark:bg-darkmode-400 px-4 py-3 text-slate-500 rounded-r-md rounded-t-md">'+sendMsg+'</div></div>';
       var divClear='<div class="clear-both"></div>';
       $('#txtChat').val('');
       $('#divChatContentDetails').append(divSendContent);
       $('#divChatContentDetails').append(divClear);

    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/chat/'+sendMsg;
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success')
            {
                var replyMsg=data.chatReply;
                var divReplyContent='<div class="chat__box__text-box flex items-end float-right mb-4"><div class="bg-primary px-4 py-3 text-white rounded-l-md rounded-t-md">'+replyMsg+'</div><div class="w-10 h-10 hidden sm:block flex-none image-fit relative bg-primary rounded-full ml-5"><img alt="SEED IUI Software" class="rounded-full" src="'+imgLocation+'"></div></div>';
                var divChatDate='<div class="text-slate-400 dark:text-slate-500 text-xs text-center mb-10 mt-5">@date</div>';
                $('#divChatContentDetails').append(divReplyContent);
                $('#divChatContentDetails').append(divClear);
                $("#divLoading").addClass('hidden');
                messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;
            }
        });
       messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;
    });

    $( "#btnClose" ).on( "click", function() {
        const el = document.querySelector("#ddlMainChat"); 
        const dropdown = tailwind.Dropdown.getOrCreateInstance(el); 
        dropdown.hide(); 
   });
})();