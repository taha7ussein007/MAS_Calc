<?php
//if session not started -> start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
////////////////////////////////////////////////////////////////////////////////
require_once 'dbConnect.php';

@mysql_query("TRUNCATE swe");
@mysql_query("TRUNCATE weights");
//@mysql_query("TRUNCATE trend");

if(isset($_SESSION))
{
    session_destroy();
}
echo "<script>setTimeout(\"location.href = 'index.php';\",0);</script>";
