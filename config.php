<?php

if ( file_exists("config.local.php") ) {
  include "config.local.php";
}
elseif (getenv("CLEARDB_DATABASE_URL")) {
  $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
  $db_name = trim($url["path"], "/");
  $db_user = trim($url["user"]);
  $db_pass = trim($url["pass"]);
  $db_host = trim($url["host"]);
}
else {
  echo "Please create a local configuration file. There is a template file named 'config.local.sample.php' that you can reference.";
  die;
}

date_default_timezone_set('America/Detroit');