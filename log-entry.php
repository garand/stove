<?php

include 'functions.php';

if ( $_POST ) {
  extract( $_POST );

  $outside_temp = file_get_contents( 'http://api.openweathermap.org/data/2.5/weather?lat=43.037254&lon=-82.503141' );
  $outside_temp = json_decode($outside_temp, true);
  $outside_temp = round((( $outside_temp["main"]["temp"] - 273.15 ) * 1.8) + 32);
  $stove_temp = mysql_real_escape_string( $stove_temp );
  $percent_full = mysql_real_escape_string( $percent_full );
  $percent_filled_to = mysql_real_escape_string( $percent_filled_to );
  $filled_by = mysql_real_escape_string( $filled_by );

  $sql = "INSERT INTO log (outside_temp,stove_temp,percent_full,percent_filled_to,filled_by,datetime) VALUES ('$outside_temp','$stove_temp','$percent_full','$percent_filled_to','$filled_by', NOW())";
  $data = mysql_query($sql,$link);

  setcookie( "filled_by" , $filled_by, time() + (10 * 365 * 24 * 60 * 60) );
  $default_filled_by = $filled_by;
}

header('Location: /log-success.php');