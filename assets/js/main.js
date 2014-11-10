$(function(){
  FastClick.attach(document.body);
  $("form").validate({errorPlacement: function(error, element) { }});
});

function alert(content){
  var iframe = document.createElement("IFRAME");
  iframe.setAttribute("src", 'data:text/plain,');
  document.documentElement.appendChild(iframe);
  window.frames[0].window.alert(content);
  iframe.parentNode.removeChild(iframe);
}