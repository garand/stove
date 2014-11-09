<?php

require ("config.php");

$link = mysql_connect($db_host,$db_user,$db_pass);

if (!$link) {
  die("Not connected: " . mysql_error());
}

$db_selected = mysql_select_db($db_name, $link);

if (!$db_selected) {
  die ("Error: " . mysql_error());
}