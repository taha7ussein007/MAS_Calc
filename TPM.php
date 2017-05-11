<?php       
//if session not started -> start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
////////////////////////////////////////////////////////////////////////////////
$_SESSION['sma'] = false;
$_SESSION['wma'] = false;
$_SESSION['esm'] = false;
$_SESSION['tpm'] = true;
echo "<script>setTimeout(\"location.href = 'index.php';\",0);</script>";