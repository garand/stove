<?php

if ( file_exists("config.local.php") ) {
  include "config.local.php";
}

if ( getenv("CLEARDB_DATABASE_URL") ) {
  $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
  putenv("db_name=" . trim($url["path"], "/") ); // Database Name
  putenv("db_user=" . trim($url["user"]) ); // Database User
  putenv("db_pass=" . trim($url["pass"]) ); // Database Password
  putenv("db_host=" . trim($url["host"]) ); // Database Host
}
elseif ( !(getenv("db_name") && getenv("db_user") && getenv("db_host")) ) {
  echo "Please create a local configuration file or configure the environment variables on your server. There is a template file named 'config.local.sample.php' that you can reference.";
  die;
}

date_default_timezone_set('America/Detroit');