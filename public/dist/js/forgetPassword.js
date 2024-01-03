/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./public/src/js/forgetPassword.js ***!
  \*****************************************/
(function () {
  "use strict";

  var forgetPassFrm = document.getElementById('frmForgetPassword');
  if (forgetPassFrm != null) {
    forgetPassFrm.addEventListener("submit", function (epf) {
      epf.preventDefault();
      var forgetdata = new FormData(forgetPassFrm);
      var params = new URLSearchParams(forgetdata);
      var errorModal = tailwind.Modal.getInstance(document.querySelector("#divForgetPassErrorModal"));
      var options = {
        method: "POST",
        body: params
      };
      var base_url = localStorage.getItem("base_url");
      var url = base_url + '/api/forgetPassword';
      fetch(url, options).then(function (response) {
        return response.json();
      }).then(function (data) {
        if (data.Success == 'Success') {
          $('#divMsg span').text(data.Message);
          if (data.ShowModal == 1) {
            document.getElementById("frmForgetPassword").reset();
            var successEditModal = tailwind.Modal.getInstance(document.querySelector("#divForgetPassSuccessModal"));
            successEditModal.show();
          }
        } else {
          $('#divErrorHead span').text(data.Success);
          $('#divErrorMsg span').text(data.Message);
          if (data.ShowModal == 1) {
            errorModal.show();
          }
        }
      })["catch"](function (error) {
        $('#divErrorHead span').text('Error');
        $('#divErrorMsg span').text(error);
        errorModal.show();
      });
    });
  }
})();
/******/ })()
;