             <?php
              session_start();      
              
              include("connect2db.php");
              include("checks_and_footplate_conf.php");
              //-------COMMON DATA FOR ALL FORMS-----
            $response_msg=5;
            $modify_set=0;
            $id_set = 0;
            $idu='';
            if(isset($_POST["modify"])){
            $modify_set = 1;
            }

          //-------------END OF COMMON DATA----
              
        
        
        ?>

<html>
<head>
	<title>Food Plate Inspection</title>
  
  <link rel="shortcut icon" href="reports/pic/logo.ico" />
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Keywords" content="southern,railway,monitoring,cli,clis,sona">
	<link rel="stylesheet" type="text/css" href="mystyle.css">
	<link rel="stylesheet" type="text/css" href="footerstyle.css">
  <!-- TO ANIMATE THE NAV BAR TO THE TOP -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <?php
    if($modify_set!=1){
    ?>
    <script type="text/javascript">
      $(document).ready(function () {
          // Handler for .ready() called.
          $('html, body').animate({
              scrollTop: $('#myHeader').offset().top
          }, 'slow');
      });

      
    </script>
    <!-- END OF ANIMATION-->
<?php   }?>
	</head>
	<body onscroll="myFunction()">

<?php
//---------------HEADER--------------
include("header.php");
?>
<header class="header" id="myHeader">
<div class="container" >
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span  class="sr-only"></span>
          <span  class="icon-bar"></span>
          <span  class="icon-bar"></span>
          <span class="icon-bar"></span>
          
        </button>

      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav"  style="float:left;">
          <li><a href=""><logo style="font-weight:bold;">Activity Log</logo><span class="sr-only">(current)</span></a></li>
        </ul>

        <ul class="nav navbar-nav"  style="float:right;" >
        
          
          <li><a href="index.php">Home</a></li>
          <li><a href="footplateinspectionviewpage.php">Foot Plate Inspection</a></li>
          <li><a href="various_checks.php">Various Checks</a></li>
          <li><a href="clis_profile.php">Profile</a></li>
          
          
        </ul>
      </div>
    </div>
  </nav>
</div>
</header>
<div class="content">
  <?php
  if(isset($_SESSION['loggeduserid_original'])||isset($_SESSION['logged_controller_id'])){

   ?>
<!--two forms -->
<div class="container-fluid">

  <div class="rows">
    <?php
    
        if(isset($_SESSION['loggeduserid_original']))
            include("activity.php");
        else
          echo "Not available for controllers";
    ?>
  </div>
</div>
<!--End of forms -->
<div class="container" id = "myresult">
  
    
  
</div>

</div>
<?php 
}//closing of session set condition
else{
//----------if not logged in--------
  include("unloggedpage.php");
}
?>
<script>
var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}


</script>



<?php
//---------------FOOTER--------------
          include("footer.php");
?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>