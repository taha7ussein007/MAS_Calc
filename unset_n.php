<?php
//if session not started -> start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
////////////////////////////////////////////////////////////////////////////////
require_once 'dbConnect.php';
if(isset($_SESSION['n']))
{
    unset($_SESSION['n']);
}
if(isset($_SESSION['s_mad']))
{
    unset($_SESSION['s_mad']);
}
@mysql_query("UPDATE swe SET sma_forecast=NULL");
@mysql_query("UPDATE swe SET sma_abserr=NULL");
echo "<script>setTimeout(\"location.href = 'index.php';\",0);</script>";
