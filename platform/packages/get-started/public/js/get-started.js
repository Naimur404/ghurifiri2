window.getStartedCookie=function(){var t="get_started_cookie",o=window.location.hostname;function e(t,e,a){var d=new Date;d.setTime(d.getTime()+24*a*60*60*1e3),document.cookie="".concat(t,"=").concat(e,";expires=").concat(d.toUTCString(),";domain=").concat(o,";path=/")}return{setupCookie:function(){var o=arguments.length>0&&void 0!==arguments[0]?arguments[0]:1;e(t,1,o)},cookieExists:function(){return-1!==document.cookie.split("; ").indexOf(t+"=1")}}}(),$((function(){window.getStartedCookie.cookieExists()||$('.get-started-modal[data-step="1"]').modal("show"),$(document).on("click",".get-started-modal button[type=submit]",(function(t){t.preventDefault(),t.stopPropagation();var o=$(this),e=o.closest("form");Botble.showButtonLoading(o),$httpClient.make().postForm(e.prop("action"),new FormData(e[0])).then((function(t){var e=t.data;o.closest(".get-started-modal").modal("hide"),$('.get-started-modal[data-step="'.concat(e.data.step,'"]')).modal("show")})).finally((function(){Botble.hideButtonLoading(o)}))})),$(".get-started-modal .btn-close").on("click",(function(t){t.preventDefault();var o=$(this).closest(".get-started-modal").data("step");$(".js-back-to-wizard").data("step",o),$(this).closest(".get-started-modal").modal("hide"),$(".close-get-started-modal").modal("show")})),$(document).on("click",".js-back-to-wizard",(function(t){t.preventDefault(),$(this).closest(".close-get-started-modal").modal("hide"),$('.get-started-modal[data-step="'.concat($(this).data("step"),'"]')).modal("show")})),$(document).on("click",".js-close-wizard",(function(t){t.preventDefault(),window.getStartedCookie.setupCookie(),$(this).closest(".close-get-started-modal").modal("hide")})),$(document).on("click",".resume-setup-wizard",(function(t){t.preventDefault(),$('.get-started-modal[data-step="1"]').modal("show")})),$(".get-started-modal").on("hide.bs.modal",(function(){window.getStartedCookie.cookieExists()||window.getStartedCookie.setupCookie(.2)}))}));