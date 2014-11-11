<?php

include 'functions.php';

if ( $_POST ) {
  extract( $_POST );

  $outside_temp = mysql_real_escape_string( $outside_temp );
  $stove_temp = mysql_real_escape_string( $stove_temp );
  $pre_fill_level = mysql_real_escape_string( $pre_fill_level );
  $post_fill_level = mysql_real_escape_string( $post_fill_level );
  $filled_by = mysql_real_escape_string( $filled_by );
  $datetime = date( 'Y-m-d H:i:s', time());

  $sql = "INSERT INTO log (outside_temp,stove_temp,pre_fill_level,post_fill_level,filled_by,datetime) VALUES ('$outside_temp','$stove_temp','$pre_fill_level','$post_fill_level','$filled_by','$datetime')";
  $data = mysql_query($sql,$link);

  send_sms( "Stove Temp: " . $stove_temp . "\nOutside Temp: " . $outside_temp . "\nPre-Fill Level: " . $pre_fill_level . "%\nPost-Fill Level: " . $post_fill_level . "%\nFilled By: " . $filled_by );

  setcookie( "filled_by" , $filled_by, time() + (10 * 365 * 24 * 60 * 60) );
  $default_filled_by = $filled_by;

  $success_message = "Thank you for serving!";

  $success_message = 'setTimeout(function() {
                        alert("' . $success_message . '");
                      }, 0);';
}
else {
  $default_filled_by = $_COOKIE["filled_by"];
}

$sql = "SELECT * FROM log ORDER BY datetime DESC LIMIT 1";
$data = mysql_fetch_assoc( mysql_query($sql,$link) );

$last_fill = $data;

$default_outside_temp = file_get_contents( 'http://api.openweathermap.org/data/2.5/weather?lat=' . getenv("outside_temp_lat") . '&lon=' . getenv("outside_temp_long") );
$default_outside_temp = json_decode($default_outside_temp, true);
$default_outside_temp = round((( $default_outside_temp["main"]["temp"] - 273.15 ) * 1.8) + 32);

?>
<?php include 'header.php' ?>
<div class="content">
  <form action="/" method="post">
    <input type="hidden" name="outside_temp" id="outside_temp" value="<?php echo $default_outside_temp ?>">
    <label for="stove_temp">Stove Temperature</label>
    <input type="tel" name="stove_temp" id="stove_temp" required>

    <label for="pre_fill_level">Pre-Fill Wood Level</label>
    <input type="radio" name="pre_fill_level" id="pre_fill_level_0" value="0" required>
    <label for="pre_fill_level_0">Empty</label>
    <input type="radio" name="pre_fill_level" id="pre_fill_level_25" value="25">
    <label for="pre_fill_level_25">1/4</label>
    <input type="radio" name="pre_fill_level" id="pre_fill_level_50" value="50">
    <label for="pre_fill_level_50">1/2</label>
    <input type="radio" name="pre_fill_level" id="pre_fill_level_75" value="75">
    <label for="pre_fill_level_75">3/4</label>
    <input type="radio" name="pre_fill_level" id="pre_fill_level_100" value="100">
    <label for="pre_fill_level_100">Full</label>

    <label for="post_fill_level">Post-Fill Wood Level</label>
    <input type="radio" name="post_fill_level" id="post_fill_level_0" value="0" required>
    <label for="post_fill_level_0">Empty</label>
    <input type="radio" name="post_fill_level" id="post_fill_level_25" value="25">
    <label for="post_fill_level_25">1/4</label>
    <input type="radio" name="post_fill_level" id="post_fill_level_50" value="50">
    <label for="post_fill_level_50">1/2</label>
    <input type="radio" name="post_fill_level" id="post_fill_level_75" value="75">
    <label for="post_fill_level_75">3/4</label>
    <input type="radio" name="post_fill_level" id="post_fill_level_100" value="100">
    <label for="post_fill_level_100">Full</label>

    <label for="filled_by">Filled By</label>
    <input type="text" name="filled_by" id="filled_by" value="<?php echo $default_filled_by ?>" required>
    <input type="submit" value="Submit Log">
  </form>
  <script type="text/javascript">
    <?php echo $success_message; ?>
    last_fill_alert = 'The stove was last filled on <?php echo date("F jS", strtotime($last_fill["datetime"]) ); ?> at <?php echo date("g:ia", strtotime($last_fill["datetime"]) ); ?> by <?php echo $last_fill["filled_by"]; ?>.\n\nThe stove temperature was <?php echo $last_fill["stove_temp"]; ?>° and the outside temperature was <?php echo $last_fill["outside_temp"]; ?>°.\n\nIt was <?php echo $last_fill["pre_fill_level"]; ?>% full, and was filled to <?php echo $last_fill["post_fill_level"]; ?>%.';
  </script>
</div>
<?php include 'footer.php' ?>