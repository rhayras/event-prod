<?php
if(!isset($_SESSION)) { session_start(); }

date_default_timezone_set('Asia/Manila');

if (!defined('BASEURL')) define("BASEURL", "/event-production/");

$db = new mysqli('localhost','root','','eventprod');


