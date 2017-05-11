<?php
//if session not started -> start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
////////////////////////////////////////////////////////////////////////////////
$_SESSION['sma'] = false;
$_SESSION['wma'] = false;
$_SESSION['esm'] = true;
$_SESSION['tpm'] = false;
echo "<script>setTimeout(\"location.href = 'index.php';\",0);</script>";