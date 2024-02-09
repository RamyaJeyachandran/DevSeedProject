import xlsx from "xlsx";
import { createIcons, icons } from "lucide";
import Tabulator from "tabulator-tables";

(function () {
    window.addEventListener("load", (e) => {
        e.preventDefault();
        console.log("called");
        // $($lnkAppointment).addClass("side-menu--active");
        // $($ulAppointment).addClass("side-menu__sub-open");

        // $($lnkMobileAppointment).addClass("menu--active");
        // $($ulMobileAppointment).addClass("menu__sub-open");
        // $($aMobileAppointmentToday).addClass("menu--active");
        setTodayAppointmentTabulator();
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
                                window.location.href="showAppointment/"+cell.getData().id;
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
/*------------------------------------------- Appointment Search END -------------------------*/ 
/*------------------------ View Patient Appointment Begin ------------------------------*/
function viewPatientAppointment($appointmentId){
    var base_url = window.location.origin;
    var url=base_url+'/api/patientAppointmentInfo/'+$appointmentId;
    var token=$('#txtToken').val();
    console.log(url);
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
    console.log(userId);
    var base_url = window.location.origin;
    var url=base_url+'/api/deleteAppointment/'+appointmentId+'/'+userId;
    var token=$('#txtToken').val();
    console.log(url);
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
            console.log(data);
            if(data.Success=='Success'){
                if (data.ShowModal==1) {
                    const deleteModal = tailwind.Modal.getInstance(document.querySelector("#divDeleteAppointment"));
                    deleteModal.hide();
                    setAppointmentTabulator();
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
     var base_url = window.location.origin;
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
                 }
             }
         })
         .catch(function(error){
             $('#divErrorHead span').text('Error');
             $('#divErrorMsg span').text(error);
             errorModal.show();
         });       
 });      
 /*-------------------------------------Appointment Update Status -----------------------------------------*/
const appointmentStatusEditform = document.getElementById('frmUpdAppointmentStatus');
if(appointmentStatusEditform!=null){
    appointmentStatusEditform.addEventListener("submit", (epf) => {
    epf.preventDefault();
     const appointmentdata = new FormData(appointmentStatusEditform);
     const params=new URLSearchParams(appointmentdata);
     var userId=$("#txtUser").val();
     console.log(userId);
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
     var base_url = window.location.origin;
     var url=base_url+'/api/updateStatus';
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             if(data.Success=='Success'){
                const statusModal = tailwind.Modal.getInstance(document.querySelector("#divStatusModal"));
                setAppointmentTabulator();
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

}
/*-------------------------------------------------Edit patient Ends -----------------------------*/

});