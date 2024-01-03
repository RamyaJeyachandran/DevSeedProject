(function () {
    "use strict";

    const forgetPassFrm = document.getElementById('frmForgetPassword');
if(forgetPassFrm!=null){
    forgetPassFrm.addEventListener("submit", (epf) => {
    epf.preventDefault();
     const forgetdata = new FormData(forgetPassFrm);
     const params=new URLSearchParams(forgetdata);
     
     const errorModal = tailwind.Modal.getInstance(document.querySelector("#divForgetPassErrorModal"));
     let options = {
         method: "POST",
         body: params,
     };
     var base_url = localStorage.getItem("base_url");
     var url=base_url+'/api/forgetPassword';
     fetch(url, options)
         .then(function(response){ 
             return response.json(); 
         })
         .then(function(data){ 
             if(data.Success=='Success'){
                 $('#divMsg span').text(data.Message);
                 if (data.ShowModal==1) {
                    document.getElementById("frmForgetPassword").reset() ;
                    const successEditModal = tailwind.Modal.getInstance(document.querySelector("#divForgetPassSuccessModal"));
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
})();