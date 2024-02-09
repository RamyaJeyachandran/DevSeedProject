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
    function logoutSession(msg)
    {
        var base_url = localStorage.getItem("base_url");
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0;
        window.location.href = base_url+ "/login/"+msg;
    }
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
        switch(pathname)
        {
            case serverPath+'/PrintSettings':
            case serverPath2+'/PrintSettings':
                setMenu("[id*=lnkPrintSettings]","[id*=ulPrintSettings]");
                setMobileMenu("[id*=lnkMobilePrint]","[id*=ulMobilePrint]","[id*=aMobilePrint]");
                cancelPrintSettings();
                break;
            case serverPath+'/ReportSignature':
            case serverPath2+'/ReportSignature':
                setMenu("[id*=lnkSemen]","[id*=ulSemenAnalysis]");
                setMobileMenu("[id*=lnkMobileSemenAnalysis]","[id*=ulMobileSemenAnalysis]","[id*=aMobileReportSign]");
                loadDepartment(base_url);
                listReportSignature();
                break;
            case serverPath+'/ImageCaptureSettings':
            case serverPath2+'/ImageCaptureSettings':
                setMenu("[id*=lnkPrintSettings]","[id*=ulPrintSettings]");
                setMobileMenu("[id*=lnkMobilePrint]","[id*=ulMobilePrint]","[id*=aMobilePrint]");
                break;
            case serverPath+'/BankWitness':
            case serverPath2+'/BankWitness':
                setMenu("[id*=lnkDonor]","[id*=ulDonor]");
                setMobileMenu("[id*=lnkMobileDonor]","[id*=ulMobileDonor]","[id*=aMobileDonor]");
                setWitness();
                break;
        }
        return;
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
    

    /*----------------------------- Print Settings BEGIN ---------------------------- */
$( "#btnEditPrintSetting" ).on( "click", function() {
    document.getElementById('btnEditPrintSetting').style.visibility ="hidden";
    document.getElementById("btnUpdPrintSetting").style.visibility = "visible";
    document.getElementById("btnCancelPrintSetting").style.visibility ="visible";

    document.getElementById('txtMarginRight').disabled = false;
    document.getElementById('txtMarginLeft').disabled = false;
    document.getElementById('txtMarginBottom').disabled = false;
    document.getElementById('txtMarginTop').disabled = false;
    document.getElementById('chkHeader').disabled = false;
});
$( "#btnCancelPrintSetting" ).on( "click", function() {
    cancelPrintSettings();
});
function cancelPrintSettings(){
    document.getElementById('btnEditPrintSetting').style.visibility ="visible";
    document.getElementById("btnUpdPrintSetting").style.visibility = "hidden";
    document.getElementById("btnCancelPrintSetting").style.visibility ="hidden";

    document.getElementById('txtMarginRight').disabled = true;
    document.getElementById('txtMarginLeft').disabled = true;
    document.getElementById('txtMarginBottom').disabled = true;
    document.getElementById('txtMarginTop').disabled = true;
    document.getElementById('chkHeader').disabled = true;
}
const printSettingForm = document.getElementById('frmPrintSettings');
if(printSettingForm!=null){
printSettingForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const printSettingdata = new FormData(printSettingForm);
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
    var url=base_url+'/api/updatePageSettings';
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divPrintSetErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $('#divMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    const successModal = tailwind.Modal.getInstance(document.querySelector("#divPrintSetSuccessModal"));
                    successModal.show();    
                    cancelPrintSettings();
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
/*----------------------------- Print Settings END ---------------------------- */


/*-------------------COLOUR THEME ------- BEGIN---------------- */
$( "#btnColorPreview" ).on( "click", function() {
    var newColor=$('#txtColor').val();
    let body=document.querySelector('body');
    body.style.backgroundColor=newColor;

    let button=document.getElementById('btnColorPreview');
    button.style.backgroundColor=newColor;

    let footer=document.getElementById('divFooter');
    footer.style.backgroundColor=newColor;

    let scroll=document.getElementById('btnScrollToTop');
    scroll.style.backgroundColor=newColor;
    
});
/* Update color  */
const colorform = document.getElementById('frmColor');
if(colorform!=null){
    colorform.addEventListener("submit", (epf) => {
    epf.preventDefault();
     const labstaffdata = new FormData(colorform);
     var token=$('#txtToken').val();
     let options = {
         method: "POST",
         body: labstaffdata,
         headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
     };
     
     var base_url = localStorage.getItem("base_url");
     var url=base_url+'/api/colorTheme';
     const errorModal = tailwind.Modal.getInstance(document.querySelector("#divColorErrorModal"));
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             if(data.Success=='Success'){
                 $('#divMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    const successEditModal = tailwind.Modal.getInstance(document.querySelector("#divColorSuccessModal"));
                     successEditModal.show();    
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
$( "#btnColorSuccess" ).on( "click", function() {
    window.scrollTo(0, 0);
    location.reload(true);
});
/*-------------------COLOUR THEME ------- END----------------- */

/*------------------------------REPORT SIGNATURE --------BEGIN ------------------------- */
// on load list the department and doctor
function loadDepartment(base_url){
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    var url=base_url+'/api/departmentList';
    var hospitalId=$('#txtHospital').val();
    var branchId=$('#txtBranch').val();
    fetch(url,options)
            .then(response => response.json())
            .then(function (result) {
                if(result.Success=='Success'){
                    var listDepartment=result.departmentList;
                    listDepartment.forEach(function(value, key) {
                        $("#ddlDepartmentLeft").append($("<option></option>").val(value.id).html(value.name)); 
                        $("#ddlDepartmentRight").append($("<option></option>").val(value.id).html(value.name)); 
                        $("#ddlDepartmentcenter").append($("<option></option>").val(value.id).html(value.name)); 
                    });
                    var deptId=$("#ddlDepartmentLeft").val();
                    var doctorUrl=base_url+'/api/doctorByDepartment/'+hospitalId+'/'+branchId+'/'+deptId;
                    fetch(doctorUrl,options)
                    .then(response => response.json())
                    .then(function (result) {
                        var listDoctor=result.doctorList;
                        listDoctor.forEach(function(value, key) {
                            $("#ddlDoctorLeft").append($("<option></option>").val(value.id).html(value.name)); 
                            $("#ddlDoctorRight").append($("<option></option>").val(value.id).html(value.name)); 
                            $("#ddlDoctorcenter").append($("<option></option>").val(value.id).html(value.name)); 
                        });
                    });  
                }
            });         
   
}
$("#ddlDepartmentLeft").on('change',function() {
    loadDoctorByDepartment("#ddlDepartmentLeft","#ddlDoctorLeft","divLeftSignature");
 });  
 $("#ddlDepartmentRight").on('change',function() {
    loadDoctorByDepartment("#ddlDepartmentRight","#ddlDoctorRight","divRightSignature");
 }); 
 $("#ddlDepartmentcenter").on('change',function() {
    loadDoctorByDepartment("#ddlDepartmentcenter","#ddlDoctorcenter","divcenterSignature");
 });  
 function loadDoctorByDepartment(departmentCtrlId,doctorCtrlId,divSignCtrl)
 {
    var departmentId=$(departmentCtrlId).val();
    var hospitalId=$('#txtHospital').val();
    var branchId=$('#txtBranch').val();
    var base_url = localStorage.getItem("base_url");
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    };
    var doctorUrl=base_url+'/api/doctorByDepartment/'+hospitalId+'/'+branchId+'/'+departmentId;
    fetch(doctorUrl,options)
            .then(response => response.json())
            .then(function (result) {
                if(result.Success=='Success'){
                    $(doctorCtrlId+" option").remove();
                    $(doctorCtrlId).append($("<option></option>").val(0).html("Select Doctor"));
                    var listDoctor=result.doctorList;
                    listDoctor.forEach(function(value, key) {
                        $(doctorCtrlId).append($("<option></option>").val(value.id).html(value.name)); 
                    });
                }
            }); 
    document.getElementById(divSignCtrl).innerHTML=""; 
 } 
 $("#ddlDoctorLeft").on('change',function() {
    getSignatureValue('ddlDoctorLeft','divLeftSignature','ddlLeftSignId','leftSignId',0,0);
 });  
 $("#ddlDoctorRight").on('change',function() {
    getSignatureValue('ddlDoctorRight','divRightSignature','ddlRightSignId','rightSignId',0,0);
 });  
 $("#ddlDoctorcenter").on('change',function() {
    getSignatureValue('ddlDoctorcenter','divcenterSignature','ddlcenterSignId','centerSignId',0,0);
 });  
 function getSignatureValue(ddlCtrl,divName,ddlSignCtrl,ddlSignCtrlName,isSelected,id){
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
    };
    fetch(url,options)
    .then(response => response.json())
    .then(function (result) {
        var signatureList=result.signatureDetails;
        var divSignature="";
        signatureList.forEach(function(value, key) {
            divSignature=divSignature+"<div class='w-24 h-24 relative image-fit mb-5 mr-5'><img class='rounded-md' src='"+value.signature+"'>";
            if(isSelected==0){
                divSignature=divSignature+"<div title='Select this signature' class='tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2'><input id='"+ddlSignCtrl+value.sNo+"' class='form-check-input' type='radio' name='"+ddlSignCtrlName+"' value='"+value.id+"'>  </div></div>";
            }else{
                divSignature=divSignature+"<div title='Select this signature' class='tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2'><input id='"+ddlSignCtrl+value.sNo+"' class='form-check-input' type='radio' name='"+ddlSignCtrlName+"' value='"+value.id+"' "+(value.id==id?"checked":"")+">  </div></div>";
            }
        });
        document.getElementById(divName).innerHTML=divSignature;
    });
}
function listReportSignature(){
    // Tabulator
    if ($("#tbReportSign").length) {
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        // Setup Tabulator
        var token=$('#txtToken').val();
        let table = new Tabulator("#tbReportSign", {
            ajaxURL: localStorage.getItem("base_url")+"/api/reportSignatureList",
            ajaxParams: {"hospitalId": hospitalId,"branchId":branchId},
            ajaxConfig:{
                method:"GET", //set request type to Position
                headers: {
                    "Content-type": 'application/json; charset=utf-8', //set specific content type
                    "Accept": 'application/json',
                    "Authorization": 'Bearer '+token,
                },
            },
            ajaxFiltering: false,
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
                    headerSort: false,
                },

                // For HTML table
                {
                    title: "LEFT SIGNATURE",
                    minWidth: 200,
                    field: "name",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div class="flex lg:justify-left">
                            <div class="intro-x w-32 h-20  image-fit">
                                <img class="rounded-full" src="${cell.getData().leftSign}">
                            </div>
                        </div>
                        <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"></div>
                        <div>
                            <div class="font-medium whitespace-nowrap">${
                                cell.getData().leftDoctorName
                            }</div>
                            <div class="text-slate-800 text-xs whitespace-nowrap">${
                                cell.getData().leftdoctorCodeNo
                            }</div>
                        </div>
                        `;
                    },
                },
                {
                    title: "RIGHT SIGNATURE",
                    minWidth: 200,
                    field: "rightDoctorName",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div class="flex lg:justify-left">
                            <div class="intro-x w-32 h-20  image-fit">
                                <img class="rounded-full" src="${cell.getData().rightSign}">
                            </div>
                        </div>
                        <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"></div>
                        <div>
                            <div class="font-medium whitespace-nowrap">${
                                cell.getData().rightDoctorName
                            }</div>
                            <div class="text-slate-800 text-xs whitespace-nowrap">${
                                cell.getData().rightdoctorCodeNo
                            }</div>
                        </div>
                        `;
                    },
                },
                {
                    title: "CENTER SIGNATURE",
                    minWidth: 150,
                    field: "centerDoctorName",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div class="flex lg:justify-left">
                            <div class="intro-x w-32 h-20  image-fit">
                                <img class="rounded-full" src="${cell.getData().centerSign}">
                            </div>
                        </div>
                        <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"></div>
                        <div>
                            <div class="font-medium whitespace-nowrap">${
                                cell.getData().centerDoctorName
                            }</div>
                            <div class="text-slate-800 text-xs whitespace-nowrap">${
                                cell.getData().centerdoctorCodeNo
                            }</div>
                        </div>
                        `;
                    },
                },
                {
                    title: "DEFAULT SIGNATURE",
                    minWidth: 30,
                    field: "isDefault",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        let a =$(`<div class="flex lg:justify-left">
                                 <div class="form-check form-switch"> 
                                    <input id="chkSetDefault" name="isDefault" class="form-check-input" type="checkbox" ${cell.getData().isDefault==1?"checked":""}> 
                                </div>
                            </div>
                            `);
                            $(a)
                            .find("input")
                            .on("change", function () {
                                setDefaultSignature(cell.getData().id,this.value);
                            });
                        return a[0];
                    },
                },
                {
                    title: "ACTIONS",
                    minWidth: 100,
                    field: "actions",
                    responsive: 1,
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        let a =
                        $(`<div class="flex lg:justify-center items-center text-info">
                        <a class="edit flex items-center mr-3 text-primary tooltip" title="Edit Details" href="javascript:;">
                            <i data-lucide="check-square" class="w-5 h-5 mr-1"></i> 
                        </a>
                    </div>`);
                    $(a)
                        .find(".edit")
                        .on("click", function () {
                            $('#txtReportSignId').val(cell.getData().id);
                            $('#ddlDepartmentLeft').val(cell.getData().leftdepartmentId==null?0:cell.getData().leftdepartmentId);
                            $('#ddlDoctorLeft').val(cell.getData().leftDoctorId);
                            $('#ddlDepartmentRight').val(cell.getData().rightdepartmentId==null?0:cell.getData().rightdepartmentId);
                            $('#ddlDoctorRight').val(cell.getData().rightDoctorId);
                            $('#ddlDepartmentcenter').val(cell.getData().centerdepartmentId==null?0:cell.getData().centerdepartmentId);
                            $('#ddlDoctorcenter').val(cell.getData().centerDoctorId);

                            getSignatureValue('ddlDoctorLeft','divLeftSignature','ddlLeftSignId','leftSignId',1,cell.getData().leftSignId);
                            getSignatureValue('ddlDoctorRight','divRightSignature','ddlRightSignId','rightSignId',1,cell.getData().rightSignId);
                            getSignatureValue('ddlDoctorcenter','divcenterSignature','ddlcenterSignId','centerSignId',1,cell.getData().centerSignId);
                            document.getElementById('chkSetDefault').checked = cell.getData().isDefault==1?true:false;
                            window.scrollTo(0, 0);
                        });
                    return a[0];
                },
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
    }
}
/* Add Report Signature */
const reportSignForm = document.getElementById('frmReportSignBank');
if(reportSignForm!=null){
reportSignForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const printSettingdata = new FormData(reportSignForm);
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
    var url=base_url+'/api/addReportSignature';
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divReportSignErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $('#divMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    const successModal = tailwind.Modal.getInstance(document.querySelector("#divReportSignSuccessModal"));
                    successModal.show();   
                    reportSignForm.reset();
                    clearSignatures(); 
                    listReportSignature();
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
function clearSignatures()
{
    document.getElementById('divLeftSignature').innerHTML="";
    document.getElementById('divRightSignature').innerHTML="";
    document.getElementById('divcenterSignature').innerHTML="";
}
function setDefaultSignature(id,isDefault)
{
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    var userId=$('#txtUser').val();
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/setDefaultSignature/'+userId+'/'+id+'/'+isDefault;
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divReportSignErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $('#divMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    const successModal = tailwind.Modal.getInstance(document.querySelector("#divReportSignSuccessModal"));
                    successModal.show();   
                    listReportSignature();
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
/*------------------------------REPORT SIGNATURE --------END ------------------------- */
$("#ddlHospital").on('change',function() {
    var token=$('#txtToken').val();
    var hospitalId=$("#ddlHospital").val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/loadBranch/'+hospitalId;
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divDefaultErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(result){ 
            if(result.Success=='Success'){
                $("#ddlBranch option").remove();
                        $("#ddlBranch").append($("<option></option>").val(0).html("Select Branch"));
                        //Load Branch
                        var listBranch=result.branchList;
                        if(listBranch.length!=0)
                        {
                            listBranch.forEach(function(value, key) {
                                $("#ddlBranch").append($("<option></option>").val(value.id).html(value.branchName)); 
                            });
                        }
                }
        })
        .catch(function(error){
            $('#divErrorHead span').text('Error');
            $('#divErrorMsg span').text(error);
            errorModal.show();
        });
});
/* Save Default hospital and branch */
const setDefaultform = document.getElementById('frmSetDefaultHospital');
if(setDefaultform!=null){
setDefaultform.addEventListener("submit", (e) => {
    e.preventDefault();
    const donorBankdata = new FormData(setDefaultform);
     var token=$('#txtToken').val();
    let options = {
        method: "POST",
        body: donorBankdata,
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    };
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/setDefaultHospital';
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divDefaultErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $('#divMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    const successModal = tailwind.Modal.getInstance(document.querySelector("#divDefaultSuccessModal"));
                    successModal.show();    
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
$("#chkImageCapture").on('change',function() {
    var isSet=$('#chkImageCapture').val();
    setImageCaptureSettings(isSet);
});
$("#chkImageCapture1").on('change',function() {
    var isSet=$('#chkImageCapture1').val();
    setImageCaptureSettings(isSet);
});
function setImageCaptureSettings(isSet)
{
    var token=$('#txtToken').val();
    var userId=$('#txtUser').val();
    let options = {
        method: "GET",
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    };
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/setImageCapture/'+userId+'/'+isSet;
    
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divImageSetErrorModal"));
    fetch(url, options)
    .then(function(response){ 
        return response.json(); 
    })
    .then(function(data){ 
        if(data.Success=='Success'){
            $('#divMsg span').text(data.Message);
            if (data.ShowModal==1) {
                const successModal = tailwind.Modal.getInstance(document.querySelector("#divImageSetSuccessModal"));
                successModal.show();    
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
/*------------------------------------ Search Bank Witness Begin ----------------------------*/
function setWitness(){
    // Tabulator
    if ($("#tbWitness").length) {
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        // Setup Tabulator
        var token=$('#txtToken').val();
        let table = new Tabulator("#tbWitness", {
            ajaxURL: localStorage.getItem("base_url")+"/api/bankWitnessList",
            ajaxParams: {"hospitalId": hospitalId,"branchId":branchId},
            ajaxConfig:{
                method:"GET", //set request type to Position
                headers: {
                    "Content-type": 'application/json; charset=utf-8', //set specific content type
                    "Accept": 'application/json',
                    "Authorization": 'Bearer '+token,
                },
            },
            ajaxFiltering: false,
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
                    headerSort: false,
                },

                // For HTML table
                {
                    title: "NAME",
                    minWidth: 100,
                    field: "name",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    responsive:2
                },
                {
                    title: "HOSPITAL NAME",
                    minWidth: 100,
                    field: "hospitalName",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "PHONE NO",
                    minWidth: 100,
                    field: "phoneNo",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "EMAIL",
                    minWidth: 100,
                    field: "email",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "ADDRESS",
                    minWidth: 100,
                    field: "address",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "ACTIONS",
                    minWidth: 200,
                    field: "actions",
                    responsive: 1,
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        let a =
                        $(`<div class="flex lg:justify-center items-center text-info">
                        <a class="edit flex items-center mr-3 text-primary tooltip" title="Edit Details" href="javascript:;">
                            <i data-lucide="check-square" class="w-5 h-5 mr-1"></i> 
                        </a>
                        <a class="delete flex items-center text-danger tooltip" title="Delete Details" href="javascript:;">
                            <i data-lucide="trash-2" class="w-5 h-5 mr-1"></i> 
                        </a>
                    </div>`);
                    $(a)
                        .find(".edit")
                        .on("click", function () {
                            $('#txtName').val(cell.getData().name);
                            $('#txtHospitalName').val(cell.getData().hospitalName);
                            $('#txtPhoneNo').val(cell.getData().phoneNo);
                            $('#txtEmail').val(cell.getData().email);
                            $('#txtAddress').val(cell.getData().address);
                            $('#txtMode').val(2);
                            $('#txtWitnessId').val(cell.getData().id);
                            window.scrollTo(0, 0);
                        });
                    $(a)
                        .find(".delete")
                        .on("click", function () {
                            const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeleteWitness"));
                            deleteModal.show();
                            $('#divWitness span').text(cell.getData().name);
                            $( "#btnDelWitness" ).on( "click", function() {
                                var userId=$('#txtUser').val();
                                deleteWitness(cell.getData().id,userId);
                            });
                        });

                    return a[0];
                },
                },
                   // For print format
                   {
                    title: "NAME",
                    field: "name",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "HOSPITAL NAME",
                    field: "hospitalName",
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
                    title: "ADDRESS",
                    field: "address",
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
    }
}
/*------------------------------------------------------- Bank Witness END ---------------------------*/
/*----------------------------------- Delete Donor Bank By ID bEGINS -------------------------*/
function deleteWitness(witnessId,userId){
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divErrorWitness"));
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/deleteBankWitness/'+witnessId+'/'+userId;
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
                if (data.ShowModal==1) {
                const el = document.querySelector("#divDeleteWitness"); 
                const modal = tailwind.Modal.getOrCreateInstance(el); 
                modal.hide();
                setWitness();
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

/*----------------------------------- Delete Donor Bank By ID END -------------------------*/
$( "#btnWitnessCancel" ).on( "click", function() {
    $('#txtMode').val(1);
});
/* --------------- Bank Witness Add form submit Begins ------------------------*/

const witnessform = document.getElementById('frmWitness');
if(witnessform!=null){
//witnessform registeration
witnessform.addEventListener("submit", (e) => {
    e.preventDefault();
    const witnessdata = new FormData(witnessform);
     var token=$('#txtToken').val();
    let options = {
        method: "POST",
        body: witnessdata,
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    };
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/addBankWitness';
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divErrorWitness"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $('#divMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    const successModal = tailwind.Modal.getInstance(document.querySelector("#divSuccessWitness"));
                    successModal.show();    
                    witnessform.reset() ;
                    $('#txtMode').val(1);
                    setWitness();
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
        window.scrollTo(0, 0);
});
 
}
/* --------------- Bank Witness Add form submit End ------------------------*/

})();