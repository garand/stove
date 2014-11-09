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

  $success_message = '
  <script type="text/javascript">
    alert("Thank you for serving!");
  </script>
  ';
}
else {
  $default_filled_by = $_COOKIE["filled_by"];
}

?>
<?php include 'header.php' ?>
<div class="content">
  <?php echo $success_message; ?>
  <form action="/" method="post">
    <label for="stove_temp">Stove Temperature</label>
    <input type="tel" name="stove_temp" id="stove_temp">
    <label for="percent_full">Percentage Full</label>
    <input type="tel" name="percent_full" id="percent_full">
    <label for="percent_filled_to">Percentage Filled</label>
    <input type="tel" name="percent_filled_to" id="percent_filled_to">
    <label for="filled_by">Filled By</label>
    <input type="text" name="filled_by" id="filled_by" value="<?php echo $default_filled_by ?>">
    <input type="submit" value="Submit Log">
  </form>
</div>
<?php include 'footer.php' ?>