<?php $default_filled_by = $_COOKIE["filled_by"]; ?>
<?php include 'header.php' ?>
<div class="content">
  <form action="/log-entry.php" method="post">
    <label for="stove_temp">Stove Temperature</label>
    <input type="stove_temp" name="stove_temp" id="stove_temp">
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