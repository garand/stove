<?php

include 'functions.php';

if ( $_POST ) {
  extract( $_POST );

  $outside_temp = mysql_real_escape_string( $outside_temp );
  $stove_temp = mysql_real_escape_string( $stove_temp );
  $pre_fill_level = mysql_real_escape_string( $pre_fill_level );
  $post_fill_level = mysql_real_escape_string( $post_fill_level );
  $filled_by = mysql_real_escape_string( $filled_by );

  $sql = "INSERT INTO log (outside_temp,stove_temp,pre_fill_level,post_fill_level,filled_by,datetime) VALUES ('$outside_temp','$stove_temp','$pre_fill_level','$post_fill_level','$filled_by', NOW())";
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

$default_outside_temp = file_get_contents( 'http://api.openweathermap.org/data/2.5/weather?lat=43.037254&lon=-82.503141' );
$default_outside_temp = json_decode($default_outside_temp, true);
$default_outside_temp = round((( $default_outside_temp["main"]["temp"] - 273.15 ) * 1.8) + 32);

?>
<?php include 'header.php' ?>
<div class="content">
  <?php echo $success_message; ?>
  <form action="/" method="post">
    <input type="hidden" name="outside_temp" id="outside_temp" value="<?php echo $default_outside_temp ?>">
    <label for="stove_temp">Stove Temperature</label>
    <input type="tel" name="stove_temp" id="stove_temp">

    <label for="pre_fill_level">Pre-Fill Wood Level</label>
    <input type="radio" name="pre_fill_level" id="pre_fill_level_0" value="0">
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
    <input type="radio" name="post_fill_level" id="post_fill_level_0" value="0">
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
    <input type="text" name="filled_by" id="filled_by" value="<?php echo $default_filled_by ?>">
    <input type="submit" value="Submit Log">
  </form>
</div>
<?php include 'footer.php' ?>