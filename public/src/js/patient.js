import xlsx from "xlsx";
import { createIcons, icons } from "lucide";
import Tabulator from "tabulator-tables";

(function () {
    "use strict";
    window.onbeforeunload = function() {
        window.scrollTo(0, 0);
    };
   
window.addEventListener("load", (e) => {
    e.preventDefault();
    var pathname = window.location.pathname;
    var base_url = window.location.origin;
console.log(pathname);
    var searchPatient="showPatient";
    if(pathname.indexOf(searchPatient) != -1){
        pathname=searchPatient;
    }
    var SearchDoctor="showDoctor";
    if(pathname.indexOf(SearchDoctor) != -1){
        pathname=SearchDoctor;
    }
    var SearchHospital="showHospital";
    if(pathname.indexOf(SearchHospital) != -1){
        pathname=SearchHospital;
    }
    var SearchBranch="showBranch";
    if(pathname.indexOf(SearchBranch) != -1){
        pathname=SearchBranch;
    }
    var SearchBranch="ConsentForm";
    if(pathname.indexOf(SearchBranch) != -1){
        pathname="/ConsentForm";
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
    switch(pathname){
        case '/Home':
            $("[id*=lnkDashboard]").addClass("side-menu--active");
            $("[id*=lnkMobileDashboard]").addClass("menu--active");
            break;
        case '/login':
        case '/Hospital':
            setMenu("[id*=lnkHospital]","[id*=ulHospital]");
            setMobileMenu("[id*=lnkMobileHospital]","[id*=ulMobileHospital]","[id*=aMobileHospital]","[id*=aMobileHpSearch]",0);
                break;
        case '/SearchHospital':
            setMenu("[id*=lnkHospital]","[id*=ulHospital]");
            setMobileMenu("[id*=lnkMobileHospital]","[id*=ulMobileHospital]","[id*=aMobileHospital]","[id*=aMobileHpSearch]",1);
            setHospitalTabulator();
            break;
        case 'showHospital':
            setMenu("[id*=lnkHospital]","[id*=ulHospital]");
            setMobileMenu("[id*=lnkMobileHospital]","[id*=ulMobileHospital]","[id*=aMobileHospital]","[id*=aMobileHpSearch]",0);
            $("#txtLogo").on('change',function() {
                $("#txtImageChanged").val(1);
            });
            break;
        case '/Doctor':
            $("#txtDOB").val('');
            setMenu("[id*=lnkDoctor]","[id*=ulDoctor]");
            setMobileMenu("[id*=lnkMobileDoctor]","[id*=ulMobileDoctor]","[id*=aMobileDoctor]","[id*=aMobileDrSearch]",0);
            addDoctorLoadEvent(base_url);
            loadHospital(base_url);
            break;
        case '/SearchDoctor':
            setMenu("[id*=lnkDoctor]","[id*=ulDoctor]");
            setMobileMenu("[id*=lnkMobileDoctor]","[id*=ulMobileDoctor]","[id*=aMobileDoctor]","[id*=aMobileDrSearch]",1);
            setDoctorTabulator();
            break;
        case "showDoctor":
            setMenu("[id*=lnkDoctor]","[id*=ulDoctor]");
            setMobileMenu("[id*=lnkMobileDoctor]","[id*=ulMobileDoctor]","[id*=aMobileDoctor]","[id*=aMobileDrSearch]",0);
            $("#txtProfileImage").on('change',function() {
                $(imgProfileImage).attr("src",$(txtProfileImage).val());
                $("#isImageChanged").val(1);
            });
            $("#txtSignature").on('change',function() {
                $(imgSignature).attr("src",$(txtSignature).val());
                $("#isSignChanged").val(1);
            });
            break;
        case '/Patient':
            setMenu("[id*=lnkPatient]","[id*=ulPatient]");
            setMobileMenu("[id*=lnkMobilePatient]","[id*=ulMobilePatient]","[id*=aMobilePatients]","[id*=aMobilePatientSearch]",0);
            addPatientLoadEvent(pathname,base_url);
            loadHospital(base_url);
            break;
        case '/SearchPatient':
            setMenu("[id*=lnkPatient]","[id*=ulPatient]");
            setMobileMenu("[id*=lnkMobilePatient]","[id*=ulMobilePatient]","[id*=aMobilePatients]","[id*=aMobilePatientSearch]",1);
                setTabulator();
            break;
        case 'showPatient':
            setMenu("[id*=lnkPatient]","[id*=ulPatient]");
            setMobileMenu("[id*=lnkMobilePatient]","[id*=ulMobilePatient]","[id*=aMobilePatients]","[id*=aMobilePatientSearch]",0);
            editPatientLoadEvent();
        break;
        case '/Branch':
            setMenu("[id*=lnkBranch]","[id*=ulBranch]");
            setMobileMenu("[id*=lnkMobileBranch]","[id*=ulMobileBranch]","[id*=aMobileBranch]","[id*=aMobileBrSearch]",0);
            addBranchLoadEvent(base_url);
            break;
        case '/SearchBranch':
            setMenu("[id*=lnkBranch]","[id*=ulBranch]");
            setMobileMenu("[id*=lnkMobileBranch]","[id*=ulMobileBranch]","[id*=aMobileBranch]","[id*=aMobileBrSearch]",1);
            setBranchTabulator();
            break;
        case 'showBranch':
            setMenu("[id*=lnkBranch]","[id*=ulBranch]");
            setMobileMenu("[id*=lnkMobileBranch]","[id*=ulMobileBranch]","[id*=aMobileBranch]","[id*=aMobileBrSearch]",0);
            $("#txtLogo").on('change',function() {
                $("#txtImageChanged").val(1);
            });
            break;
        case "/ConsentForm":
            setMenu("[id*=lnkConsentForm]","[id*=ulConsentForm]");
            setMobileMenu("[id*=lnkMobileConsent]","[id*=ulMobileConsent]","[id*=aMobileConsent]","[id*=aMobilePatientConsent]",1);
            consentFormOnLoad();
            break;
        case "/SearchConsent":
            setMenu("[id*=lnkConsentForm]","[id*=ulConsentForm]");
            setMobileMenu("[id*=lnkMobileConsent]","[id*=ulMobileConsent]","[id*=aMobileConsent]","[id*=aMobilePatientConsent]",1);
            setConsentTabulator();
            break;
        case "/ViewConsent":
            setMenu("[id*=lnkConsentForm]","[id*=ulConsentForm]");
            setMobileMenu("[id*=lnkMobileConsent]","[id*=ulMobileConsent]","[id*=aMobileConsent]","[id*=aMobilePatientConsent]",1);
            loadViewConsentForm();
            break;
        case "/subscribe":
            $("[id*=lnkSubscribe]").addClass("side-menu--active");
            $("[id*=lnkMobileSubscribe]").addClass("menu--active");
            break;            
        case '/PatientAppointment':
                setMenu("[id*=lnkAppointment]","[id*=ulAppointment]");
                setMobileMenu("[id*=lnkMobileAppointment]","[id*=ulMobileAppointment]","[id*=aMobileAppointment]","[id*=aMobileAppointmentSearch]",0);
                addAppointmentLoadEvent(base_url);
                loadHospital(base_url);
                break;
        case '/AllAppointments':
            setMenu("[id*=lnkAppointment]","[id*=ulAppointment]");
            setMobileMenu("[id*=lnkMobileAppointment]","[id*=ulMobileAppointment]","[id*=aMobileAppointment]","[id*=aMobileAppointmentSearch]",0);
            setAppointmentTabulator();
            break;
           
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
  function addPatientLoadEvent(pathname,base_url){
    if(pathname=='/Patient')
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
    console.log("called");
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
     var base_url = window.location.origin;
     var url=base_url+'/api/updatePatient';
     console.log(url);
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             console.log(data);
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
    console.log("entered");
    if ($("#tbPatient").length) {
        console.log( window.location.origin);
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        // Setup Tabulator
        var token=$('#txtToken').val();
        let table = new Tabulator("#tbPatient", {
            ajaxURL: window.location.origin+"/api/patientList",
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
                    title: "REGISTERED NO",
                    minWidth: 50,
                    field: "hcNo",
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
                            <a class="view flex items-center mr-3" href="javascript:;">
                                <i data-lucide="eye" class="w-4 h-4 mr-1"></i> 
                            </a>
                            <a class="edit flex items-center mr-3 text-primary" href="javascript:;">
                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> 
                            </a>
                            <a class="delete flex items-center text-danger" href="javascript:;">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> 
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
                                window.location.href="showPatient/"+cell.getData().id;
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#delete-modal-preview"));
                                deleteModal.show();
                                $('#txtId').val(cell.getData().id);
                                $('#divHcNo span').text(cell.getData().hcNo);
                                console.log(cell.getData().id);
                                $( "#btnDelPatient" ).on( "click", function() {
                                    deletePatient(cell.getData().id,1);
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
    var base_url = window.location.origin;
    var url=base_url+'/api/patientInfo/'+$patientId;
    var token=$('#txtToken').val();
    console.log(url);
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
    var base_url = window.location.origin;
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
                }                   
            }else{
                $('#divErrorHead span').text(data.Success);
                $('#divErrorMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    errorModal.show();
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
    var base_url = window.location.origin;
    window.location.href = base_url+ "/SearchPatient";
});


//Back to search from update/delete End

/*----------------------------------- Delete Patient By ID bEGINS -------------------------*/
function deletePatient(patientId,userId){
    var base_url = window.location.origin;
    var url=base_url+'/api/deletePatient/'+patientId+'/'+userId;
    var token=$('#txtToken').val();
    console.log(url);
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
            console.log(data);
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
==============================================================================================================================================
                                                    ==========================================Doctor=====================================
==============================================================================================================================================
---------------------------------Load Add doctor DropDown  ctrl--BEGIN --------------------------- */
function loadHospital(base_url){
    var token=$('#txtToken').val();
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    var url=base_url+'/api/loadHospital';
    console.log(url);
    fetch(url,options)
            .then(response => response.json())
            .then(function (result) {
                // Load Hospital
                var listHospital=result.hospitalList;
                if(listHospital!=null)
                {
                    listHospital.forEach(function(value, key) {
                        $("#ddlHospital").append($("<option></option>").val(value.id).html(value.hospitalName)); 
                    });
                }
            }); 
            var hospitalId=$('#txtHospital').val();
            console.log(hospitalId);
            var ddlUrl=base_url+'/api/loadBranch/'+hospitalId;
            fetch(ddlUrl,options)
            .then(response => response.json())
            .then(function (result) {
                // Load Hospital
                var listBranch=result.branchList;
                console.log(listBranch);
                console.log(listBranch.length);
                if(listBranch.length!=0)
                {
                    listBranch.forEach(function(value, key) {
                        $("#ddlBranch").append($("<option></option>").val(value.id).html(value.branchName)); 
                    });
                    $("#divBranchddl").removeClass("hidden").removeAttr("style");
                }else{
                    $("#divBranchddl").addClass('hidden');
                }
            });         
}
$("#ddlBranch").on('change',function() {
    $('#txtBranch').val($("#ddlBranch").val());
});
$("#ddlHospital").on('change',function() {
    var token=$('#txtToken').val();
    var hospitalId=$("#ddlHospital").val();
    $('#txtHospital').val(hospitalId);
    console.log(hospitalId);
    let options = {
        method: 'GET',
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
    }
    var base_url = window.location.origin;
    var ddlUrl=base_url+'/api/loadBranch/'+hospitalId;
    fetch(ddlUrl,options)
            .then(response => response.json())
            .then(function (result) {
                $("#ddlBranch option").remove();
                $("#ddlBranch").append($("<option></option>").val(0).html("Select Branch"));
                //Load Branch
                var listBranch=result.branchList;
                if(listBranch.length!=0)
                {
                    listBranch.forEach(function(value, key) {
                        $("#ddlBranch").append($("<option></option>").val(value.id).html(value.branchName)); 
                    });
                    $("#divBranchddl").removeClass("hidden").removeAttr("style");
                    $("#divBranchddl1").removeClass("hidden").removeAttr("style");
                    // $("#divBranchddl2").removeClass("hidden").removeAttr("style");
                }else{
                    $("#divBranchddl").addClass('hidden');
                    $("#divBranchddl1").addClass('hidden');
                    $("#divBranchddl2").addClass('hidden');
                }
            });  
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
    console.log(url);
    fetch(url,options)
            .then(response => response.json())
            .then(function (result) {
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
            });         
   
}
/*---------------------------------Load Add doctor DropDown  ctrl--END --------------------------- */

/* --------------- Doctor Add form submit Begins ------------------------*/

const doctorFrom = document.getElementById('frmDoctor');
if(doctorFrom!=null){
    console.log("called");
//Doctor registeration
doctorFrom.addEventListener("submit", (e) => {
    e.preventDefault();
    const doctorData = new FormData(doctorFrom);
    //  const doctorParams=new URLSearchParams(doctorData);
     const file = document.querySelector('#txtProfileImage').files[0];
     if(file!= null){
        doctorData.append('profileImage', file);
     }
     const sign_file = document.querySelector('#txtSignature').files[0];
     if(sign_file!= null){
        doctorData.append('signature', sign_file);
     }
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
console.log(options);
    var base_url = window.location.origin;
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
                }                   
            }else{
                $('#divDrErrorHead span').text(data.Success);
                $('#divDrErrorMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    drerrorModal.show();
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
        console.log( window.location.origin);
        var hospitalId=$('#txtHospital').val();
        var branchId=$('#txtBranch').val();
        console.log(hospitalId);
        var token=$('#txtToken').val();
        // Setup Tabulator
        let table = new Tabulator("#tbDoctor", {
            ajaxURL: window.location.origin+"/api/doctorList",
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
                    title: "Email",
                    minWidth: 100,
                    field: "email",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "BLOOD GROUP",
                    minWidth: 50,
                    field: "bloodGroup",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "DESIGNATION",
                    minWidth: 50,
                    field: "designation",
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
                            <a class="view flex items-center mr-3" href="javascript:;">
                                <i data-lucide="eye" class="w-4 h-4 mr-1"></i> 
                            </a>
                            <a class="edit flex items-center mr-3 text-primary" href="javascript:;">
                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> 
                            </a>
                            <a class="delete flex items-center text-danger" href="javascript:;">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> 
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
                                window.location.href="showDoctor/"+cell.getData().id;
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#delete-modal-preview"));
                                deleteModal.show();
                                $('#txtId').val(cell.getData().id);
                                $('#divDrCodeNo span').text(cell.getData().doctorCodeNo);
                                console.log(cell.getData().id);
                                $( "#btnDelDoctor" ).on( "click", function() {
                                    deleteDoctor(cell.getData().id,1);
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

/*----------------------------------- Delete Patient By ID bEGINS -------------------------*/
function deleteDoctor(doctorId,userId){
    var base_url = window.location.origin;
    var token=$('#txtToken').val();
    var url=base_url+'/api/deleteDoctor/'+doctorId+'/'+userId;
    console.log(url);
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
            console.log(data);
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
                }
            }
        })
        .catch(function(error){
            $('#divErrorHead span').text('Error');
            $('#divErrorMsg span').text(error);
            errorModal.show();
        });       
    }
    
    /*----------------------------------- Delete Patient By ID END -------------------------*/
/*------------------------ View Doctor Begin ------------------------------*/
function viewDoctor($doctorId){
    var base_url = window.location.origin;
    var url=base_url+'/api/doctorInfo/'+$doctorId;
    console.log(url);
    var token=$('#txtToken').val();
    console.log(token);
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
                $(imgSignature).attr("src",data.doctorDetails.signature);
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
/*--------------------------------------Edit Doctor Begins------------------------------*/
const doctorEditform = document.getElementById('frmEditDoctor');
if(doctorEditform!=null){
    doctorEditform.addEventListener("submit", (epf) => {
    epf.preventDefault();
    console.log("called");
     const doctordata = new FormData(doctorEditform);
     const file = document.querySelector('#txtProfileImage').files[0];
     if(file!=null){
        doctordata.append('profileImage', file);
     }
     const sign_file = document.querySelector('#txtSignature').files[0];
     if(sign_file!=null){
        doctordata.append('signature', sign_file);
     }
     var token=$('#txtToken').val();
     let options = {
         method: "POST",
         body: doctordata,
         headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
     };
     
     var base_url = window.location.origin;
     var url=base_url+'/api/updateDoctor';
     console.log(url);
     const errorDrModal = tailwind.Modal.getInstance(document.querySelector("#divErrorEditDoctor"));
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             console.log(data);
             if(data.Success=='Success'){
                 $('#divMsg span').text(data.Message);
                 $('#divDoctorCodeNo span').text(data.doctorCodeNo);
                 if (data.ShowModal==1) {
                    const successEditModal = tailwind.Modal.getInstance(document.querySelector("#divSuccessEditDoctor"));
                     successEditModal.show();    
                 }                   
             }else{
                 $('#divErrorHead span').text(data.Success);
                 $('#divErrorMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    errorDrModal.show();
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
/*-------------------------------------------------Edit Doctor Ends -----------------------------*/
$( "#btnDrRedirect" ).on( "click", function() {
    window.scrollTo(0, 0);
    window.location.href = window.location.origin+ "/SearchDoctor";
});

/* --------------- Hospital Add form submit Begins ------------------------*/

const hospitalFrom = document.getElementById('frmHospital');
if(hospitalFrom!=null){
//Hospital registeration
hospitalFrom.addEventListener("submit", (e) => {
    e.preventDefault();
    const hospitalData = new FormData(hospitalFrom);
     const file = document.querySelector('#txtLogo').files[0];
     if(file!= null){
        hospitalData.append('logo', file);
     }
     var token=$('#txtToken').val();
     console.log(token);
    let options = {
        method: "POST",
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer '+token,
          },
        body: hospitalData
    };
    var base_url = window.location.origin;
    var url=base_url+'/api/addHospital';

    const drerrorModal = tailwind.Modal.getInstance(document.querySelector("#divHospitalErrorModal"));
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
            ajaxURL: window.location.origin+"/api/hospitalList",
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
                    title: "SUBSCRIBED",
                    minWidth: 50,
                    field: "is_subscribed",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                // {
                //     title: "ACTIVE",
                //     minWidth: 75,
                //     field: "status",
                //     hozAlign: "center",
                //     vertAlign: "middle",
                //     print: false,
                //     download: false,
                //     formatter(cell, formatterParams) {
                //         return `<div class="flex lg:justify-center">
                //             <div class="form-check form-switch">
                //                 <input id="checkbox-switch-7" class="form-check-input" type="checkbox">
                //             </div>
                //         </div>`;
                //     },
                // },
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
                            <a class="view flex items-center mr-3" href="javascript:;">
                                <i data-lucide="eye" class="w-4 h-4 mr-1"></i> 
                            </a>
                            <a class="edit flex items-center mr-3 text-primary" href="javascript:;">
                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> 
                            </a>
                            <a class="delete flex items-center text-danger" href="javascript:;">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> 
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
                                window.location.href="showHospital/"+cell.getData().id;
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeleteHospital"));
                                deleteModal.show();
                                $('#txtId').val(cell.getData().id);
                                $('#divHospitalName span').text(cell.getData().hospitalName);
                                console.log(cell.getData().id);
                                $( "#btnDelHospital" ).on( "click", function() {
                                    deleteHospital(cell.getData().id,1);
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
    var base_url = window.location.origin;
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
    var base_url = window.location.origin;
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
            console.log(data);
            if(data.Success=='Success'){
                if (data.ShowModal==1) {
                  const el = document.querySelector("#divDeleteHospital"); 
                  const modal = tailwind.Modal.getOrCreateInstance(el); 
                  modal.hide();
                  setHospitalTabulator();
                }                   
            }else{
                $('#divErrorHead span').text(data.Success);
                $('#divErrorMsg span').text(data.Message);
                if (data.ShowModal==1) {
                    errorModal.show();
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
     var base_url = window.location.origin;
     var url=base_url+'/api/updateHospital';
     const errorDrModal = tailwind.Modal.getInstance(document.querySelector("#divErrorEditHospital"));
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             console.log(data);
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
    window.location.href = window.location.origin+ "/SearchHospital";
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
                    var hospitalList=result.hospitalList;
                    hospitalList.forEach(function(value, key) {
                        $("#ddlHospital").append($("<option></option>").val(value.id).html(value.hospitalName)); 
                    });
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
    var base_url = window.location.origin;
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
            ajaxURL: window.location.origin+"/api/branchList",
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
                                <i data-lucide="eye" class="w-4 h-4 mr-1"></i> 
                            </a>
                            <a class="edit flex items-center mr-3 text-primary" href="javascript:;">
                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> 
                            </a>
                            <a class="delete flex items-center text-danger" href="javascript:;">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> 
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
                                window.location.href="showBranch/"+cell.getData().id;
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeleteBranch"));
                                deleteModal.show();
                                $('#txtId').val(cell.getData().id);
                                $('#divBranchName span').text(cell.getData().branchName);
                                console.log(cell.getData().id);
                                $( "#btnDelBranch" ).on( "click", function() {
                                    deleteBranch(cell.getData().id,1);
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
    var base_url = window.location.origin;
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
    var base_url = window.location.origin;
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
     var base_url = window.location.origin;
     var url=base_url+'/api/updateBranch';
     const errorDrModal = tailwind.Modal.getInstance(document.querySelector("#divErrorEditHospital"));
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             console.log(data);
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
    window.location.href = window.location.origin+ "/SearchBranch";
});
/*-------------------------------------- Consent Form --------------------------------------*/
function consentFormOnLoad(){
    $("#divNewPanel").addClass('hidden');
    var hcNo=$("#txtRegNo").val();
    if(hcNo>0){
        clearConsentForm();
        getPatientFormInfo();
        $("#divRegPanel").addClass('hidden');
        $("#divNewPanel").removeClass("hidden").removeAttr("style");
        document.getElementById('btnPrintConsent').disabled = false;
        document.getElementById('btnPrintAllConsent').disabled = false; 
    }else{
        $("#txtRegNo").val('');
    }
    $("#btnRegNoClear").on("click", function () {
        $("#txtRegNo").val("");
        clearConsentForm();
    });
    $("#btnNewConsent").on("click", function () {
        $("#txtRegNo").val("");
        clearConsentForm();
        $("#divNewPanel").addClass('hidden');
        $("#divRegPanel").removeClass("hidden").removeAttr("style");
    });
    $("#btnGo").on("click", function () {
        clearConsentForm();
        getPatientFormInfo();  
        $("#txtRegNo").val("");      
    });
    $( "#btnPrintConsent" ).on( "click", function() {
      var divToPrint=document.getElementById('divConsentContent');
      var newWin=window.open('','Print-Window');
      newWin.document.open();
      newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
      newWin.document.close();
      setTimeout(function(){newWin.close();},10);            
    });
    $('#btnSaveConsent').on("click",function(){
        saveConsentForm();
    });
}
/*----------------- clear consent form -----------*/
    function clearConsentForm(){
        sessionStorage.removeItem("selectedForm");
        document.getElementById('btnPrintConsent').disabled = true;
        document.getElementById('btnPrintAllConsent').disabled = true;
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
    var base_url = window.location.origin;
    const errorDrModal = tailwind.Modal.getInstance(document.querySelector("#divConsentErrorModal"));
    var hospitalId=$("#txtHospital").val();
    var branchId=$("#txtBranch").val()==""?0:$("#txtBranch").val();
    var hcNo=$("#txtRegNo").val();
    console.log(hcNo);
    if(hcNo==""||hcNo==0||hcNo==null){
        $('#divErrorHead span').text('Error');
        $('#divErrorMsg span').text("Please enter Patient Registered Number");
        errorDrModal.show();
    }else{
        var token=$('#txtToken').val();
            var url=base_url+'/api/consentFormList/'+hospitalId+'/'+branchId+'/'+hcNo;
            console.log(url);
            var isSaved=0;
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
                    console.log(data);
                    if(data.Success=='Success'){
                        //Load Consent form list -- BEGIN
                        var html = "";
                        var formList=data.consentList;
                        var i=1;
                        formList.forEach(function(value, key) {
                            html = '<div id=div'+i+' class="intro-x bg-blue-800 text-white cursor-pointer box relative flex items-center p-5 '+(i>1?'mt-5':'')+'"><div class="ml-2 overflow-hidden"><div class="form-check mt-2"> <input id="chk'+value.id+'" class="form-check-input" type="checkbox"><label class="form-check-label" for="chk'+value.id+'"> <div class="flex items-center"><a href="javascript:;" class="font-medium">'+value.formName+'</a> </div></label></div></div></div> '; 
                            $('#divFormNameList').append(html);
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
                                    console.log(chkId);
                                    $(chkId).on("change",function(event) {
                                        console.log(this.checked);
                                        if(this.checked) {
                                            index_id=selectedForm.indexOf(value.id);
                                            if(index_id<0){
                                                selectedForm.push(value.id);
                                            }
                                        }else if(!this.checked){
                                            isSaved=1;
                                            index_id=selectedForm.indexOf(value.id);
                                            console.log(value.id);
                                            console.log("index_id"+index_id);
                                            if(index_id>=0){
                                                selectedForm.splice(index_id,1);
                                            }
                                        }
                                        sessionStorage.setItem("selectedForm", selectedForm);
                                    });                             
                                    //Get the checked Checkbox ---END
                                    let currentDate = new Date().toISOString().slice(0, 10).split('-').reverse().join('/'); 
                                    let display_formContent=value.formContent;
                                     display_formContent=display_formContent.replaceAll("@hospitalName ", data.patientDetails.hospitalName);
                                     display_formContent=display_formContent.replaceAll("@hospitalAddress ", data.patientDetails.hospitalAddress);
                                     display_formContent= display_formContent.replaceAll("@patientName", data.patientDetails.name);
                                     display_formContent= display_formContent.replaceAll("@spouseName", data.patientDetails.spouseName);
                                     display_formContent= display_formContent.replaceAll("@date", currentDate);

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
                            $('#divGender span').text(data.patientDetails.gender);
                            $('#divDob span').text(data.patientDetails.dob);
                            $('#divAge span').text(data.patientDetails.age);
                            $('#divBloodGrp span').text(data.patientDetails.bloodGroup);
                            $('#divHeight span').text(data.patientDetails.height);
                            $('#divWeight span').text(data.patientDetails.weight);
                            $('#divSpouseName span').text(data.patientDetails.spouseName);
                            $('#divSpousePhoneNo span').text(data.patientDetails.spousePhnNo);
                            $('#divReason span').text(data.patientDetails.reason);
                            $('#divReferedBy span').text(data.patientDetails.refferedBy);
                            if(data.patientDetails.refferedBy=="Doctor"){
                                $('#divDoctorName span').text(data.patientDetails.refDoctorName);
                                $('#divDrHospital span').text(data.patientDetails.refDrHospitalName);
                                $('#lblDrName').text("Doctor Name :");
                                $('#lblDrHospital').text("Doctor hospital :");
                            }else{
                                $('#divDoctorName span').text("");
                                $('#divDrHospital span').text("");
                                $('#lblDrName').text("");
                                $('#lblDrHospital').text("");
                            }
                        // Patient Information --- END
                        $("#divProfile").removeClass("hidden").removeAttr("style");
                        $("#divFormList").removeClass("hidden").removeAttr("style");
                        $("#divFormContent").removeClass("hidden").removeAttr("style");
                    }else{
                        $('#divErrorHead span').text(data.Success);
                        $('#divErrorMsg span').text(data.Message);
                        if (data.ShowModal==1) {
                        errorDrModal.show();
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
function saveConsentForm(){
    var selectedForm= sessionStorage.getItem("selectedForm");
    const errorModal = tailwind.Modal.getInstance(document.querySelector("#divConsentErrorModal"));
    if(selectedForm==null || selectedForm.length==0){
        $('#divErrorHead span').text('Validation Error');
        $('#divErrorMsg span').text("Please select the any one of the consent form");
        errorModal.show();
        return;
    }

var patientDetails={
    "userId": $("#txtUser").val(),
    "patientId": $("#txtPatientId").val(),
    "consentFormList": selectedForm
};
console.log(patientDetails);
var token=$('#txtToken').val();
    var base_url = window.location.origin;
    var url=base_url+'/api/savePatientConsent';
    let options = {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        Authorization: 'Bearer '+token,
                      },
                    body: JSON.stringify(patientDetails)
                };
                console.log(options);
    fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             console.log(data);
             if(data.Success=='Success'){
                 $('#divMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    const successModal = tailwind.Modal.getInstance(document.querySelector("#divSuccessModal"));
                    successModal.show(); 
                    document.getElementById('btnPrintConsent').disabled = false;
                    document.getElementById('btnPrintAllConsent').disabled = false;   
                    $('#txtRegNo').val('');
                 }                   
             }else{
                 $('#divErrorHead span').text(data.Success);
                 $('#divErrorMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    errorModal.show();
                 }
             }
         })
         .catch(function(error){
             $('#divErrorHead span').text('Error');
             $('#divErrorMsg span').text(error);
             errorModal.show();
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
            ajaxURL: window.location.origin+"/api/patientConsentList",
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
                    minWidth: 50,
                    field: "patientName",
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
                    title: "CONSENT FORM",
                    minWidth: 150,
                    field: "consentForms",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "CREATED DATE",
                    minWidth: 150,
                    field: "created_date",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "UPDATED DATE",
                    minWidth: 150,
                    field: "updated_at",
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
                            <a class="edit flex items-center mr-3 text-primary" href="javascript:;">
                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> 
                            </a>
                        </div>`);
                        $(a)
                            .find(".edit")
                            .on("click", function () {
                                window.location.href="ConsentForm/"+cell.getData().hcNo;
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
    var base_url = window.location.origin;
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
                            html = '<div id=div'+i+' class="intro-x bg-blue-800 text-white cursor-pointer box relative flex items-center p-5 '+(i>1?'mt-5':'')+'"><div class="ml-2 overflow-hidden"><div class="form-check mt-2"> <input id="chk'+value.id+'" class="form-check-input" type="checkbox"><label class="form-check-label" for="chk'+value.id+'"> <div class="flex items-center"><a href="javascript:;" class="font-medium">'+value.formName+'</a> </div></label></div></div></div> '; 
                            $('#divFormNameList').append(html);
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
                                    document.getElementById('divConsentContent').innerHTML=value.formContent;
                                $('#divConsentHeader span').text(value.formName);                               
                            });
                            i=i+1;
                        });
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
        $("#txtHcNo").val("");
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
                var listGender=result.gender;
                listGender.forEach(function(value, key) {
                    $("#ddlGender").append($("<option></option>").val(value.name).html(value.name)); 
                });

                var listDepartment=result.department;
                listDepartment.forEach(function(value, key) {
                    $("#ddlDepartment").append($("<option></option>").val(value.id).html(value.name)); 
                });
            });  
    
            //Doctor details   
        var doctorUrl=base_url+'/api/doctorByDepartment/'+hospitalId+'/'+branchId+'/0';
    fetch(doctorUrl,options)
            .then(response => response.json())
            .then(function (result) {
                var listDoctor=result.doctorList;
                listDoctor.forEach(function(value, key) {
                    $("#ddlDoctor").append($("<option></option>").val(value.id).html(value.name)); 
                });
            });    
    
            //Department change load doctor
     $("#ddlDepartment").on('change',function() {
        var departmentId=$("#ddlDepartment").val();
        var doctorUrl=base_url+'/api/doctorByDepartment/'+hospitalId+'/'+branchId+'/'+departmentId;
        fetch(doctorUrl,options)
                .then(response => response.json())
                .then(function (result) {
                    $("#ddlDoctor option").remove();
                    $("#ddlDoctor").append($("<option></option>").val(0).html("Select Doctor"));
                    var listDoctor=result.doctorList;
                    listDoctor.forEach(function(value, key) {
                        $("#ddlDoctor").append($("<option></option>").val(value.id).html(value.name)); 
                    });
                });  
     });      
    
     //Display Patient Information
     $('#txtHcNo').on("keypress", function(e) {
        e.preventDefault();
        if (e.key == "Enter") {
            var hcNo=$("#txtHcNo").val();
            console.log(hcNo);
            const errorModal = tailwind.Modal.getInstance(document.querySelector("#divErrorAppointment"));
            if(hcNo==null || hcNo==0)
            {
                clearTabData(1);
                $('#divAppErrorHead span').text("Invalid Registered Number");
                $('#divAppErrorMsg span').text("Please enter the valid registered number");
                    errorModal.show();
                return false;
            }
            var url=base_url+'/api/registeredPatientInfo/'+hcNo+'/'+hospitalId+'/'+branchId;
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
                }
            }
        })
        .catch(function(error){
            $('#divAppErrorHead span').text('Error');
            $('#divAppErrorMsg span').text(error);
            $("#divPatientInfo").addClass('hidden');
            errorModal.show();
        }); 

            return false; 
        }
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
     var base_url = window.location.origin;
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
                 }                   
             }else{
                 $('#divAppErrorHead span').text(data.Success);
                 $('#divAppErrorMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                     errorModal.show();
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
    const myTab = tailwind.Tab.getInstance(document.querySelector("#divPatientTab1"));
    myTab.show();
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
            ajaxURL: window.location.origin+"/api/appointmentList",
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
                    title: "Email",
                    minWidth: 100,
                    field: "email",
                    hozAlign: "left",
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
                            <a class="view flex items-center mr-3" href="javascript:;">
                                <i data-lucide="eye" class="w-4 h-4 mr-1"></i> 
                            </a>
                            <a class="edit flex items-center mr-3 text-primary" href="javascript:;">
                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> 
                            </a>
                            <a class="delete flex items-center text-danger" href="javascript:;">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> 
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
                                window.location.href="showPatient/"+cell.getData().id;
                            });
                        $(a)
                            .find(".delete")
                            .on("click", function () {
                                const deleteModal = tailwind.Modal.getInstance(document.querySelector("#delete-modal-preview"));
                                deleteModal.show();
                                $('#txtId').val(cell.getData().id);
                                $('#divHcNo span').text(cell.getData().hcNo);
                                console.log(cell.getData().id);
                                $( "#btnDelPatient" ).on( "click", function() {
                                    deletePatient(cell.getData().id,1);
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
                sheetName: "Patients",
            });
        });
        // Print
        $("#tbAppointment-print").on("click", function (event) {
            table.print();
        });
    }
}
/*------------------------------------------- Appointment Search END -------------------------*/ 
})();
