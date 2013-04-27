<?php
    // display errors and warnings but not notices
    ini_set("display_errors", TRUE);
    error_reporting(E_ALL ^ E_NOTICE);

    // enable sessions, restricting cookie to /clef/
    if (preg_match("{^(/clef/)}", $_SERVER["REQUEST_URI"], $matches))
        session_set_cookie_params(0, $matches[1]);
    session_start();

    // requirements
    require_once("constants.php");
    require_once("mysql.php");
?>