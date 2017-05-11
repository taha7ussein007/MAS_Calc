<?php
require_once 'mas_calc.php';
//if session not started -> start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
////////////////////////////////////////////////////////////////////////////////
//check -> calc -> goto result OR check -> error -> goto suitable page
switch (mas_calc::case_what())
{
    case SMA:
        if(isset($_SESSION['n']))
        {
            if(mas_calc::count("swe", "quantity") >= $_SESSION['n'])
            {
                for ($i = $_SESSION['n']+1 ; $i <= mas_calc::count("swe", "quantity")+1 ; $i++)//MM
                {
                    mas_calc::CalcSMA_Forecast($i);
                }
                mas_calc::CalcSMA_Error();
                $_SESSION['s_mad'] = mas_calc::GET_SMA_MAD();
                echo "<script>setTimeout(\"location.href = 'result.php';\",0);</script>"; 
            }
            else
            {
                echo "<script>alert('Insufficient Entries!!');</script>";
                echo "<script>setTimeout(\"location.href = 'index.php';\",0);</script>";
            }
        }
        else
        {
            echo "<script>setTimeout(\"location.href = 'index.php';\",0);</script>";
        }
        break;
    case WMA:
        if(mas_calc::count("weights") >= 2 && mas_calc::count("swe", "quantity") >= mas_calc::count("weights"))
        {
            for ($i = mas_calc::count("weights")+1 ; $i <= mas_calc::count("swe", "quantity")+1 ; $i++)
            {
                mas_calc::CalcWMA_Forecast($i);
            }
            mas_calc::CalcWMA_Error();
            $_SESSION['w_mad'] = mas_calc::GET_WMA_MAD();
            echo "<script>setTimeout(\"location.href = 'result.php';\",0);</script>"; 
        }
        else
        {
            echo "<script>alert('Insufficient Entries!!');</script>";
            echo "<script>setTimeout(\"location.href = 'index.php';\",0);</script>";
        }
        break;
    case ESM:
        if(isset($_SESSION['a']))
        {
            for ($i = 2 ; $i <= mas_calc::count("swe", "quantity")+1 ; $i++)
            {
                mas_calc::CalcESM_Forecast($i);
            }
            mas_calc::CalcESM_Error();
            $_SESSION['e_mad'] = mas_calc::GET_ESM_MAD();
            echo "<script>setTimeout(\"location.href = 'result.php';\",0);</script>"; 
        }
        else
        {
            echo "<script>alert('Insufficient Entries!!');</script>";
            echo "<script>setTimeout(\"location.href = 'index.php';\",0);</script>";
        }
        break;
    case TPM:
        //Working On...
        break;
    default: //!!!
        echo "<script>setTimeout(\"location.href = 'SMA.php';\",0);</script>";
        break;
}
////////////////////////////////////////////////////////////////////////////////


