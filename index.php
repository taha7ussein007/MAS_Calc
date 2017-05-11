<?php
require_once 'dbConnect.php';
require_once 'mas_calc.php';
//if session not started -> start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
////////////////////////////////////////////////////////////////////////////////
if(@isset($_POST['add']))
{
    if(@$_POST['quantity'] <> NULL)
    {
        (double)@$_POST['quantity'];
        if(@$_POST['quantity'] >= 0)
        {
            $quantity = @$_POST['quantity'];
            $year = @$_POST['year'];
            $month = @$_POST['month'];  
            if(mas_calc::count("swe","quantity") < mas_calc::count("swe"))
            {
                if($year == "" || $month == ""){echo "<script>alert('Please Enter a Valid Date!');</script>";}
                else{ $lastID = mas_calc::count("swe");
                mysql_query("UPDATE swe SET quantity = $quantity WHERE period = $lastID");
                mysql_query("UPDATE swe SET year = $year WHERE period = $lastID");
                mysql_query("UPDATE swe SET month = '$month' WHERE period = $lastID");}
            }
            else
            {
                if($year == "" || $month == ""){echo "<script>alert('Please Enter a Valid Date!');</script>";}
                else{mysql_query("INSERT INTO swe (quantity,year,month) VALUES ('$quantity','$year','$month')");}
            }
        }
        else
        {
            echo "<script>alert('Quantity Must Be a Positive Value!');</script>";
        }
    }
    // && mas_calc::count("swe", "quantity") > 0 ==> means don't accept any values before entering a quantity  
    if(@$_POST['periods_no'] <> NULL && mas_calc::count("swe", "quantity") > 0)
    {
        if(@isset($_POST['periods_no']))
        {
            (double)@$_POST['periods_no'];
            if(@$_POST['periods_no'] > 1)
            {
                $_SESSION['n'] = @$_POST['periods_no'];
            }
            else 
            {
                echo "<script>alert('The Number Of Periods Must Be Greater Than One!');</script>";
            }
            unset($_POST['periods_no']);        
        }
    }
    if(@$_POST['alpha'] <> NULL && mas_calc::count("swe", "quantity") > 0)
    {
        if(@isset($_POST['alpha']))
        {
            (double)@$_POST['alpha'];
            if(@$_POST['alpha'] <= 1 && @$_POST['alpha'] >= 0)
            {
                $_SESSION['a'] = @$_POST['alpha'];
            }
            else
            {
                echo "<script>alert('Smoothing Constant Must Be a Value Between <0> and <1> !');</script>";
            }
            unset($_POST['alpha']);
        }
    }
    if(@$_POST['weight'] <> NULL && mas_calc::count("swe", "quantity") > 0)
    {
        if(@isset($_POST['weight']))
        {
            $wgt = (double)@$_POST['weight'];
            if($wgt >= 0)
            {
                mysql_query("INSERT INTO weights (weight) VALUES ('$wgt')");
            }
            else
            {
                echo "<script>alert('Weight Value Must Be Positive!');</script>";
            }
            unset($_POST['weight']);
        }
    }
    if(@$_POST['first_forecast'] <> NULL && mas_calc::count("swe", "quantity") > 0)
    {
        if(@isset($_POST['first_forecast']))
        {
            (double)@$_POST['first_forecast'];
            if(@$_POST['first_forecast'] >= 0)
            {
                $_SESSION['ff'] = @$_POST['first_forecast'];
            }
            else 
            {
                echo "<script>alert('The First Forecast Value Must Be Positive!');</script>";
            }
            unset($_POST['first_forecast']);        
        }
    }
}
?>

<html>
    <head>
        
    <meta charset="UTF-8">
    <title>Modeling & Simulation Calculator</title>
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/ie-emulation-modes-warning.js"></script>
    <!-- MY Custom Styles -->
    <link href="dist/css/carousel.css" rel="stylesheet">
    <link href="dist/css/custom.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- Icon -->
    <link rel="icon" href="myicon.png">
    
    <script type="text/javascript">
    function SMA()
    {
        window.location = "SMA.php";
    }
    function WMA()
    {
        window.location = "WMA.php"; 
    } 
    function ESM()
    {
        window.location = "ESM.php";
    }
    function TPM()
    {
        window.location = "TPM.php";
    }
    function unset_n()
    {
        window.location = "unset_n.php";
    }
    function unset_a()
    {
        window.location = "unset_a.php";
    }
    function truncate_weights()
    {
        window.location = "truncate_weights.php";
    }
    function truncate_all()
    {
        window.location = "truncate_all.php";
    }
    </script>
    
    </head>
    
    <body>
    <!-- NAVBAR ================================================== -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><img src="myicon.png" id="logo" align="left">&nbsp; MAS Calculator</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                
              <ul class="nav navbar-nav">
                  
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Choose Method <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#" onclick="SMA()">Simple Moving Average</a></li>
                    <li><a href="#" onclick="WMA()">Weighted Moving Average</a></li>
                    <li><a href="#" onclick="ESM()">Exponential Smoothing</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Another Method (Working On...)</li>
                    <li><a href="#" onclick="TPM()">Trend Projection</a></li>
		    <li class="divider"></li>
                    <li><a href="#" data-toggle="modal" data-target="#help">How To Use It?</a></li>
                  </ul>
                </li>
                
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">New Calculations <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <?php
                    if(mas_calc::case_what() == SMA)
                    {echo'<li><a href="#" title="Remove (Number Of Periods) if exits" onclick="unset_n()">New (n) Value</a></li>';}
                    elseif(mas_calc::case_what() == ESM)
                    {echo'<li><a href="#" title="Remove (Alpha) if exits" onclick="unset_a()">New (α) Value</a></li>';}
                    elseif(mas_calc::case_what() == WMA)
                    {echo'<li><a href="#" title="Remove (Weights) if exits" onclick="truncate_weights()">New Weights</a></li>';} 
                    ?>
                    <li class="divider"></li>
                    <li><a href="#" title='Remove any old entries if exits' onclick="truncate_all()">Truncate All</a></li>
                  </ul>
                </li>
                
              </ul>

	      <ul class="nav navbar-nav navbar-right">
                <li><a href="#twitter" title="Follow US ☺" class="fa fa-twitter"></a></li>
                <li><a href="#facebook" title="Like Our Channel ☺" class="fa fa-facebook"></a></li>
                <li><a href="#gplus" title="+1 ☺" class="fa fa-google-plus"></a></li>
		<li><a href="#youtube" title="Subscribe Now ☺" class="fa fa-youtube"></a></li>
	      </ul>
			  
            </div>
           </div>
        </nav>
    <br><br><br><br>
       
    <div class="container marketing">     
        <div class="container">    
            <!-- Form ================================================== -->
            <div id="calcbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                <div class="panel panel-info" >
                    <div class="panel-heading">
                        <?php
                        $form_name= "";
                        switch(mas_calc::case_what())
                        {  
                        case SMA:
                            $form_name="Simple Moving Average Calc.";
                            break;
                        case WMA:
                            $form_name="Weighted Moving Average Calc.";
                            break;
                        case ESM:
                            $form_name="Exponential Smoothing Calc.";
                            break;
                        case TPM:
                            $form_name="Trend Projection (Linear Regression) Calc.";
                            break;
                        default: //failed -->SMA
                            echo "<script>setTimeout(\"location.href = 'SMA.php';\",0);</script>";
                            break;
                        }
                        //<!-- Form Name -->
                        echo"<div class='panel-title'>$form_name</div>";
                        ?>
                    </div>     
                    <div style="padding-top:30px" class="panel-body">
                        <form class="form-horizontal" name="add" method="post" action="">
                            <fieldset> 
                                <!-- Select Basic -->
                                <div class="control-group">
                                  <div class="controls">
                                    <div style="margin-bottom: 25px" class="input-group">
                                      <span class="input-group-addon"><i>Select Year:</i></span>
                                      <select id="setyear" name="year" class="form-control">
                                            <option value="">--Select Year--</option>
                                            <?php
                                            $cur_year = date("Y");
                                            $year = $cur_year-120;
                                            while (++$year <= $cur_year){
                                            echo"<option value='$year'>$year</option>"; }
                                            ?>
                                      </select>
                                    </div>  
                                  </div>
                                </div> 
                                <!-- Select Basic -->
                                <div class="control-group">
                                  <div class="controls">
                                    <div id="select-month" style="margin-bottom: 25px" class="input-group">
                                      <span class="input-group-addon"><i>Select Month:</i></span>
                                      <select id="setmonth" name="month" class="form-control">
                                          <option value="">--Select Month--</option>
                                          <?php $cur_month = date("m"); ?>
                                          <!-- JS WILL DO THIS SECTION ACCORDING TO THE YEAR SELECTED :D -->
                                      </select>
                                    </div>  
                                  </div>
                                </div>
                                <!-- Text input-->
                                <div class="control-group">
                                <div style="margin-bottom: 25px" class="input-group">
                                    <span class="input-group-addon"><i>Quantity:</i></span>
                                    <?php
                                    if( ((mas_calc::case_what() == SMA || mas_calc::case_what() == WMA) && mas_calc::count("swe","quantity") < 2) 
                                        || (mas_calc::case_what() == ESM && mas_calc::count("swe","quantity") < 1) )
                                    {
                                        REQUIRED:
                                        echo'<input id="quantity" name="quantity" type="text" placeholder="Type a quantity here" class="form-control" required="">';
                                    }
                                    else if(isset($_SESSION['n']))
                                    {
                                        if(mas_calc::count("swe","quantity") >= $_SESSION['n'])
                                        {
                                            echo'<input id="quantity" name="quantity" type="text" placeholder="Type a quantity here" class="form-control">';
                                        }
                                        else
                                        {
                                            goto REQUIRED;
                                        }
                                    }
                                    else if(mas_calc::count("swe","quantity") >= mas_calc::count("weights"))
                                    {
                                        echo'<input id="quantity" name="quantity" type="text" placeholder="Type a quantity here" class="form-control">';
                                    }
                                    else if(mas_calc::case_what() == ESM && mas_calc::count("swe","quantity") >= 1)
                                    {
                                        echo'<input id="quantity" name="quantity" type="text" placeholder="Type a quantity here" class="form-control">';
                                    }
                                    else
                                    {
                                        goto REQUIRED;
                                    }                        
                                    ?>
                                </div>
                                </div>
                                
                                <!-- Text input-->
                                <?php
                                switch (mas_calc::case_what())
                                {
                                //case Simple Moving Average
                                case SMA:
                                if(!isset($_SESSION['n'])) //should printed only one time
                                {
                                    echo '
                                    <div class="control-group">
                                    <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i><font size=\'4\'>n :</font></i></span>
                                        <input id="periods_no" name="periods_no" type="text" placeholder="Enter the number of periods in the moving average" class="form-control" required="">                                      
                                    </div>
                                    </div> ';
                                }
                                break;
                                //case Weighted Moving Average
                                case WMA:
                                if($_SESSION['wma'] == true) //required at least two times
                                {
                                    //count weights
                                    $n = mas_calc::count("weights")+1;
                                    $str = (string)$n; //
                                    echo'
                                    <div class="control-group">
                                    <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i>Weight:</i></span>';
                                    if($n < 3) //required
                                    { 
                                        echo"<input id='weight' name='weight' type='text' placeholder='Last $str period weight' class='form-control' required>";
                                    }
                                    else //not required
                                    {                                           
                                        echo"<input id='weight' name='weight' type='text' placeholder='Last $str periods weight' class='form-control'>";
                                    }
                                    echo'            
                                    </div>
                                    </div> ';
                                }
                                break;
                                //case Exponential Smoothing Method
                                case ESM:
                                    if(!isset($_SESSION['ff'])) //should printed only one time
                                    {
                                        echo '
                                        <div class="control-group">
                                        <div style="margin-bottom: 25px" class="input-group">
                                            <span class="input-group-addon"><i><font size=\'4\'>First Forecast :</font></i></span>
                                            <input id="first_forecast" name="first_forecast" type="text" placeholder="Enter The First Forecast Value" class="form-control" required="">                                      
                                        </div>
                                        </div> ';
                                    }
                                    if(!isset($_SESSION['a'])) //should printed only one time
                                    {
                                        echo '
                                        <div class="control-group">
                                        <div style="margin-bottom: 25px" class="input-group">
                                            <span class="input-group-addon"><i><font size=\'4\'>α :</font></i></span>
                                            <input id="alpha" name="alpha" type="text" placeholder="Smoothing Constant: (0 ≤ α ≤ 1)" class="form-control" required="">                                      
                                        </div>
                                        </div> ';
                                    }
                                break;
                                //case Trend Projection Method
                                case TPM:
                                    //Working on...
                                    echo "<script>alert('Still Working On ☺...')</script>";
                                    echo "<script>setTimeout(\"location.href = 'SMA.php';\",0);</script>";
                                break;
                                //case Failure! -->SMA
                                default:
                                    echo "<script>setTimeout(\"location.href = 'SMA.php';\",0);</script>";
                                break;
                                }//endswitch
                                ?>
                                                                                                                               
                               <!-- Button (Double) -->
                                <hr class="colorgraph">
                                <div class="control-group">
                                  <span class="input-group-addon"><i>Select Operation:</i></span>
                                  <div class="controls">
                                    <div class="row">    
                                    <div class="col-xs-12 col-md-12"><button id="add" name="add" class="btn btn-primary btn-block btn-lg">Add Entry</button></div>
                                    </div>
                                  </div>
                                </div>

                            </fieldset>
                        </form>
                        <div class="col-xs-14 col-md-14">
                            <?php            
                            switch (mas_calc::case_what())
                            {
                            //case Simple Moving Average
                            case SMA:
                                if(isset($_SESSION['n']))
                                {
                                    if(mas_calc::count("swe","quantity") >= $_SESSION['n'] && mas_calc::count("swe","quantity") >= 2)
                                    {
                                        $onclick = 'window.location.href="calcnow.php"';
                                    }
                                    else
                                    {
                                        $onclick = 'alert("Insufficient Entries!")';
                                    }
                                }
                                else
                                {
                                    $onclick = 'alert("Insufficient Entries!")';
                                }
                            break;
                            //case Weighted Moving Average
                            case WMA:
                                if(mas_calc::count("swe","quantity") >= mas_calc::count("weights") && mas_calc::count("swe","quantity") >= 2)
                                {
                                    $onclick = 'window.location.href="calcnow.php"';
                                }
                                else
                                {
                                    $onclick = 'alert("Insufficient Entries!")';
                                }
                            break;
                            //case Exponential Smoothing Method
                            case ESM:
                                if(mas_calc::count("swe","quantity") >= 1)
                                {
                                    $onclick = 'window.location.href="calcnow.php"';
                                }
                                else
                                {
                                    $onclick = 'alert("Insufficient Entries!")';
                                }
                            break;
                            //case Trend Projection Method
                            case TPM:
                            break;
                            //case Failure! -->SMA
                            default:
                                $onclick = 'window.location.href="calcnow.php"';
                            break;
                            }//endswitch
                            echo"<button id='calc' name='calc' onclick='$onclick' class='btn btn-success btn-block btn-lg'>Calculate Now!</button>";
                            ?>
                        </div>                    
                    </div>                     
                 </div>  
            </div>
        </div>
        <br><br>
        <!-- Table Of Contents from database ================================================== -->      
        <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading"><center><font size='4'>▼&nbsp;&nbsp;&nbsp; Your   Entries &nbsp;&nbsp;&nbsp;▼</font></center></div>
        <!-- Table -->
        <table class="table" border='2' border-color='blue'>
            <?php
            echo "<th bgcolor=yellow># </th>";
            echo "<th bgcolor=yellow>Year ▼</th>";
            echo "<th bgcolor=yellow>Month ▼</th>";
            echo "<th bgcolor=yellow>Quantity ▼</th>";
            echo "<th bgcolor=yellow>SMA Forecast ▼</th>";
            echo "<th bgcolor=yellow>WMA Forecast ▼</th>";
            echo "<th bgcolor=yellow>ESM Forecast ▼</th>";
            echo "<th bgcolor=yellow>SMA Error ▼</th>";
            echo "<th bgcolor=yellow>WMA Error ▼</th>";
            echo "<th bgcolor=yellow>ESM Error ▼</th>";
            //Do the query
            $query = "SELECT * FROM swe";
            $result = mysql_query($query);
            //iterate over all the rows
            while($row = @ mysql_fetch_row($result))
            {
                echo "
                    <tr>
                       <td>$row[0]</td>
                       <td>$row[8]</td>
                       <td>$row[9]</td>
                       <td>$row[1]</td>
                       <td>$row[2]</td>
                       <td>$row[3]</td>
                       <td>$row[4]</td>
                       <td>$row[5]</td>
                       <td>$row[6]</td>
                       <td>$row[7]</td>
                    </tr>
                    ";
            }
            ?>
        </table>
      </div>
        
    <br><br>   
    <!-- Footer ================================================== -->
    <footer>
        <p class="pull-right"><a href="#top">Back to top</a></p>
        <p>&copy; 2015-<?php echo date("Y")?> All Rights Reserved. &middot; <a href="#privacy">Privacy</a> &middot; <a href="#contact">Contact Us</a></p>
    </footer>            
    </div><!--end of marketing container-->
    <!-- Modals ================================================== -->
    <!-- Modal -->
    <div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                    <div class="modal-content">
                            <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">How To Use It?</h4>
                            </div>
                            <div class="modal-body">
                                <p>Simple Moving Average :  Enter the n (number of wanted forecast months )  just once then you can edit it later new calculation button then select year , month and enter  the Demand or supply Quantity  then add this entry after all press Calculate Now  .</p>
                                    <p>Weighted Moving Average :  Enter the weight ( weight of forecast )  just once then select year , month and enter  the Demand or supply Quantity  then add this entry after all press Calculate Now  .</p>
                                    <p>Exponential Smoothing :  Enter the constant  just once and later you can change it from new calculation button then you must enter the first forecast for this method then select year , month and enter  the Demand or supply Quantity  then add this entry after all press Calculate Now  .</p>
                                    <p>Trend Projection : Oops  Still Working On !!</p>
                                    <p>New Calculation : To Empty all entries ( Truncate all )  OR  to - Enter new Forecast Constant for Exponential Smoothing Method - Enter new n for Simple Moving Average method - Enter new weight for Weighted Moving Average method .</p>
                                    <p>About US : Overview for the project and A word about the Application 's  Developer .</p>
                            </div>
                            <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Ok, I got it ☺</button>
                            </div>
                    </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
       
    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
    
    <!--Year & Month Drop Down List-->
    <script>
    $('#setyear').change(function(){
        var selectedyear = $(this).val();
        //Remove All First
        document.getElementById('setmonth').options.length = 1;
        if(selectedyear === "<?php Print($cur_year); ?>"){
            var cur_month = <?php Print($cur_month); ?>;
            //Set The List Options
            if(cur_month >= 1){$("select#setmonth").append($("<option>").val("January").html("1 : January"));}
            if(cur_month >= 2){$("select#setmonth").append($("<option>").val("February").html("2 : February"));}
            if(cur_month >= 3){$("select#setmonth").append($("<option>").val("March").html("3 : March"));}
            if(cur_month >= 4){$("select#setmonth").append($("<option>").val("April").html("4 : April"));}
            if(cur_month >= 5){$("select#setmonth").append($("<option>").val("May").html("5 : May"));}
            if(cur_month >= 6){$("select#setmonth").append($("<option>").val("June").html("6 : June"));}
            if(cur_month >= 7){$("select#setmonth").append($("<option>").val("July").html("7 : July"));}
            if(cur_month >= 8){$("select#setmonth").append($("<option>").val("August").html("8 : August"));}
            if(cur_month >= 9){$("select#setmonth").append($("<option>").val("September").html("9 : September"));}
            if(cur_month >= 10){$("select#setmonth").append($("<option>").val("October").html("10 : October"));}
            if(cur_month >= 11){$("select#setmonth").append($("<option>").val("November").html("11 : November"));}
            if(cur_month === 12){$("select#setmonth").append($("<option>").val("December").html("12 : December"));}
        }
        else{
            //Set The List Options
            if(selectedyear !== ""){
                $("select#setmonth").append($("<option>").val("January").html("1 : January"));
                $("select#setmonth").append($("<option>").val("February").html("2 : February"));
                $("select#setmonth").append($("<option>").val("March").html("3 : March"));
                $("select#setmonth").append($("<option>").val("April").html("4 : April"));
                $("select#setmonth").append($("<option>").val("May").html("5 : May"));
                $("select#setmonth").append($("<option>").val("June").html("6 : June"));
                $("select#setmonth").append($("<option>").val("July").html("7 : July"));
                $("select#setmonth").append($("<option>").val("August").html("8 : August"));
                $("select#setmonth").append($("<option>").val("September").html("9 : September"));
                $("select#setmonth").append($("<option>").val("October").html("10 : October"));
                $("select#setmonth").append($("<option>").val("November").html("11 : November"));
                $("select#setmonth").append($("<option>").val("December").html("12 : December"));
            }
        }
    });
    </script>
    
    </body>
</html>