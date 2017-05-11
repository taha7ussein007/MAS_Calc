<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
	<title> About </title>
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!--fonts-->
		<link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lato:100,200,300,400,500,600,700,800,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>	
	<!--//fonts-->
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<!-- for-mobile-apps -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Click On Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
		Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- //for-mobile-apps -->
	<!-- js -->
		<script type="text/javascript" src="js/jquery.min.js"></script>
	<!-- js -->
	<!-- start-smooth-scrolling -->
		<script type="text/javascript" src="js/move-top.js"></script>
		<script type="text/javascript" src="js/easing.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
		</script>
	<!-- start-smooth-scrolling -->
        
        
    <meta charset="UTF-8">
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
    function truncate()
    {
        window.location = "truncate.php";
    }
    ////////////////////////////////////////////////////////////
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
                <li><a href="index.php">Home</a></li>
                <li class="active"><a href="about.php">About</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Choose Method <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#" onclick="SMA()">Simple Moving Average</a></li>
                    <li><a href="#" onclick="WMA()">Weighted Moving Average</a></li>
                    <li><a href="#" onclick="ESM()">Exponential Smoothing</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Another Method</li>
                    <li><a href="#" onclick="TPM()">Trend Projection</a></li>
		    <li class="divider"></li>
                    <li><a href="#" data-toggle="modal" data-target="#help">How To Use It?</a></li>
                  </ul>
                </li>
                <li><a href="#" title='Remove any old entries if exits' onclick="truncate()">New Calculations</a></li>
              </ul>

	      <ul class="nav navbar-nav navbar-right">
                <li><a href="#twitter" title="Follow US ?" class="fa fa-twitter"></a></li>
                <li><a href="#facebook" title="Like Our Channel ?" class="fa fa-facebook"></a></li>
                <li><a href="#gplus" title="+1 ?" class="fa fa-google-plus"></a></li>
		<li><a href="#youtube" title="Subscribe Now ?" class="fa fa-youtube"></a></li>
	      </ul>
			  
            </div>
           </div>
        </nav>
    <br><br><br><br>


<!-- about -->
<div class="about">
	<div class="container">
		<div class="about-info">
			<h2>ABOUT</h2>
			<p>This Application for Calculating Different Types of Forcast 
                        , Also it Calculate the Mean Absolute Deviation ((  MAD  ))
                        you can also Begin New Calculation and it will Remove all Data 
                        You Have Entered before .
                        
</p>
		</div>
		<div class="about-grids">
			<div class="about-left">
				<img src="images/h2.jpg" alt=""/>
			</div>
			<div class="about-right">
				<h3>WHO WE ARE : </h3>
				<p>We Just a FCIH Student Project Team try to help end Users by Developing Applications  
                                that can Resolve Problems that Face you in your normal daily life at home , school , college  
                                and Work ..... All Applications are for free Enjoy it just only if you care follow us 
                                for new applications .
                                </p>
				<p>This Application was a Simulation Project and we Made this Application in a record time ....   </p>
                                
				<a href="down">MORE</a>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>


<div class="our-staff">
	<div class="container">
		<div class="staff-info">
			<h2>OUR <span>STAFF</span></h2>
		</div>
            
            
            <p></p>
            
            
             <div class="staff-grid">
				<img src="images/fff.jpg" alt=""/>
                     <p>- PHP Developer <br> - Data Base Developer <br>- Java Coder<br>- Amazing Researcher <br> - C# Programmer . </p> 

				<div class="desc">
					<p>Mahmoud Hamed</p>
				</div>
			</div>
            

            <div class="staff-grids">
			<div class="staff-grid">
				<img src="images/ggg.jpg" alt=""/>
                                <p>- PHP Developer <br> - Data Base Developer <br>- IBM Trainee .</p>
				<div class="desc">
					<p>Abdel Rahman Hamdy</p>
				</div>
			</div>
                
                   <div class="staff-grid">
				<img src="images/3a.jpg" alt=""/>
                                <p>- PHP Developer <br> - Data Base Designer - Console  C Programmer  <br>- Nice Programming Mind .</p> 
				<div class="desc">
					<p>Abdel Rahman Mahmoud </p>
				</div>
			</div>
                
                <div class="staff-grid">
				<img src="images/eee.jpg" alt=""/>
                      <p>- PHP Developer <br> - Data Base Designer <br> - C# Programmer <br> - XAML Programmer <br> - App Factory Trainee . </p> 
				<div class="desc">
					<p>Taha Hussein</p>
				</div>
			</div>
                    
                    
                <p></p>
                    
                
                <div class="staff-grid">
				<img src="images/fi.jpg" alt=""/>
                                <p>- PHP Developer <br> - Data Base Designer <br> - Programming Hub Man <br> - Great Designer . </p> 
				<div class="desc">
					<p>Abdel Rahman Afify</p>
				</div>
			</div>
                
			
			
                
                   
                
			
                    <div class="staff-grid">
				<img src="images/ddd.jpg" alt=""/>
			 <p>- Architecture Developer <br> - PHP Developer <br>- Great  Researcher . </p>
				<div class="desc">
					<p>Mohamed Mamdouh</p>
				</div>
			</div>
                 
                    
                    
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!-- //about -->
<!-- footer -->
<div class="footer">
	<div class="container">
		<p>&copy; 2015-<?php echo date("Y")?> All Rights Reserved. &middot; <a href="#privacy">Privacy</a> &middot; <a href="#contact">Contact Us</a></p>
	</div>
</div>
<!-- //footer -->
    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>


</body>
</html>