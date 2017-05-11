<?php
require_once 'dbConnect.php';
require_once 'mas_calc.php';
//if session not started -> start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
////////////////////////////////////////////////////////////////////////////////
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
    
    <script type="text/javascript">
    window.addEvent('domready', function(){
        $$('#container div').each(function(drag){
        new Drag.Move(drag);}); 
    }); 
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
    <br><br><br><br><br><br> 
   
    <div class="container marketing">     
        <div class="container"> 
            <!-- Notes ==> MADs Results ================================================== --> 
            <?php 
            if(isset($_SESSION['s_mad']) || isset($_SESSION['w_mad']) || isset($_SESSION['e_mad']))
            {
                mas_calc::colorMAD($s_color, $w_color, $e_color);
            }
            ?>
            <div class="row">   
                <div class="col-xs-6 col-md-4">
                <div class="stickyNote">
                    <center>
                    <font color=#003366><h1>SMA_MAD</h1></font>
                    <?php
                    if(isset($_SESSION['s_mad']))
                    {
                        $value = $_SESSION['s_mad'];
                        echo"<font color='$s_color'><h1>$value</h1></font>";
                    }
                    else
                    {
                        echo"<h1><a href='#' onclick='SMA()'>Calc. Now!</a></h1>";
                    }
                    ?>
                    </center>
                </div>
                </div>

                <div class="col-xs-6 col-md-4">
                 <div class="stickyNote">
                    <center>
                    <font color=#003366><h1>WMA_MAD</h1></font>
                    <?php
                    if(isset($_SESSION['w_mad']))
                    {
                        $value = $_SESSION['w_mad'];
                        echo"<font color='$w_color'><h1>$value</h1></font>";
                    }
                    else
                    {
                        echo"<h1><a href='#' onclick='WMA()'>Calc. Now!</a></h1>";
                    }
                    ?>
                    </center>
                 </div>
                </div>

                <div class="col-xs-6 col-md-4">
                 <div class="stickyNote">
                    <center>
                    <font color=#003366><h1>ESM_MAD</h1></font>
                    <?php
                    if(isset($_SESSION['e_mad']))
                    {
                        $value = $_SESSION['e_mad'];
                        echo"<font color='$e_color'><h1>$value</h1></font>";
                    }
                    else
                    {
                        echo"<h1><a href='#' onclick='ESM()'>Calc. Now!</a></h1>";
                    }
                    ?>
                    </center>
                 </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="container">
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
            while($row = mysql_fetch_row($result))
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
       </div><!--end of container -->
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
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
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
    </body>
</html>



