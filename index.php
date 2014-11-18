<?php

include 'functions.php';

$default_filled_by = $_COOKIE["filled_by"];

$sql = "SELECT * FROM log ORDER BY datetime DESC LIMIT 1";
$last_fill = mysql_fetch_assoc( mysql_query($sql,$link) );

if ( $last_fill["comments"] != '' )
  $comments = '\n\nComments:\n' . $last_fill["comments"];
else
  $comments = '';

if ( mysql_num_rows(mysql_query($sql,$link)) > 0 )
  $last_fill_message = 'The stove was last filled on ' . date("F jS", strtotime($last_fill["datetime"]) ) . ' at ' . date("g:ia", strtotime($last_fill["datetime"]) ) . ' by ' . $last_fill["filled_by"] . '.\n\nThe stove temperature was ' . $last_fill["stove_temp"] . '° and the outside temperature was ' . $last_fill["outside_temp"] . '°.\n\nIt was ' . $last_fill["pre_fill_level"] . '% full, and was filled to ' . $last_fill["post_fill_level"] . '%.' . $comments;
else
  $last_fill_message = 'No stove fillings have been logged.';

$default_outside_temp = file_get_contents( 'http://api.openweathermap.org/data/2.5/weather?lat=' . getenv("outside_temp_lat") . '&lon=' . getenv("outside_temp_long") );
$default_outside_temp = json_decode($default_outside_temp, true);
$default_outside_temp = round((( $default_outside_temp["main"]["temp"] - 273.15 ) * 1.8) + 32);

?>
<?php include 'header.php' ?>
<div class="content">
  <form action="/submit.php" method="post">
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

    <label for="comments">Comments</label>
    <input type="text" name="comments" id="comments">

    <input type="submit" value="Submit Log">
  </form>
  <script type="text/javascript">
    last_fill_alert = "<?php echo $last_fill_message; ?>"
  </script>
</div>
<?php include 'footer.php' ?>