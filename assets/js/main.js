$(function(){
  FastClick.attach(document.body);
  $("form").validate({errorPlacement: function(error, element) { }});

  $(".last-fill").click(function() {
    setTimeout(function() {
      alert( last_fill_alert );
    }, 0);
  });
});

function alert(content){
  var iframe = document.createElement("IFRAME");
  iframe.setAttribute("src", 'data:text/plain,');
  document.documentElement.appendChild(iframe);
  window.frames[0].window.alert(content);
  iframe.parentNode.removeChild(iframe);
}