$(function(){
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!
  var yyyy = today.getFullYear();
  var hour   = today.getHours();
  var minute = today.getMinutes();
  var second = today.getSeconds();
  if (dd<10){dd='0'+dd}
  if (mm<10){mm='0'+mm}
  date = yyyy+'-'+mm+'-'+dd;
  time = hour+':'+minute;
  am_pm = "AM"
  if (hour>=12){am_pm=" PM"}

  $( "#fill_date" ).val( date );
  $( "#fill_time" ).val( time + am_pm );
});