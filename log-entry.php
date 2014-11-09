<?php

include 'functions.php';

if ( $_POST ) {
  extract( $_POST );

  $fill_date = mysql_real_escape_string( $fill_date );
  $fill_time = mysql_real_escape_string( $fill_time );
  $temp = mysql_real_escape_string( $temp );
  $percent_full = mysql_real_escape_string( $percent_full );
  $percent_filled_to = mysql_real_escape_string( $percent_filled_to );
  $filled_by = mysql_real_escape_string( $filled_by );

  $sql = "INSERT INTO log (fill_date,fill_time,temp,percent_full,percent_filled_to,filled_by) VALUES ('$fill_date','$fill_time','$temp','$percent_full','$percent_filled_to','$filled_by')";
  $data = mysql_query($sql,$link);

  setcookie( "filled_by" , $filled_by, time() + (10 * 365 * 24 * 60 * 60) );
  $default_filled_by = $filled_by;
}

header('Location: /log-success.php');