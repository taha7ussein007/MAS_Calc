<?php
//if session not started -> start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
////////////////////////////////////////////////////////////////////////////////
require_once 'dbConnect.php';
if(isset($_SESSION['a']))
{
    unset($_SESSION['a']);
}
if(isset($_SESSION['e_mad']))
{
    unset($_SESSION['e_mad']);
}
if(isset($_SESSION['ff']))
{
    unset($_SESSION['ff']);
}
@mysql_query("UPDATE swe SET esm_forecast=NULL");
@mysql_query("UPDATE swe SET esm_abserr=NULL");
echo "<script>setTimeout(\"location.href = 'index.php';\",0);</script>";
