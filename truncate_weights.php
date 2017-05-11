<?php
//if session not started -> start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
////////////////////////////////////////////////////////////////////////////////
require_once 'dbConnect.php';
if(isset($_SESSION['w_mad']))
{
    unset($_SESSION['w_mad']);
}
@mysql_query("TRUNCATE weights");
@mysql_query("UPDATE swe SET wma_forecast=NULL");
@mysql_query("UPDATE swe SET wma_abserr=NULL");
echo "<script>setTimeout(\"location.href = 'index.php';\",0);</script>";
