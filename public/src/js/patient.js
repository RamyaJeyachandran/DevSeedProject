import xlsx from "xlsx";
import { createIcons, icons } from "lucide";
import Tabulator from "tabulator-tables";
import colors from "./colors";
import Chart from "chart.js/auto";
import TomSelect from "tom-select";
import tippy, { roundArrow } from "tippy.js";

// import { forEach } from "lodash";

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
        
    function setMenu($lnkControl,$ulControl){
        $($lnkControl).addClass("side-menu--active");
        $($ulControl).addClass("side-menu__sub-open");
    }
    function setMobileMenu($lnkMobile,$ulMobile,$aMobile,$asMobile,$search){
        $($lnkMobile).addClass("menu--active");
        $($ulMobile).addClass("menu__sub-open");
        if($search==1){
            $($asMobile).addClass("menu--active");
        }else{
            $($aMobile).addClass("menu--active");
        }
    }
   
    if(pathname==serverPath+'/Home' || pathname==serverPath2+'/Home')
{
    $("[id*=lnkDashboard]").addClass("side-menu--active");
    $("[id*=lnkMobileDashboard]").addClass("menu--active");
    getAppointmentStatusChart();
}
 if(pathname== serverPath+'/login' || pathname== serverPath+'/Hospital' || pathname== serverPath2+'/login' || pathname== serverPath2+'/Hospital')
{
    setMenu("[id*=lnkHospital]","[id*=ulHospital]");
    setMobileMenu("[id*=lnkMobileHospital]","[id*=ulMobileHospital]","[id*=aMobileHospital]","[id*=aMobileHpSearch]",0);
    $("#divResetPassword").addClass('hidden');
}
 if(pathname==serverPath+'/SearchHospital' || pathname==serverPath2+'/SearchHospital')//.indexOf('SearchHospital') != -1
{
    setMenu("[id*=lnkHospital]","[id*=ulHospital]");
    setMobileMenu("[id*=lnkMobileHospital]","[id*=ulMobileHospital]","[id*=aMobileHospital]","[id*=aMobileHpSearch]",1);
    setHospitalTabulator();
}
 if(pathname.indexOf('showHospital') != -1)
{
    setMenu("[id*=lnkHospital]","[id*=ulHospital]");
    setMobileMenu("[id*=lnkMobileHospital]","[id*=ulMobileHospital]","[id*=aMobileHospital]","[id*=aMobileHpSearch]",0);
    $("#txtLogo").on('change',function() {
        $("#txtImageChanged").val(1);
    });
}
 if(pathname==serverPath+'/Doctor' || pathname==serverPath2+'/Doctor')
{
    $("#txtDOB").val('');
    setMenu("[id*=lnkDoctor]","[id*=ulDoctor]");
    setMobileMenu("[id*=lnkMobileDoctor]","[id*=ulMobileDoctor]","[id*=aMobileDoctor]","[id*=aMobileDrSearch]",0);
    addDoctorLoadEvent(base_url);
    loadHospital(base_url);
}
 if(pathname==serverPath+'/SearchDoctor' || pathname==serverPath2+'/SearchDoctor')
{
    setMenu("[id*=lnkDoctor]","[id*=ulDoctor]");
    setMobileMenu("[id*=lnkMobileDoctor]","[id*=ulMobileDoctor]","[id*=aMobileDoctor]","[id*=aMobileDrSearch]",1);
    setDoctorTabulator();

}
 if(pathname.indexOf('showDoctor') != -1)
{
    setMenu("[id*=lnkDoctor]","[id*=ulDoctor]");
    setMobileMenu("[id*=lnkMobileDoctor]","[id*=ulMobileDoctor]","[id*=aMobileDoctor]","[id*=aMobileDrSearch]",0);
    $("#txtProfileImage").on('change',function() {
        $("#txtImageChanged").val(1);
        $(imgProfileImage).attr("src",$(txtProfileImage).val());
    });
    $("#txtSignature").on('change',function() {
        $("#txtSignChanged").val(1);
    });
}
 if(pathname==serverPath+'/Patient' || pathname==serverPath2+'/Patient')
{
    setMenu("[id*=lnkPatient]","[id*=ulPatient]");
    setMobileMenu("[id*=lnkMobilePatient]","[id*=ulMobilePatient]","[id*=aMobilePatients]","[id*=aMobilePatientSearch]",0);
    addPatientLoadEvent(pathname,base_url,serverPath,serverPath2);
    loadHospital(base_url);
}
 if(pathname==serverPath+'/SearchPatient' || pathname==serverPath2+'/SearchPatient')
{
    setMenu("[id*=lnkPatient]","[id*=ulPatient]");
    setMobileMenu("[id*=lnkMobilePatient]","[id*=ulMobilePatient]","[id*=aMobilePatients]","[id*=aMobilePatientSearch]",1);
        setTabulator();
}
 if(pathname==serverPath+'/RefferedBy' || pathname==serverPath2+'/RefferedBy')
{
    setMenu("[id*=lnkPatient]","[id*=ulPatient]");
    setMobileMenu("[id*=lnkMobilePatient]","[id*=ulMobilePatient]","[id*=aMobilePatients]","[id*=aMobileRefferedBy]",1);
    setRefferedBy();
}
 if (pathname.indexOf('viewRefferedBy') != -1)
{
    setMenu("[id*=lnkPatient]","[id*=ulPatient]");
    setMobileMenu("[id*=lnkMobilePatient]","[id*=ulMobilePatient]","[id*=aMobilePatients]","[id*=aMobileRefferedBy]",1);
}
 if(pathname.indexOf('showPatient') != -1)
{
    setMenu("[id*=lnkPatient]","[id*=ulPatient]");
    setMobileMenu("[id*=lnkMobilePatient]","[id*=ulMobilePatient]","[id*=aMobilePatients]","[id*=aMobilePatientSearch]",0);
    editPatientLoadEvent();
}
 if(pathname==serverPath+'/Branch' || pathname==serverPath2+'/Branch')
{
    setMenu("[id*=lnkBranch]","[id*=ulBranch]");
    setMobileMenu("[id*=lnkMobileBranch]","[id*=ulMobileBranch]","[id*=aMobileBranch]","[id*=aMobileBrSearch]",0);
    addBranchLoadEvent(base_url);
}
 if(pathname==serverPath+'/SearchBranch' || pathname==serverPath2+'/SearchBranch')
{
    setMenu("[id*=lnkBranch]","[id*=ulBranch]");
    setMobileMenu("[id*=lnkMobileBranch]","[id*=ulMobileBranch]","[id*=aMobileBranch]","[id*=aMobileBrSearch]",1);
    setBranchTabulator();
}
 if(pathname.indexOf('showBranch') != -1)
{
    setMenu("[id*=lnkBranch]","[id*=ulBranch]");
    setMobileMenu("[id*=lnkMobileBranch]","[id*=ulMobileBranch]","[id*=aMobileBranch]","[id*=aMobileBrSearch]",0);
    $("#txtLogo").on('change',function() {
        $("#txtImageChanged").val(1);
    });
}
 if(pathname.indexOf('ConsentForm') != -1)
{
    setMenu("[id*=lnkConsentForm]","[id*=ulConsentForm]");
    setMobileMenu("[id*=lnkMobileConsent]","[id*=ulMobileConsent]","[id*=aMobileConsent]","[id*=aMobilePatientConsent]",1);
    consentFormOnLoad();
    /*set tom-select for dropdown */
      let options = {
        plugins: {
            dropdown_input: {},
        },
    };
            // clear_button :{},
    new TomSelect('#ddlPatientList', options);
    
}
 if(pathname==serverPath+"/SearchConsent" || pathname==serverPath2+"/SearchConsent")
{
    setMenu("[id*=lnkConsentForm]","[id*=ulConsentForm]");
    setMobileMenu("[id*=lnkMobileConsent]","[id*=ulMobileConsent]","[id*=aMobileConsent]","[id*=aMobilePatientConsent]",1);
    setConsentTabulator();
}
 if(pathname==serverPath+"/ViewConsent" || pathname==serverPath2+"/ViewConsent")
{
    setMenu("[id*=lnkConsentForm]","[id*=ulConsentForm]");
    setMobileMenu("[id*=lnkMobileConsent]","[id*=ulMobileConsent]","[id*=aMobileConsent]","[id*=aMobilePatientConsent]",1);
    loadViewConsentForm();
}
 if(pathname==serverPath+"/subscribe" || pathname==serverPath2+"/subscribe")
{
    $("[id*=lnkSubscribe]").addClass("side-menu--active");
    $("[id*=lnkMobileSubscribe]").addClass("menu--active");
    loadSubscribeHospital(base_url);
    $("#btnPlan1").addClass('hidden');
}
 if(pathname==serverPath+"/DonorBank" || pathname==serverPath2+"/DonorBank")
{
    setMenu("[id*=lnkDonor]","[id*=ulDonor]");
    setMobileMenu("[id*=lnkMobileDonor]","[id*=ulMobileDonor]","[id*=aMobileDonor]","[id*=aMobileWitness]",1);
    setDonor();
}
 if(pathname==serverPath+'/PatientAppointment' || pathname==serverPath2+'/PatientAppointment')
{
    setMenu("[id*=lnkAppointment]","[id*=ulAppointment]");
    setMobileMenu("[id*=lnkMobileAppointment]","[id*=ulMobileAppointment]","[id*=aMobileAppointment]","[id*=aMobileAppointmentSearch]",0);
    addAppointmentLoadEvent(base_url);
    loadHospital(base_url);
      /*set tom-select for dropdown */
      let options = {
        plugins: {
            dropdown_input: {},
            clear_button :{},
        },
    };
    new TomSelect('#ddlAppointmentPatient', options);

    document.querySelectorAll("form").forEach((formElement) => {
        formElement.addEventListener("reset", (event) => {
          event.target
            .querySelectorAll(".tomselected")
            .forEach((tomselectedElement) => {
              tomselectedElement.tomselect.clear();
            });
        });
      });
}
 if(pathname==serverPath+'/AllAppointments' || pathname==serverPath2+'/AllAppointments')
{
    setMenu("[id*=lnkAppointment]","[id*=ulAppointment]");
    setMobileMenu("[id*=lnkMobileAppointment]","[id*=ulMobileAppointment]","[id*=aMobileAppointment]","[id*=aMobileAppointmentSearch]",0);
    $("#divDateSearch").addClass('hidden');
    $("input#tbAppointment-html-filter-value-1").hide();
    $("#tbAppointment-html-filter-value-1-label").hide();
    setAppointmentTabulator();
}
 if(pathname==serverPath+'/TodayAppointments' || pathname==serverPath2+'/TodayAppointments')
{
    setMenu("[id*=lnkAppointment]","[id*=ulAppointment]");
    setMobileMenu("[id*=lnkMobileAppointment]","[id*=ulMobileAppointment]","[id*=aMobileAppointment]","[id*=aMobileAppointmentSearch]",0);
    setTodayAppointmentTabulator();
}
 if(pathname.indexOf('showAppointment') != -1)
{
    setMenu("[id*=lnkAppointment]","[id*=ulAppointment]");
    setMobileMenu("[id*=lnkMobileAppointment]","[id*=ulMobileAppointment]","[id*=aMobileAppointment]","[id*=aMobileAppointmentSearch]",1);
}
 if(pathname==serverPath+'/SemenAnalysis' || pathname==serverPath2+'/SemenAnalysis')
{
    setMenu("[id*=lnkSemen]","[id*=ulSemenAnalysis]");
    setMobileMenu("[id*=lnkMobileSemenAnalysis]","[id*=ulMobileSemenAnalysis]","[id*=aMobileSemenAnalysis]","[id*=aMobileSemenAnalysis]",0);
    let ddlBranch = document.getElementById('ddlBranch');
    let ddlHospital = document.getElementById('ddlHospital');
    if (ddlBranch == null && ddlHospital == null) {
        getPatientDoctor();
    }else{
        loadHospital(base_url);            
    }
    semenAnalysisFormOnLoad(base_url);   
}
 if(pathname.indexOf('PrintSemenAnalysis') != -1)
{
    setMenu("[id*=lnkSemen]","[id*=ulSemenAnalysis]");
    setMobileMenu("[id*=lnkMobileSemenAnalysis]","[id*=ulMobileSemenAnalysis]","[id*=aMobileSemenAnalysis]","[id*=aMobileSemenAnalysis]",1);  
}
 if(pathname==serverPath+'/SearchSemenAnalysis' || pathname==serverPath2+'/SearchSemenAnalysis')
{
    setMenu("[id*=lnkSemen]","[id*=ulSemenAnalysis]");
    setMobileMenu("[id*=lnkMobileSemenAnalysis]","[id*=ulMobileSemenAnalysis]","[id*=aMobileSemenAnalysis]","[id*=aMobileSemenAnalysis]",1); 
    $("#divDateSearch").addClass('hidden');
    $("input#tbSemen-html-filter-value-1").hide();
    $("#tbSemen-html-filter-value-1-label").hide();
    setSemenAnalysisTabulator();
}
 if(pathname.indexOf('ShowSemenAnalysis') != -1)
{
    setMenu("[id*=lnkSemen]","[id*=ulSemenAnalysis]");
    setMobileMenu("[id*=lnkMobileSemenAnalysis]","[id*=ulMobileSemenAnalysis]","[id*=aMobileSemenAnalysis]","[id*=aMobileSemenAnalysis]",0); 
}
 if(pathname==serverPath+'/PatientReport' || pathname==serverPath2+'/PatientReport')
{
    setMenu("[id*=lnkPatientReport]","[id*=ulReport]");
    setMobileMenu("[id*=lnkMobileReport]","[id*=ulMobilePatientReport]","[id*=aMobilePatientReport]","[id*=aMobileSemenAnalysis]",0); 
    loadYear();
    // loadHospital(base_url);
    getPatientDoctor();
    hideReportOption();
}
 if(pathname==serverPath+'/AssignDoctor' || pathname==serverPath2+'/AssignDoctor')
{
    setMenu("[id*=lnkDoctor]","[id*=ulDoctor]");
    setMobileMenu("[id*=lnkMobileReport]","[id*=ulMobilePatientReport]","[id*=aMobilePatientReport]","[id*=aMobileSemenAnalysis]",0); 
    // loadHospitalForAssign(base_url);
    getAssignPatientDoctor();
}
 if(pathname==serverPath+'/ListAssignedDoctor' || pathname==serverPath2+'/ListAssignedDoctor')
{
    setMenu("[id*=lnkDoctor]","[id*=ulDoctor]");
    setMobileMenu("[id*=lnkMobileReport]","[id*=ulMobilePatientReport]","[id*=aMobilePatientReport]","[id*=aMobileSemenAnalysis]",0); 
    loadHospital(base_url);
    setAssignDoctorTabulator();
}
 if(pathname==serverPath+'/PatientDetails' || pathname==serverPath2+'/PatientDetails')
{
    setMenu("[id*=lnkPatientDetails]","[id*=ulReport]");
    setMobileMenu("[id*=lnkMobileReport]","[id*=ulMobilePatientReport]","[id*=aMobilePatientReport]","[id*=aMobilePatientDetails]",0); 
    loadHospital(base_url);
    $("#divPrintPatientDetails").addClass('hidden');
    $("#divPrintPatientButton").addClass("hidden");
}
   return;
  });
  
  /*--------------------------------------- Edit Patient Load Event--BEGIN ---------------------*/
  function editPatientLoadEvent(){
    if($( "#ddlRefferedBy" ).val()=='Doctor'){
        $( "#divDocName" ).show();
        $( "#divDocHpName" ).show();
        $( "#divDocName" ).focus();
    }else{
        $( "#divDocName" ).hide();
        $( "#divDocHpName" ).hide();
    }
      /* ---------------WebCam Photo capture -BEGIN ---------------*/
      Webcam.set({
        width: 250,
        height: 200,
        image_format: 'jpeg',
        jpeg_quality: 90
    });            
    Webcam.attach( '#my_camera' );
    $( "#btnSnapshot" ).on( "click", function() {
        take_snapshot();
        $("#txtImageChanged").val("1");
    });
/* ---------------WebCam Photo capture -END ---------------*/
  }
  /*--------------------------------------- Edit Patient Load Event--END ---------------------*/

  /* ------------------------------------------ Add Patient Begin -----------------------*/
  function addPatientLoadEvent(pathname,base_url,serverPath,serverPath2){
    if(pathname==serverPath+'/Patient' || pathname==serverPath2+'/Patient')
    {
        $("#txtDOB").val('');
        $( "#divDocName" ).hide();
        $( "#divDocHpName" ).hide();
    }
    var token=$('#txtToken').val();
        let options = {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer '+token,
              },
        }
        var url=base_url+'/api/getCommonData';
        fetch(url,options)
                .then(response => response.json())
                .then(function (result) {
                    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divPatientErrorModal"));
                    if(result.Success=='Success')
                    {
                    var listCity=result.cities;
                    listCity.forEach(function(value, key) {
                        $("#ddlState").append($("<option></option>").val(value.city_state).html(value.city_state)); 
                    });
    
                    var listGender=result.gender;
                    listGender.forEach(function(value, key) {
                        $("#ddlGender").append($("<option></option>").val(value.name).html(value.name)); 
                    });
    
                    var listMartialStatus=result.martialStatus;
                    listMartialStatus.forEach(function(value, key) {
                        $("#ddlmartialStatus").append($("<option></option>").val(value.name).html(value.name)); 
                    });
    
                    var listRefferedBy=result.refferedBy;
                    listRefferedBy.forEach(function(value, key) {
                        $("#ddlRefferedBy").append($("<option></option>").val(value.name).html(value.name)); 
                    });
    
                    var listBloodGrp=result.bloodGrp;
                     listBloodGrp.forEach(function(value, key) {
                        $("#ddlBloodGrp").append($("<option></option>").val(value.name).html(value.name)); 
                    });
                }else{
                    $('#divErrorHead span').text(data.Success);
                    $('#divErrorMsg span').text(data.Message);
                    if (data.ShowModal==1) {
                        errorModal.show();
                    }
                    else if(data.ShowModal==2)
                    {
                       logoutSession(data.Message);
                    }
                }
                }) .catch(function(error){
                    $('#divDrErrorHead span').text('Error');
                    $('#divDrErrorMsg span').text(error);
                    errorModal.show();
                }); 
        /* ---------------WebCam Photo capture -BEGIN ---------------*/
                Webcam.set({
                    width: 250,
                    height: 200,
                    image_format: 'jpeg',
                    jpeg_quality: 90
                });            
                Webcam.attach( '#my_camera' );
                $( "#btnSnapshot" ).on( "click", function() {
                    take_snapshot();
                });
        /* ---------------WebCam Photo capture -END ---------------*/
       
}
/* ------------------------------------------ Add Patient END -----------------------*/

/*--------------------------------------Edit patient Begins------------------------------*/
const patientEditform = document.getElementById('frmEditPatient');
if(patientEditform!=null){
patientEditform.addEventListener("submit", (epf) => {
    epf.preventDefault();
     const patientdata = new FormData(patientEditform);
    //  const params=new URLSearchParams(patientdata);
      var base64data = $("#btnCapturedImg").val();
     if(base64data!= null){
        patientdata.append('profileImage', base64data);
     }
     const errorModal = tailwind.Modal.getInstance(document.querySelector("#divEditPatientErrorModal"));
     var token=$('#txtToken').val();
     let options = {
         method: "POST",
         body: patientdata,
         headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
     };
     var base_url = localStorage.getItem("base_url");
     var url=base_url+'/api/updatePatient';
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             if(data.Success=='Success'){
                 $('#divMsg span').text(data.Message);
                 $('#divHcNo span').text(data.hcNo);
                 if (data.ShowModal==1) {
                    const successEditModal = tailwind.Modal.getInstance(document.querySelector("#success-redirect-modal-preview"));
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
/*-------------------------------------------------Edit patient Ends -----------------------------*/

/*------------------------------------ Search Patient Begin ----------------------------*/
  function setTabulator(){
    // Tabulator
    if ($("#tbPatient").length) {
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        // Setup Tabulator
        var token=$('#txtToken').val();
        let table = new Tabulator("#tbPatient", {
            ajaxURL: localStorage.getItem("base_url")+"/api/patientList",//window.location.origin+"/api/patientList",
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
                    headerSort: false,
                },

                // For HTML table
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
                    minWidth: 100,
                    field: "name",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div>
                            <div class="font-medium whitespace-nowrap">${
                                cell.getData().name
                            }</div>
                            <div class="text-slate-800 text-xs whitespace-nowrap">${
                                cell.getData().hcNo
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "Blood Type",
                    minWidth: 50,
                    field: "bloodGroup",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "PHONE NO",
                    minWidth: 100,
                    field: "phoneNo",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    responsive:2
                },
                {
                    title: "Email",
                    minWidth: 100,
                    field: "email",
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
                            <a class="view flex items-center mr-3 tooltip" title="View Patient Details" href="javascript:;">
                                <i data-lucide="eye" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="edit flex items-center mr-3 text-primary tooltip" title="Edit Patient Details" href="javascript:;">
                                <i data-lucide="check-square" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="delete flex items-center text-danger tooltip" title="Delete Patient" href="javascript:;">
                                <i data-lucide="trash-2" class="w-5 h-5 mr-1"></i> 
                            </a>
                        </div>`);
                        $(a)
                        .find(".view")
                        .on("click", function () {
                            viewPatient(cell.getData().id);
                        });
                        $(a)
                            .find(".edit")
                            .on("click", function () {
                                window.location.href=localStorage.getItem("base_url")+"/showPatient/"+cell.getData().id;
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#delete-modal-preview"));
                                deleteModal.show();
                                $('#txtId').val(cell.getData().id);
                                $('#divHcNo span').text(cell.getData().hcNo);
                                $( "#btnDelPatient" ).on( "click", function() {
                                    var userId=$('#txtUser').val();
                                    deletePatient(cell.getData().id,userId);
                                });
                            });

                        return a[0];
                    },
                },

                // For print format
                {
                    title: "REGISTERED NO",
                    field: "hcNo",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "NAME",
                    field: "name",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "BLOOD TYPE",
                    field: "bloodGroup",
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
            let field = $("#tbPatient-html-filter-field").val();
            let type = $("#tbPatient-html-filter-type").val();
            let value = $("#tbPatient-html-filter-value").val();
            table.setFilter(field, type, value);
        }

        // On submit filter form
        $("#tbPatient-html-filter-form")[0].addEventListener(
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
        $("#tbPatient-html-filter-go").on("click", function (event) {
            filterHTMLForm();
        });

        // On reset filter form
        $("#tbPatient-html-filter-reset").on("click", function (event) {
            $("#tbPatient-html-filter-field").val("hcNo");
            $("#tbPatient-html-filter-type").val("like");
            $("#tbPatient-html-filter-value").val("");
            filterHTMLForm();
        });

        // Export
        $("#tbPatient-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            table.download("xlsx", "Patients.xlsx", {
                sheetName: "Patients",
            });
        });
        // Print
        $("#tbPatient-print").on("click", function (event) {
            table.print();
        });
    }
}

/*------------------------ View Patient Begin ------------------------------*/
function viewPatient($patientId){
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/patientInfo/'+$patientId;
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divPatientErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $(imgProfileImage).attr("src",data.patientDetails.profileImage);
                $('#lblHcNo span').text(data.patientDetails.hcNo);
                $('#lblName span').text(data.patientDetails.name);
                $('#lblPhoneNo span').text(data.patientDetails.phoneNo);
                $('#lblEmail span').text(data.patientDetails.email);
                $('#lblAadharCardNo span').text(data.patientDetails.aadharCardNo);
                $('#lblDob span').text(data.patientDetails.dob);
                $('#lblAge span').text(data.patientDetails.age);
                $('#lblGender span').text(data.patientDetails.gender);
                $('#lblBloodGrp span').text(data.patientDetails.bloodGroup);
                $('#lblMartialStatus span').text(data.patientDetails.martialStatus);
                $('#lblHeight span').text(data.patientDetails.patientHeight);
                $('#lblWeight span').text(data.patientDetails.patientWeight);
                $('#lblAddress span').text(data.patientDetails.address);
                $('#lblCity span').text(data.patientDetails.city);
                $('#lblState span').text(data.patientDetails.state);
                $('#lblPincode span').text(data.patientDetails.pincode);
                $('#lblReason span').text(data.patientDetails.reason);
                $('#lblSpouseName span').text(data.patientDetails.spouseName);
                $('#lblSpousePhNo span').text(data.patientDetails.spousePhnNo);
                $('#lblAttendingDoctor span').text(data.patientDetails.attendingDoctor);
                $('#lblRefferedByDoctor span').text(data.patientDetails.refferedById);
                const viewModal = tailwind.Modal.getInstance(document.querySelector("#divViewPatient"));
                viewModal.show();
                $("#tbPrintPatient").on("click",function(){
                    $("#tbViewPatient").print();
                });
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
/*------------------------ View Patient End ------------------------------*/

/*------------------------ Search Patient End ------------------------*/

$( "#ddlRefferedBy" ).on( "change", function() {
    $( "#txtDocHpName" ).val("");
    $( "#txtDocName" ).val("");
    if($( "#ddlRefferedBy" ).val()=='Doctor'){
        $( "#divDocName" ).show();
        $( "#divDocHpName" ).show();
        $( "#divDocName" ).focus();
    }else{
        $( "#divDocName" ).hide();
        $( "#divDocHpName" ).hide();
    }
} );
 $( "#btnCancelPatient" ).on( "click", function() {
    window.scrollTo(0, 0);
 });
 /*adhaar-number verification */
 $( "#txtAadharCardNo" ).on( "keyup", function() {
    var value = $("#txtAadharCardNo").val();
    value = value.replace(/\D/g, "").split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join("-");
    $("#txtAadharCardNo").val(value);
 });

 /* --------------- Patient Add form submit Begins ------------------------*/

const patientform = document.getElementById('frmPatient');
if(patientform!=null){
//Patient registeration
patientform.addEventListener("submit", (e) => {
    e.preventDefault();
    const patientdata = new FormData(patientform);
     var base64data = $("#btnCapturedImg").val();
     if(base64data!= null){
        patientdata.append('profileImage', base64data);
     }
     var token=$('#txtToken').val();
    let options = {
        method: "POST",
        body: patientdata,
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    };
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/addPatient';
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divPatientErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $('#divMsg span').text(data.Message);
                $('#divHcNo span').text(data.hcNo);
                if (data.ShowModal==1) {
                    const successModal = tailwind.Modal.getInstance(document.querySelector("#divPatientSuccessModal"));
                    successModal.show();    
                    document.getElementById("frmPatient").reset() ;
                    $(imgProfileImage).attr("src","");
                    $("#ddlBranch option").remove();
                    $("#ddlBranch").append($("<option></option>").val(0).html("Select Branch"));
                    $("#divBranchddl").addClass('hidden');
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
/* --------------- Patient Add form submit End ------------------------*/

//Back to search from update/delete Begin
$( "#btnRedirect" ).on( "click", function() {
    window.scrollTo(0, 0);
    var base_url = localStorage.getItem("base_url");
    window.location.href = base_url+ "/SearchPatient";
});


//Back to search from update/delete End

/*----------------------------------- Delete Patient By ID bEGINS -------------------------*/
function deletePatient(patientId,userId){
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/deletePatient/'+patientId+'/'+userId;
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
                const el = document.querySelector("#delete-modal-preview"); 
                const modal = tailwind.Modal.getOrCreateInstance(el); 
                modal.hide();
                setTabulator();
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

/*----------------------------------- Delete Patient By ID END -------------------------

---------------------------------Load Add doctor DropDown  ctrl--BEGIN --------------------------- */
function loadHospital(base_url){
    let ddlBranch = document.getElementById('ddlBranch');
    let ddlPatient = document.getElementById('ddlPatient');
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    var url=base_url+'/api/loadHospital';
    fetch(url,options)
            .then(response => response.json())
            .then(function (result) {
                if(result.Success=='Success'){
                // Load Hospital
                    var listHospital=result.hospitalList;
                    if(listHospital!=null)
                    {
                        listHospital.forEach(function(value, key) {
                            $("#ddlHospital").append($("<option></option>").val(value.id).html(value.hospitalName)); 
                        });
                    }
                }
            }); 
           
            var hospitalId=$('#txtHospital').val();
            if (ddlBranch !== null) {
                var ddlUrl=base_url+'/api/loadBranch/'+hospitalId;

                    fetch(ddlUrl,options)
                    .then(response => response.json())
                    .then(function (result) {
                        if(result.Success=='Success'){
                        // Load Branch
                            var listBranch=result.branchList;
                            $("#ddlBranch option").remove();
                            $("#ddlBranch").append($("<option></option>").val(0).html("Select Branch"));
                            if(listBranch.length!=0)
                            {
                                listBranch.forEach(function(value, key) {
                                    $("#ddlBranch").append($("<option></option>").val(value.id).html(value.branchName)); 
                                });
                                $("#divBranchddl").removeClass("hidden").removeAttr("style");
                            }else{
                                $("#divBranchddl").addClass('hidden');
                                if(ddlPatient !== null){
                                    getPatientDoctor();
                                }
                            }
                        }
                    }); 
            }else{
                if(hospitalId>0 && ddlPatient !== null){
                    getPatientDoctor();
                }else{
                    clearddlForSemen();
                }
            }
}
$("#ddlBranch").on('change',function() {
    $('#txtBranch').val($("#ddlBranch").val());
    var ddlPatient=document.getElementById('ddlPatient');
    if(ddlPatient !== null){
        getPatientDoctor();
    }
});
$("#ddlHospital").on('change',function() {
    var token=$('#txtToken').val();
    var hospitalId=$("#ddlHospital").val();
    $('#txtHospital').val(hospitalId);
    let ddlBranch = document.getElementById('ddlBranch');
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    var base_url = localStorage.getItem("base_url");
    var ddlUrl=base_url+'/api/loadBranch/'+hospitalId;
    if (ddlBranch !== null) {
        fetch(ddlUrl,options)
                .then(response => response.json())
                .then(function (result) {
                    $("#ddlBranch option").remove();
                    $("#ddlBranch").append($("<option></option>").val(0).html("Select Branch"));
                    //Load Branch
                    if(result.Success=='Success'){
                        var listBranch=result.branchList;
                        if(listBranch.length!=0)
                        {
                            listBranch.forEach(function(value, key) {
                                $("#ddlBranch").append($("<option></option>").val(value.id).html(value.branchName)); 
                            });
                            $("#divBranchddl").removeClass("hidden").removeAttr("style");
                            $("#divBranchddl1").removeClass("hidden").removeAttr("style");
                        }else{
                            $("#divBranchddl").addClass('hidden');
                            $("#divBranchddl1").addClass('hidden');
                            $("#divBranchddl2").addClass('hidden');
                        }
                    }
                });  
        }
        getPatientDoctor();
 });   

function addDoctorLoadEvent(base_url){
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    var url=base_url+'/api/getDoctorCommonData';
    fetch(url,options)
            .then(response => response.json())
            .then(function (result) {
                if(result.Success=='Success'){
                    // Load GENDER
                    var listGender=result.gender;
                    listGender.forEach(function(value, key) {
                        $("#ddlGender").append($("<option></option>").val(value.name).html(value.name)); 
                    });
                    //LOAD BLOOD GROUP
                    var listBloodGrp=result.bloodGrp;
                    listBloodGrp.forEach(function(value, key) {
                        $("#ddlBloodGrp").append($("<option></option>").val(value.name).html(value.name)); 
                    });
                    //LOAD DEPARTMENT
                    var listDepartment=result.department;
                    listDepartment.forEach(function(value, key) {
                        $("#ddlDepartment").append($("<option></option>").val(value.id).html(value.name)); 
                    });
                }
            });         
   
}
/*---------------------------------Load Add doctor DropDown  ctrl--END --------------------------- */

/* --------------- Doctor Add form submit Begins ------------------------*/

const doctorFrom = document.getElementById('frmDoctor');
if(doctorFrom!=null){
//Doctor registeration
doctorFrom.addEventListener("submit", (e) => {
    e.preventDefault();
    const doctorData = new FormData(doctorFrom);
     var token=$('#txtToken').val();
    let options = {
        method: "POST",
        body: doctorData,
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    };
    // delete options.headers['Content-Type'];
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/addDoctor';

    const drerrorModal = tailwind.Modal.getInstance(document.querySelector("#divDoctorErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $('#divDrMsg span').text(data.Message);
                $('#divDoctorCodeNo span').text(data.doctorCodeNo);
                $('#divDrLogin span').text(data.loginCreation==1?"User Login created successfully":"");
                if (data.ShowModal==1) {
                    const successModal = tailwind.Modal.getInstance(document.querySelector("#success-modal-preview"));
                    successModal.show();    
                    document.getElementById("frmDoctor").reset() ;
                    $("#ddlBranch option").remove();
                    $("#ddlBranch").append($("<option></option>").val(0).html("Select Branch"));
                    $("#divBranchddl").addClass('hidden');
                }                   
            }else{
                $('#divDrErrorHead span').text(data.Success);
                $('#divDrErrorMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    drerrorModal.show();
                 }else if(data.ShowModal==2)
                 {
                    logoutSession(data.Message);
                 }
            }
        })
        .catch(function(error){
            $('#divDrErrorHead span').text('Error');
            $('#divDrErrorMsg span').text(error);
            drerrorModal.show();
        });
        window.scrollTo(0, 0);
});
 
}
/* --------------- Doctor Add form submit End ------------------------*/
/*------------------------------------ Search Doctor Begin ----------------------------*/
function setDoctorTabulator(){
    // Tabulator
    if ($("#tbDoctor").length) {
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        var token=$('#txtToken').val();
        // Setup Tabulator
        let table = new Tabulator("#tbDoctor", {
            ajaxURL: localStorage.getItem("base_url")+"/api/doctorList",
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
                    headerSort: false,
                },

                // For HTML table
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
                    title: "CODE NO",
                    minWidth: 50,
                    field: "doctorCodeNo",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "NAME",
                    minWidth: 100,
                    field: "name",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
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
                    title: "DEPARTMENT",
                    minWidth: 50,
                    field: "department",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "SIGNATURE",
                    minWidth: 150,
                    field: "actions",
                    responsive: 1,
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        if(cell.getData().total_signature>0){
                                let a =
                                    $(`<div class="flex lg:justify-center items-center text-info">
                                    <a class="view flex items-center mr-3 text-primary" href="javascript:;">
                                    <i data-lucide="crop" class="w-5 h-5 mr-1"></i>  View
                                    </a>
                                </div>`);
                                $(a)
                                .find(".view")
                                .on("click", function () {
                                    viewSignature(cell.getData().id);
                                });
                                return a[0];
                        }else{
                            let a =
                                    $(`<div class="flex lg:justify-center items-center text-info">
                                    No Signature
                                </div>`);
                            return a[0];
                        }
                    },
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
                            <a class="view flex items-center mr-3 tooltip" title="View Doctor Details" href="javascript:;">
                                <i data-lucide="eye" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="edit flex items-center mr-3 text-primary tooltip" title="Edit Doctor Details" href="javascript:;">
                                <i data-lucide="check-square" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="delete flex items-center text-danger tooltip" title="Delete Doctor" href="javascript:;">
                                <i data-lucide="trash-2" class="w-5 h-5 mr-1"></i> 
                            </a>
                        </div>`);
                        $(a)
                        .find(".view")
                        .on("click", function () {
                            viewDoctor(cell.getData().id);
                        });
                        $(a)
                            .find(".edit")
                            .on("click", function () {
                                window.location.href= localStorage.getItem("base_url")+"/showDoctor/"+cell.getData().id;
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#delete-modal-preview"));
                                deleteModal.show();
                                $('#txtId').val(cell.getData().id);
                                $('#divDrCodeNo span').text(cell.getData().doctorCodeNo);
                                $( "#btnDelDoctor" ).on( "click", function() {
                                    var userId=$('#txtUser').val();
                                    deleteDoctor(cell.getData().id,userId);
                                });
                            });

                        return a[0];
                    },
                },

                // For print format
                {
                    title: "CODE NO",
                    field: "doctorCodeNo",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "NAME",
                    field: "name",
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
                    title: "BLOOD TYPE",
                    field: "bloodGroup",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "DESIGNATION",
                    field: "designation",
                    visible: false,
                    print: false,
                    download: false,
                },
                {
                    title: "DEPARTMENT",
                    field: "department",
                    visible: false,
                    print: false,
                    download: false,
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
        function filterHTMLDoctorForm() {
            let field = $("#tbDoctor-html-filter-field").val();
            let type = $("#tbDoctor-html-filter-type").val();
            let value = $("#tbDoctor-html-filter-value").val();
            table.setFilter(field, type, value);
        }

        // On submit filter form
        $("#tbDoctor-html-filter-form")[0].addEventListener(
            "keypress",
            function (event) {
                let keycode = event.keyCode ? event.keyCode : event.which;
                if (keycode == "13") {
                    event.preventDefault();
                    filterHTMLDoctorForm();
                }
            }
        );

        // On click go button
        $("#tbDoctor-html-filter-go").on("click", function (event) {
            filterHTMLDoctorForm();
        });

        // On reset filter form
        $("#tbDoctor-html-filter-reset").on("click", function (event) {
            $("#tbDoctor-html-filter-field").val("doctorCodeNo");
            $("#tbDoctor-html-filter-type").val("like");
            $("#tbDoctor-html-filter-value").val("");
            filterHTMLDoctorForm();
        });

        // Export
        $("#tbDoctor-export-csv").on("click", function (event) {
            table.download("csv", "data.csv");
        });

        $("#tbDoctor-export-json").on("click", function (event) {
            table.download("json", "data.json");
        });

        $("#tbDoctor-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            table.download("xlsx", "Doctors.xlsx", {
                sheetName: "Doctors",
            });
        });

        $("#tbDoctor-export-html").on("click", function (event) {
            table.download("html", "data.html", {
                style: true,
            });
        });

        // Print
        $("#tbDoctor-print").on("click", function (event) {
            table.print();
        });
    }
}
/*------------------------ Search Doctor End ------------------------*/

/*----------------------------------- Delete Doctor By ID BEGINS -------------------------*/
function deleteDoctor(doctorId,userId){
    var base_url = localStorage.getItem("base_url");
    var token=$('#txtToken').val();
    var url=base_url+'/api/deleteDoctor/'+doctorId+'/'+userId;
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divDoctorErrorModal"));
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
                  const el = document.querySelector("#delete-modal-preview"); 
                  const modal = tailwind.Modal.getOrCreateInstance(el); 
                  modal.hide();
                  setDoctorTabulator();
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
    
    /*----------------------------------- Delete Doctor By ID END -------------------------*/
/*------------------------ View Doctor Begin ------------------------------*/
function viewDoctor($doctorId){
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/doctorInfo/'+$doctorId;
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divDoctorErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $(imgProfileImage).attr("src",data.doctorDetails.profileImage);
                $('#divCode span').text(data.doctorDetails.doctorCodeNo);
                $('#divName span').text(data.doctorDetails.name);
                $('#divPhoneNo span').text(data.doctorDetails.phoneNo);
                $('#divEmail span').text(data.doctorDetails.email);
                $('#divDob span').text((data.doctorDetails.dob==""?"Not Provided" : data.doctorDetails.dob));
                $('#divGender span').text((data.doctorDetails.gender==0?"Not Provided" :data.doctorDetails.gender));
                $('#divBloodGrp span').text((data.doctorDetails.bloodGroup==0?"Not Provided" :data.doctorDetails.bloodGroup));
                $('#divEducation span').text((data.doctorDetails.education==""?"Not Provided" :data.doctorDetails.education));
                $('#divDesignation span').text((data.doctorDetails.designation==""?"Not Provided" :data.doctorDetails.designation));
                $('#divDepartment span').text((data.doctorDetails.department==""?"Not Provided" :data.doctorDetails.department));
                $('#divExperience span').text((data.doctorDetails.experience==""?"Not Provided" :data.doctorDetails.experience));
                // $('#divAppointmentInterval span').text((data.doctorDetails.appointmentInterval==""?"Not Provided" :data.doctorDetails.appointmentInterval));
                $('#divAddress span').text((data.doctorDetails.address==""?"Not Provided" : data.doctorDetails.address));
                const viewModal = tailwind.Modal.getInstance(document.querySelector("#divViewDoctor"));
                viewModal.show();
                // $("#tbPrintPatient").on("click",function(){
                //     $("#tbViewPatient").print();
                // });
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
/*------------------------ View Doctor End ------------------------------*/
/*------------------------ View Signature Begin ------------------------------*/
function viewSignature($doctorId){
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/doctorSignature/'+$doctorId;
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
        },
    }
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divDoctorErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                var signatureDetails=data.signatureDetails;
                var signDiv='';
                signatureDetails.forEach(function(value, key) {
                    signDiv= signDiv + '<div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y"> <div class="box p-5 zoom-in"><img src="'+value.signature+'" /></div></div>';
                });
                document.getElementById('divSignature').innerHTML=signDiv;
                const viewModal = tailwind.Modal.getInstance(document.querySelector("#divViewSignature"));
                viewModal.show();
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
/*------------------------ View Signature End ------------------------------*/
//Signature DELETE
$(".use-sign").on("click",function() {
    var $row = $(this).closest("tr");    // Find the row
    var id = $row.find(".sign-id").html();
    var deletedSignature=$('#txtdeletedSignature').val();
    deletedSignature=deletedSignature + (deletedSignature != "" ? "," : deletedSignature) +id;
    $('#txtdeletedSignature').val(deletedSignature);
    $row.remove();
});
/*--------------------------------------Edit Doctor Begins------------------------------*/
const doctorEditform = document.getElementById('frmEditDoctor');
if(doctorEditform!=null){
    doctorEditform.addEventListener("submit", (epf) => {
    epf.preventDefault();
     const doctordata = new FormData(doctorEditform);
     var token=$('#txtToken').val();
     let options = {
         method: "POST",
         body: doctordata,
         headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
     };
     
     var base_url = localStorage.getItem("base_url");
     var url=base_url+'/api/updateDoctor';
     const errorDrModal = tailwind.Modal.getInstance(document.querySelector("#divErrorEditDoctor"));
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             if(data.Success=='Success'){
                 $('#divMsg span').text(data.Message);
                 $('#divDoctorCodeNo span').text(data.doctorCodeNo);
                 if (data.ShowModal==1) {
                    const successEditModal = tailwind.Modal.getInstance(document.querySelector("#divSuccessEditDoctor"));
                     successEditModal.show();    
                 }                   
             }else{
                 $('#divDrErrorHead span').text(data.Success);
                 $('#divDrErrorMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    errorDrModal.show();
                 }
                 else if(data.ShowModal==2)
                 {
                    logoutSession(data.Message);
                 }
             }
         })
         .catch(function(error){
             $('#divDrErrorHead span').text('Error');
             $('#divDrErrorMsg span').text(error);
             errorDrModal.show();
         });       
 });      
}
/*-------------------------------------------------Edit Doctor Ends -----------------------------*/
$( "#btnDrRedirect" ).on( "click", function() {
    window.scrollTo(0, 0);
    window.location.href = localStorage.getItem("base_url")+ "/SearchDoctor";
});
function deleteSignature(){
    alert("called");
}
/* --------------- Hospital Add form submit Begins ------------------------*/

const hospitalFrom = document.getElementById('frmHospital');
if(hospitalFrom!=null){
//Hospital registeration
hospitalFrom.addEventListener("submit", (e) => {
    e.preventDefault();
    const drerrorModal = tailwind.Modal.getInstance(document.querySelector("#divHospitalErrorModal"));

    const hospitalData = new FormData(hospitalFrom);
     const file = document.querySelector('#txtLogo').files[0];
     if(file!= null){
        hospitalData.append('logo', file);
     }
     var token=$('#txtToken').val();
    let options = {
        method: "POST",
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
        body: hospitalData
    };
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/addHospital';

    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $('#divDrMsg span').text(data.Message);
                $('#divDrLogin span').text(data.loginCreation==1?"User Login created successfully":"");
                if (data.ShowModal==1) {
                    const successModal = tailwind.Modal.getInstance(document.querySelector("#divHospitalSuccessModal"));
                    successModal.show();    
                    document.getElementById("frmHospital").reset() ;
                }                   
            }else{
                $('#divDrErrorHead span').text(data.Success);
                $('#divDrErrorMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    drerrorModal.show();
                 }else if(data.ShowModal==2)
                 {
                    logoutSession(data.Message);
                 }
            }
        })
        .catch(function(error){
            $('#divDrErrorHead span').text('Error');
            $('#divDrErrorMsg span').text(error);
            drerrorModal.show();
        });
    window.scrollTo(0, 0);
});
 
}
/* --------------- Hospital Add form submit End ------------------------*/
/*------------------------------------ Search Hospital Begin ----------------------------*/
function setHospitalTabulator(){
    // Tabulator
    var token=$('#txtToken').val();
    if ($("#tbHospital").length) {
        // Setup Tabulator
        let table = new Tabulator("#tbHospital", {
            ajaxURL: localStorage.getItem("base_url")+"/api/hospitalList",
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
                    headerSort: false,
                },

                // For HTML table
                {
                    title: "LOGO",
                    minWidth: 75,
                    field: "logo",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div class="flex lg:justify-center">
                            <div class="intro-x w-12 h-12 image-fit">
                                <img class="rounded-full" src="${cell.getData().logo}">
                            </div>
                        </div>`;
                    },
                },
                {
                    title: "HOSPITAL NAME",
                    minWidth: 50,
                    field: "hospitalName",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
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
                    title: "Email",
                    minWidth: 100,
                    field: "email",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "ADDRESS",
                    minWidth: 150,
                    field: "address",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "BRANCH LIMIT",
                    minWidth: 50,
                    field: "branchLimit",
                    hozAlign: "center",
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
                            <a class="view flex items-center mr-3 text-dark tooltip" title="View Hospital Details" href="javascript:;">
                                <i data-lucide="eye" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="edit flex items-center mr-3 text-primary tooltip" title="Edit Hospital Details" href="javascript:;">
                                <i data-lucide="check-square" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="delete flex items-center text-danger tooltip" title="Delete Hospital" href="javascript:;">
                                <i data-lucide="trash-2" class="w-5 h-5 mr-1"></i> 
                            </a>
                        </div>`);
                       
                    
                        $(a)
                        .find(".view")
                        .on("click", function () {
                            viewHospital(cell.getData().id);
                        });
                        $(a)
                            .find(".edit")
                            .on("click", function () {
                                window.location.href= localStorage.getItem("base_url")+"/showHospital/"+cell.getData().id;
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeleteHospital"));
                                deleteModal.show();
                                $('#txtId').val(cell.getData().id);
                                $('#divHospitalName span').text(cell.getData().hospitalName);
                                $( "#btnDelHospital" ).on( "click", function() {
                                    var userId=$('#txtUser').val();
                                    deleteHospital(cell.getData().id,userId);
                                });
                            });

                        return a[0];
                    },
                },

                // For print format
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
                {
                    title: "CONTACT PERSON",
                    field: "inChargePerson",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "CONTACT PERSON PHONE NO",
                    field: "inChargePhoneNo",
                    visible: false,
                    print: false,
                    download: false,
                },
                {
                    title: "SUBSCRIBED",
                    field: "is_subscribed",
                    visible: false,
                    print: false,
                    download: false,
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
        function filterHTMLDoctorForm() {
            let field = $("#tbHospital-html-filter-field").val();
            let type = $("#tbHospital-html-filter-type").val();
            let value = $("#tbHospital-html-filter-value").val();
            table.setFilter(field, type, value);
        }

        // On submit filter form
        $("#tbHospital-html-filter-form")[0].addEventListener(
            "keypress",
            function (event) {
                let keycode = event.keyCode ? event.keyCode : event.which;
                if (keycode == "13") {
                    event.preventDefault();
                    filterHTMLDoctorForm();
                }
            }
        );

        // On click go button
        $("#tbHospital-html-filter-go").on("click", function (event) {
            filterHTMLDoctorForm();
        });

        // On reset filter form
        $("#tbHospital-html-filter-reset").on("click", function (event) {
            $("#tbHospital-html-filter-field").val("doctorCodeNo");
            $("#tbHospital-html-filter-type").val("like");
            $("#tbHospital-html-filter-value").val("");
            filterHTMLDoctorForm();
        });

        // Export
        $("#tbHospital-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            table.download("xlsx", "Hospitals.xlsx", {
                sheetName: "Hospitals",
            });
        });
        // Print
        $("#tbHospital-print").on("click", function (event) {
            table.print();
        });
    }
}
/*------------------------ Search Hospital End ------------------------*/
/*------------------------ View Hospital Begin ------------------------------*/
function viewHospital($hospitalId){
    var base_url = localStorage.getItem("base_url");
    var token=$('#txtToken').val();
    var url=base_url+'/api/hospitalInfo/'+$hospitalId;
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divHospitalErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $(imgLogo).attr("src",data.hospitalDetails.logo);
                $('#divContactPerson span').text(data.hospitalDetails.inChargePerson);
                $('#divName span').text(data.hospitalDetails.hospitalName);
                $('#divPhoneNo span').text(data.hospitalDetails.phoneNo+" , "+data.hospitalDetails.inChargePhoneNo);
                $('#divEmail span').text(data.hospitalDetails.email);
                $('#divAddress span').text(data.hospitalDetails.address);
                const viewModal = tailwind.Modal.getInstance(document.querySelector("#divViewHospital"));
                viewModal.show();
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
/*------------------------ View Hospital End ------------------------------*/
/*----------------------------------- Delete Hospital By ID BEGINS -------------------------*/
function deleteHospital(hospitalId,userId){
    var base_url = localStorage.getItem("base_url");
    var token=$('#txtToken').val();
    var url=base_url+'/api/deleteHospital/'+hospitalId+'/'+userId;
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divHospitalErrorModal"));
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
                  const el = document.querySelector("#divDeleteHospital"); 
                  const modal = tailwind.Modal.getOrCreateInstance(el); 
                  modal.hide();
                  if(data.isReload==1)
                  {
                    window.location.reload();
                  }
                  setHospitalTabulator();
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
    
    /*----------------------------------- Delete Hospital By ID END -------------------------*/
/*--------------------------------------Edit Hospital Begins------------------------------*/
const hospitalEditform = document.getElementById('frmEditHospital');
if(hospitalEditform!=null){
    hospitalEditform.addEventListener("submit", (epf) => {
    epf.preventDefault();
     const hospitaldata = new FormData(hospitalEditform);
     const file = document.querySelector('#txtLogo').files[0];
     if(file!=null){
        hospitaldata.append('logo', file);
     }
     var token=$('#txtToken').val();
     let options = {
         method: "POST",
         body: hospitaldata,
         headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
     };
     var base_url = localStorage.getItem("base_url");
     var url=base_url+'/api/updateHospital';
     const errorDrModal = tailwind.Modal.getInstance(document.querySelector("#divErrorEditHospital"));
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             if(data.Success=='Success'){
                 $('#divMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    const successEditModal = tailwind.Modal.getInstance(document.querySelector("#divSuccessEditHospital"));
                     successEditModal.show();    
                 }                   
             }else{
                 $('#divErrorHead span').text(data.Success);
                 $('#divErrorMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    errorDrModal.show();
                 }else if(data.ShowModal==2)
                 {
                    logoutSession(data.Message);
                 }
             }
         })
         .catch(function(error){
             $('#divErrorHead span').text('Error');
             $('#divErrorMsg span').text(error);
             errorDrModal.show();
         });       
 });      
}
/*-------------------------------------------------Edit Hospital Ends -----------------------------*/
$( "#btnHsRedirect" ).on( "click", function() {
    window.scrollTo(0, 0);
    window.location.href = localStorage.getItem("base_url")+ "/SearchHospital";
});
  /* ------------------------------------------ Add Branch Begin -----------------------*/
  function addBranchLoadEvent(base_url){
    var token=$('#txtToken').val();
        let options = {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer '+token,
              },
        }
        var url=base_url+'/api/listAllHospital';
        fetch(url,options)
                .then(response => response.json())
                .then(function (result) {
                    if(result.Success=='Success'){
                        var hospitalList=result.hospitalList;
                        hospitalList.forEach(function(value, key) {
                            $("#ddlHospital").append($("<option></option>").val(value.id).html(value.hospitalName)); 
                        });
                    }
                });        
                $("#ddlHospital").val($('#txtHospital').val());
}
/* ------------------------------------------ Add Branch END -----------------------*/
/* --------------- Branch Add form submit Begins ------------------------*/

const branchFrom = document.getElementById('frmBranch');
if(branchFrom!=null){
//Branch registeration
branchFrom.addEventListener("submit", (e) => {
    e.preventDefault();
    const branchData = new FormData(branchFrom);
     const file = document.querySelector('#txtLogo').files[0];
     if(file!= null){
        branchData.append('logo', file);
     }
     var token=$('#txtToken').val();
    let options = {
        method: "POST",
        body: branchData,
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    };
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/addBranch';

    const brerrorModal = tailwind.Modal.getInstance(document.querySelector("#divBranchErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $('#divBrMsg span').text(data.Message);
                $('#divBrLogin span').text(data.loginCreation==1?"User Login created successfully":"");
                if (data.ShowModal==1) {
                    const successModal = tailwind.Modal.getInstance(document.querySelector("#divBranchSuccessModal"));
                    successModal.show();    
                    document.getElementById("frmBranch").reset() ;
                }                   
            }else{
                $('#divBrErrorHead span').text(data.Success);
                $('#divBrErrorMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    brerrorModal.show();
                 }else if(data.ShowModal==2)
                 {
                    logoutSession(data.Message);
                 }
            }
        })
        .catch(function(error){
            $('#divBrErrorHead span').text('Error');
            $('#divBrErrorMsg span').text(error);
            brerrorModal.show();
        });
        window.scrollTo(0, 0);
});
 
}
/* --------------- Branch Add form submit End ------------------------*/
/*------------------------------------ Search Branch Begin ----------------------------*/
function setBranchTabulator(){
    // Tabulator
    if ($("#tbBranch").length) {
        var hospitalId=$('#txtHospital').val();
        var token=$('#txtToken').val();
        // Setup Tabulator
        let table = new Tabulator("#tbBranch", {
            ajaxURL: localStorage.getItem("base_url")+"/api/branchList",
            ajaxParams: {"hospitalId": hospitalId},
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
                    headerSort: false,
                },

                // For HTML table
                {
                    title: "LOGO",
                    minWidth: 75,
                    field: "logo",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div class="flex lg:justify-center">
                            <div class="intro-x w-12 h-12 image-fit">
                                <img class="rounded-full" src="${cell.getData().logo}">
                            </div>
                        </div>`;
                    },
                },
                {
                    title: "HOSPITAL NAME",
                    minWidth: 50,
                    field: "hospitalName",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },{
                    title: "BRANCH NAME",
                    minWidth: 50,
                    field: "branchName",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
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
                    title: "Email",
                    minWidth: 100,
                    field: "email",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "ADDRESS",
                    minWidth: 150,
                    field: "address",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "SUBSCRIBED",
                    minWidth: 50,
                    field: "is_subscribed",
                    hozAlign: "center",
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
                            $(`<div class="flex lg:justify-center items-center text-success">
                            <a class="view flex items-center mr-3" href="javascript:;">
                                <i data-lucide="eye" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="edit flex items-center mr-3 text-primary" href="javascript:;">
                                <i data-lucide="check-square" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="delete flex items-center text-danger" href="javascript:;">
                                <i data-lucide="trash-2" class="w-5 h-5 mr-1"></i> 
                            </a>
                        </div>`);
                        $(a)
                        .find(".view")
                        .on("click", function () {
                            viewBranch(cell.getData().id);
                        });
                        $(a)
                            .find(".edit")
                            .on("click", function () {
                                window.location.href= localStorage.getItem("base_url")+"/showBranch/"+cell.getData().id;
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeleteBranch"));
                                deleteModal.show();
                                $('#txtId').val(cell.getData().id);
                                $('#divBranchName span').text(cell.getData().branchName);
                                $( "#btnDelBranch" ).on( "click", function() {
                                    var userId=$('#txtUser').val();
                                    deleteBranch(cell.getData().id,userId);
                                });
                            });

                        return a[0];
                    },
                },

                // For print format
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
                {
                    title: "CONTACT PERSON",
                    field: "inChargePerson",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "CONTACT PERSON PHONE NO",
                    field: "inChargePhoneNo",
                    visible: false,
                    print: false,
                    download: false,
                },
                {
                    title: "SUBSCRIBED",
                    field: "is_subscribed",
                    visible: false,
                    print: false,
                    download: false,
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
        function filterHTMLDoctorForm() {
            let field = $("#tbBranch-html-filter-field").val();
            let type = $("#tbBranch-html-filter-type").val();
            let value = $("#tbBranch-html-filter-value").val();
            table.setFilter(field, type, value);
        }

        // On submit filter form
        $("#tbBranch-html-filter-form")[0].addEventListener(
            "keypress",
            function (event) {
                let keycode = event.keyCode ? event.keyCode : event.which;
                if (keycode == "13") {
                    event.preventDefault();
                    filterHTMLDoctorForm();
                }
            }
        );

        // On click go button
        $("#tbBranch-html-filter-go").on("click", function (event) {
            filterHTMLDoctorForm();
        });

        // On reset filter form
        $("#tbBranch-html-filter-reset").on("click", function (event) {
            $("#tbBranch-html-filter-field").val("doctorCodeNo");
            $("#tbBranch-html-filter-type").val("like");
            $("#tbBranch-html-filter-value").val("");
            filterHTMLDoctorForm();
        });

        // Export
        $("#tbBranch-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            table.download("xlsx", "HospitalBranch.xlsx", {
                sheetName: "Branch",
            });
        });
        // Print
        $("#tbBranch-print").on("click", function (event) {
            table.print();
        });
    }
}
/*------------------------ Search Branch End ------------------------*/
/*------------------------ View Branch Begin ------------------------------*/
function viewBranch($branchId){
    var token=$('#txtToken').val();
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/branchInfo/'+$branchId;
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divBranchErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $(imgLogo).attr("src",data.branchDetails.logo);
                $('#divHospitalName span').text(data.branchDetails.hospitalName);
                $('#divContactPerson span').text(data.branchDetails.contactPerson);
                $('#divName span').text(data.branchDetails.branchName);
                $('#divPhoneNo span').text(data.branchDetails.phoneNo+" , "+data.branchDetails.contactPersonPhNo);
                $('#divEmail span').text(data.branchDetails.email);
                $('#divAddress span').text(data.branchDetails.address);
                const viewModal = tailwind.Modal.getInstance(document.querySelector("#divViewBranch"));
                viewModal.show();
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
/*------------------------ View Branch End ------------------------------*/
/*----------------------------------- Delete Branch By ID BEGINS -------------------------*/
function deleteBranch(branchId,userId){
    var token=$('#txtToken').val();
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/deleteBranch/'+branchId+'/'+userId;
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divBranchErrorModal"));
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
                  const el = document.querySelector("#divDeleteBranch"); 
                  const modal = tailwind.Modal.getOrCreateInstance(el); 
                  modal.hide();
                  setBranchTabulator();
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
    
    /*----------------------------------- Delete Branch By ID END -------------------------*/
/*--------------------------------------Edit Branch Begins------------------------------*/
const branchEditform = document.getElementById('frmEditBranch');
if(branchEditform!=null){
    branchEditform.addEventListener("submit", (epf) => {
    epf.preventDefault();
     const branchdata = new FormData(branchEditform);
     const file = document.querySelector('#txtLogo').files[0];
     if(file!=null){
        branchdata.append('logo', file);
     }
     var token=$('#txtToken').val();
     let options = {
         method: "POST",
         body: branchdata,
         headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
     };
     var base_url = localStorage.getItem("base_url");
     var url=base_url+'/api/updateBranch';
     const errorDrModal = tailwind.Modal.getInstance(document.querySelector("#divErrorEditHospital"));
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             if(data.Success=='Success'){
                 $('#divMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    const successEditModal = tailwind.Modal.getInstance(document.querySelector("#divSuccessEditHospital"));
                     successEditModal.show();    
                 }                   
             }else{
                 $('#divErrorHead span').text(data.Success);
                 $('#divErrorMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    errorDrModal.show();
                 }else if(data.ShowModal==2)
                 {
                    logoutSession(data.Message);
                 }
             }
         })
         .catch(function(error){
             $('#divErrorHead span').text('Error');
             $('#divErrorMsg span').text(error);
             errorDrModal.show();
         });       
 });      
}
/*-------------------------------------------------Edit Branch Ends -----------------------------*/
$( "#btnbrRedirect" ).on( "click", function() {
    window.scrollTo(0, 0);
    window.location.href = localStorage.getItem("base_url")+ "/SearchBranch";
});
/*-------------------------------------- Consent Form --------------------------------------*/
$( "#ddlPatientList" ).on( "change", function() {
    $("#txtPatient").val($("#ddlPatientList").val());
});
function consentFormOnLoad(){
    $("#divNewPanel").addClass('hidden');
    var patientId=$("#txtPatient").val();
    if(patientId!=0){
        clearConsentForm();
        getPatientFormInfo();
        $("#divRegPanel").addClass('hidden');
        $("#divNewPanel").removeClass("hidden").removeAttr("style");
        document.getElementById('btnPrintConsent').disabled = false;
        // document.getElementById('btnPrintAllConsent').disabled = false; 
    }
    // $("#btnRegNoClear").on("click", function () {
    //     // $("#txtRegNo").val("");
    //     clearConsentForm();
    // });
    $("#btnNewConsent").on("click", function () {
        // $("#txtRegNo").val("");
        clearConsentForm();
        $("#divNewPanel").addClass('hidden');
        $("#divRegPanel").removeClass("hidden").removeAttr("style");
    });
    $("#btnGo").on("click", function () {
        clearConsentForm();
        getPatientFormInfo();  
        // $("#txtRegNo").val("");      
    });
    $( "#btnPrintConsent" ).on( "click", function() {
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
                    
                    var contents = $("#divConsentContent").html();
                    var frame1 = $('<iframe />');
                    var style='<head><style>@media print {@page {size: auto; } body{margin: '+pixelsmt+'px '+pixelsmr+'px '+pixelsmb+'px '+pixelsml+'px ;}}</style></head>';
                    frame1[0].name = "frame1";//margin: 0mm;
                    frame1.css({ "position": "absolute", "top": "-1000000px" });
                    $("body").append(frame1);
                    var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
                    frameDoc.document.open();
                    //Create a new HTML document.
                    frameDoc.document.write('<html>'+style);
                    frameDoc.document.write('<body>');
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
                }else{
                    if (typeof data.ShowModal !== 'undefined') {
                        if(data.ShowModal==2)
                        {
                            logoutSession(data.Message);
                        }
                    }
                }
            })
            .catch(function(error){
                const errorDrModal = tailwind.Modal.getInstance(document.querySelector("#divConsentErrorModal"));
                $('#divErrorHead span').text('Error');
                $('#divErrorMsg span').text(error);
                errorDrModal.show();
            }); 
    });
}
/*----------------- clear consent form -----------*/
    function clearConsentForm(){
        sessionStorage.removeItem("selectedForm");
        document.getElementById('btnPrintConsent').disabled = true;
        // document.getElementById('btnPrintAllConsent').disabled = true;
        document.getElementById('divFormNameList').innerHTML="";
        document.getElementById('divConsentContent').innerHTML='<div class="mx-auto text-center"><div class="font-medium">Please click the form to view</div></div>';
        $('#divConsentHeader span').text("");
        $("#divProfile").addClass('hidden');
        $("#divFormList").addClass('hidden');
        $("#divFormContent").addClass('hidden');       
    }
    
    /*----------------------------------------------- Display Patient Info and Consent Form BEGIN -------------------------------------*/
    function getPatientFormInfo(){
        let selectedForm=[];
        var index_id;
    var base_url = localStorage.getItem("base_url");
    const errorDrModal = tailwind.Modal.getInstance(document.querySelector("#divConsentErrorModal"));
    var hospitalId=$("#txtHospital").val();
    var branchId=$("#txtBranch").val()==""?0:$("#txtBranch").val();
    var patientId=$("#txtPatient").val();
    if(patientId==""||patientId==0||patientId==null){
        $('#divErrorHead span').text('Error');
        $('#divErrorMsg span').text("Please select the Patient");
        errorDrModal.show();
    }else{
        
        var token=$('#txtToken').val();
            var url=base_url+'/api/consentFormList/'+hospitalId+'/'+branchId+'/'+patientId;
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
                        //Load Consent form list -- BEGIN
                        var html = "";
                        var formList=data.consentList;
                        var i=1;
                        formList.forEach(function(value, key) {
                            var ctrl_name='div'+i;
                            html = '<div id='+ctrl_name+' title="'+value.formTitle+'" class="intro-x bg-primary text-white cursor-pointer box relative flex items-center p-5 '+(i>1?'mt-5':'')+' "><div class="form-check mt-2"> <input id="chk'+value.id+'" class="form-check-input" type="checkbox"><label class="form-check-label" for="chk'+value.id+'"> <div class="flex items-center"><a href="javascript:;" class="font-medium">'+value.formName+'</a> </div></label></div></div>'; 
                            $('#divFormNameList').append(html);
                            let options = {
                                content: $('#'+ctrl_name).attr("title"),
                            };
                            tippy($('#'+ctrl_name), {
                                arrow: roundArrow,
                                animation: "shift-away",
                                ...options,
                            });
                                    // Consent for display -- BEGIN
                                    $("#div"+i).on("click",function(){
                                                $(".chat__box")
                                            .children("div:nth-child(2)")
                                            .fadeOut(300, function () {
                                                $(".chat__box")
                                                    .children("div:nth-child(1)")
                                                    .fadeIn(300, function (el) {
                                                        $(el).removeClass("hidden").removeAttr("style");
                                                    });
                                            });
                                    // Consent for display -- END
                                            //Get the checked Checkbox ---BEGIN
                                    var chkId='#chk'+value.id;
                                    $(chkId).on("change",function(event) {
                                        if(this.checked) {
                                            index_id=selectedForm.indexOf(value.id);
                                            if(index_id<0){
                                                selectedForm.push(value.id);
                                            }
                                        }else if(!this.checked){
                                            index_id=selectedForm.indexOf(value.id);
                                            if(index_id>=0){
                                                selectedForm.splice(index_id,1);
                                            }
                                        }
                                        sessionStorage.setItem("selectedForm", selectedForm);
                                    });                             
                                    //Get the checked Checkbox ---END
                                    let currentDate = new Date().toISOString().slice(0, 10).split('-').reverse().join('/'); 
                                    let display_formContent=value.formContent;
                                     display_formContent=display_formContent.replaceAll("@hospitalName", data.patientDetails.hospitalName);
                                     display_formContent=display_formContent.replaceAll("@hospitalAddress", data.patientDetails.hospitalAddress);
                                     display_formContent= display_formContent.replaceAll("@patientName", data.patientDetails.name);
                                     display_formContent= display_formContent.replaceAll("@patientPhoneNo", data.patientDetails.phoneNo);
                                     display_formContent= display_formContent.replaceAll("@patientAddress", data.patientDetails.address);
                                     display_formContent= display_formContent.replaceAll("@spouseName", data.patientDetails.spouseName);
                                     display_formContent= display_formContent.replaceAll("@aadharCardNo", data.patientDetails.aadharCardNo);
                                     display_formContent= display_formContent.replaceAll("@date", currentDate);
                                     display_formContent= display_formContent.replaceAll("@place", data.patientDetails.city);
                                     display_formContent= display_formContent.replaceAll("@witnessName", data.patientDetails.witnessHospital);
                                     display_formContent= display_formContent.replaceAll("@witnessAddress", data.patientDetails.witnessHospAddress);
                                     display_formContent= display_formContent.replaceAll("@witnessBankName", data.patientDetails.witnessBank);
                                     display_formContent= display_formContent.replaceAll("@witnessBankAddress", data.patientDetails.witnessBankAddress);
                                     display_formContent= display_formContent.replaceAll("@donorBankName", data.patientDetails.donorBankName);
                                     display_formContent= display_formContent.replaceAll("@donorBankAddress", data.patientDetails.donorBankAddress);
                                     display_formContent= display_formContent.replaceAll("@attendingDoctor", data.patientDetails.attendingDoctor);
                                     display_formContent= display_formContent.replaceAll("@attendingDoctorAddress", data.patientDetails.attendingDoctorAddress); 
                                     display_formContent= display_formContent.replaceAll("@counsellor", data.patientDetails.counsellor);
                                     display_formContent= display_formContent.replaceAll("@counsellorAddress", data.patientDetails.counsellorAddress);
                                     display_formContent= display_formContent.replaceAll("@shapeImg",base_url+ "/images/shape1.png");

                                document.getElementById('divConsentContent').innerHTML=display_formContent;
                                $('#divConsentHeader span').text(value.formName);                               
                            });
                            i=i+1;
                        });
                        //Load Consent form list -- END
                        /*------------------ select the checkbox BEGIN ---------------*/
                        data.selectedForm.forEach(element=> {
                            var chkSelectedId='#chk'+element['consentFormId'];
                            $(chkSelectedId).attr('checked', true);
                            document.getElementById('btnPrintConsent').disabled = false;

                            index_id=selectedForm.indexOf(element['consentFormId']);
                            if(index_id<0){
                                    selectedForm.push(element['consentFormId']);
                            }
                        });
                        if(selectedForm!=null && selectedForm.length>0){
                            sessionStorage.setItem("selectedForm", selectedForm);
                        }
                        /*------------------ select the checkbox END ---------------*/
                        // Patient Information --- Begin
                            $('#txtPatientId').val(data.patientDetails.patientId);
                            $('#divName span').text(data.patientDetails.name);
                            $('#divRegNo span').text(data.patientDetails.hcNo);
                            $('#divEmail span').text(data.patientDetails.email);
                            $('#divPhoneNo span').text(data.patientDetails.phoneNo);
                            $('#divAddress span').text(data.patientDetails.address);
                            $('#divState span').text(data.patientDetails.stat);
                            $('#divAadharCardNo span').text(data.patientDetails.aadharCardNo);
                            $('#divGender span').text(data.patientDetails.gender);
                            $('#divDob span').text(data.patientDetails.dob);
                            $('#divAge span').text(data.patientDetails.age);
                            $('#divBloodGrp span').text(data.patientDetails.bloodGroup);
                            $('#divHeight span').text(data.patientDetails.height);
                            $('#divWeight span').text(data.patientDetails.weight);
                            $('#divSpouseName span').text(data.patientDetails.spouseName);
                            $('#divSpousePhoneNo span').text(data.patientDetails.spousePhnNo);
                            $('#divReason span').text(data.patientDetails.reason);
                            $('#divReferedBy span').text(data.patientDetails.counsellor);
                            $('#divWitnessHospital span').text(data.patientDetails.witnessHospital);
                            $('#divWitnessBank span').text(data.patientDetails.witnessBank);
                            $('#divDonorBankName span').text(data.patientDetails.donorBankName);
                            $('#divDonorBankAddress span').text(data.patientDetails.donorBankAddress);
                            $('#divAttendingDoctor span').text(data.patientDetails.attendingDoctor);
                           
                        // Patient Information --- END
                        $("#divProfile").removeClass("hidden").removeAttr("style");
                        $("#divFormList").removeClass("hidden").removeAttr("style");
                        $("#divFormContent").removeClass("hidden").removeAttr("style");
                    }else{
                        $('#divErrorHead span').text(data.Success);
                        $('#divErrorMsg span').text(data.Message);
                        if (data.ShowModal==1) {
                        errorDrModal.show();
                        }else if(data.ShowModal==2)
                        {
                           logoutSession(data.Message);
                        }
                    }
                })
                .catch(function(error){
                    $('#divErrorHead span').text('Error');
                    $('#divErrorMsg span').text(error);
                    errorDrModal.show();
                }); 
    }      
}
/*----------------------------------------------- Display Patient Info and Consent Form END -------------------------------------*/
/*--------------------------- Save CONSENT FORM BEGIN ------------------------------*/
const consentForm = document.getElementById('frmPatientConsentForm');
if(consentForm!=null){
consentForm.addEventListener("submit", (e) => {
    e.preventDefault();
    var selectedForm= sessionStorage.getItem("selectedForm");
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divConsentErrorModal"));
    if(selectedForm==null || selectedForm.length==0){
        $('#divErrorHead span').text('Validation Error');
        $('#divErrorMsg span').text("Please select the any one of the consent form");
        errorModal.show();
        return;
    }

    const consentdata = new FormData(consentForm);

    consentdata.append('consentFormList', selectedForm);
     var token=$('#txtToken').val();
    let options = {
        method: "POST",
        body: consentdata,
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    };
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/savePatientConsent';
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $('#divMsg span').text(data.Message);
                if (data.ShowModal==1) {
                   const successModal = tailwind.Modal.getInstance(document.querySelector("#divSuccessModal"));
                   successModal.show(); 
                   document.getElementById('btnPrintConsent').disabled = false;
                   // document.getElementById('btnPrintAllConsent').disabled = false;   
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
/*--------------------------- Save CONSENT FORM END ------------------------------*/
/*------------------------------------ Search Consent Form Begin ----------------------------*/
function setConsentTabulator(){
    // Tabulator
    if ($("#tbConsent").length) {
        // Setup Tabulator
        var hospitalId=$("#txtHospital").val();
        var branchId=$("#txtBranch").val();
        var token=$('#txtToken').val();
        let table = new Tabulator("#tbConsent", {
            ajaxURL: localStorage.getItem("base_url")+"/api/patientConsentList",
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
                    headerSort: false,
                },

                // For HTML table
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
                    title: "CONSENT FORM",
                    minWidth: 300,
                    field: "consentForms",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "CREATED DATE",
                    minWidth: 120,
                    field: "created_date",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "UPDATED DATE",
                    minWidth: 120,
                    field: "updated_at",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
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
                            <a class="edit flex items-center mr-3 text-primary" href="javascript:;">
                                <i data-lucide="check-square" class="w-5 h-5 mr-1"></i> 
                            </a>
                        </div>`);
                        $(a)
                            .find(".edit")
                            .on("click", function () {
                                window.location.href= localStorage.getItem("base_url")+"/ConsentForm/"+cell.getData().patientId;
                            });
                        return a[0];
                    },
                },

                // For print format
                {
                    title: "REGISTERED NO",
                    field: "hcNo",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "PATIENT NAME",
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
                    title: "CONSENT FORM",
                    field: "consentForms",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "CREATED DATE",
                    field: "created_date",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "UPDATED DATE",
                    field: "updated_at",
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
        function filterHTMLDoctorForm() {
            let field = $("#tbConsent-html-filter-field").val();
            let type = $("#tbConsent-html-filter-type").val();
            let value = $("#tbConsent-html-filter-value").val();
            table.setFilter(field, type, value);
        }

        // On submit filter form
        $("#tbConsent-html-filter-form")[0].addEventListener(
            "keypress",
            function (event) {
                let keycode = event.keyCode ? event.keyCode : event.which;
                if (keycode == "13") {
                    event.preventDefault();
                    filterHTMLDoctorForm();
                }
            }
        );

        // On click go button
        $("#tbConsent-html-filter-go").on("click", function (event) {
            filterHTMLDoctorForm();
        });

        // On reset filter form
        $("#tbConsent-html-filter-reset").on("click", function (event) {
            $("#tbConsent-html-filter-field").val("hcNo");
            $("#tbConsent-html-filter-type").val("like");
            $("#tbConsent-html-filter-value").val("");
            filterHTMLDoctorForm();
        });

        // Export
        $("#tbConsent-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            table.download("xlsx", "PatientConsentForm.xlsx", {
                sheetName: "PatientConsentForm",
            });
        });
        // Print
        $("#tbConsent-print").on("click", function (event) {
            table.print();
        });
    }
}
/*------------------------ Search Hospital End ------------------------*/
function loadViewConsentForm(){
    var base_url = localStorage.getItem("base_url");
    var hospitalId=$("#txtHospital").val();
    var branchId=$("#txtBranch").val()==""?0:$("#txtBranch").val();
    var url=base_url+'/api/consentFormList/'+hospitalId+'/'+branchId+'/'+0;
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
                        //Load Consent form list -- BEGIN
                        var html = "";
                        var formList=data.consentList;
                        var i=1;
                        formList.forEach(function(value, key) {
                            var ctrl_name='div'+i;
                            html = '<div id='+ctrl_name+' title="'+value.formTitle+'" class="intro-x bg-primary text-white cursor-pointer box relative flex items-center p-5 '+(i>1?'mt-5':'')+'"><div class="flex items-center"><a href="javascript:;" class="font-medium">'+value.formName+'</a> </div></div> '; 
                            $('#divFormNameList').append(html);
                            let options = {
                                content: $('#'+ctrl_name).attr("title"),
                            };
                            tippy($('#'+ctrl_name), {
                                arrow: roundArrow,
                                animation: "shift-away",
                                ...options,
                            });
                                    // Consent for display -- BEGIN
                                    $("#div"+i).on("click",function(){
                                                $(".chat__box")
                                            .children("div:nth-child(2)")
                                            .fadeOut(300, function () {
                                                $(".chat__box")
                                                    .children("div:nth-child(1)")
                                                    .fadeIn(300, function (el) {
                                                        $(el).removeClass("hidden").removeAttr("style");
                                                    });
                                            });
                                    let display_formContent=value.formContent;
                                    display_formContent= display_formContent.replaceAll("@shapeImg",base_url+ "/images/shape1.png");
                                    document.getElementById('divConsentContent').innerHTML=display_formContent;
                                $('#divConsentHeader span').text(value.formName);    
                                window.scrollTo(0, 0);                           
                            });
                            i=i+1;
                        });
                    }else{
                        if (typeof data.ShowModal !== 'undefined') {
                            if(data.ShowModal==2)
                            {
                             logoutSession(data.Message);
                            }
                        }
                    }
                });
}
function take_snapshot() {
    Webcam.snap( function(data_uri) {
        $(".image-tag").val(data_uri);
        $(imgProfileImage).attr("src",data_uri);
    } );
}
function clearTabData(tabNo){
switch(tabNo){
    case 1:
        $("#divPatientInfo").addClass('hidden');
        $('#txtPatient').val("");
        $('#ddlAppointmentPatient').val('0');
        break;
    case 2:
        $("#txtName").val("");
        $("#txtPhoneNo").val("");
        $("#txtEmail").val("");
        break;
}
}
$( "#btnTab1" ).on( "click", function() {
    clearTabData(1);
    $("#txtTabNo").val(1);
});
$( "#btnTab2" ).on( "click", function() {
    clearTabData(2);
    $("#txtTabNo").val(2);
});
function addAppointmentLoadEvent(base_url){
    //Hide patient panel
    clearTabData(1);
    $("#txtTabNo").val(1);
    var hospitalId=$("#txtHospital").val();
    var branchId=$("#txtBranch").val();
    // Tab change event
    const myTabEl = document.getElementById('divPatientTab') ;
    myTabEl.addEventListener('show.tw.tab', function(event) { alert("called");}) 
    var token=$('#txtToken').val();
    //Load Dropdowns
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    var url=base_url+'/api/listAppointmentDDl';
    fetch(url,options)
            .then(response => response.json())
            .then(function (result) {
                if(result.Success=='Success'){
                    var listGender=result.gender;
                    listGender.forEach(function(value, key) {
                        $("#ddlGender").append($("<option></option>").val(value.name).html(value.name)); 
                    });

                    var listDepartment=result.department;
                    listDepartment.forEach(function(value, key) {
                        $("#ddlDepartment").append($("<option></option>").val(value.id).html(value.name)); 
                    });
                }
            });  
    
            //Doctor details   
        var doctorUrl=base_url+'/api/doctorByDepartment/'+hospitalId+'/'+branchId+'/0';
    fetch(doctorUrl,options)
            .then(response => response.json())
            .then(function (result) {
                if(result.Success=='Success'){
                    var listDoctor=result.doctorList;
                    listDoctor.forEach(function(value, key) {
                        $("#ddlDoctor").append($("<option></option>").val(value.id).html(value.name)); 
                    });
                }
            });    
    
            //Department change load doctor
     $("#ddlDepartment").on('change',function() {
        var departmentId=$("#ddlDepartment").val();
        var doctorUrl=base_url+'/api/doctorByDepartment/'+hospitalId+'/'+branchId+'/'+departmentId;
        fetch(doctorUrl,options)
                .then(response => response.json())
                .then(function (result) {
                    if(result.Success=='Success'){
                        $("#ddlDoctor option").remove();
                        $("#ddlDoctor").append($("<option></option>").val(0).html("Select Doctor"));
                        var listDoctor=result.doctorList;
                        listDoctor.forEach(function(value, key) {
                            $("#ddlDoctor").append($("<option></option>").val(value.id).html(value.name)); 
                        });
                    }
                });  
     });      
    
     //Display Patient Information
     $( "#ddlAppointmentPatient" ).on( "change", function() {
        var patientId=$("#ddlAppointmentPatient").val();
        $("#txtPatient").val(patientId);
            const errorModal = tailwind.Modal.getInstance(document.querySelector("#divErrorAppointment"));
            var url=base_url+'/api/registeredPatientInfo/'+patientId+'/'+hospitalId+'/'+branchId;
            fetch(url, options)
            .then(function(response){ 
                return response.json(); 
             })
            .then(function(data){ 
                if(data.Success=='Success'){
                    if(data.patientDetails!=null){
                        $('#txtPatientId').val(data.patientDetails.patientId);
                            $(imgProfileImage).attr("src",data.patientDetails.profileImage);
                            $('#lblHcNo span').text(data.patientDetails.hcNo);
                            $('#lblName span').text(data.patientDetails.name);
                            $('#lblPhoneNo span').text(data.patientDetails.phoneNo);
                            $('#lblEmail span').text(data.patientDetails.email);
                            $('#lblDob span').text(data.patientDetails.dob);
                            $('#lblAge span').text(data.patientDetails.age);
                            $('#lblGender span').text(data.patientDetails.gender);
                            $('#lblBloodGrp span').text(data.patientDetails.bloodGroup);
                            $('#lblMartialStatus span').text(data.patientDetails.martialStatus);
                            $('#lblHeight span').text(data.patientDetails.patientHeight);
                            $('#lblWeight span').text(data.patientDetails.patientWeight);
                            $('#lblAddress span').text(data.patientDetails.address);
                            $('#lblCity span').text(data.patientDetails.city);
                            $('#lblState span').text(data.patientDetails.state);
                            $('#lblPincode span').text(data.patientDetails.pincode);
                            $('#lblReason span').text(data.patientDetails.reason);
                            $('#lblSpouseName span').text(data.patientDetails.spouseName);
                            $('#lblSpousePhNo span').text(data.patientDetails.spousePhnNo);

                            $("#divPatientInfo").removeClass("hidden").removeAttr("style");
                    }else{
                        $('#divAppErrorHead span').text("Invalid Registered Number");
                        $('#divAppErrorMsg span').text("Please enter the valid registered number");
                        $("#divPatientInfo").addClass('hidden');
                        errorModal.show();
                        return false;
                    }
                }else{
                    $('#divAppErrorHead span').text(data.Success);
                    $('#divAppErrorMsg span').text(data.Message);
                    if (data.ShowModal==1) {
                        $("#divPatientInfo").addClass('hidden');
                        errorModal.show();
                    }else if(data.ShowModal==2)
                    {
                        logoutSession(data.Message);
                    }
                }
            })
            .catch(function(error){
                $('#divAppErrorHead span').text('Error');
                $('#divAppErrorMsg span').text(error);
                $("#divPatientInfo").addClass('hidden');
                errorModal.show();
            }); 
        });
}
 /* --------------- Patient Add form submit Begins ------------------------*/

 const appointmentForm = document.getElementById('frmAppointment');
 if(appointmentForm!=null){
 //Patient registeration
 appointmentForm.addEventListener("submit", (e) => {
     e.preventDefault();
     const appointmentdata = new FormData(appointmentForm);
     const appointmentParams=new URLSearchParams(appointmentdata);
     var token=$('#txtToken').val();

     let options = {
         method: "POST",
         body: appointmentParams,
         headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
     };
     var base_url = localStorage.getItem("base_url");
     var url=base_url+'/api/addPatientAppointment';
     const errorModal = tailwind.Modal.getInstance(document.querySelector("#divErrorAppointment"));
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             if(data.Success=='Success'){
                 $('#divMsg span').text(data.Message);
                 $('#divPatientMsg span').text(data.patientMsg);
                 if (data.ShowModal==1) {
                     const successModal = tailwind.Modal.getInstance(document.querySelector("#divSuccessAppointment"));
                     successModal.show();    
                     clearTabData(1);
                     clearTabData(2);
                     document.getElementById("frmAppointment").reset();
                     $("#ddlBranch option").remove();
                        $("#ddlBranch").append($("<option></option>").val(0).html("Select Branch"));
                        $("#divBranchddl").addClass('hidden');
                 }                   
             }else{
                 $('#divAppErrorHead span').text(data.Success);
                 $('#divAppErrorMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                     errorModal.show();
                  }else if(data.ShowModal==2)
                  {
                     logoutSession(data.Message);
                  }
             }
         })
         .catch(function(error){
             $('#divAppErrorHead span').text('Error');
             $('#divAppErrorMsg span').text(error);
             errorModal.show();
         });
         window.scrollTo(0, 0);
 });
  
 }
 /* --------------- Appontment Add form submit End ------------------------*/
 $( "#btnCancelAppointment" ).on( "click", function() {
    clearTabData(1);
    clearTabData(2);
    $("#txtTabNo").val(1);
    // const myTab = tailwind.Tab.getInstance(document.querySelector("#divPatientTab1"));
    // myTab.show();
 });
/*------------------------------------------- Appointment Search BEGIN -------------------------*/ 
function setAppointmentTabulator(){
    // Tabulator
    if ($("#tbAppointment").length) {
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        // Setup Tabulator
        var token=$('#txtToken').val();
        let table = new Tabulator("#tbAppointment", {
            ajaxURL: localStorage.getItem("base_url")+"/api/appointmentList",
            ajaxParams: {"hospitalId": hospitalId,"branchId":branchId,"type":1},
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
            // dataTree:true,
            // dataTreeStartExpanded:true,
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
                    title: "APPOINTMENT DATE & TIME",
                    minWidth: 50,
                    field: "appointmentDateTime",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "REGISTERED NO",
                    minWidth: 50,
                    field: "hcNo",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "PATIENT NAME",
                    minWidth: 100,
                    field: "patientName",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
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
                    title: "STATUS",
                    minWidth: 80,
                    field: "status",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        let a = $(`<div class="flex lg:justify-center items-center text-white">
                             <mark class="p-1 bg-${
                                cell.getData().statusColor
                             } rounded-full">
                               <a class="status flex items-center mr-3 tooltip" title="View Appointment Details" href="javascript:;">
                                ${
                                    cell.getData().status
                                 }
                               </a>
                            </mark>
                         </div>  `);
                         $(a)
                        .find(".status")
                        .on("click", function () {
                            $("#txtAppointmentId").val(cell.getData().id);
                            var rdName="rd"+cell.getData().status;
                            document.getElementById(rdName).checked = true;
                            const viewModal = tailwind.Modal.getInstance(document.querySelector("#divStatusModal"));
                            viewModal.show();
                        });
                        return a[0];
                    },
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
                            <a class="tooltip view flex items-center mr-3" title="View Appointment Details" href="javascript:;">
                                <i data-lucide="eye" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="tooltip edit flex items-center mr-3 text-primary" href="javascript:;">
                                <i data-lucide="check-square" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="tooltip delete flex items-center text-danger" href="javascript:;">
                                <i data-lucide="trash-2" class="w-5 h-5 mr-1"></i> 
                            </a>
                        </div>`);
                        $(a)
                        .find(".view")
                        .on("click", function () {
                            viewPatientAppointment(cell.getData().id);
                        });
                        $(a)
                            .find(".edit")
                            .on("click", function () {
                                window.location.href= localStorage.getItem("base_url")+"/showAppointment/"+cell.getData().id+"/1";
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeleteAppointment"));
                                deleteModal.show();
                                $('#txtId').val(cell.getData().id);
                                $( "#btnDelAppointment" ).on( "click", function() {
                                    var userId=$('#txtUser').val();
                                    deleteAppointment(cell.getData().id,userId);
                                });
                            });

                        return a[0];
                    },
                },

                // For print format
                {
                    title: "APPOINTMENT DATE",
                    field: "appointmentDate",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "APPOINTMENT TIME",
                    field: "appointmentTime",
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
                    title: "PATIENT NAME",
                    field: "patientName",
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
                {
                    title: "STATUS",
                    field: "status",
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
            let field = $("#tbAppointment-html-filter-field").val();
            let type = $("#tbAppointment-html-filter-type").val();
            let value = $("#tbAppointment-html-filter-value").val();
            let dateValue= $("#tbAppointment-html-filter-value-1").val();
            if(field=='appointmentDate'){
                table.setFilter(field, type, dateValue);
            }else{
                table.setFilter(field, type, value);
            }
        }

        // On submit filter form
        $("#tbAppointment-html-filter-form")[0].addEventListener(
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
        $("#tbAppointment-html-filter-go").on("click", function (event) {
            filterHTMLForm();
        });

        // On reset filter form
        $("#tbAppointment-html-filter-reset").on("click", function (event) {
            $("#tbAppointment-html-filter-field").val("hcNo");
            $("#tbAppointment-html-filter-type").val("like");
            $("#tbAppointment-html-filter-value").val("");
            $("#tbAppointment-html-filter-value-1").val("");

            $("#divValueSearch").removeClass("hidden").removeAttr("style");
            $("input#tbAppointment-html-filter-value").show();
            $("#tbAppointment-html-filter-value-label").show();
    
            $("#divDateSearch").addClass('hidden');      
            $("input#tbAppointment-html-filter-value-1").hide();
            $("#tbAppointment-html-filter-value-1-label").hide();

            filterHTMLForm();
        });

        // Export
        $("#tbAppointment-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            table.download("xlsx", "Patients.xlsx", {
                sheetName: "PatientAppointment",
            });
        });
        // Print
        $("#tbAppointment-print").on("click", function (event) {
            table.print();
        });
    }
}
/*------------------------------------------- Appointment Search END -------------------------*/ 
$( "#tbAppointment-html-filter-field" ).on( "change", function() {
    $("#tbAppointment-html-filter-value").val("");
    $("#tbAppointment-html-filter-value-1").val("");
    var field=$( "#tbAppointment-html-filter-field" ).val();
    if(field=='appointmentDate'){
        $("#divDateSearch").removeClass("hidden").removeAttr("style");
        $("input#tbAppointment-html-filter-value-1").show();
        $("#tbAppointment-html-filter-value-1-label").show();

        $("#divValueSearch").addClass('hidden');
        $("input#tbAppointment-html-filter-value").hide();
        $("#tbAppointment-html-filter-value-label").hide();
    }else{
        $("#divValueSearch").removeClass("hidden").removeAttr("style");
        $("input#tbAppointment-html-filter-value").show();
        $("#tbAppointment-html-filter-value-label").show();

        $("#divDateSearch").addClass('hidden');      
        $("input#tbAppointment-html-filter-value-1").hide();
        $("#tbAppointment-html-filter-value-1-label").hide();
    }
} );
/*------------------------ View Patient Appointment Begin ------------------------------*/
function viewPatientAppointment(appointmentId){
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/patientAppointmentInfo/'+appointmentId;
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divAppointmentErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $(imgProfileImage).attr("src",data.appointmentDetails.profileImage);
                $('#lblHcNo span').text(data.appointmentDetails.hcNo);
                $('#lblStatus span').text(data.appointmentDetails.status);
                $('#lblName span').text(data.appointmentDetails.patientName);
                $('#lblPhoneNo span').text(data.appointmentDetails.phoneNo);
                $('#lblEmail span').text(data.appointmentDetails.email);
                $('#lblGender span').text(data.appointmentDetails.gender);
                $('#lblBloodGrp span').text(data.appointmentDetails.bloodGroup);
                $('#lblMartialStatus span').text(data.appointmentDetails.martialStatus);
                $('#lblHeight span').text(data.appointmentDetails.patientHeight);
                $('#lblWeight span').text(data.appointmentDetails.patientWeight);
                $('#lblAddress span').text(data.appointmentDetails.address);
                $('#lblReason span').text(data.appointmentDetails.reason);
                $('#lblSpouseName span').text(data.appointmentDetails.spouseName);
                $('#lblSpousePhNo span').text(data.appointmentDetails.spousePhnNo);
                $('#lblAppointmentDate span').text(data.appointmentDetails.appointmentDate);
                $('#lblAppointmentTime span').text(data.appointmentDetails.appointmentTime);
                $('#lblDoctorName span').text(data.appointmentDetails.doctorName);
                $('#lblDepartment span').text(data.appointmentDetails.departmentName);
                const viewModal = tailwind.Modal.getInstance(document.querySelector("#divViewAppointment"));
                viewModal.show();
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
/*------------------------ View Patient Appointment End ------------------------------*/
/*----------------------------------- Delete Patient Appointment By ID bEGINS -------------------------*/
function deleteAppointment(appointmentId,userId){
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/deleteAppointment/'+appointmentId+'/'+userId;
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divAppointmentErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                if (data.ShowModal==1) {
                    const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeleteAppointment"));
                    deleteModal.hide();
                    var type=$('#txtType').val();
                    if(type==1){
                        setAppointmentTabulator();
                    }else if(type==2){
                        setTodayAppointmentTabulator();
                    }
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

/*----------------------------------- Delete Patient Appointment By ID END -------------------------*/
/*--------------------------------------Edit patient Begins------------------------------*/
const appointmentEditform = document.getElementById('frmEditAppointment');
if(appointmentEditform!=null){
    appointmentEditform.addEventListener("submit", (epf) => {
    epf.preventDefault();
     const appointmentdata = new FormData(appointmentEditform);
     const params=new URLSearchParams(appointmentdata);

     const errorModal = tailwind.Modal.getInstance(document.querySelector("#divErrorEditAppointment"));
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
     var url=base_url+'/api/updateAppointment';
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             if(data.Success=='Success'){
                 $('#divMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    const successEditModal = tailwind.Modal.getInstance(document.querySelector("#divSuccessEditAppointment"));
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
/*-------------------------------------------------Edit patient Ends -----------------------------*/
$( "#btnAppointmentRedirect" ).on( "click", function() {
    window.scrollTo(0, 0);
    var base_url = localStorage.getItem("base_url");
    var type=$('#txtType').val();
    if(type==1){
        window.location.href = base_url+ "/AllAppointments";
    }else if(type==2){
        window.location.href = base_url+ "/TodayAppointments";
    }
});
/*-------------------------------------Appointment Update Status -----------------------------------------*/
const appointmentStatusEditform = document.getElementById('frmUpdAppointmentStatus');
if(appointmentStatusEditform!=null){
    appointmentStatusEditform.addEventListener("submit", (epf) => {
    epf.preventDefault();
     const appointmentdata = new FormData(appointmentStatusEditform);
     const params=new URLSearchParams(appointmentdata);
     var userId=$("#txtUser").val();
     params.append("userId", userId);

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
     var url=base_url+'/api/updateStatus';
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             if(data.Success=='Success'){
                const statusModal = tailwind.Modal.getInstance(document.querySelector("#divStatusModal"));
                var type=$('#txtType').val();
                if(type==1){
                    setAppointmentTabulator();
                }else if(type==2){
                    setTodayAppointmentTabulator();
                }
                 statusModal.hide();   
             }else{
                 $('#divErrorHead span').text(data.Success);
                 $('#divErrorMsg span').text(data.Message);
             }
         })
         .catch(function(error){
             $('#divErrorHead span').text('Error');
             $('#divErrorMsg span').text(error);
         });       
         /*-------------------------------------Appointment Update Status -----------------------------------------*/
 });      
}
 /*------------------------------------------- Today Appointment Search BEGIN -------------------------*/ 
 function setTodayAppointmentTabulator(){
    // Tabulator
    if ($("#tbAppointment").length) {
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        // Setup Tabulator
        var token=$('#txtToken').val();
        let table = new Tabulator("#tbAppointment", {
            ajaxURL: localStorage.getItem("base_url")+"/api/appointmentList",
            ajaxParams: {"hospitalId": hospitalId,"branchId":branchId,"type":2},
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
            // dataTree:true,
            // dataTreeStartExpanded:true,
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
                    title: "APPOINTMENT DATE & TIME",
                    minWidth: 50,
                    field: "appointmentDateTime",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "REGISTERED NO",
                    minWidth: 50,
                    field: "hcNo",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "PATIENT NAME",
                    minWidth: 100,
                    field: "patientName",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
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
                    title: "STATUS",
                    minWidth: 80,
                    field: "status",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        let a = $(`<div class="flex lg:justify-center items-center text-white">
                             <mark class="p-1 bg-${
                                cell.getData().statusColor
                             } rounded-full">
                               <a class="status flex items-center mr-3 tooltip" title="View Appointment Details" href="javascript:;">
                                ${
                                    cell.getData().status
                                 }
                               </a>
                            </mark>
                         </div>  `);
                         $(a)
                        .find(".status")
                        .on("click", function () {
                            $("#txtAppointmentId").val(cell.getData().id);
                            var rdName="rd"+cell.getData().status;
                            document.getElementById(rdName).checked = true;
                            const viewModal = tailwind.Modal.getInstance(document.querySelector("#divStatusModal"));
                            viewModal.show();
                        });
                        return a[0];
                    },
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
                            <a class="tooltip view flex items-center mr-3" title="View Appointment Details" href="javascript:;">
                                <i data-lucide="eye" class="w-4 h-4 mr-1"></i> 
                            </a>
                            <a class="tooltip edit flex items-center mr-3 text-primary" href="javascript:;">
                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> 
                            </a>
                            <a class="tooltip delete flex items-center text-danger" href="javascript:;">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> 
                            </a>
                        </div>`);
                        $(a)
                        .find(".view")
                        .on("click", function () {
                            viewPatientAppointment(cell.getData().id);
                        });
                        $(a)
                            .find(".edit")
                            .on("click", function () {
                                window.location.href= localStorage.getItem("base_url")+"/showAppointment/"+cell.getData().id+"/2";
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeleteAppointment"));
                                deleteModal.show();
                                $('#txtId').val(cell.getData().id);
                                $( "#btnDelAppointment" ).on( "click", function() {
                                    var userId=$('#txtUser').val();
                                    deleteAppointment(cell.getData().id,userId);
                                });
                            });

                        return a[0];
                    },
                },

                // For print format
                {
                    title: "APPOINTMENT DATE",
                    field: "appointmentDate",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "APPOINTMENT TIME",
                    field: "appointmentTime",
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
                    title: "PATIENT NAME",
                    field: "patientName",
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
                {
                    title: "STATUS",
                    field: "status",
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
            let field = $("#tbAppointment-html-filter-field").val();
            let type = $("#tbAppointment-html-filter-type").val();
            let value = $("#tbAppointment-html-filter-value").val();
                table.setFilter(field, type, value);
        }

        // On submit filter form
        $("#tbAppointment-html-filter-form")[0].addEventListener(
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
        $("#tbAppointment-html-filter-go").on("click", function (event) {
            filterHTMLForm();
        });

        // On reset filter form
        $("#tbAppointment-html-filter-reset").on("click", function (event) {
            $("#tbAppointment-html-filter-field").val("hcNo");
            $("#tbAppointment-html-filter-type").val("like");
            $("#tbAppointment-html-filter-value").val("");
            filterHTMLForm();
        });

        // Export
        $("#tbAppointment-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            table.download("xlsx", "Patients.xlsx", {
                sheetName: "PatientAppointment",
            });
        });
        // Print
        $("#tbAppointment-print").on("click", function (event) {
            table.print();
        });
    }
}
/*------------------------------------------- Today Appointment Search END -------------------------*/ 
/*-------------------------------------Appointment Update Status -----------------------------------------*/
const resetPwdForm = document.getElementById('frmRestPwd');
if(resetPwdForm!=null){
    resetPwdForm.addEventListener("submit", (epf) => {
    epf.preventDefault();
     const resetdata = new FormData(resetPwdForm);
     const params=new URLSearchParams(resetdata);

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
     var url=base_url+'/api/resetPassword';
     const errorModal = tailwind.Modal.getInstance(document.querySelector("#divPasswordErrorModal"));
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             if(data.Success=='Success'){
                $('#divMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    const successModal = tailwind.Modal.getInstance(document.querySelector("#divPasswordSuccessModal"));
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
$( "#btnReLogin" ).on( "click", function() {
    window.scrollTo(0, 0);
    var base_url = localStorage.getItem("base_url");
    window.location.href = base_url+ "/logout";
});
/*---------------------------------------------- Doctor Dashboard Appointment status CHART BEGIN ----------------------------*/
function getAppointmentStatusChart(){
if ($("#pie-chart-appointmentStatus").length) {
    if($('#txtType').val()==1){
    var token=$('#txtToken').val();
    var id=$('#txtDoctorId').val();
    let options = {
        method: "GET",
        headers: {
           Accept: 'application/json',
           Authorization: 'Bearer '+token,
         },
    };
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/appointmentStatusChart/'+id;
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divDashboardErrorModal"));

    var chart_data="";
    var chart_labels="";
    var chart_bgColor="";
    fetch(url, options)
    .then(function(response){ 
        return response.json(); 
    })
    .then(function(data){ 
        if(data.Success=='Success'){
           if (data.ShowModal==1) {
              chart_data=data.chart_data.length>0?data.chart_data:"";
              chart_labels=data.chart_labels.length>0?data.chart_labels:"";
              chart_bgColor=data.chart_bgColor;
              getChart(chart_labels,chart_data,chart_bgColor);
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
    }}
}
function getChart(chart_labels,chart_data,chart_bgColor){
if(chart_labels!=""){
    let ctx = $("#pie-chart-appointmentStatus")[0].getContext("2d");
    let myPieChart = new Chart(ctx, {
        type: "pie",
        data: {
            labels:chart_labels,
            datasets: [
                {
                    data: chart_data,
                    backgroundColor:chart_bgColor,
                    hoverBackgroundColor: chart_bgColor,
                    borderWidth: 5,
                    borderColor: $("html").hasClass("dark")
                        ? colors.darkmode[700]()
                        : colors.white,
                },
            ],
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: colors.slate["500"](0.8),
                    },
                },
                title: {
                    display: true,
                    text: 'Appointment Status'
                  },
            },
        },
    });
    }
}
/*---------------------------------------------- Doctor Dashboard Appointment status CHART END ----------------------------*/
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
        if(result.Success=='Success'){
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
                    var ddlDoctor=document.getElementById("ddlDoctor");
                    if(ddlDoctor!== null)
                    {
                        loadDoctorddl('ddlDoctor',doctorList);
                    }
                }
        }
    });
}
}
function loadDoctorddl(ddlCtrl,doctorList){
    var ddloption="#"+ddlCtrl+" option";
    $(ddloption).remove();
    $("#"+ddlCtrl).append($("<option></option>").val(0).html("Select Doctor"));
    doctorList.forEach(function(value, key) {
        $("#"+ddlCtrl).append($("<option></option>").val(value.id).html(value.name)); 
    });
}
function clearddlForSemen(){
    var ddlPatient=document.getElementById("ddlPatient");
    var ddlDoctor=document.getElementById("ddlDoctor");
    var ddlScientist1=document.getElementById("ddlScientist1");
    var ddlScientist2=document.getElementById("ddlScientist2");
    var ddlMedicalDirector=document.getElementById("ddlMedicalDirector");
    if(ddlPatient!==null){
        $("#ddlPatient option").remove();
        $("#ddlPatient").append($("<option></option>").val(0).html("Select Patient"));
    }
    if(ddlDoctor!==null){
        $("#ddlDoctor option").remove();
        $("#ddlDoctor").append($("<option></option>").val(0).html("Select Doctor"));
    }
    if(ddlScientist1!==null){
        $("#ddlScientist1 option").remove();
        $("#ddlScientist1").append($("<option></option>").val(0).html("Select Doctor"));
    }
    if(ddlScientist2!==null){
        $("#ddlScientist2 option").remove();
        $("#ddlScientist2").append($("<option></option>").val(0).html("Select Doctor"));
    }
    if(ddlMedicalDirector!==null){
        $("#ddlMedicalDirector option").remove();
        $("#ddlMedicalDirector").append($("<option></option>").val(0).html("Select Doctor"));
    }
}
/* Get Patient and Doctor for Semen Analysis --END */
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
            // dataTree:true,
            // dataTreeStartExpanded:true,
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
                sheetName: "PatientAppointment",
            });
        });
        // Print
        $("#tbSemen-print").on("click", function (event) {
            table.print();
        });
    }
}
/*------------------------------------------- Semen Search END -------------------------*/ 
/*------------------------------------------- Appointment Search END -------------------------*/ 
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
$( "#btnSemenAnalysisSuccess" ).on( "click", function() {
    window.scrollTo(0, 0);
    var base_url = localStorage.getItem("base_url");
    window.location.href = base_url+ "/SearchSemenAnalysis";
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
/*-------------- Report Load Year -----------------*/
function loadYear(){
    let dateDropdown = document.getElementById('ddlYear'); 
       
    let currentYear = new Date().getFullYear();    
    let earliestYear = 1990;     
    while (currentYear >= earliestYear) {      
      let dateOption = document.createElement('option');          
      dateOption.text = currentYear;      
      dateOption.value = currentYear;        
      dateDropdown.add(dateOption);      
      currentYear -= 1;    
    }
}
/*------------------------------ Report Option ------------------*/
$('#ddlReport').on('change',function(){
    var reportType=$('#ddlReport').val();
    switch(reportType){
        case '1':
            $("#divMonth").addClass('hidden');
            $("#divYear").addClass('hidden');
            $("#divDateRange").removeClass("hidden").removeAttr("style");
            break;
        case '2':
            $("#divYear").addClass('hidden');
            $("#divDateRange").addClass('hidden');
            $("#divMonth").removeClass("hidden").removeAttr("style");
            break;
        case '3':
            $("#divDateRange").addClass('hidden');
            $("#divMonth").addClass('hidden');
            $("#divYear").removeClass("hidden").removeAttr("style");
            break;
        default:
            hideReportOption();
            break;
    }
    });
    function hideReportOption(){
        $("#divDateRange").addClass('hidden');
            $("#divYear").addClass('hidden');
            $("#divMonth").addClass('hidden');
            /*Hide Table*/
            $("#divPrintButton").addClass('hidden');
            $("#divPrintContent").addClass('hidden');
            $("#divPrintReport").addClass('hidden');
            $("#divReportPatient").addClass('hidden');
            $("#divReportNoRecord").addClass('hidden');
    }
    /*------------------------------------------ Patient wise report ----------------------------------*/
    function reportValidation(reportId){
        var chkResult=0;
        if(reportId>0){
            switch(reportId)
            {
                case '1':
                    chkResult= $('#txtDateRange').val()!=''?0:1;
                    break;
                case '2':
                    chkResult=$('#txtMonthYear').val()!=''?0:1;
                    break;
                case '3':
                    chkResult=$('#ddlYear').val()>0?0:1;
                    break;
            }
        }else{
            chkResult=1;
        }
        return chkResult;
    }
    const frmPatientReport = document.getElementById('frmPatientReport');
    if(frmPatientReport!=null){
        frmPatientReport.addEventListener("submit", (e) => {
        e.preventDefault();
        const drerrorModal = tailwind.Modal.getInstance(document.querySelector("#divReportErrorModal"));
        var reportId=$('#ddlReport').val();
        var chkResult=reportValidation(reportId);
        if(chkResult==0){
            const reportData = new FormData(frmPatientReport);
            var token=$('#txtToken').val();
            let options = {
                method: "POST",
                body: reportData,
                headers: {
                    Accept: 'application/json',
                    Authorization: 'Bearer '+token,
                },
            };
            var base_url = localStorage.getItem("base_url");
            var url=base_url+'/api/reportPatientWise';
    
            fetch(url, options)
                .then(function(response){ 
                    return response.json(); 
                })
                .then(function(data){ 
                    if(data.Success=='Success'){  
                        $("#divPrintReport").removeClass("hidden").removeAttr("style");
                        $("#divPrintContent").removeClass("hidden").removeAttr("style");
                        if(data.reportDetails.length==0)
                        {
                            $('#divReportNoRecord span').text('No Record Found');
                            $("#divPrintButton").addClass("hidden");
                            tableVisible(1);  
                        }else{
                            var title="",subTitle="",reportType=0;
                            var ddlPatient=document.getElementById("ddlPatient");
                            var patientDetails="";
                            var patientTitle="";
                            deleteRows('tbReport');/* Delete Rows */
                            var tableHeader = document.getElementById('tbReport').getElementsByTagName('thead')[0];
                            if(tableHeader.rows.length>0)/* Delete Header */
                            {
                                tableHeader.deleteRow(0);
                            }
                            if($("#ddlPatient").val()!='0' && $("#ddlDoctor").val()!='0')/* Particular Patient  & Particular Doctor */
                            {
                                patientTitle ="Appointment";
                                var headerData="<tr><th >S.No</th><th >APPOINTMENT DATE</th><th>APPOINTMENT TIME</th><th>REASON</th></tr>";
                                tableHeader.insertRow().innerHTML = headerData;
                                tableVisible(7);
                                reportType=1;
                            }
                            else if($("#ddlPatient").val()=='0' && $("#ddlDoctor").val()=='0')/* All Patient  & All Doctor */
                            {
                                patientTitle ="Over All Appointment";
                                var headerData="<tr><th >S.No</th><th >APPOINTMENT DATE & TIME</th><th>PATIENT NAME</th><th>PHONE NO</th><th>EMAIL</th><th>DOCTOR NAME</th><th>DEPARTMENT / DESIGNATION</th><th>REASON</th></tr>";
                                tableHeader.insertRow().innerHTML = headerData;
                                tableVisible(6);
                                reportType=2;
                            }
                            else if($("#ddlPatient").val()!='0' && $("#ddlDoctor").val()=='0')/* Particular Patient  */
                            {
                                patientDetails=ddlPatient.options[ddlPatient.selectedIndex].text;
                                var patientName=patientDetails.split("-");
                                patientTitle =patientName[0]+" ("+patientName[1]+") Appointment";
                                var headerData="<tr><th >S.No</th><th >APPOINTMENT DATE & TIME</th><th >REASON</th><th >DOCTOR NAME</th><th >DOCTOR CODE</th><th >DOCTOR PHONE NO</th><th >DOCTOR EMAIL</th><th >DEPARTMENT / DESIGNATION</th></tr>";
                                tableHeader.insertRow().innerHTML = headerData;
                                tableVisible(3);
                                reportType=3;
                            }
                            else if($("#ddlPatient").val() == '0' && $("#ddlDoctor").val() != '0') /* Particular Doctor  */
                            {
                                var doctorDetails=ddlDoctor.options[ddlDoctor.selectedIndex].text;
                                var doctorName=doctorDetails.split("-");
                                patientTitle =doctorName[0]+" ("+doctorName[1]+") Appointment";
                                var headerData="<tr><th >S.No</th><th >APPOINTMENT DATE & TIME</th><th>PATIENT NAME</th><th>PATIENT #</th><th>PHONE NO</th><th>EMAIL</th><th>GENDER</th><th>REASON</th></tr>";
                                tableHeader.insertRow().innerHTML = headerData;
                                reportType=4;
                            }
                                switch(reportId){
                                    case '1':
                                        title=patientTitle+" Report";
                                        subTitle="("+$('#txtDateRange').val()+" )";
                                        break;
                                    case '2':
                                        title=patientTitle+" Report";
                                        subTitle="("+$('#txtMonthYear').val()+" )";
                                        break;
                                    case '3':
                                        title=patientTitle+" Report";
                                        subTitle="("+$('#ddlYear').val()+" )";
                                        break;                                        
                                }
                            $('#divPrintHeader span').text(title);
                            $('#divPrintSubHeader span').text(subTitle);                           
                            var tableData="";
                            var tableRef = document.getElementById('tbReport').getElementsByTagName('tbody')[0];
                            
                                data.reportDetails.forEach(function(value, key) {
                                    switch(reportType)
                                    {
                                        case 1: /* Particular patient and doctor report */
                                            /* Patient Information */
                                            $('#divPatientName span').text(value.patientName);
                                            $('#divPatientHcNo span').text(value.hcNo);
                                            $('#divPatientPhoneNo span').text(value.phoneNo);
                                            $('#divPatientEmail span').text(value.email);
                                            $('#divPatientGender span').text(value.gender);
                                            $('#divPatientSpouse span').text(value.spouseName);
                                            /* Doctor Information */
                                            $('#divDoctorName span').text(value.doctorName);
                                            $('#divDoctorCode span').text(value.doctorCodeNo);
                                            $('#divDoctorPhoneNo span').text(value.doctorPhoneNo);
                                            $('#divDoctorEmail span').text(value.doctorEmail);
                                            $('#divDepartment span').text(value.department);
                                            $('#divDesignation span').text(value.designation);

                                            tableData=tableData +'<tr class="intro-x">';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.sNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.appointmentDate  +'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.appointmentTime+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.reason+'</div></td>';
                                            tableData= tableData +'</tr>';
                                            
                                            tableRef.insertRow().innerHTML = tableData;
                                            break;
                                        case 2: /* All the patient and doctor report */
                                            tableData=tableData +'<tr class="intro-x">';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.sNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.appointmentDate +' - '+value.appointmentTime +'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.patientName+' - '+value.hcNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.phoneNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.email+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.doctorName+' - '+value.doctorCodeNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.department+' - '+value.designation+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.reason+'</div></td>';
                                            tableData= tableData +'</tr>';
                                            
                                            tableRef.insertRow().innerHTML = tableData;
                                            break;
                                        case 3: /* Particular patient report */
                                            $('#divPatientName span').text(value.patientName);
                                            $('#divPatientHcNo span').text(value.hcNo);
                                            $('#divPatientPhoneNo span').text(value.phoneNo);
                                            $('#divPatientEmail span').text(value.email);
                                            $('#divPatientGender span').text(value.gender);
                                            $('#divPatientSpouse span').text(value.spouseName);
            
                                            tableData=tableData +'<tr class="intro-x">';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.sNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.appointmentDate +' - '+value.appointmentTime +'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.reason+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.doctorName+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.doctorCodeNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.doctorPhoneNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.doctorEmail+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.department+' / '+value.designation+'</div></td>';
                                            tableData= tableData +' </tr>';
            
                                            tableRef.insertRow().innerHTML = tableData;
                                            break;
                                        case 4:/* Particular Doctor report */
                                            $('#divDoctorName span').text(value.doctorName);
                                            $('#divDoctorCode span').text(value.doctorCodeNo);
                                            $('#divDoctorPhoneNo span').text(value.doctorPhoneNo);
                                            $('#divDoctorEmail span').text(value.doctorEmail);
                                            $('#divDepartment span').text(value.department);
                                            $('#divDesignation span').text(value.designation);
            
                                            tableData=tableData +'<tr class="intro-x">';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.sNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.appointmentDate +' - '+value.appointmentTime +'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.doctorName+' - '+value.doctorCodeNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.doctorPhoneNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.doctorEmail+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.department+' - '+value.designation+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.patientName+' - '+value.hcNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.reason+'</div></td>';
                                            tableData= tableData +' </tr>';
            
                                            tableRef.insertRow().innerHTML = tableData;
                                            break;
                                    }
                                  
                                    tableData="";
                                });
                                $("#divPrintButton").removeClass("hidden").removeAttr("style");
                        }
                    }else{
                        $('#divErrorHead span').text(data.Success);
                        $('#divErrorMsg span').text(data.Message);
                            drerrorModal.show();                        
                    }
                })
                .catch(function(error){
                    $('#divErrorHead span').text('Error');
                    $('#divErrorMsg span').text(error);
                    drerrorModal.show();
                });
                window.scrollTo(0, 0);
            }else{
                $('#divErrorHead span').text('Validation Error');
                $('#divErrorMsg span').text("Please select the mandatory field marked as *.");
                drerrorModal.show();
            }
    });
    }
    function tableVisible(type){
        switch(type){
            case 1:/*---No Record--*/
                $("#divPrintHeader").addClass('hidden');
                $("#divPrintSubHeader").addClass('hidden');
                $("#divReportNoRecord").removeClass("hidden").removeAttr("style");
                $("#divReportPatient").addClass('hidden');
                $("#tbReport").addClass('hidden');
                $("#tbDoctorHeader").addClass('hidden');
                break;
            case 2:/*---All patient--*/
                $("#divPrintHeader").removeClass("hidden").removeAttr("style");
                $("#divPrintSubHeader").removeClass("hidden").removeAttr("style");
                $("#divReportNoRecord").addClass('hidden');
                $("#divReportPatient").addClass('hidden');
                $("#tbReport").removeClass("hidden").removeAttr("style");
                $("#tbDoctorHeader").addClass('hidden');
                break;
            case 3:/*---paritcular patient--*/
                $("#divPrintHeader").removeClass("hidden").removeAttr("style");
                $("#divPrintSubHeader").removeClass("hidden").removeAttr("style");
                $("#divReportNoRecord").addClass('hidden');
                $("#divReportPatient").removeClass("hidden").removeAttr("style");
                $("#tbReport").removeClass("hidden").removeAttr("style");
                $("#tbDoctorHeader").addClass('hidden');
                break;
            case 4: /*---paritcular doctor--*/
                $("#divPrintHeader").removeClass("hidden").removeAttr("style");
                $("#divPrintSubHeader").removeClass("hidden").removeAttr("style");
                $("#divReportNoRecord").addClass('hidden');
                $("#divReportPatient").addClass('hidden');
                $("#tbReport").removeClass("hidden").removeAttr("style");
                $("#tbDoctorHeader").removeClass("hidden").removeAttr("style");
                break;
            case 5: /*---All doctor--*/
                $("#divPrintHeader").removeClass("hidden").removeAttr("style");
                $("#divPrintSubHeader").removeClass("hidden").removeAttr("style");
                $("#divReportNoRecord").addClass('hidden');
                $("#divReportPatient").addClass('hidden');
                $("#tbReport").removeClass("hidden").removeAttr("style");
                $("#tbDoctorHeader").addClass('hidden');
                break;
            case 6: /* All */
                $("#divPrintHeader").removeClass("hidden").removeAttr("style");
                $("#divPrintSubHeader").removeClass("hidden").removeAttr("style");
                $("#divReportNoRecord").addClass('hidden');
                $("#divReportPatient").addClass('hidden');
                $("#tbDoctorHeader").addClass('hidden');
                $("#tbDoctorHeader").css('display', 'none');
                // $("#divReportNoRecord").css('visibility', 'none');
                $("#tbReport").removeClass("hidden").removeAttr("style");
                break;
            case 7:
                $("#divPrintHeader").removeClass("hidden").removeAttr("style");
                $("#divPrintSubHeader").removeClass("hidden").removeAttr("style");
                $("#divReportNoRecord").addClass('hidden');
                $("#divReportPatient").removeClass("hidden").removeAttr("style");
                $("#tbDoctorHeader").removeClass("hidden").removeAttr("style");
                $("#tbReport").removeClass("hidden").removeAttr("style");
                break;
        }
    }
    function deleteRows(ctrlElement){
        var tbReport=document.getElementById(ctrlElement);
        var rowCount = tbReport.rows.length;
        for (var i = rowCount-1; i > 0; i--) {
            tbReport.deleteRow(i);
         }
    }
    /*---------------------------- PRINT REPORT --------------------------*/    
    function printData(printContent,title){
        var contents = $(printContent).html();
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

                var frame1 = $('<iframe />');
                frame1[0].name = "frame1";
                frame1.css({ "position": "absolute", "top": "-1000000px" });
                $("body").append(frame1);
                var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
                frameDoc.document.open();
                //Create a new HTML document.
                frameDoc.document.write('<html><head><style>@media print {@page {size: auto; margin: 0mm;} body{margin: '+pixelsmt+'px '+pixelsmr+'px '+pixelsmb+'px '+pixelsml+'px ;} .hidden{display: none;}} table {width: 100%; font-size:12px } table, th, td { border: 1px solid black;border-collapse: collapse;} div,span {text-align: center; font-weight: 500; font-size:14px; }</style>');
                frameDoc.document.write('</head><body>');
                //Append the DIV contents.
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
    }
    /*---------------------------- PRINT REPORT --------------------------*/    
    $( "#btnPrintReport" ).on( "click", function() {
        var title='';
        var divPrintContent='#divPrintContent';
        printData(divPrintContent,title);
    });
    /* ---------------------- Reset Report----------------------------- */
    $("#btnReportReset").on("click", function (event) {
         deleteRows('tbReport');
        hideReportOption();
        $("#ddlBranch option").remove();
        $("#ddlBranch").append($("<option></option>").val(0).html("Select Branch"));
        $("#divBranchddl").addClass('hidden');
    });

    /*---------------------------- PRINT Patient details --------------------------*/
    $( "#btnPrintPatientDetails" ).on( "click", function() {
        var title='';
        var divPrintContent='#divPrintPatientContent';
        printData(divPrintContent,title);
    });
    /* ---------------------- Reset Patient details----------------------------- */
        $("#btnReportPatientReset").on("click", function (event) {
             deleteRows('tbPatientDetails');
            $("#divPrintPatientDetails").addClass('hidden');
            $("#divBranchddl").addClass('hidden');
            $('#divPrintPatientButton').addClass('hidden');
        });
    /* ---------------------------- Report Patient Detials --------------------------------------- */
    const frmPatientDetailReport = document.getElementById('frmPatientDetailReport');
    if(frmPatientDetailReport!=null){
        frmPatientDetailReport.addEventListener("submit", (e) => {
            e.preventDefault();
            const drerrorModal = tailwind.Modal.getInstance(document.querySelector("#divReportPatientErrorModal"));
            const reportData = new FormData(frmPatientDetailReport);
            var token=$('#txtToken').val();
            let options = {
                method: "POST",
                body: reportData,
                headers: {
                    Accept: 'application/json',
                    Authorization: 'Bearer '+token,
                },
            };
            var base_url = localStorage.getItem("base_url");
            var url=base_url+'/api/reportPatientDetails';
    
            fetch(url, options)
                .then(function(response){ 
                    return response.json(); 
                })
                .then(function(data){ 
                    if(data.Success=='Success'){  
                        deleteRows('tbPatientDetails');
                        $("#divPrintPatientDetails").removeClass("hidden").removeAttr("style");
                        if(data.reportDetails.length==0)
                        {
                            $('#divReportNoRecord span').text('No Record Found');
                            $("#divPrintPatientButton").addClass("hidden");
                        }else{
                            var tableData="";
                            var tableRef = document.getElementById('tbPatientDetails').getElementsByTagName('tbody')[0];
                            
                                data.reportDetails.forEach(function(value, key) {
                                            tableData=tableData +'<tr class="intro-x">';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.sNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.name +' - '+value.hcNo +'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.created_date+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.phoneNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.email+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.age+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.gender+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.bloodGroup+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.height+((value.height!="" && value.weight!="")? ' / ':'')+value.weight+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.spouseName+((value.spouseName!="" && value.spousePhnNo!="")? ' - ':'')+value.spousePhnNo+'</div></td>';
                                            tableData= tableData + '<td class="w-40"><div class="flex">'+value.assignedDoctor+'</div></td>';
                                            tableData= tableData +'</tr>';
                                            
                                            tableRef.insertRow().innerHTML = tableData;

                                            tableData="";
                                });
                                $("#divPrintPatientButton").removeClass("hidden").removeAttr("style");
                                $("#divReportNoRecord").addClass("hidden");
                        }
                    }else{
                        $('#divErrorHead span').text(data.Success);
                        $('#divErrorMsg span').text(data.Message);
                            drerrorModal.show();
                    }
                })
                .catch(function(error){
                    $('#divErrorHead span').text('Error');
                    $('#divErrorMsg span').text(error);
                    drerrorModal.show();
                });
        });
    }
    /* -------------------------------- Load Hospital,Branch,Patient and Doctor For Assign Doctor -------BEGIN ------------------------------------ */
    function loadHospitalForAssign(){
        var token=$('#txtToken').val();
        let options = {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer '+token,
            },
        }
        var base_url = localStorage.getItem("base_url");
        var url=base_url+'/api/loadHospital';
        fetch(url,options)
            .then(response => response.json())
            .then(function (result) {
                // Load Hospital
                if(result.Success=='Success'){
                    var listHospital=result.hospitalList;
                    if(listHospital!=null)
                    {
                        listHospital.forEach(function(value, key) {
                            $("#ddlAssignHospital").append($("<option></option>").val(value.id).html(value.hospitalName)); 
                        });
                    }
                }
            }); 
            let ddlAssignBranch = document.getElementById('ddlAssignBranch');
            var hospitalId=$('#txtHospital').val();
            if (ddlAssignBranch !== null) {
                var ddlUrl=base_url+'/api/loadBranch/'+hospitalId;

                    fetch(ddlUrl,options)
                    .then(response => response.json())
                    .then(function (result) {
                        // Load Branch
                        var listBranch=result.branchList;
                        $("#ddlAssignBranch option").remove();
                        $("#ddlAssignBranch").append($("<option></option>").val(0).html("Select Branch"));
                        if(listBranch.length!=0)
                        {
                            listBranch.forEach(function(value, key) {
                                $("#ddlAssignBranch").append($("<option></option>").val(value.id).html(value.branchName)); 
                            });
                            $("#divAssignBranchddl").removeClass("hidden").removeAttr("style");
                        }else{
                            $("#divAssignBranchddl").addClass('hidden');
                        }
                    }); 
            }
            //getAssignPatient & doctor
            getAssignPatientDoctor();
    }
    /* -------------------------- Get Unassigned Patient & Doctor List----------------------------- */
    function getAssignPatientDoctor(){
        var token=$('#txtToken').val();
        let options = {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer '+token,
            },
        }
        const errorModal = tailwind.Modal.getInstance(document.querySelector("#divAssignErrorModal"));
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        var base_url = localStorage.getItem("base_url");
        var url = base_url + '/api/loadUnAssigned/'+hospitalId+"/"+branchId;
        $("#ddlAssignPatient option").remove();
        $("#ddlAssignPatient").append($("<option></option>").val(0).html("Select Patient"));
        $("#ddlAssignDoctor option").remove();
        $("#ddlAssignDoctor").append($("<option></option>").val(0).html("Select Doctor"));

        fetch(url,options)
            .then(response => response.json())
            .then(function (result) {
                // Load Patient
                var listPatient=result.patientList;
                if(listPatient!=null)
                {
                    listPatient.forEach(function(value, key) {
                        $("#ddlAssignPatient").append($("<option></option>").val(value.id).html(value.name)); 
                    });
                }
                // Load Doctor
                var listDoctor=result.doctorList;
                if(listDoctor!=null)
                {
                    listDoctor.forEach(function(value, key) {
                        $("#ddlAssignDoctor").append($("<option></option>").val(value.id).html(value.name)); 
                    });
                }
            }).catch(function(error){
                $('#divErrorHead span').text('Error');
                $('#divErrorMsg span').text(error);
                errorModal.show();
            });
    }
    /*----- Assign Doctor -- Branch change ------------------*/
    $("#ddlAssignBranch").on('change',function() {
        $('#txtBranch').val($("#ddlAssignBranch").val());
        getAssignPatientDoctor();
    });
    /* Assign doctor - Hospital change */
    $("#ddlAssignHospital").on('change',function() {
        var token=$('#txtToken').val();
        var hospitalId=$("#ddlAssignHospital").val();
        $('#txtHospital').val(hospitalId);
        let ddlAssignBranch = document.getElementById('ddlAssignBranch');
        let options = {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer '+token,
              },
        }
        var base_url = localStorage.getItem("base_url");
        var ddlUrl=base_url+'/api/loadBranch/'+hospitalId;
        if (ddlAssignBranch !== null) {
            $("#ddlAssignBranch option").remove();
            $("#ddlAssignBranch").append($("<option></option>").val(0).html("Select Branch"));
            
            fetch(ddlUrl,options)
                    .then(response => response.json())
                    .then(function (result) {
                        //Load Branch
                        var listBranch=result.branchList;
                        var branchId=$("#ddlAssignBranch").val();
                        if(listBranch.length!=0)
                        {
                            listBranch.forEach(function(value, key) {
                                $("#ddlAssignBranch").append($("<option></option>").val(value.id).html(value.branchName)); 
                            });
                            $("#divAssignBranchddl").removeClass("hidden").removeAttr("style");
                            $('#txtBranch').val(branchId);
                        }else{
                            $("#divAssignBranchddl").addClass('hidden');
                            $('#txtBranch').val(branchId);
                        }
                    });  
            }
            getAssignPatientDoctor();
     });   
     /* Clear dropdown list after save */
     function ClearAssignDdl()
     {
        $("#ddlAssignPatient option").remove();
        $("#ddlAssignPatient").append($("<option></option>").val(0).html("Select Patient"));
        $("#ddlAssignDoctor option").remove();
        $("#ddlAssignDoctor").append($("<option></option>").val(0).html("Select Doctor"));
        $("#ddlAssignBranch option").remove();
        $("#ddlAssignBranch").append($("<option></option>").val(0).html("Select Doctor"));
        $("#divAssignBranchddl").addClass('hidden');
     }
    /* -------------------------------- Load Hospital,Branch,Patient and Doctor For Assign Doctor --- END --------------------------------- */
    /* ------------------------------------ Assign Doctor for Patient -------------------------------------- */
    function chkAssignDoctor(){ /*------- Form Validation---- */
        var chkResult=0;
        if($("#ddlAssignPatient").val()==0){
            chkResult=1;
        }else if($("#ddlAssignDoctor").val()==0){
            chkResult=1;
        }else{
            let ddlAssignHospital = document.getElementById('ddlAssignHospital');
            if(ddlAssignHospital!==null){
                chkResult=$("#ddlAssignHospital").val()==0?1:0;
            }
        }
        return chkResult;
    }
    /* Form Submit */
    const frmAssignDoctor = document.getElementById('frmAssignDoctor');
    if(frmAssignDoctor!=null){
        frmAssignDoctor.addEventListener("submit", (e) => {
            e.preventDefault();
            const errorModal = tailwind.Modal.getInstance(document.querySelector("#divAssignErrorModal"));
           var chkResult=chkAssignDoctor();
           if(chkResult==1)
           {
                $('#divErrorHead span').text('Validation Error');
                $('#divErrorMsg span').text("Please select the mandatory field marked as *.");
                errorModal.show();
           }else{
            const assigndata = new FormData(frmAssignDoctor);
            const assignParam=new URLSearchParams(assigndata);
            var token=$('#txtToken').val();
            let options = {
                method: "POST",
                body: assignParam,
                headers: {
                    Accept: 'application/json',
                    Authorization: 'Bearer '+token,
                },
            };
            var base_url = localStorage.getItem("base_url");
            var url=base_url+'/api/addAssignDoctor';
    
            fetch(url, options)
                .then(function(response){ 
                    return response.json(); 
                })
                .then(function(data){ 
                    if(data.Success=='Success'){  
                        $('#divMsg span').text(data.Message);
                        if (data.ShowModal==1) {
                            const successModal = tailwind.Modal.getInstance(document.querySelector("#divAssignSuccessModal"));
                            successModal.show();    
                            document.getElementById("frmAssignDoctor").reset();
                            // ClearAssignDdl();
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
        });
    }
    $( "#btnAssignCancel" ).on( "click", function() {
        ClearAssignDdl();
    });  
    /* -------------------------------------- ASSIGN DOCTOR ENDS------------------------------------ */
    /* ------------------------------------ Subscribe --------------------------------------------- */
    function loadSubscribeHospital(base_url){
        let ddlBranch = document.getElementById('ddlSubBranch');
        var token=$('#txtToken').val();
        let options = {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer '+token,
              },
        }
        var url=base_url+'/api/loadHospital';
        fetch(url,options)
                .then(response => response.json())
                .then(function (result) {
                    // Load Hospital
                    var listHospital=result.hospitalList;
                    if(listHospital!=null)
                    {
                        listHospital.forEach(function(value, key) {
                            $("#ddlSubHospital").append($("<option></option>").val(value.id).html(value.hospitalName)); 
                        });
                    }
                }); 
               
                var hospitalId=$('#txtHospital').val();
                if (ddlBranch !== null) {
                    var ddlUrl=base_url+'/api/loadBranch/'+hospitalId;
    
                        fetch(ddlUrl,options)
                        .then(response => response.json())
                        .then(function (result) {
                            // Load Branch
                            var listBranch=result.branchList;
                            $("#ddlSubBranch option").remove();
                            $("#ddlSubBranch").append($("<option></option>").val(0).html("Select Branch"));
                            if(listBranch.length!=0)
                            {
                                listBranch.forEach(function(value, key) {
                                    $("#ddlSubBranch").append($("<option></option>").val(value.id).html(value.branchName)); 
                                });
                                $("#divSubBranchddl").removeClass("hidden").removeAttr("style");
                            }else{
                                $("#divSubBranchddl").addClass('hidden');
                            }
                        }); 
                }
    } 
    /* ---- Hospital Change Event ----*/
    $("#ddlSubHospital").on('change',function() {
        var token=$('#txtToken').val();
        var hospitalId=$("#ddlSubHospital").val();
        $('#txtHospital').val(hospitalId);
        let ddlBranch = document.getElementById('ddlSubBranch');
        let options = {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer '+token,
              },
        }
        $("#divSubBranchddl").addClass('hidden');
        var base_url = localStorage.getItem("base_url");
        var ddlUrl=base_url+'/api/loadBranch/'+hospitalId;
        if (ddlBranch !== null) {
            fetch(ddlUrl,options)
                    .then(response => response.json())
                    .then(function (result) {
                        $("#ddlSubBranch option").remove();
                        $("#ddlSubBranch").append($("<option></option>").val(0).html("Select Branch"));
                        //Load Branch
                        var listBranch=result.branchList;
                        if(listBranch.length!=0)
                        {
                            listBranch.forEach(function(value, key) {
                                $("#ddlSubBranch").append($("<option></option>").val(value.id).html(value.branchName)); 
                            });
                            $("#divSubBranchddl").removeClass("hidden").removeAttr("style");
                        }
                    });  
            }
            if(hospitalId!='0')
            {
                $("#btnPlan1").removeClass("hidden").removeAttr("style");
            }else{
                $("#btnPlan1").addClass('hidden');
            }
     });   
    /*-----------------Branch Change Event ----------------- */
     $("#ddlSubBranch").on('change',function() {
        $('#txtBranch').val($("#ddlSubBranch").val());
    });
    /*--------------Buy button-------------- */
    $( "#btnPlan1" ).on( "click", function() {
        var base_url = localStorage.getItem("base_url");
        const errorModal = tailwind.Modal.getInstance(document.querySelector("#divSubscribeErrorModal"));

        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        var userId=$('#txtUser').val();
        // var url=base_url+'/phonepe/'+hospitalId+'/'+branchId+'/'+userId;
        var url=base_url+'/phonepe';
        window.location.href =url;
    });
    /*------------------------------------ Search Assign Doctor Begin ----------------------------*/
function setAssignDoctorTabulator(){
    // Tabulator
    if ($("#tbAssign").length) {
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        var token=$('#txtToken').val();
        // Setup Tabulator
        let table = new Tabulator("#tbAssign", {
            ajaxURL: localStorage.getItem("base_url")+"/api/assignedPatientList",
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
                    headerSort: false,
                },

                // For HTML table
                {
                    title: "PATIENT INFORMATION",
                    minWidth: 75,
                    field: "patientName",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div class="flex lg:justify-center">
                            <div class="intro-x w-12 h-12 image-fit">
                                <img class="rounded-full" src="${cell.getData().patientImage}">
                            </div>
                        </div>
                        <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"> </div>
                    <div>
                        <div class="font-medium whitespace-nowrap">${
                            cell.getData().patientName
                        }</div>
                        <div class="text-xs whitespace-nowrap">Reg.No: ${
                            cell.getData().hcNo
                        }</div>
                        <div class="text-xs whitespace-nowrap">
                            <a class="flex items-center mr-3" href="javascript:;">
                                    <i data-lucide="phone" class="w-3 h-3 mr-1"></i>  ${
                                        cell.getData().patientPhoneNo
                                    }
                            </a>
                       </div>
                    </div>`;
                    },
                },
                {
                    title: "DOCTOR INFORMATION",
                    minWidth: 75,
                    field: "doctorName",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div class="flex lg:justify-center">
                            <div class="intro-x w-12 h-12 image-fit">
                                <img class="rounded-full" src="${cell.getData().doctorImage}">
                            </div>
                        </div>
                        <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"> </div>
                    <div>
                        <div class="font-medium whitespace-nowrap">${
                            cell.getData().doctorName
                        }</div>
                        <div class="text-xs whitespace-nowrap">Code: ${
                            cell.getData().doctorCodeNo
                        }</div>
                        <div class="text-xs whitespace-nowrap">
                            <a class="flex items-center mr-3" href="javascript:;">
                                    <i data-lucide="phone" class="w-3 h-3 mr-1"></i>  ${
                                        cell.getData().doctorPhoneNo
                                    }
                            </a>
                       </div>
                    </div>`;
                    },
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
                            <a class="edit flex items-center mr-3 text-primary tooltip" title="Edit Doctor Details" href="javascript:;">
                                <i data-lucide="check-square" class="w-5 h-5 mr-1"></i> 
                            </a>
                            <a class="delete flex items-center text-danger tooltip" title="Delete Doctor" href="javascript:;">
                                <i data-lucide="trash-2" class="w-5 h-5 mr-1"></i> 
                            </a>
                        </div>`);
                        $(a)
                            .find(".edit")
                            .on("click", function () {
                                window.location.href= localStorage.getItem("base_url")+"/showAssignEdit/"+cell.getData().id;
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeleteAssign"));
                                deleteModal.show();
                                $( "#btnDelAssign" ).on( "click", function() {
                                    var userId=$('#txtUser').val();
                                    deleteAssignDoctor(cell.getData().id,userId);
                                });
                            });

                        return a[0];
                    },
                },

                // For print format
                {
                    title: "PATIENT NAME",
                    field: "patientName",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "PATIENT REG.NO",
                    field: "hcNo",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "PATIENT PHONE NO",
                    field: "patientPhoneNo",
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
                {
                    title: "DOCTOR CODE NO",
                    field: "doctorCodeNo",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "DOCTOR PHONE NO",
                    field: "doctorPhoneNo",
                    visible: false,
                    print: false,
                    download: false,
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
        function filterHTMLDoctorForm() {
            let field = $("#tbAssign-html-filter-field").val();
            let type = $("#tbAssign-html-filter-type").val();
            let value = $("#tbAssign-html-filter-value").val();
            table.setFilter(field, type, value);
        }

        // On submit filter form
        $("#tbAssign-html-filter-form")[0].addEventListener(
            "keypress",
            function (event) {
                let keycode = event.keyCode ? event.keyCode : event.which;
                if (keycode == "13") {
                    event.preventDefault();
                    filterHTMLDoctorForm();
                }
            }
        );

        // On click go button
        $("#tbAssign-html-filter-go").on("click", function (event) {
            filterHTMLDoctorForm();
        });

        // On reset filter form
        $("#tbAssign-html-filter-reset").on("click", function (event) {
            $("#tbAssign-html-filter-field").val("patientName");
            $("#tbAssign-html-filter-type").val("like");
            $("#tbAssign-html-filter-value").val("");
            filterHTMLDoctorForm();
        });

        // Export
        $("#tbAssign-export-csv").on("click", function (event) {
            table.download("csv", "data.csv");
        });

        $("#tbAssign-export-json").on("click", function (event) {
            table.download("json", "data.json");
        });

        $("#tbAssign-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            table.download("xlsx", "Doctors.xlsx", {
                sheetName: "Doctors",
            });
        });

        $("#tbAssign-export-html").on("click", function (event) {
            table.download("html", "data.html", {
                style: true,
            });
        });

        // Print
        $("#tbAssign-print").on("click", function (event) {
            table.print();
        });
    }
}
/*------------------------ Search Assign Doctor End ------------------------*/
/*----------------------------------- Delete Assign Doctor By ID BEGINS -------------------------*/
function deleteAssignDoctor(assignId,userId){
    var base_url = localStorage.getItem("base_url");
    var token=$('#txtToken').val();
    var url=base_url+'/api/deleteAssignedDoctor/'+assignId+'/'+userId;
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divAssignErrorModal"));
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
                  const el = document.querySelector("#divDeleteAssign"); 
                  const modal = tailwind.Modal.getOrCreateInstance(el); 
                  modal.hide();
                  setAssignDoctorTabulator();
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
    
    /*----------------------------------- Delete Assign Doctor By ID END -------------------------*/
    function assignRedirect(){
        window.scrollTo(0, 0);
        var base_url = localStorage.getItem("base_url");
        window.location.href = base_url+ "/ListAssignedDoctor";
    }
    $( "#btnBackAssign" ).on( "click", function() {
        assignRedirect();
    });
    $( "#btnAssignRedirect" ).on( "click", function() {
        assignRedirect();
    });
    
    /*--------------------------------------Edit Doctor Begins------------------------------*/
const assignEditform = document.getElementById('frmEditAssign');
if(assignEditform!=null){
    assignEditform.addEventListener("submit", (epf) => {
    epf.preventDefault();
     const hospitaldata = new FormData(assignEditform);
    
     var token=$('#txtToken').val();
     let options = {
         method: "POST",
         body: hospitaldata,
         headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
     };
     var base_url = localStorage.getItem("base_url");
     var url=base_url+'/api/updateAssignDoctor';
     const errorDrModal = tailwind.Modal.getInstance(document.querySelector("#divErrorEditAssign"));
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             if(data.Success=='Success'){
                 $('#divMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    const successEditModal = tailwind.Modal.getInstance(document.querySelector("#divSuccessEditAssign"));
                     successEditModal.show();    
                 }                   
             }else{
                 $('#divErrorHead span').text(data.Success);
                 $('#divErrorMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    errorDrModal.show();
                 }else if(data.ShowModal==2)
                 {
                    logoutSession(data.Message);
                 }
             }
         })
         .catch(function(error){
             $('#divErrorHead span').text('Error');
             $('#divErrorMsg span').text(error);
             errorDrModal.show();
         });       
 });      
}
/*-------------------------------------------------Edit Assign Doctor Ends -----------------------------*/
/*------------------------------------ Search reffered By Begin ----------------------------*/
function setRefferedBy(){
    // Tabulator
    if ($("#tbRefferedBy").length) {
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        // Setup Tabulator
        var token=$('#txtToken').val();
        let table = new Tabulator("#tbRefferedBy", {
            ajaxURL: localStorage.getItem("base_url")+"/api/patientList",
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
                    headerSort: false,
                },

                // For HTML table
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
                    title: "PATIENT NAME",
                    minWidth: 100,
                    field: "name",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div>
                            <div class="font-medium whitespace-nowrap">${
                                cell.getData().name
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
                    responsive:2
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
                    title: "REFFERED BY",
                    minWidth: 50,
                    field: "doctorName",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div class="flex lg:justify-center">
                            <div class="intro-x w-12 h-12 image-fit" style="display: ${cell.getData().doctorCodeNo==0?'none':'block'};">
                                <img class="rounded-full" src="${cell.getData().doctorImage}">
                            </div>
                        </div>
                        <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500"> </div>
                    <div>
                        <div class="font-medium whitespace-nowrap">${
                            cell.getData().doctorName==0?'':cell.getData().doctorName
                        }</div>
                        <div class="text-xs whitespace-nowrap"> ${
                            cell.getData().doctorCodeNo==0?'':cell.getData().doctorCodeNo
                        }</div>
                    </div>`;
                    },
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
                            $(`<div class="flex lg:justify-center items-center text-danger">
                            <a class="view flex items-center mr-3 tooltip" title="Add/View Reffered By" href="javascript:;">
                                <i data-lucide="check-square" class="w-4 h-4 mr-2"></i>  Reffered By
                            </a>
                        </div>`);
                        $(a)
                            .find(".view")
                            .on("click", function () {
                                window.location.href=localStorage.getItem("base_url")+"/viewRefferedBy/"+cell.getData().id;
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

        // Filter function
        function filterHTMLForm() {
            let field = $("#tbRefferedBy-html-filter-field").val();
            let type = $("#tbRefferedBy-html-filter-type").val();
            let value = $("#tbRefferedBy-html-filter-value").val();
            table.setFilter(field, type, value);
        }

        // On submit filter form
        $("#tbRefferedBy-html-filter-form")[0].addEventListener(
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
        $("#tbRefferedBy-html-filter-go").on("click", function (event) {
            filterHTMLForm();
        });

        // On reset filter form
        $("#tbRefferedBy-html-filter-reset").on("click", function (event) {
            $("#tbRefferedBy-html-filter-field").val("hcNo");
            $("#tbRefferedBy-html-filter-type").val("like");
            $("#tbRefferedBy-html-filter-value").val("");
            filterHTMLForm();
        });
    }
}
/*------------------------------------------------------- Reffered By END ---------------------------*/
function redirectToRefferedBy(){
    window.scrollTo(0, 0);
    var base_url = localStorage.getItem("base_url");
    window.location.href = base_url+ "/RefferedBy";
}
$( "#btnCancelRefferedBy" ).on( "click", function() {
    redirectToRefferedBy();
});
$( "#btnRefRedirect" ).on( "click", function() {
    redirectToRefferedBy();
});
/*--------------------------------------Save Reffered Begins------------------------------*/
const refferedByform = document.getElementById('frmRefferedBy');
if(refferedByform!=null){
    refferedByform.addEventListener("submit", (epf) => {
    epf.preventDefault();
     const patientdata = new FormData(refferedByform);
     const errorModal = tailwind.Modal.getInstance(document.querySelector("#divRefferedByErrorModal"));
     var token=$('#txtToken').val();
     let options = {
         method: "POST",
         body: patientdata,
         headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
     };
     var base_url = localStorage.getItem("base_url");
     var url=base_url+'/api/updateRefferedBy';
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             if(data.Success=='Success'){
                 $('#divMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    const successEditModal = tailwind.Modal.getInstance(document.querySelector("#divRefferedBySuccessModal"));
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
/*-------------------------------------------------Save Reffered Ends -----------------------------*/
/*------------------------------------ Search Donor Begin ----------------------------*/
function setDonor(){
    // Tabulator
    if ($("#tbDonor").length) {
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        // Setup Tabulator
        var token=$('#txtToken').val();
        let table = new Tabulator("#tbDonor", {
            ajaxURL: localStorage.getItem("base_url")+"/api/donorBankList",
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
                        <a class="edit flex items-center mr-3 text-primary tooltip" title="Edit Donor Bank Details" href="javascript:;">
                            <i data-lucide="check-square" class="w-5 h-5 mr-1"></i> 
                        </a>
                        <a class="delete flex items-center text-danger tooltip" title="Delete Donor Bank" href="javascript:;">
                            <i data-lucide="trash-2" class="w-5 h-5 mr-1"></i> 
                        </a>
                    </div>`);
                    $(a)
                        .find(".edit")
                        .on("click", function () {
                            $('#txtName').val(cell.getData().name);
                            $('#txtAddress').val(cell.getData().address);
                            $('#txtMode').val(2);
                            $('#txtDonorId').val(cell.getData().id);
                        });
                    $(a)
                        .find(".delete")
                        .on("click", function () {
                            const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeleteDonorBank"));
                            deleteModal.show();
                            $('#divDonorBank span').text(cell.getData().name);
                            $( "#btnDelDonorBank" ).on( "click", function() {
                                var userId=$('#txtUser').val();
                                deleteDonorBank(cell.getData().id,userId);
                            });
                        });

                    return a[0];
                },
                },
                   // For print format
                   {
                    title: "DONOR BANK NAME",
                    field: "name",
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
/*------------------------------------------------------- Donor END ---------------------------*/
/* --------------- Donor Bank Add form submit Begins ------------------------*/

const donorBankform = document.getElementById('frmDonorBank');
if(donorBankform!=null){
//donorBankform registeration
donorBankform.addEventListener("submit", (e) => {
    e.preventDefault();
    const donorBankdata = new FormData(donorBankform);
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
    var url=base_url+'/api/addDonorBank';
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divDonorErrorModal"));
    fetch(url, options)
        .then(function(response){ 
            return response.json(); 
        })
        .then(function(data){ 
            if(data.Success=='Success'){
                $('#divMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    const successModal = tailwind.Modal.getInstance(document.querySelector("#divDonorSuccessModal"));
                    successModal.show();    
                    document.getElementById("frmDonorBank").reset() ;
                    $('#txtMode').val(1);
                    setDonor();
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
/* --------------- Donor Bank Add form submit End ------------------------*/
/*----------------------------------- Delete Donor Bank By ID bEGINS -------------------------*/
function deleteDonorBank(patientId,userId){
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divDonorErrorModal"));
    var base_url = localStorage.getItem("base_url");
    var url=base_url+'/api/deleteDonorBank/'+patientId+'/'+userId;
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
                const el = document.querySelector("#divDeleteDonorBank"); 
                const modal = tailwind.Modal.getOrCreateInstance(el); 
                modal.hide();
                setDonor();
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
$( "#btnCancelDonor" ).on( "click", function() {
    $('#txtMode').val(1);
});

$( "#btnShowAppointmentSlot" ).on( "click", function() {
   alert( $('#txtAppointmentTime').val());
});
})();
