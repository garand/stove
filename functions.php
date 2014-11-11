<?php

require ('vendor/autoload.php');
require ("config.php");

$link = mysql_connect( getenv("db_host"), getenv("db_user"), getenv("db_pass") );

if (!$link) {
  die("Not connected: " . mysql_error());
}

$db_selected = mysql_select_db( getenv("db_name"), $link );

if (!$db_selected) {
  die ("Error: " . mysql_error());
}

// Check if log table exists. If not, create it.
if ( mysql_num_rows( mysql_query("SHOW TABLES LIKE 'log'") ) !== 1 ) {
  $sql = "CREATE TABLE `log` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `outside_temp` varchar(10) DEFAULT NULL,
          `stove_temp` varchar(10) DEFAULT NULL,
          `pre_fill_level` varchar(10) DEFAULT NULL,
          `post_fill_level` varchar(10) DEFAULT NULL,
          `filled_by` varchar(200) DEFAULT NULL,
          `datetime` datetime DEFAULT NULL,
          PRIMARY KEY (`id`)
          )";
  $result = mysql_query($sql, $link);
}

function send_sms( $body ) {
  $sid = getenv("twilio_sid");
  $token = getenv("twilio_token");
  $to = getenv("twilio_to");
  $from = getenv("twilio_from");

  // resource url & authentication
  $uri = 'https://api.twilio.com/2010-04-01/Accounts/' . $sid . '/SMS/Messages';
  $auth = $sid . ':' . $token;

  // post string (phone number format= +15554443333 ), case matters
  $fields =
      '&To=' .  urlencode( $to ) .
      '&From=' . urlencode( $from ) .
      '&Body=' . urlencode( $body );

  // start cURL
  $res = curl_init();

  // set cURL options
  curl_setopt( $res, CURLOPT_URL, $uri );
  curl_setopt( $res, CURLOPT_POST, 3 ); // number of fields
  curl_setopt( $res, CURLOPT_POSTFIELDS, $fields );
  curl_setopt( $res, CURLOPT_USERPWD, $auth ); // authenticate
  curl_setopt( $res, CURLOPT_RETURNTRANSFER, true ); // don't echo

  // send cURL
  $result = curl_exec( $res );
  return $result;
}