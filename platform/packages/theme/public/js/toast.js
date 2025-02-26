(()=>{"use strict";function t(n){return t="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},t(n)}function n(t,n){for(var o=0;o<n.length;o++){var e=n[o];e.enumerable=e.enumerable||!1,e.configurable=!0,"value"in e&&(e.writable=!0),Object.defineProperty(t,e.key,e)}}var o,e=function(){function o(t){var n,e,i;!function(t,n){if(!(t instanceof n))throw new TypeError("Cannot call a class as a function")}(this,o),i={oldestFirst:!0,text:"Toastify is awesome!",node:void 0,duration:3e3,selector:void 0,callback:function(){},close:!1,gravity:"toastify-top",position:"",className:"",stopOnFocus:!0,onClick:function(){},offset:{x:0,y:0},escapeMarkup:!0,ariaLive:"polite",style:{background:""}},(e="defaults")in(n=this)?Object.defineProperty(n,e,{value:i,enumerable:!0,configurable:!0,writable:!0}):n[e]=i,this.options={},this.toastElement=null,this._rootElement=document.body,this._init(t)}var e,i,s;return e=o,(i=[{key:"showToast",value:function(){var t=this;if(this.toastElement=this._buildToast(),"string"==typeof this.options.selector?this._rootElement=document.getElementById(this.options.selector):this.options.selector instanceof HTMLElement||this.options.selector instanceof ShadowRoot?this._rootElement=this.options.selector:this._rootElement=document.body,!this._rootElement)throw"Root element is not defined";return this._rootElement.insertBefore(this.toastElement,this._rootElement.firstChild),this._reposition(),this.options.duration>0&&(this.toastElement.timeOutValue=window.setTimeout((function(){t._removeElement(t.toastElement)}),this.options.duration)),this}},{key:"hideToast",value:function(){this.toastElement.timeOutValue&&clearTimeout(this.toastElement.timeOutValue),this._removeElement(this.toastElement)}},{key:"_init",value:function(t){this.options=Object.assign(this.defaults,t),this.toastElement=null,this.options.gravity="bottom"===t.gravity?"toastify-bottom":"toastify-top",this.options.stopOnFocus=void 0===t.stopOnFocus||t.stopOnFocus}},{key:"_buildToast",value:function(){var n=this;if(!this.options)throw"Toastify is not initialized";var o=document.createElement("div");for(var e in o.className="toastify on ".concat(this.options.className," pe-5"),o.className+=" toastify-".concat(this.options.position),o.className+=" ".concat(this.options.gravity),this.options.style)o.style[e]=this.options.style[e];if(this.options.ariaLive&&o.setAttribute("aria-live",this.options.ariaLive),""!==this.options.icon){var i=document.createElement("div");i.className="toastify-icon",i.innerHTML=this.options.icon,o.appendChild(i)}var s=document.createElement("span");if(s.className="toastify-text",this.options.node&&this.options.node.nodeType===Node.ELEMENT_NODE?s.appendChild(this.options.node):this.options.escapeMarkup?s.innerText=this.options.text:s.innerHTML=this.options.text,o.appendChild(s),!0===this.options.close){var r=document.createElement("button");r.type="button",r.setAttribute("aria-label","Close"),r.className="toast-close",r.style.cssText="position: absolute; top: 8px; inset-inline-end: 8px;",r.innerHTML='<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n                <path d="M18 6l-12 12"></path>\n                <path d="M6 6l12 12"></path>\n            </svg>',r.addEventListener("click",(function(t){t.stopPropagation(),n._removeElement(n.toastElement),window.clearTimeout(n.toastElement.timeOutValue)}));var a=window.innerWidth>0?window.innerWidth:screen.width;"left"===this.options.position&&a>360?o.insertAdjacentElement("afterbegin",r):o.appendChild(r)}if(this.options.stopOnFocus&&this.options.duration>0&&(o.addEventListener("mouseover",(function(t){window.clearTimeout(o.timeOutValue)})),o.addEventListener("mouseleave",(function(){o.timeOutValue=window.setTimeout((function(){n._removeElement(o)}),n.options.duration)}))),"function"==typeof this.options.onClick&&o.addEventListener("click",(function(t){t.stopPropagation(),n.options.onClick()})),"object"===t(this.options.offset)){var l=this._getAxisOffsetAValue("x",this.options),c=this._getAxisOffsetAValue("y",this.options),p="left"===this.options.position?l:"-".concat(l),d="toastify-top"===this.options.gravity?c:"-".concat(c);o.style.transform="translate(".concat(p,",").concat(d,")")}return o}},{key:"_removeElement",value:function(t){var n=this;t.className=t.className.replace(" on",""),window.setTimeout((function(){n.options.node&&n.options.node.parentNode&&n.options.node.parentNode.removeChild(n.options.node),t.parentNode&&t.parentNode.removeChild(t),n.options.callback.call(t),n._reposition()}),400)}},{key:"_reposition",value:function(){for(var t,n={top:15,bottom:15},o={top:15,bottom:15},e={top:15,bottom:15},i=this._rootElement.querySelectorAll(".toastify"),s=0;s<i.length;s++){t=!0===i[s].classList.contains("toastify-top")?"toastify-top":"toastify-bottom";var r=i[s].offsetHeight;t=t.substr(9,t.length-1),(window.innerWidth>0?window.innerWidth:screen.width)<=360?(i[s].style[t]="".concat(e[t],"px"),e[t]+=r+15):!0===i[s].classList.contains("toastify-left")?(i[s].style[t]="".concat(n[t],"px"),n[t]+=r+15):(i[s].style[t]="".concat(o[t],"px"),o[t]+=r+15)}}},{key:"_getAxisOffsetAValue",value:function(t,n){return n.offset[t]?isNaN(n.offset[t])?n.offset[t]:"".concat(n.offset[t],"px"):"0px"}}])&&n(e.prototype,i),s&&n(e,s),Object.defineProperty(e,"prototype",{writable:!1}),o}();(o=document.createElement("style")).textContent="\n        .toastify {\n            padding: 0.75rem 2rem 0.75rem 0.75rem;\n            color: #ffffff;\n            display: flex;\n            align-items: center;\n            gap: 0.5rem;\n            box-shadow:\n                0 3px 6px -1px rgba(0, 0, 0, 0.12),\n                0 10px 36px -4px rgba(77, 96, 232, 0.3);\n            background: -webkit-linear-gradient(315deg, #73a5ff, #5477f5);\n            background: linear-gradient(135deg, #73a5ff, #5477f5);\n            position: fixed;\n            opacity: 0;\n            transition: all 0.4s cubic-bezier(0.215, 0.61, 0.355, 1);\n            border-radius: 2px;\n            cursor: pointer;\n            text-decoration: none;\n            z-index: 999999;\n            width: 25rem;\n            max-width: calc(100% - 30px);\n        }\n\n        .toastify.on {\n            opacity: 1;\n        }\n\n        .toastify-icon {\n            width: 1.5rem;\n            height: 1.5rem;\n        }\n\n        .toast-close {\n            background: transparent;\n            border: 0;\n            color: white;\n            cursor: pointer;\n            font-family: inherit;\n            font-size: 1em;\n            opacity: 0.4;\n            padding: 0 5px;\n            position: absolute;\n            top: 0.25rem;\n            inset-inline-end: 0.25rem;\n        }\n\n        .toast-close svg {\n            width: 1em;\n            height: 1em;\n        }\n\n        .toastify-text a {\n            text-decoration: underline;\n            color: #fff;\n        }\n\n        .toastify-right {\n            inset-inline-end: 15px;\n        }\n\n        .toastify-left {\n            inset-inline-start: 15px;\n        }\n\n        .toastify-top {\n            top: -150px;\n        }\n\n        .toastify-bottom {\n            bottom: -150px;\n        }\n\n        .toastify-rounded {\n            border-radius: 25px;\n        }\n\n        .toastify-center {\n            margin-inline-start: auto;\n            margin-inline-end: auto;\n            inset-inline-start: 0;\n            inset-inline-end: 0;\n            max-width: fit-content;\n            max-width: -moz-fit-content;\n        }\n\n        @media only screen and (max-width: 360px) {\n            .toastify-right,\n            .toastify-left {\n                margin-inline-start: auto;\n                margin-inline-end: auto;\n                inset-inline-start: 0;\n                inset-inline-end: 0;\n                max-width: fit-content;\n            }\n        }\n    ",document.head.appendChild(o);const i=function(t){return new e(t)};var s=s||{};window.Theme=s,s.showNotice=function(t,n){var o="#fff",e="";switch(t){case"success":o="#51a351",e='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>';break;case"danger":o="#bd362f",e='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 9v4" /><path d="M12 16v.01" /></svg>';break;case"warning":o="#f89406",e='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 8v4" /><path d="M12 16h.01" /></svg>';break;case"info":o="#2f96b4",e='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>'}i({text:n,icon:e,duration:5e3,close:!0,gravity:"bottom",position:"right",stopOnFocus:!0,style:{background:o},escapeMarkup:!1}).showToast()},s.showError=function(t){this.showNotice("danger",t)},s.showSuccess=function(t){this.showNotice("success",t)},s.handleError=function(t){void 0!==t.errors&&t.errors.length?s.handleValidationError(t.errors):void 0!==t.responseJSON?void 0!==t.responseJSON.errors?422===t.status&&s.handleValidationError(t.responseJSON.errors):void 0!==t.responseJSON.message?s.showError(t.responseJSON.message):s.showError(t.responseJSON.join(", ").join(", ")):s.showError(t.statusText)},s.handleValidationError=function(t){var n="";Object.values(t).forEach((function(t){""!==n&&(n+="\n"),n+=t})),s.showError(n)}})();