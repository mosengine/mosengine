var about=function(e){function t(n){if(a[n])return a[n].exports;var o=a[n]={exports:{},id:n,loaded:!1};return e[n].call(o.exports,o,o.exports,t),o.loaded=!0,o.exports}var a={};return t.m=e,t.c=a,t.p="",t(0)}([function(e,t){"use strict";$("#feedback_contact_form").on("beforeSubmit",function(){var e=$("#feedback_contact_form"),t=e.serialize();return $.ajax({type:"POST",url:"/ajax/feedback",data:t,success:function(t){e.find("input[type=text], textarea").val("")},dataType:"json"}),!1}),$(".feedback-contact-form-submit").on("click",function(){var e=$("#feedback_contact_form");e.submit()}),$(".about-btn").click(function(){$(".about-start-btn").hide(),$(".about-feedback").fadeIn()}),$(".comment-content").readmore({collapsedHeight:75,heightMargin:50,embedCSS:!1,moreLink:'<a href="#" class="more">Еще</a>',lessLink:'<a href="#" class="less">Закрыть</a>',speed:150})}]);