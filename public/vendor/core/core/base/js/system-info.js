(()=>{function e(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}var t=function(){function t(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t)}var n,r,a;return n=t,(r=[{key:"init",value:function(){var e=document.getElementById("txt-report").value;e=(e=(e=e.replace(/(^\s*)|(\s*$)/gi,"")).replace(/[ ]{2,}/gi," ")).replace(/\n /,"\n"),document.getElementById("txt-report").value=e,$("#btn-report").on("click",(function(){$("#report-wrapper").slideToggle()})),$("#copy-report").on("click",(function(){$("#txt-report").trigger("select")})),$httpClient.make().get($("[data-get-addition-data-url]").data("get-addition-data-url")).then((function(e){var t=e.data;$("#system-app-size").text(t.data.appSize)}))}}])&&e(n.prototype,r),a&&e(n,a),Object.defineProperty(n,"prototype",{writable:!1}),t}();$((function(){(new t).init()}))})();