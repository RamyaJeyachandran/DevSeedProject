import xlsx from "xlsx";
import { createIcons, icons } from "lucide";
import Tabulator from "tabulator-tables";
import tippy, { roundArrow } from "tippy.js";
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
        // var base_url = window.location.origin;
        // localStorage.setItem("base_url", base_url);
        // var serverPath='';
        // var serverPath2='';

        //server Path
         var base_url = window.location.origin+'/seed/public';
        localStorage.setItem("base_url", base_url);
        var serverPath='/seed/public/index.php';
        var serverPath2='/seed/public';
       
        if(document.getElementById("divYear")!=null)
        {
            document.getElementById("divYear").innerHTML = '@'+new Date().getFullYear() + ' Agnai Solutions';
        }
       if(pathname!=serverPath2+'/SetNormalValues' && pathname!=serverPath+'/SetNormalValues')
       {
        setMenu("[id*=lnkSemen]","[id*=ulSemenAnalysis]");
        setMobileMenu("[id*=lnkMobileSemenAnalysis]","[id*=ulMobileSemenAnalysis]","[id*=aMobileSemenAnalysis]");
       }
       if(pathname.indexOf('ShowSemenAnalysis') != -1)
       {
        editImgAnalysis(base_url);
       }
        switch(pathname)
        {
            case serverPath+'/SemenAnalysis':
            case serverPath2+'/SemenAnalysis':
                semenAnalysisFormOnLoad(base_url);    
                getPatientDoctor();
                loadReportSign();    
                var $isSetImg=$("#txtIsSetImg").val();
                if($isSetImg==0)
                {
                    $("#divImageCaputre").addClass('hidden');
                }
                else{
                    $("#divImageCaputre").removeClass("hidden").removeAttr("style");
                    $("#divCaptureImage").addClass('hidden');
                    $("#btnCaptureImg").addClass('hidden');
                }
                clearLocalStorage("add_ctrl_name_list");
                break;
            case serverPath+'/SearchSemenAnalysis':
            case serverPath2+'/SearchSemenAnalysis':
                $("#divDateSearch").addClass('hidden');
                $("input#tbSemen-html-filter-value-1").hide();
                $("#tbSemen-html-filter-value-1-label").hide();
                setSemenAnalysisTabulator();
                break;
            case serverPath+'/SetNormalValues':
            case serverPath2+'/SetNormalValues':
                setMenu("[id*=lnkPrintSettings]","[id*=ulPrintSettings]");
                setMobileMenu("[id*=lnkMobilePrint]","[id*=ulMobilePrint]","[id*=aMobilePrint]");
                cancelNormalValue();
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
/*------------------------------------------- Semen Analysis Search BEGIN -------------------------*/ 
function setSemenAnalysisTabulator(){
    // Tabulator
    if ($("#tbSemen").length) {
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        // Setup Tabulator
        var token=$('#txtToken').val();
        let table = new Tabulator("#tbSemen", {
            ajaxURL: localStorage.getItem("base_url")+"/api/SemenAnalysisList",
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
                },
                {
                    title: "PATIENT REPORT S.NO",
                    minWidth: 100,
                    field: "patientSeqNo",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "PATIENT INFORMATION",
                    minWidth: 250,
                    field: "hcNo",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div class="flex lg:justify-center">
                            <div class="intro-x w-12 h-12 image-fit">
                                <img class="rounded-full" src="${cell.getData().profileImage}">
                            </div>
                        </div>
                        <div>
                        <div class="font-medium whitespace-nowrap">${
                            cell.getData().patientName
                        }</div>
                        <div class="text-slate-800 text-xs whitespace-nowrap">${
                            cell.getData().hcNo
                        }</div>
                        <div class="text-slate-800 text-xs whitespace-nowrap">${
                            cell.getData().phoneNo
                        }</div>
                        <div class="text-slate-800 text-xs whitespace-nowrap">${
                            cell.getData().email
                        }</div>
                        </div>`;
                    },
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
                            <a class="tooltip view flex items-center mr-3 tooltip" title="Print Semen Details" href="javascript:;">
                                <i data-lucide="printer" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="tooltip edit flex items-center mr-3 text-primary tooltip" title="Edit Semen Details" href="javascript:;">
                                <i data-lucide="check-square" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="tooltip delete flex items-center text-danger tooltip" title="Delete Details" href="javascript:;">
                                <i data-lucide="trash-2" class="w-5 h-5 mr-1"></i> 
                            </a>
                        </div>`);
                        $(a)
                        .find(".view")
                        .on("click", function () {
                            window.location.href= localStorage.getItem("base_url")+"/PrintSemenAnalysis/"+cell.getData().id;
                        });
                        $(a)
                            .find(".edit")
                            .on("click", function () {
                                window.location.href= localStorage.getItem("base_url")+"/ShowSemenAnalysis/"+cell.getData().id;
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeleteSemen"));
                                deleteModal.show();
                                $('#txtId').val(cell.getData().id);
                                $( "#btnDelSemen" ).on( "click", function() {
                                    var userId=$('#txtUser').val();
                                    deleteSemenAnalysis(cell.getData().id,userId);
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
            let field = $("#tbSemen-html-filter-field").val();
            let type = $("#tbSemen-html-filter-type").val();
            let value = $("#tbSemen-html-filter-value").val();
            let dateValue= $("#tbSemen-html-filter-value-1").val();
            if(field=='created_date'){
                table.setFilter(field, type, dateValue);
            }else{
                table.setFilter(field, type, value);
            }
        }

        // On submit filter form
        $("#tbSemen-html-filter-form")[0].addEventListener(
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
        $("#tbSemen-html-filter-go").on("click", function (event) {
            filterHTMLForm();
        });

        // On reset filter form
        $("#tbSemen-html-filter-reset").on("click", function (event) {
            $("#tbSemen-html-filter-field").val("hcNo");
            $("#tbSemen-html-filter-type").val("like");
            $("#tbSemen-html-filter-value").val("");
            $("#tbSemen-html-filter-value-1").val("");

            $("#divValueSearch").removeClass("hidden").removeAttr("style");
            $("input#tbSemen-html-filter-value").show();
            $("#tbSemen-html-filter-value-label").show();
    
            $("#divDateSearch").addClass('hidden');      
            $("input#tbSemen-html-filter-value-1").hide();
            $("#tbSemen-html-filter-value-1-label").hide();

            filterHTMLForm();
        });

        // Export
        $("#tbSemen-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            table.download("xlsx", "Patients.xlsx", {
                sheetName: "SemenAnalysis",
            });
        });
        // Print
        $("#tbSemen-print").on("click", function (event) {
            table.print();
        });
    }
}
/*------------------------------------------- Semen Search END -------------------------*/ 
/*---------------------- PRINT SEMEN ANALYSIS--- BEGIN -------------------*/
$( "#btnPrintSemenAnalysis" ).on( "click", function() {
    var contents = $("#divPrintSemenAnalysis").html();
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
                   var style='<head><style>@media print {@page {size: auto; margin: 0mm; } .break-before { page-break-before: always; margin: '+pixelsmt+'px '+pixelsmr+'px '+pixelsmb+'px '+pixelsml+'px ; }  body{margin: '+pixelsmt+'px '+pixelsmr+'px '+pixelsmb+'px '+pixelsml+'px ; }}table { width: 100%; font-size:12px } table, th, td { border: 1px solid black;border-collapse: collapse;} img {width: 50%;height: 30%;} .printImg {width: 100%;height: 100%;}</style></head>';
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
               const errorDrModal = tailwind.Modal.getInstance(document.querySelector("#divPrintSAErrorModal"));
               $('#divErrorHead span').text('Error');
               $('#divErrorMsg span').text(error);
               errorDrModal.show();
           });        
});
/*---------------------- PRINT SEMEN ANALYSIS--- END -------------------*/

/*-----------------------------------EDIT SEMEN ANALYSIS ----------------BEGIN------------------------- */
$( "#btnSemenAnalysisSuccess" ).on( "click", function() {
    window.scrollTo(0, 0);
    var base_url = localStorage.getItem("base_url");
    window.location.href = base_url+ "/SearchSemenAnalysis";
});
$( "#btnSemenSuccessPrint" ).on( "click", function() {
    window.scrollTo(0, 0);
    var id=$('#txtId').val();
    var base_url = localStorage.getItem("base_url");
    window.location.href = base_url+ "/PrintSemenAnalysis/"+id;
});
$("#ddlScientist1").on('change',function() {
    getSignatureValue('ddlScientist1','divLeftSignature','ddlLeftSignDoctorId','leftsigndoctorId');
});
$("#ddlScientist2").on('change',function() {
    getSignatureValue('ddlScientist2','divCenterSignature','ddlCenterSignDoctorId','centersigndoctorId');
});
$("#ddlMedicalDirector").on('change',function() {
    getSignatureValue('ddlMedicalDirector','divRightSignature','ddlRightSignDoctorId','rightsigndoctorId');
});
function getSignatureValue(ddlCtrl,divName,ddlSignCtrl,ddlSignCtrlName){
    var base_url = localStorage.getItem("base_url");
    var doctorId=$("#"+ddlCtrl).val();
    var url = base_url + '/api/doctorSignature/'+doctorId;
    var token=$('#txtToken').val();
    //Load Dropdowns
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    fetch(url,options)
    .then(response => response.json())
    .then(function (result) {
        var signatureList=result.signatureDetails;
        var divSignature="";
        signatureList.forEach(function(value, key) {
            divSignature=divSignature+"<div class='w-24 h-24 relative image-fit mb-5 mr-5'><img class='rounded-md' src='"+value.signature+"'>";
            divSignature=divSignature+"<div title='Select this signature' class='tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2'><input id='"+ddlSignCtrl+value.sNo+"' class='form-check-input' type='radio' name='"+ddlSignCtrlName+"' value='"+value.id+"'>  </div></div>";
        });
        document.getElementById(divName).innerHTML=divSignature;
    });
}
/*-----------Update Semen analysis Begins--------------*/
const semenanalysiseditform = document.getElementById('frmEditSemenAnalysis'); 
if (semenanalysiseditform != null) {
    semenanalysiseditform.addEventListener("submit", (epf) => {
        epf.preventDefault();
        const semenanalysisdata = new FormData(semenanalysiseditform);
        const params = new URLSearchParams(semenanalysisdata);
        /** Add capture image to form data */
        if (localStorage.getItem("ctrl_name_list") !== null)
        {
            var newImg="";
            var ctrl_name_list=localStorage.getItem("ctrl_name_list");
            let get_ctrl_name = JSON.parse(ctrl_name_list);
            get_ctrl_name.forEach(delCtrlName => {
                var img_data=localStorage.getItem(delCtrlName);
                if(newImg.length !== 0 )
                {
                    newImg=newImg +"@" +img_data;
                }
                else{
                    newImg=img_data;
                }
            });
            params.append("newAnalysisImage", newImg);
        }
        /** End  Add capture image to form data */

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
        var url = base_url + '/api/updateSemenAnalysis';
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
                        document.getElementById("frmEditSemenAnalysis").reset();
                        clearLocalStorage("ctrl_name_list");
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
/*----------------------------EDIT SEMEN ANALYSIS ----------------END------------------------- */

/*-----------------------------------ADD SEMEN ANALYSIS ----------------BEGIN------------------------- */
function semenAnalysisFormOnLoad(base_url) {
    var token=$('#txtToken').val();
    let options = {
        method: "GET",
        headers: {
           Accept: 'application/json',
           Authorization: 'Bearer '+token,
         },
    };
    var url = base_url + '/api/getSemenAnalysisCommonData';
    fetch(url, options)
        .then(response => response.json())
        .then(function (result) {
            //liquefaction
            var listliquefaction = result.liquefaction;
            listliquefaction.forEach(function (value, key) {
                $("#ddlliquefaction").append($("<option></option>").val(value.name).html(value.name));
            });
            //apperance
            var listappearance = result.appearance;
            listappearance.forEach(function (value, key) {
                $("#ddlappearance").append($("<option></option>").val(value.name).html(value.name));
            });

            //ph
            var listph = result.ph;
            listph.forEach(function (value, key) {
                $("#ddlph").append($("<option></option>").val(value.name).html(value.name));
            });
            //viscosity

            var listviscosity = result.viscosity;
            listviscosity.forEach(function (value, key) {
                $("#ddlviscosity").append($("<option></option>").val(value.name).html(value.name));
            });
            //abstinence         
            var listabstinence = result.abstinence;
            listabstinence.forEach(function (value, key) {
                $("#ddlabstinence").append($("<option></option>").val(value.name).html(value.name));
            });
            //agglutination & granulardebris
            var listagglutination = result.agglutination;
            listagglutination.forEach(function (value, key) {
                $("#ddlagglutination").append($("<option></option>").val(value.name).html(value.name));
                $("#ddlgranulardebris").append($("<option></option>").val(value.name).html(value.name));

            });
            //clumping & epithelialcells
            var listclumping = result.clumping;
            listclumping.forEach(function (value, key) {
                $("#ddlclumping").append($("<option></option>").val(value.name).html(value.name));
                $("#ddlepithelialcells").append($("<option></option>").val(value.name).html(value.name));

            });
            //pusCells
            var listpusCells = result.pusCells;
            listpusCells.forEach(function (value, key) {
                $("#ddlpuscells").append($("<option></option>").val(value.name).html(value.name))
            });

        });
// Patient change Event
        $("#ddlPatient").on('change',function() {
            var base_url = localStorage.getItem("base_url");
            var patientId=$("#ddlPatient").val();
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
            url = base_url + '/api/patientSemenSequenceNo/'+patientId;
            fetch(url,options)
            .then(response => response.json())
            .then(function (result) {
                $('#txtSequenceNo').val(result.seqNo);
            });
        });
}
/* --------------- Semen Analysis Add form submit Begins ------------------------*/

const semenanalysisform = document.getElementById('frmSemenAnalysis');
if (semenanalysisform != null) {
    //Semen analysiscentry
    semenanalysisform.addEventListener("submit", (e) => {
        e.preventDefault();
        const semenanalysisdata = new FormData(semenanalysisform);
        const params = new URLSearchParams(semenanalysisdata);
        params.append('seqNo', $('#txtSequenceNo').val());
        /** Add capture image to form data */
        if (localStorage.getItem("add_ctrl_name_list") !== null)
        {
            var newImg="";
            var ctrl_name_list=localStorage.getItem("add_ctrl_name_list");
            let get_ctrl_name = JSON.parse(ctrl_name_list);
            if(get_ctrl_name !== null)
            {
                get_ctrl_name.forEach(delCtrlName => {
                    var img_data=localStorage.getItem(delCtrlName);
                    if(newImg.length !== 0 )
                    {
                        newImg=newImg +"@" +img_data;
                    }
                    else{
                        newImg=img_data;
                    }
                });
            }
            params.append("analysisImage", newImg);
        }
        /** End  Add capture image to form data */
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
        var url = base_url + '/api/addSemenAnalysis';
        const errorModal = tailwind.Modal.getInstance(document.querySelector("#warning-modal-preview"));
        fetch(url, options)
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.Success == 'Success') {
                    $('#divMsg span').text(data.Message);

                    if (data.ShowModal == 1) {
                        const successModal = tailwind.Modal.getInstance(document.querySelector("#success-modal-preview"));
                        document.getElementById("frmSemenAnalysis").reset();
                        clearImageCapture();
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
    });

}
/* --------------- Semen Analysis Add form submit End ------------------------*/
/* Get Patient and Doctor for Semen Analysis -- BEGIN */
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
    var url = base_url + '/api/getPatientDoctor/'+hospitalId+"/"+branchId;
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
/*-----------------------------------ADD SEMEN ANALYSIS ----------------END------------------------- */

/*---------- Normal value BEGIN----------- */
function cancelNormalValue(){
    document.getElementById('btnEditNormalValue').style.visibility ="visible";
    document.getElementById("btnUpdNormalValue").style.visibility = "hidden";
    document.getElementById("btnCancelNormalValue").style.visibility ="hidden";

    document.getElementById('txtliquefaction').disabled = true;
    document.getElementById('txtapperance').disabled = true;
    document.getElementById('txtph').disabled = true;
    document.getElementById('txtvolume').disabled = true;

    document.getElementById('txtviscosity').disabled = true;
    document.getElementById('txtabstinence').disabled = true;
    document.getElementById('txtmedication').disabled = true;
    document.getElementById('txtspermConcentration').disabled = true;

    document.getElementById('txtagglutination').disabled = true;
    document.getElementById('txtclumping').disabled = true;
    document.getElementById('txtgranularDebris').disabled = true;
    document.getElementById('txttotalMotility').disabled = true;

    document.getElementById('txtrapidProgressiveMovement').disabled = true;
    document.getElementById('txtsluggishProgressiveMovement').disabled = true;
    document.getElementById('txtnonProgressive').disabled = true;
    document.getElementById('txtnonMotile').disabled = true;

    document.getElementById('txtnormalSperms').disabled = true;
    document.getElementById('txtheadDefects').disabled = true;
    document.getElementById('txtneckMidPieceDefects').disabled = true;
    document.getElementById('txttailDeffects').disabled = true;

    document.getElementById('txtcytoplasmicDroplets').disabled = true;
    document.getElementById('txtepithelialCells').disabled = true;
    document.getElementById('txtpusCells').disabled = true;
    document.getElementById('txtRBC').disabled = true;
    window.scrollTo(0, 0);
}
$( "#btnEditNormalValue" ).on( "click", function() {
    document.getElementById('btnEditNormalValue').style.visibility ="hidden";
    document.getElementById("btnUpdNormalValue").style.visibility = "visible";
    document.getElementById("btnCancelNormalValue").style.visibility ="visible";

    document.getElementById('txtliquefaction').disabled = false;
    document.getElementById('txtapperance').disabled = false;
    document.getElementById('txtph').disabled = false;
    document.getElementById('txtvolume').disabled = false;

    document.getElementById('txtviscosity').disabled = false;
    document.getElementById('txtabstinence').disabled = false;
    document.getElementById('txtmedication').disabled = false;
    document.getElementById('txtspermConcentration').disabled = false;

    document.getElementById('txtagglutination').disabled = false;
    document.getElementById('txtclumping').disabled = false;
    document.getElementById('txtgranularDebris').disabled = false;
    document.getElementById('txttotalMotility').disabled = false;

    document.getElementById('txtrapidProgressiveMovement').disabled = false;
    document.getElementById('txtsluggishProgressiveMovement').disabled = false;
    document.getElementById('txtnonProgressive').disabled = false;
    document.getElementById('txtnonMotile').disabled = false;

    document.getElementById('txtnormalSperms').disabled = false;
    document.getElementById('txtheadDefects').disabled = false;
    document.getElementById('txtneckMidPieceDefects').disabled = false;
    document.getElementById('txttailDeffects').disabled = false;

    document.getElementById('txtcytoplasmicDroplets').disabled = false;
    document.getElementById('txtepithelialCells').disabled = false;
    document.getElementById('txtpusCells').disabled = false;
    document.getElementById('txtRBC').disabled = false;
});
$( "#btnCancelNormalValue" ).on( "click", function() {
    cancelNormalValue();
});
/* Save normal values */
const normalValueForm = document.getElementById('frmNormalValues');
if(normalValueForm!=null){
normalValueForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const printSettingdata = new FormData(normalValueForm);
     var token=$('#txtToken').val();
    let options = {
        method: "POST",
        body: printSettingdata,
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    };
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/updateNormalValues';
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divNormalValueErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $('#divMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    const successModal = tailwind.Modal.getInstance(document.querySelector("#divNormalValueSuccessModal"));
                    successModal.show();    
                    cancelNormalValue();
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
});
}

/*---------- Normal value END----------- */
$( "#tbSemen-html-filter-field" ).on( "change", function() {
    $("#tbSemen-html-filter-value").val("");
    $("#tbSemen-html-filter-value-1").val("");
    var field=$( "#tbSemen-html-filter-field" ).val();
    if(field=='created_date'){
        $("#divDateSearch").removeClass("hidden").removeAttr("style");
        $("input#tbSemen-html-filter-value-1").show();
        $("#tbSemen-html-filter-value-1-label").show();

        $("#divValueSearch").addClass('hidden');
        $("input#tbSemen-html-filter-value").hide();
        $("#tbSemen-html-filter-value-label").hide();
    }else{
        $("#divValueSearch").removeClass("hidden").removeAttr("style");
        $("input#tbSemen-html-filter-value").show();
        $("#tbSemen-html-filter-value-label").show();

        $("#divDateSearch").addClass('hidden');      
        $("input#tbSemen-html-filter-value-1").hide();
        $("#tbSemen-html-filter-value-1-label").hide();
    }
} );
/*----------------------------------- Delete Patient Semen Analysis By ID BEGINS -------------------------*/
function deleteSemenAnalysis(semenId,userId){
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/deleteSemenAnalysis/'+semenId+'/'+userId;
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divSemenErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                if (data.ShowModal==1) {
                    const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeleteSemen"));
                    deleteModal.hide();
                    setSemenAnalysisTabulator();
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

/*----------------------------------- Delete Patient Semen Analysis By ID END -------------------------*/
$( "#btnOnCam" ).on( "click", function() {
    Webcam.set({
        width: 250,
        height: 200,
        image_format: 'jpeg',
        jpeg_quality: 90
    });            
    Webcam.attach( '#my_camera' );
    $("#btnCaptureImg").removeClass("hidden").removeAttr("style");
    $("#divCaptureImage").removeClass('hidden').removeAttr("style");
    $("#btnOnCam").addClass('hidden');
});  
$( "#btnCaptureImg" ).on( "click", function() {
    Webcam.snap( function(data_uri) {
        var id=$("#txtImgCount").val();
        var ctrl_name='divImgDel'+id;
        var div_ctrl='divImgView'+id;
        var divDisplayImg_data='<div id="'+div_ctrl+'" class="col-span-5 md:col-span-2 h-28 relative image-fit cursor-pointer"><img class="rounded-md" alt="SEED" src="'+data_uri+'"><div id="'+ctrl_name+'" title="Remove this image?" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x w-4 h-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>  </div></div>';
        $('#divDisplayImg').append(divDisplayImg_data);
        /** Store data in local storage */
        var store_data=div_ctrl+'@'+data_uri;
        localStorage.setItem(ctrl_name, store_data);
        if (localStorage.getItem("add_ctrl_name_list") === null) {
            var ctrl_name_list =[ctrl_name];
            let store_ctrl_name = JSON.stringify(ctrl_name_list);
            localStorage.setItem("add_ctrl_name_list", store_ctrl_name);
        }else{
            var ctrl_name_list=localStorage.getItem("add_ctrl_name_list");
            let get_ctrl_name = JSON.parse(ctrl_name_list);
            get_ctrl_name.push(ctrl_name);
            let store_ctrl_name = JSON.stringify(get_ctrl_name);
            localStorage.setItem("add_ctrl_name_list", store_ctrl_name);
        }

        id=parseInt(id)+1;
        $("#txtImgCount").val(id);
        
        /**Remove Captured images */
        $( "#"+ctrl_name ).on( "click", function() {
            var ctrl_data=localStorage.getItem(ctrl_name);
            const img_array=ctrl_data.split("@");
            if(img_array.length>0)
            {
                var del_div_ctrl=img_array[0];
                $( "#"+del_div_ctrl ).remove();
                localStorage.removeItem(ctrl_name);
                var get_ctrl=localStorage.getItem("add_ctrl_name_list");
                let get_ctrl_name = JSON.parse(get_ctrl)
                var delete_ctrl_index=get_ctrl_name.findIndex((list_ctrlName) => list_ctrlName === ctrl_name); 
                get_ctrl_name.splice(delete_ctrl_index, 1); 
                let store_ctrl_name = JSON.stringify(get_ctrl_name);
                localStorage.setItem("add_ctrl_name_list", store_ctrl_name);
            }
        });

        let options = {
            content: $('#'+ctrl_name).attr("title"),
        };
        tippy($('#'+ctrl_name), {
            arrow: roundArrow,
            animation: "shift-away",
            ...options,
        });
    });
});

$( "#btnCancelanalysis" ).on( "click", function() {
    clearImageCapture();
});
function clearImageCapture()
{
    document.getElementById('divDisplayImg').innerHTML="";
    $("#btnOnCam").removeClass("hidden").removeAttr("style");
    $("#btnCaptureImg").addClass('hidden');
    $("txtImgCount").val('0');
    $("#divCaptureImage").addClass('hidden');
    Webcam.reset( function() {
    });
}
$( "#btnEditOnCam" ).on( "click", function() {
    Webcam.set({
        width: 250,
        height: 200,
        image_format: 'jpeg',
        jpeg_quality: 90
    });            
    Webcam.attach( '#edit_my_camera' );
    $("#btnEditCaptureImg").removeClass("hidden").removeAttr("style");
    $("#divEditCaptureImage").removeClass('hidden').removeAttr("style");
    $("#btnEditOnCam").addClass('hidden');
});
$( "#btnEditCaptureImg" ).on( "click", function() {
    Webcam.snap( function(data_uri) {
        var id=$("#txtEditImgCount").val();
        var ctrl_name='divEditImgDel'+id;
        var div_ctrl='divEditImgView'+id;
        var divDisplayImg_data='<div id="'+div_ctrl+'" class="col-span-5 md:col-span-2 h-28 relative image-fit cursor-pointer"><img class="rounded-md" alt="SEED" src="'+data_uri+'"><div id="'+ctrl_name+'" title="Remove this image?" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x w-4 h-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>  </div></div>';
        $('#divEditDisplayImg').append(divDisplayImg_data);
        var store_data=div_ctrl+'@'+data_uri;
        /** Store in local storage  */
        localStorage.setItem(ctrl_name, store_data);
        if (localStorage.getItem("ctrl_name_list") === null) {
            var ctrl_name_list =[ctrl_name];
            let store_ctrl_name = JSON.stringify(ctrl_name_list);
            localStorage.setItem("ctrl_name_list", store_ctrl_name);
        }else{
            var ctrl_name_list=localStorage.getItem("ctrl_name_list");
            let get_ctrl_name = JSON.parse(ctrl_name_list);
            get_ctrl_name.push(ctrl_name);
            let store_ctrl_name = JSON.stringify(get_ctrl_name);
            localStorage.setItem("ctrl_name_list", store_ctrl_name);
        }
        $("#txtEditImgCount").val(parseInt(id)+1);

        /**Remove Captured images */
        $( "#"+ctrl_name ).on( "click", function() {
            var ctrl_data=localStorage.getItem(ctrl_name);
            const img_array=ctrl_data.split("@");
            if(img_array.length>0)
            {
                var del_div_ctrl=img_array[0];
                $( "#"+del_div_ctrl ).remove();
                localStorage.removeItem(ctrl_name);
                var get_ctrl=localStorage.getItem("ctrl_name_list");
                let get_ctrl_name = JSON.parse(get_ctrl)
                var delete_ctrl_index=get_ctrl_name.findIndex((list_ctrlName) => list_ctrlName === ctrl_name); 
                get_ctrl_name.splice(delete_ctrl_index, 1); 
                let store_ctrl_name = JSON.stringify(get_ctrl_name);
                localStorage.setItem("ctrl_name_list", store_ctrl_name);
            }
        });

        let options = {
            content: $('#'+ctrl_name).attr("title"),
        };
        tippy($('#'+ctrl_name), {
            arrow: roundArrow,
            animation: "shift-away",
            ...options,
        });
    });
});
function clearLocalStorage(storage_name)
{
    if (localStorage.getItem(storage_name) !== null) {
        var ctrl_name_list=localStorage.getItem(storage_name);
        let get_ctrl_name = JSON.parse(ctrl_name_list);
        if(get_ctrl_name!==null)
        {
            get_ctrl_name.forEach(delCtrlName => {
                localStorage.removeItem(delCtrlName);
            });
        }
    }
    localStorage.removeItem(storage_name);
}
function editImgAnalysis(base_url)
{
    clearLocalStorage("ctrl_name_list");
    var semenId=$("#txtSemenAnalysisId").val();
    var url = base_url + '/api/analysisImages/'+semenId;
    var token=$('#txtToken').val();
    //Load Dropdowns
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    fetch(url,options)
    .then(response => response.json())
    .then(function (result) {
        var imgList=result.analysisImg;
        var img_index=0;
        imgList.forEach(function(value, key) {
            var ctrl_name='divEditImgDel'+img_index;
            var div_ctrl='divEditImgView'+img_index;
            var txt_ctrl='txtAnalysisImgId'+img_index;
            var divDisplayImg_data='<div id="'+div_ctrl+'" class="col-span-5 md:col-span-2 h-28 relative image-fit cursor-pointer"><img class="rounded-md" alt="SEED" src="'+value.imageFile+'"><div id="'+ctrl_name+'" title="Remove this image?" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x w-4 h-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>  </div></div>';
            var txtId='<input id="'+txt_ctrl+'" value="'+value.id+'" type="hidden" class="form-control">';
            $('#divEditDisplayImg').append(divDisplayImg_data);
            $('#divEditDisplayImg').append(txtId);
            localStorage.setItem(ctrl_name, div_ctrl);

            /**Remove Captured images */
        $( "#"+ctrl_name ).on( "click", function() {
            var div_ctrl=localStorage.getItem(ctrl_name);
            let matches = div_ctrl.match(/(\d+)/);
            if (matches) {
                var deleteId=(parseInt(matches[0]));
                let delAnalysisImg=$("#txtDelAnalysisImage").val();
                let imgId=$("#txtAnalysisImgId"+deleteId).val();
                if(delAnalysisImg.length !== 0 )
                {
                    delAnalysisImg=delAnalysisImg+","+imgId;
                }else{
                    delAnalysisImg=imgId;
                }
                $("#txtDelAnalysisImage").val(delAnalysisImg);
            }
            $( "#"+div_ctrl ).remove();
            localStorage.removeItem(ctrl_name);
        });
            img_index++;
        });
    });
}
})();