!function(t){var e={};function n(i){if(e[i])return e[i].exports;var a=e[i]={i:i,l:!1,exports:{}};return t[i].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=t,n.c=e,n.d=function(t,e,i){n.o(t,e)||Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:i})},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="/",n(n.s=178)}({178:function(t,e,n){t.exports=n(179)},179:function(t,e,n){window.onload=function(){!function(t,e,i){"use strict";t(i).ready(function(){n(180),n(181),n(182),console.log("Global js ready!"),t('a[data-toggle="tab"]').on("shown.bs.tab",function(e){history.pushState?history.pushState(null,null,t(this).attr("href")):location.hash=t(this).attr("href")}),t("form[id$='-search']").submit(function(n){t("#formHash").length?t("#formHash").val(e.location.hash):t(this).append(t("<input>",{type:"hidden",id:"formHash",name:"formHash",val:e.location.hash}))})});var a=e.location.hash;if(t("#formHash").length)a=t("#formHash").val();if(""!=a||void 0!=a){var o=t('a[href="'+a+'"]');1==o.length&&o.tab("show")}"https://wiki.restarters.dev"==e.location.origin&&(t(".wiki-nav-item").addClass("active"),t(".nav-tabs-block li a").removeClass("active"),t('.nav-tabs-block li a[href*="'+e.location.pathname+'"]').each(function(){t(this).addClass("active")}))}(jQuery,window,document)}},180:function(t,e){$(".toggle-dropdown-menu").click(function(){if($(this).hasClass("dropdown-active"))return $(".toggle-dropdown-menu").each(function(){$(this).removeClass("dropdown-active"),$(this).parents().children(".dropdown-menu-items").hide()}),!1;$(".toggle-dropdown-menu").not(this).each(function(){$(this).removeClass("dropdown-active"),$(this).parents().children(".dropdown-menu-items").hide()}),$(this).toggleClass("dropdown-active"),$(this).parents().children(".dropdown-menu-items").show()})},181:function(t,e){$notification_menu_items=$(".notification-menu-items"),$notification_menu_items.hide(),$(".toggle-notifications-menu .bell-icon-active").hide(),$url="https://restarters.dev/test/discourse/notifications",$.ajax({headers:{"Content-Type":"application/x-www-form-urlencoded"},xhrFields:{withCredentials:!0},type:"GET",url:$url,datatype:"json",success:function(t){if(console.log("Success: connected to Discourse."),"failed"==t.message)return console.log("Success: failed to find any new notifications."),!1;var e=t.notifications;Object.keys(e).length>0&&(console.log("Success: notifications found on Discourse."),$notification_menu_items.css("display",""),$notification_menu_items.empty(),$(".toggle-notifications-menu .bell-icon-active").css("display",""),$.each(e,function(t,e){$notification_menu_items.append($("<li>").append($("<a>").attr("href","https://restarters.dev/notifications/"+e.id).text(e.data.title)).attr("class","notifcation-text"))}))}})},182:function(t,e){$url="https://restarters.dev/test/check-auth",$notifications_list_item=$(".notifications-list-item").hide(),$auth_menu_items=$(".auth-menu-items").hide(),$auth_menu_items.removeClass("dropdown-menu-items"),$.ajax({headers:{"Content-Type":"application/x-www-form-urlencoded"},xhrFields:{withCredentials:!0},type:"GET",url:$url,datatype:"json",success:function(t){$auth_list_item=$(".auth-list-item"),t=t.data,$main_navigation_dropdown=$(".main-nav-dropdown"),null!==t.authenticated&&void 0!==t.authenticated?($.each(t.menu.reporting,function(t,e){var n=t.includes("spacer");t.includes("header")?$main_navigation_dropdown.append($("<li>").attr("class","dropdown-menu-header").text(e)):n?$main_navigation_dropdown.append($("<li>").attr("class","dropdown-spacer")):$main_navigation_dropdown.append($("<li>").append($("<a>").attr("href",e).text(t)))}),$(".regular-user-svg").addClass("d-none"),$(".authenticated-user-svg").removeClass("d-none"),$.each(t.menu.user,function(t,e){var n=t.includes("spacer");t.includes("header")?$auth_menu_items.append($("<li>").attr("class","dropdown-menu-header").text(e)):n?$auth_menu_items.append($("<li>").attr("class","dropdown-spacer")):$auth_menu_items.append($("<li>").append($("<a>").attr("href",e).text(t)))}),$notifications_list_item.length&&$notifications_list_item.css("display",""),$auth_list_item.length&&($auth_menu_items.addClass("dropdown-menu-items"),$auth_menu_items.css("display",""))):$auth_list_item.find("a").attr("href","https://restarters.dev"),$.each(t.menu.general,function(t,e){$main_navigation_dropdown.append($("<li>").append($("<a>").attr("href",e).text(t)))})}})}});