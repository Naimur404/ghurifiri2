(()=>{function e(e,t){for(var n=0;n<t.length;n++){var a=t[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(e,a.key,a)}}function t(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var n=function(){function n(){var e=this;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,n),t(this,"modal",$(document).find(".crop-image-modal")),t(this,"image",this.modal.find(".cropper-image")),t(this,"cropper",null),this.modal.on("change",'input[type="file"]',(function(t){var n,a,r=t.target.files;r&&r.length>0&&(a=r[0],URL?e.image.prop("src",URL.createObjectURL(a)):FileReader&&((n=new FileReader).onload=function(){e.image.prop("src",n.result)},n.readAsDataURL(a))),e.init()})).on("click",'button[type="submit"]',(function(t){t.preventDefault();var n=$(t.currentTarget),a=e.modal.find("form");e.cropper.getCroppedCanvas({width:160,height:160}).toBlob((function(t){var r=new FormData;r.append(a.find('input[type="file"]').prop("name"),t),$httpClient.make().withButtonLoading(n).post(a.prop("action"),r).then((function(t){var n=t.data;e.updateImage(n.data.url),Botble.showSuccess(n.message),e.modal.modal("hide")}))}))})).on("shown.bs.modal",(function(t){var n=$(t.relatedTarget).closest(".crop-image-container").find(".crop-image-original"),a=new Image;a.src=n.prop("src"),a.onload=function(){e.image.prop("src",a.src),e.init()}})).on("hidden.bs.modal",(function(){e.destroy()})),$(document).on("click",'[data-bb-toggle="delete-avatar"]',(function(t){t.preventDefault();var n=$(t.currentTarget);$httpClient.make().post(n.prop("href")).then((function(t){var n=t.data;e.updateImage(n.data.url),Botble.showSuccess(n.message),e.modal.modal("hide")}))}))}var a,r,o;return a=n,(r=[{key:"init",value:function(){this.cropper&&this.cropper.destroy(),this.cropper=new Cropper(this.image[0],{aspectRatio:1,preview:".img-preview"})}},{key:"destroy",value:function(){this.cropper.destroy(),this.cropper=null,this.image.prop("src",""),this.modal.find('input[type="file"]').val("")}},{key:"updateImage",value:function(e){$(document).find(".crop-image-original").each((function(t,n){$(n).is("img")?$(n).prop("src",e):$(n).css("background-image","url(".concat(e,")"))}))}}])&&e(a.prototype,r),o&&e(a,o),Object.defineProperty(a,"prototype",{writable:!1}),n}();$((function(){new n}))})();