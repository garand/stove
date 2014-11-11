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