import xlsx from "xlsx";
import { createIcons, icons } from "lucide";
import Tabulator from "tabulator-tables";
(function () {
    "use strict";
   
    window.onbeforeunload = function() {
        window.scrollTo(0, 0);
    };
    $( "#btnScrollToTop" ).on( "click", function() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0;
    });  
    window.addEventListener("load", (e) => {
        e.preventDefault();
        var pathname = window.location.pathname;
        
        //Local Path
        var base_url = window.location.origin;
        localStorage.setItem("base_url", base_url);
        var serverPath='';
        var serverPath2='';
        
        //server Path
        //  var base_url = window.location.origin+'/seed/public';
        // localStorage.setItem("base_url", base_url);
        // var serverPath='/seed/public/index.php';
        // var serverPath2='/seed/public';
        

        if(document.getElementById("divYear")!=null)
        {
            document.getElementById("divYear").innerHTML = '@'+new Date().getFullYear() + ' Agnai Solutions';
        }
        setMenu("[id*=lnkSemen]","[id*=ulSemenAnalysis]");
        setMobileMenu("[id*=lnkMobileSemenAnalysis]","[id*=ulMobileSemenAnalysis]","[id*=aMobileSemenAnalysis]");
        switch(pathname)
        {
            case serverPath+'/PrePostAnalysis':
            case serverPath2+'/PrePostAnalysis':
                getPatientDoctor();
                loadReportSign();
                break;
            case serverPath+'/SearchPrePostAnalysis':
            case serverPath2+'/SearchPrePostAnalysis':
                $("#divDateSearch").addClass('hidden');
                $("input#tbPrePost-html-filter-value-1").hide();
                $("#tbPrePost-html-filter-value-1-label").hide();
                setPrePostWash();
                break;
        }
    });
    function setMenu($lnkControl,$ulControl){
        $($lnkControl).addClass("side-menu--active");
        $($ulControl).addClass("side-menu__sub-open");
    }
    function setMobileMenu($lnkMobile,$ulMobile,$aMobile){
        $($lnkMobile).addClass("menu--active");
        $($ulMobile).addClass("menu__sub-open");
        $($aMobile).addClass("menu--active");
    }
    // Patient change Event
    $("#ddlPatient").on('change',function() {
        var patientId=$("#ddlPatient").val();
        if(patientId!='')
        {
            var token=$('#txtToken').val();
            let options = {
                method: "GET",
                headers: {
                Accept: 'application/json',
                Authorization: 'Bearer '+token,
                },
            };
            var base_url = localStorage.getItem("base_url");
            var url = base_url + '/api/patientInfo/'+patientId;
        
            fetch(url,options)
            .then(response => response.json())
            .then(function (result) {
                var patientList=result.patientDetails;
                if(patientList!=null)
                {
                    $('#txtSpouseName').val(patientList.spouseName);
                }else{
                    $('#txtSpouseName').val("");
                }
            });
            $('#txtSequenceNo').val("");
            url = base_url + '/api/patientPrePostSequenceNo/'+patientId;
            fetch(url,options)
            .then(response => response.json())
            .then(function (result) {
                $('#txtSequenceNo').val(result.seqNo);
            });
        }
    });
    function getPatientDoctor(){       
        let ddlPatient = document.getElementById('ddlPatient');
        if(ddlPatient!==null){
        var token=$('#txtToken').val();
        let options = {
            method: "GET",
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer '+token,
              },
        };
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        var base_url = localStorage.getItem("base_url");
        var url = base_url + '/api/getPrePostPatientDoctor/'+hospitalId+"/"+branchId;
        $("#ddlPatient option").remove();
        $("#ddlPatient").append($("<option></option>").val(0).html("Select Patient"));
        fetch(url,options)
        .then(response => response.json())
        .then(function (result) {
            var patientList=result.patientList;
            if(patientList!=null)
                    {
                        patientList.forEach(function(value, key) {
                            $("#ddlPatient").append($("<option></option>").val(value.id).html(value.name)); 
                        });
                    }
            var doctorList=result.doctorList;
            if(doctorList!=null)
                {
                    doctorList.forEach(function(value, key) {
                        $("#ddlDoctor").append($("<option></option>").val(value.id).html(value.name)); 
                    });
                }
        });
    }
    }
    function loadReportSign()
{
    var token=$('#txtToken').val();
    let options = {
        method: "GET",
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    };
    var hospitalId=$('#txtHospital').val();
    var branchId=$('#txtBranch').val();
    var base_url = localStorage.getItem("base_url");
    var url = base_url + '/api/defaultReportSign/'+hospitalId+"/"+branchId;

    fetch(url,options)
    .then(response => response.json())
    .then(function (result) {
        var signatureList=result.data;
        $('#txtReportSignId').val(signatureList.id);
        $('#lblLeftSign').text('Left Signature: '+signatureList.leftDoctorName);
        $('#lblCenterSign').text('Center Signature: '+signatureList.centerDoctorName);
        $('#lblRightSign').text('Right Signature: '+signatureList.rightDoctorName);
        $(ïmgLeftSign).attr("src",signatureList.leftSign);
        $(imgCenterSign).attr("src",signatureList.centerSign);
        $(imgRightSign).attr("src",signatureList.rightSign);
    });
}
/* --------------- Pre/post Analysis Add form submit Begins ------------------------*/

const prePostanalysisform = document.getElementById('frmPrePost');
if (prePostanalysisform != null) {
    //prePost analysiscentry
    prePostanalysisform.addEventListener("submit", (e) => {
        e.preventDefault();
//         var chkStatus=1;
//         var preMotility=$('#txtMotility').val();
//         var preRapidProgressive=$('#txtRapid').val();
//         var preSlowProgressive=$('#txtSlow').val();
//         var preNonProgressive=$('#txtNonProgressive').val();
//         var preImmotile=$('#txtImmotile').val();
//         const errorModal = tailwind.Modal.getInstance(document.querySelector("#warning-modal-preview"));

//         let preLimit=preMotility/4;
//         if(preRapidProgressive>preLimit || preSlowProgressive>preLimit || preNonProgressive>preLimit || preImmotile>preLimit)
//         {
//             chkStatus=0;
//             $('#divErrorHead span').text("Validation Error");
//             $('#divErrorMsg span').text("Please the Prewash Motility,Rapid Progressive,Slow Progressive,Non-Progressive and Immotile values");
//             errorModal.show();
//         }
//         if(chkStatus==1){
//             var postMotility=$('#txtPostMotility').val();
//             var postRapidProgressive=$('#txtPostRapid').val();
//             var postSlowProgressive=$('#txtPostSlow').val();
//             var postNonProgressive=$('#txtPostNonProgressive').val();
//             var postImmotile=$('#txtPostImmotile').val();
//             let postLimit=preMotility/4;
//             if(postRapidProgressive>postLimit || postSlowProgressive>postLimit || postNonProgressive>postLimit || postImmotile>postLimit)
//             {
//                 chkStatus=0;
//                 $('#divErrorHead span').text("Validation Error");
//                 $('#divErrorMsg span').text("Please the postwash Motility,Rapid Progressive,Slow Progressive,Non-Progressive and Immotile values");
//                 errorModal.show();
//             }
//         }
// if(chkStatus==1){
        const prePostanalysisdata = new FormData(prePostanalysisform);
        const params = new URLSearchParams(prePostanalysisdata);
        params.append('seqNo', $('#txtSequenceNo').val());
        var token=$('#txtToken').val();
        let options = {
            method: "POST",
            body: params,
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer '+token,
              },
        };
        var base_url = localStorage.getItem("base_url");
        var url = base_url + '/api/addPrePostWash';
        fetch(url, options)
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.Success == 'Success') {
                    $('#divMsg span').text(data.Message);

                    if (data.ShowModal == 1) {
                        const successModal = tailwind.Modal.getInstance(document.querySelector("#success-modal-preview"));
                        prePostanalysisform.reset();
                        $('#txtId').val(data.semenId);
                        successModal.show($('#txtId').val());
                    }
                } else {
                    $('#divErrorHead span').text(data.Success);
                    $('#divErrorMsg span').text(data.Message);
                    if (data.ShowModal == 1) {
                        errorModal.show();
                    }else if(data.ShowModal==2)
                    {
                       logoutSession(data.Message);
                    }
                }
            })
            .catch(function (error) {
                $('#divErrorHead span').text('Error');
                $('#divErrorMsg span').text(error);
                errorModal.show();
            });
        window.scrollTo(0, 0);
        // }
    });
}
/* --------------- Pre/post Analysis Add form submit End ------------------------*/
/*------------------------------------------- PrePost Analysis Search BEGIN -------------------------*/ 
function setPrePostWash(){
    if ($("#tbPrePost").length) {
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        // Setup Tabulator
        var token=$('#txtToken').val();
        let table = new Tabulator("#tbPrePost", {
            ajaxURL: localStorage.getItem("base_url")+"/api/PrePostWashList",
            ajaxParams: {"hospitalId": hospitalId,"branchId":branchId},
            ajaxConfig:{
                method:"GET", //set request type to Position
                headers: {
                    "Content-type": 'application/json; charset=utf-8', //set specific content type
                    "Accept": 'application/json',
                    "Authorization": 'Bearer '+token,
                },
            },
            ajaxFiltering: true,
            ajaxSorting: true,
            printAsHtml: true,
            printStyled: true,
            pagination: "remote",
            paginationSize: 10,
            paginationSizeSelector: [10, 20, 30, 40],
            layout: "fitColumns",
            responsiveLayout: "collapse",
            placeholder: "No matching records found",
            columns: [
                {
                    formatter: "responsiveCollapse",
                    width: 40,
                    minWidth: 30,
                    hozAlign: "center",
                    resizable: false,
                    headerSort: true,
                },

                // For HTML table
                {
                    title: "DATE",
                    minWidth: 80,
                    field: "created_date",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,                    
                },{
                    title: "PATIENT S.NO",
                    minWidth: 30,
                    field: "sNo",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,                    
                },
                {
                    title: "PROFILE IMAGE",
                    minWidth: 75,
                    field: "images",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div class="flex lg:justify-center">
                            <div class="intro-x w-12 h-12 image-fit">
                                <img class="rounded-full" src="${cell.getData().profileImage}">
                            </div>
                        </div>`;
                    },
                },
                {
                    title: "PATIENT",
                    minWidth: 50,
                    field: "patientName",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div>
                            <div class="font-medium whitespace-nowrap">${
                                cell.getData().patientName
                            }</div>
                            <div class="text-slate-800 text-xs whitespace-nowrap">${
                                cell.getData().hcNo
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "PHONE NO",
                    minWidth: 100,
                    field: "phoneNo",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "DOCTOR NAME",
                    minWidth: 50,
                    field: "doctorName",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "ACTIONS",
                    minWidth: 80,
                    field: "actions",
                    responsive: 1,
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        let a =
                            $(`<div class="flex lg:justify-center items-center text-info">
                            <a class="tooltip view flex items-center mr-3 tooltip" title="Print Details" href="javascript:;">
                                <i data-lucide="printer" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="tooltip edit flex items-center mr-3 text-primary tooltip" title="Edit Details" href="javascript:;">
                                <i data-lucide="check-square" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="tooltip delete flex items-center text-danger tooltip" title="Delete Details" href="javascript:;">
                                <i data-lucide="trash-2" class="w-5 h-5 mr-1"></i> 
                            </a>
                        </div>`);
                        $(a)
                        .find(".view")
                        .on("click", function () {
                            window.location.href= localStorage.getItem("base_url")+"/PrintPrePostAnalysis/"+cell.getData().id;
                        });
                        $(a)
                            .find(".edit")
                            .on("click", function () {
                                window.location.href= localStorage.getItem("base_url")+"/ShowPrePostAnalysis/"+cell.getData().id;
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeletePrePost"));
                                deleteModal.show();
                                $('#txtId').val(cell.getData().id);
                                $( "#btnDelPrePost" ).on( "click", function() {
                                    var userId=$('#txtUser').val();
                                    deletePrePost(cell.getData().id,userId);
                                });
                            });

                        return a[0];
                    },
                },

                // For print format
                {
                    title: "DATE",
                    field: "created_date",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "PATIENT NAME",
                    field: "patientName",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "PATIENT REGISTERED NO",
                    field: "hcNo",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "PHONE NO",
                    field: "phoneNo",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "EMAIL",
                    field: "email",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "DOCTOR NAME",
                    field: "doctorName",
                    visible: false,
                    print: true,
                    download: true,
                },
            ],
            renderComplete() {
                createIcons({
                    icons,
                    "stroke-width": 1.5,
                    nameAttr: "data-lucide",
                });
            },
        });

        // Redraw table onresize
        window.addEventListener("resize", () => {
            table.redraw();
            createIcons({
                icons,
                "stroke-width": 1.5,
                nameAttr: "data-lucide",
            });
        });

        // Filter function
        function filterHTMLForm() {
            let field = $("#tbPrePost-html-filter-field").val();
            let type = $("#tbPrePost-html-filter-type").val();
            let value = $("#tbPrePost-html-filter-value").val();
            let dateValue= $("#tbPrePost-html-filter-value-1").val();
            if(field=='created_date'){
                table.setFilter(field, type, dateValue);
            }else{
                table.setFilter(field, type, value);
            }
        }

        // On submit filter form
        $("#tbPrePost-html-filter-form")[0].addEventListener(
            "keypress",
            function (event) {
                let keycode = event.keyCode ? event.keyCode : event.which;
                if (keycode == "13") {
                    event.preventDefault();
                    filterHTMLForm();
                }
            }
        );

        // On click go button
        $("#tbPrePost-html-filter-go").on("click", function (event) {
            filterHTMLForm();
        });

        // On reset filter form
        $("#tbPrePost-html-filter-reset").on("click", function (event) {
            $("#tbPrePost-html-filter-field").val("hcNo");
            $("#tbPrePost-html-filter-type").val("like");
            $("#tbPrePost-html-filter-value").val("");
            $("#tbPrePost-html-filter-value-1").val("");

            $("#divValueSearch").removeClass("hidden").removeAttr("style");
            $("input#tbPrePost-html-filter-value").show();
            $("#tbPrePost-html-filter-value-label").show();
    
            $("#divDateSearch").addClass('hidden');      
            $("input#tbPrePost-html-filter-value-1").hide();
            $("#tbPrePost-html-filter-value-1-label").hide();

            filterHTMLForm();
        });

        // Export
        $("#tbPrePost-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            table.download("xlsx", "Patients.xlsx", {
                sheetName: "PrePostWashAnalysis",
            });
        });
        // Print
        $("#tbPrePost-print").on("click", function (event) {
            table.print();
        });
    }
}
/*------------------------------------------- PrePost Search END -------------------------*/ 
$( "#tbPrePost-html-filter-field" ).on( "change", function() {
    $("#tbPrePost-html-filter-value").val("");
    $("#tbPrePost-html-filter-value-1").val("");
    var field=$( "#tbPrePost-html-filter-field" ).val();
    if(field=='created_date'){
        $("#divDateSearch").removeClass("hidden").removeAttr("style");
        $("input#tbPrePost-html-filter-value-1").show();
        $("#tbPrePost-html-filter-value-1-label").show();

        $("#divValueSearch").addClass('hidden');
        $("input#tbPrePost-html-filter-value").hide();
        $("#tbPrePost-html-filter-value-label").hide();
    }else{
        $("#divValueSearch").removeClass("hidden").removeAttr("style");
        $("input#tbPrePost-html-filter-value").show();
        $("#tbPrePost-html-filter-value-label").show();

        $("#divDateSearch").addClass('hidden');      
        $("input#tbPrePost-html-filter-value-1").hide();
        $("#tbPrePost-html-filter-value-1-label").hide();
    }
} );
/*----------------------------------- Delete Patient Semen Analysis By ID BEGINS -------------------------*/
function deletePrePost(semenId,userId){
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/deletePrePostWash/'+semenId+'/'+userId;
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divPrePostErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                if (data.ShowModal==1) {
                    const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeletePrePost"));
                    deleteModal.hide();
                    setPrePostWash();
                }                   
            }else{
                $('#divErrorHead span').text(data.Success);
                $('#divErrorMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    errorModal.show();
                }else if(data.ShowModal==2)
                {
                   logoutSession(data.Message);
                }
            }
        })
        .catch(function(error){
            $('#divErrorHead span').text('Error');
            $('#divErrorMsg span').text(error);
            errorModal.show();
        });       
}

/*----------------------------------- Delete Patient PrePost Analysis By ID END -------------------------*/
/*-----------Update PrePost analysis Begins--------------*/
const prePostEdit = document.getElementById('frmEditPrePost'); 
if (prePostEdit != null) {
    prePostEdit.addEventListener("submit", (epf) => {
        epf.preventDefault();
        const prePostanalysisdata = new FormData(prePostEdit);
        const params = new URLSearchParams(prePostanalysisdata);
        var token=$('#txtToken').val();
        let options = {
            method: "POST",
            body: params,
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer '+token,
              },
        };
        var base_url = localStorage.getItem("base_url");
        var url = base_url + '/api/updatePrePostWash';
        const errorModal = tailwind.Modal.getInstance(document.querySelector("#warning-modal-preview"));
        fetch(url, options)
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.Success == 'Success') {
                    $('#divMsg span').text(data.Message);

                    if (data.ShowModal == 1) {
                        const successEditModal = tailwind.Modal.getInstance(document.querySelector("#success-modal-preview"));
                        successEditModal.show();
                        prePostEdit.reset();
                    }
                } else {
                    $('#divErrorHead span').text(data.Success);
                    $('#divErrorMsg span').text(data.Message);
                    if (data.ShowModal == 1) {
                        errorModal.show();
                    }else if(data.ShowModal==2)
                    {
                       logoutSession(data.Message);
                    }
                }
            })
            .catch(function (error) {
                $('#divErrorHead span').text('Error');
                $('#divErrorMsg span').text(error);
                errorModal.show();
            });
    });
}
/*-------Update Ends -------*/
$( "#btnPrePostSuccess" ).on( "click", function() {
    window.scrollTo(0, 0);
    var base_url = localStorage.getItem("base_url");
    window.location.href = base_url+ "/SearchPrePostAnalysis";
});
$( "#btnPrePostPrint" ).on( "click", function() {
    window.scrollTo(0, 0);
    var id=$('#txtId').val();
    var base_url = localStorage.getItem("base_url");
    window.location.href = base_url+ "/PrintPrePostAnalysis/"+id;
});
/*---------------------- PRINT PRE & POST ANALYSIS--- BEGIN -------------------*/
$( "#btnPrintPrePostWash" ).on( "click", function() {
    var contents = $("#divPrintPrePostWash").html();
    var userId=$("#txtUser").val();
       var base_url = localStorage.getItem("base_url");
       var url=base_url+'/api/getPrintMargin/'+userId;
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
               if(data.Success=='Success'){
                   let pixelsmt = (96 * data.pageSettingsDetails.marginTop) / 2.54;
                   let pixelsmr = (96 * data.pageSettingsDetails.marginRight) / 2.54;
                   let pixelsmb = (96 * data.pageSettingsDetails.marginBottom) / 2.54;
                   let pixelsml = (96 * data.pageSettingsDetails.marginLeft) / 2.54;
                   let isHeaderDisplay=data.pageSettingsDetails.isHeaderDisplay;

                   var title='';
                   if(isHeaderDisplay==1)
                   {
                        var isHospital=data.pageSettingsDetails.isHospital;
                        var hospitalDetails=isHospital==1?data.pageSettingsDetails.hospitalAddress:data.pageSettingsDetails.branchAddress;
                        if(isHospital==1)
                        {
                            title='<center>'+hospitalDetails.hospitalName+'<br>'+hospitalDetails.address+'<br>'+hospitalDetails.email+', '+hospitalDetails.phoneNo+'</center><br>';
                        }else{
                            title='<center>'+hospitalDetails.branchName+'<br>'+hospitalDetails.address+'<br>'+hospitalDetails.email+', '+hospitalDetails.phoneNo+'</center><br>';
                        }
                   }
                   var frame1 = $('<iframe />');
                   var style='<head><style>@media print {@page {size: auto; margin: 0mm;} body{margin: '+pixelsmt+'px '+pixelsmr+'px '+pixelsmb+'px '+pixelsml+'px ;}}table { width: 100%; font-size:12px } table, th, td { border: 1px solid black;border-collapse: collapse;} img {width: 50%;height: 30%;}</style></head>';
                   frame1[0].name = "frame1";
                   frame1.css({ "position": "absolute", "top": "-1000000px" });
                   $("body").append(frame1);
                   var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
                   frameDoc.document.open();
                   //Create a new HTML document.
                   frameDoc.document.write('<html>'+style);
                   frameDoc.document.write('<body >');
                   //Append the DIV contents.
                   frameDoc.document.write(title);
                   frameDoc.document.write(contents);
                   frameDoc.document.write('</body></html>');
                   frameDoc.document.close();
                   setTimeout(function () {
                       window.frames["frame1"].focus();
                       window.frames["frame1"].print();
                       frame1.remove();
                   }, 500);
               }
           })
           .catch(function(error){
               const errorDrModal = tailwind.Modal.getInstance(document.querySelector("#divPrintPrePostErrorModal"));
               $('#divErrorHead span').text('Error');
               $('#divErrorMsg span').text(error);
               errorDrModal.show();
           });        
});
/*---------------------- PRINT PRE & POST ANALYSIS--- END -------------------*/

})();