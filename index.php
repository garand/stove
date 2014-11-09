<?php

$default_filled_by = $_COOKIE["filled_by"];

?>
<?php include 'header.php' ?>
<div class="content">
  <form action="/log-entry.php" method="post">
    <label for="fill_date">Date</label>
    <input type="fill_date" name="fill_date" id="fill_date">
    <label for="fill_time">Time</label>
    <input type="fill_time" name="fill_time" id="fill_time">
    <label for="temp">Temperature</label>
    <input type="temp" name="temp" id="temp">
    <label for="percent_full">% Full (when you arrived)</label>
    <input type="text" name="percent_full" id="percent_full">
    <label for="percent_filled_to">% Filled To</label>
    <input type="text" name="percent_filled_to" id="percent_filled_to">
    <label for="filled_by">Filled By</label>
    <input type="text" name="filled_by" id="filled_by" value="<?php echo $default_filled_by ?>">

    <input type="submit" value="Submit">
  </form>
</div>
<?php include 'footer.php' ?>