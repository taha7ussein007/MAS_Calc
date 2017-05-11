<?php
define("FAILURE", 0);
define("SMA", 1);
define("WMA", 2);
define("ESM", 3);
define("TPM", 4);

//if session not started -> start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbConnect.php';
////////////////////////////////////////////////////////////////////////////////
class mas_calc {
    ////////////////////////////////////////////////////////////////////////////
    static function case_what()
    {
        //case Simple Moving Average
        if(isset($_SESSION['sma']))
        {
            if($_SESSION['sma'] == true)
            {
                return SMA;
            }
        }
        //case Weighted Moving Average
        if(isset($_SESSION['wma']))
        {
            if($_SESSION['wma'] == true)
            {
                return WMA;
            }
        }
        //case Exponential Smoothing Method
        if(isset($_SESSION['esm']))
        {
            if($_SESSION['esm'] == true)
            {
                return ESM;
            }
        }
        //case TPM
        if(isset($_SESSION['tpm']))
        {
            if($_SESSION['tpm'] == true)
            {
                return TPM;
            }
        }
        //case failed!
        return FAILURE;
    }
    ////////////////////////////////////////////////////////////////////////////
    static function count($tableName, $columnName = NULL)
    {
        if($columnName == NULL)
        {
            $res = mysql_query("SELECT COUNT(*) FROM $tableName");
            $row = @mysql_fetch_row($res);
            return $row[0];
        }
        else
        {
            $res = mysql_query("SELECT COUNT($columnName) FROM $tableName");
            $row = @mysql_fetch_row($res);
            return $row[0];
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    static function mad_compare()
    {
        //case 1
        if(isset($_SESSION['s_mad']) && isset($_SESSION['w_mad']) && isset($_SESSION['e_mad']) )
        {
            //7 cases
            if($_SESSION['s_mad'] == $_SESSION['w_mad'] && $_SESSION['w_mad'] == $_SESSION['e_mad']){return "swe";}
            if($_SESSION['s_mad'] == $_SESSION['w_mad'] && $_SESSION['w_mad'] < $_SESSION['e_mad']){return "sw";}
            if($_SESSION['s_mad'] == $_SESSION['e_mad'] && $_SESSION['e_mad'] < $_SESSION['w_mad']){return "se";}
            if($_SESSION['w_mad'] == $_SESSION['e_mad'] && $_SESSION['e_mad'] < $_SESSION['s_mad']){return "we";}
            if($_SESSION['s_mad'] < $_SESSION['w_mad'] && $_SESSION['s_mad'] < $_SESSION['e_mad']){return "s";}
            if($_SESSION['w_mad'] < $_SESSION['s_mad'] && $_SESSION['w_mad'] < $_SESSION['e_mad']){return "w";}
            if($_SESSION['e_mad'] < $_SESSION['s_mad'] && $_SESSION['e_mad'] < $_SESSION['w_mad']){return "e";}
        }
        //case 2
        if(isset($_SESSION['s_mad']) && !isset($_SESSION['w_mad']) && !isset($_SESSION['e_mad']) )
        {
            return "s";
        }
        //case 3
        if(!isset($_SESSION['s_mad']) && isset($_SESSION['w_mad']) && !isset($_SESSION['e_mad']) )
        {
            return "w";
        }
        //case 4
        if(!isset($_SESSION['s_mad']) && !isset($_SESSION['w_mad']) && isset($_SESSION['e_mad']) )
        {
            return "e";
        }
        //case 5
        if(isset($_SESSION['s_mad']) && isset($_SESSION['w_mad']) && !isset($_SESSION['e_mad']) )
        {
            //3 cases
            if($_SESSION['s_mad'] < $_SESSION['w_mad']) {return "s";}
            if($_SESSION['s_mad'] > $_SESSION['w_mad']) {return "w";}
            if($_SESSION['s_mad'] == $_SESSION['w_mad']) {return "sw";}
        }
        //case 6
        if(isset($_SESSION['s_mad']) && !isset($_SESSION['w_mad']) && isset($_SESSION['e_mad']) )
        {
            //3 cases
            if($_SESSION['s_mad'] < $_SESSION['e_mad']) {return "s";}
            if($_SESSION['s_mad'] > $_SESSION['e_mad']) {return "e";}
            if($_SESSION['s_mad'] == $_SESSION['e_mad']) {return "se";}
        }
        //case 7
        if(!isset($_SESSION['s_mad']) && isset($_SESSION['w_mad']) && isset($_SESSION['e_mad']) )
        {
            //3 cases
            if($_SESSION['w_mad'] < $_SESSION['e_mad']) {return "w";}
            if($_SESSION['w_mad'] > $_SESSION['e_mad']) {return "e";}
            if($_SESSION['w_mad'] == $_SESSION['e_mad']) {return "we";}
        }
        //case 8
        if(!isset($_SESSION['s_mad']) && !isset($_SESSION['w_mad']) && !isset($_SESSION['e_mad']) )
        {
            return "";
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    static function colorMAD(&$s_mad, &$w_mad, &$e_mad)
    {
        switch (mas_calc::mad_compare())
        {
            case "": $s_mad = "black"; $w_mad = "black"; $e_mad = "black"; break;
            //
            case "s": $s_mad = "forestgreen"; $w_mad = "firebrick"; $e_mad = "firebrick"; break;
            //
            case "w": $s_mad = "firebrick"; $w_mad = "forestgreen"; $e_mad = "firebrick"; break;
            //
            case "e": $s_mad = "firebrick"; $w_mad = "firebrick"; $e_mad = "forestgreen"; break;
            //
            case "sw": $s_mad = "forestgreen"; $w_mad = "forestgreen"; $e_mad = "firebrick"; break;
            //
            case "se": $s_mad = "forestgreen"; $w_mad = "firebrick"; $e_mad = "forestgreen"; break;
            //
            case "we": $s_mad = "firebrick"; $w_mad = "forestgreen"; $e_mad = "forestgreen"; break;
            //
            case "swe": $s_mad = "forestgreen"; $w_mad = "forestgreen"; $e_mad = "forestgreen"; break;
            //
            default: $s_mad = "black"; $w_mad = "black"; $e_mad = "black"; break;            
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    static function init_row($ROW_ID, &$Quantity = NULL, &$smaForecast = NULL, &$wmaForecast = NULL, &$esmForecast = NULL)
    {
        $swe_res = mysql_query("SELECT quantity, sma_forecast, wma_forecast, esm_forecast FROM swe WHERE period = $ROW_ID");
        if(@mysql_num_rows($swe_res) == 1)
        {
            $swe_row = @mysql_fetch_row($swe_res);
            if($swe_row[0] <> NULL){$Quantity = (double)$swe_row[0]; } else {$Quantity = NULL;}
            if($swe_row[1] <> NULL){$smaForecast = (double)$swe_row[1]; } else {$smaForecast = NULL;}
            if($swe_row[2] <> NULL){$wmaForecast = (double)$swe_row[2]; } else {$wmaForecast = NULL;}
            if($swe_row[3] <> NULL){$esmForecast = (double)$swe_row[3]; } else {$esmForecast = NULL;}
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    static function init_weight($ROW_ID , &$Weight)
    {
        $weights_res = mysql_query("SELECT weight FROM weights WHERE period = $ROW_ID");
        if(@mysql_num_rows($weights_res) == 1)
        {
            $w_row = @mysql_fetch_row($weights_res);
            $Weight = (double)$w_row[0];
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    static function Abs(&$Double)
    {
        (double)$Double;
        if($Double < 0)
        {
            $Double = $Double*(-1.0);
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    static function CalcSMA_Forecast($ROW_ID)
    {
        //calc forecast value
        $forecast = 0.0; $n = $_SESSION['n']; $begin = $ROW_ID - $n; $end = $ROW_ID - 1; $prevQuantity = NULL;
        while ($begin <= $end)
        {
            mas_calc::init_row($begin, $prevQuantity);
            $forecast += (double)$prevQuantity;
            $begin++;
        }
        @$forecast /= $n;

        //case 1 //update
        if($ROW_ID > $n && $ROW_ID <= mas_calc::count("swe", "quantity"))
        {
            mysql_query("UPDATE swe SET sma_forecast = $forecast WHERE period = $ROW_ID");
            return TRUE;
        }
        //case 2
        if($ROW_ID > $n && $ROW_ID == mas_calc::count("swe", "quantity")+1)
        {
            //case 2.1 //update
            if(mas_calc::count("swe", "quantity") == mas_calc::count("swe"))
            {
                mysql_query("INSERT INTO swe (sma_forecast) VALUES ($forecast)");
                return TRUE;
            }
            //case 2.2 //insert
            else 
            {
                mysql_query("UPDATE swe SET sma_forecast = $forecast WHERE period = $ROW_ID");
                return TRUE;
            }
        }
        //case 3 //failure!
        else
        {
            return FALSE;
        } 
    }
    ////////////////////////////////////////////////////////////////////////////
    static function CalcSMA_Error()
    {
        $quantity = NULL; $forecast = NULL; $dum1=NULL; $dum2=NULL;
        for($ROW = 1 ; $ROW <= mas_calc::count("swe") ; $ROW++)
        {
            mas_calc::init_row($ROW, $quantity, $forecast, $dum1, $dum2);
            if($quantity <> NULL && $forecast <> NULL)
            {
                $err = $quantity - $forecast;
                mas_calc::Abs($err); //get abs error
                mysql_query("UPDATE swe SET sma_abserr = $err WHERE period = $ROW");
            }
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    static function GET_SMA_MAD()
    {
        $res = mysql_query("SELECT AVG(sma_abserr) FROM swe");
        $SMA_MAD = @mysql_fetch_row($res);
        return $SMA_MAD[0];
    }
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    static function CalcWMA_Forecast($ROW_ID)
    {
        //calc forecast value
        $forecast = 0.0; $n = mas_calc::count("weights"); $begin = $ROW_ID - $n;
        $end = $ROW_ID - 1; $prevQuantity = NULL; $w_id = 1; $weight = NULL;
        while ($begin <= $end)
        {
            mas_calc::init_weight($w_id, $weight);
            mas_calc::init_row($end, $prevQuantity);
            $forecast += (double)($weight*$prevQuantity);
            $w_id++; $end--;
        }
        $res = mysql_query("SELECT SUM(weight) FROM weights");
        $sumOfweights = mysql_fetch_row($res);
        $forecast /= $sumOfweights[0];
        
        //case 1 //update
        if($ROW_ID > $n && $ROW_ID <= mas_calc::count("swe", "quantity"))
        {
            mysql_query("UPDATE swe SET wma_forecast = $forecast WHERE period = $ROW_ID");
            return TRUE;
        }
        //case 2
        if($ROW_ID > $n && $ROW_ID == mas_calc::count("swe", "quantity")+1)
        {
            //case 2.1 //update
            if(mas_calc::count("swe", "quantity") == mas_calc::count("swe"))
            {
                mysql_query("INSERT INTO swe (wma_forecast) VALUES ($forecast)");
                return TRUE;
            }
            //case 2.2 //insert
            else 
            {
                mysql_query("UPDATE swe SET wma_forecast = $forecast WHERE period = $ROW_ID");
                return TRUE;
            }
        }
        //case 3 //failure!
        else
        {
            return FALSE;
        } 

    }
    ////////////////////////////////////////////////////////////////////////////
    static function CalcWMA_Error()
    {
        $quantity = NULL; $forecast = NULL; $dum1=NULL; $dum2=NULL;
        for($ROW = 1 ; $ROW <= mas_calc::count("swe") ; $ROW++)
        {
            mas_calc::init_row($ROW, $quantity, $dum1, $forecast, $dum2);
            if($quantity <> NULL && $forecast <> NULL)
            {
                $err = $quantity - $forecast;
                mas_calc::Abs($err); //get abs error
                mysql_query("UPDATE swe SET wma_abserr = $err WHERE period = $ROW");
            }
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    static function GET_WMA_MAD()
    {
        $res = mysql_query("SELECT AVG(wma_abserr) FROM swe");
        $WMA_MAD = @mysql_fetch_row($res);
        return $WMA_MAD[0];
    }
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    static function CalcESM_Forecast($ROW_ID)
    {
        $alpha = $_SESSION['a'];
        //case 1
        if($ROW_ID < 1 || $ROW_ID > mas_calc::count("swe","quantity")+1)
        {
            return FALSE;
        }
        //case 2
        if(($ROW_ID == 1) && $ROW_ID <= mas_calc::count("swe","quantity"))        
        {
            //calc forecast
            $First_Forecast = $_SESSION['ff'];
            mysql_query("UPDATE swe SET esm_forecast = $First_Forecast WHERE period = 1");
            return TRUE;
        }
        //case 3
        if($ROW_ID == mas_calc::count("swe","quantity")+1)
        {
            $prev_quantity = NULL; $prevforecast = NULL; $dum1 = NULL; $dum2 = NULL;
            mas_calc::init_row($ROW_ID-1, $prev_quantity, $dum1, $dum2, $prevforecast);
            //calc forecast            
            $forecast = $prevforecast + ( $alpha * ($prev_quantity - $prevforecast) );
            //Insert Values
            if(mas_calc::count("swe", "quantity") == mas_calc::count("swe"))
            {
                mysql_query("INSERT INTO swe (esm_forecast) VALUES ($forecast)");
                return TRUE;
            }
            else // لو فى اى فوركاست محطوط ابديت جنبه
            {
                mysql_query("UPDATE swe SET esm_forecast = $forecast WHERE period = $ROW_ID");
                return TRUE;
            }
        }
        //case 4
        else
        {
            $prev_quantity = NULL; $prevforecast = NULL; $dum1 = NULL; $dum2 = NULL;
            mas_calc::init_row($ROW_ID-1, $prev_quantity, $dum1, $dum2, $prevforecast);
            //calc forecast            
            $forecast = $prevforecast + ( $alpha * ($prev_quantity - $prevforecast) );    
            //Insert Values
            mysql_query("UPDATE swe SET esm_forecast = $forecast WHERE period = $ROW_ID");
            return TRUE;
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    static function CalcESM_Error()
    {
        $quantity = NULL; $forecast = NULL; $dum1=NULL; $dum2=NULL;
        for($ROW = 1 ; $ROW <= mas_calc::count("swe") ; $ROW++)
        {
            mas_calc::init_row($ROW, $quantity, $dum1, $dum2, $forecast);
            if($quantity <> NULL && $forecast <> NULL)
            {
                $err = $quantity - $forecast;
                mas_calc::Abs($err); //get abs error
                mysql_query("UPDATE swe SET esm_abserr = $err WHERE period = $ROW");
            }
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    static function GET_ESM_MAD()
    {
        $res = mysql_query("SELECT AVG(esm_abserr) FROM swe");
        $ESM_MAD = @mysql_fetch_row($res);
        return $ESM_MAD[0];
    }
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
}
