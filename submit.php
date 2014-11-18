<?php

include 'functions.php';

if ( $_POST ) {
  extract( $_POST );

  $outside_temp = mysql_real_escape_string( $outside_temp );
  $stove_temp = mysql_real_escape_string( $stove_temp );
  $pre_fill_level = mysql_real_escape_string( $pre_fill_level );
  $post_fill_level = mysql_real_escape_string( $post_fill_level );
  $filled_by = mysql_real_escape_string( $filled_by );
  $comments = mysql_real_escape_string( $comments );
  $datetime = date( 'Y-m-d H:i:s', time());

  $sql = "INSERT INTO log (outside_temp,stove_temp,pre_fill_level,post_fill_level,filled_by,comments,datetime) VALUES ('$outside_temp','$stove_temp','$pre_fill_level','$post_fill_level','$filled_by','$comments','$datetime')";
  $data = mysql_query($sql,$link);

  if ( $comments != '' )
    $comments_sms = "\nComments: " . $comments;
  else
    $comments_sms = '';

  send_sms( "Stove Temp: " . $stove_temp . "\nOutside Temp: " . $outside_temp . "\nPre-Fill Level: " . $pre_fill_level . "%\nPost-Fill Level: " . $post_fill_level . "%\nFilled By: " . $filled_by . $comments_sms);

  setcookie( "filled_by" , $filled_by, time() + (10 * 365 * 24 * 60 * 60) );
  $default_filled_by = $filled_by;

  $success_message = "Thank you for serving!";

  $success_message = 'setTimeout(function() {
                        alert("' . $success_message . '");
                      }, 0);';
}

?>

<script type="text/javascript">
  <?php echo $success_message; ?>
</script>

<meta http-equiv="refresh" content="0;URL=/">