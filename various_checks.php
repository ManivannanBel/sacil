<?php
  session_start();
  include("connect2db.php");
  include("checks_and_footplate_conf.php");

  $fname = '';
  if(isset($_GET['fname'])){
    $fname = $_GET['fname'];
   
  }
  
?>
<html>
<head>
	<title>Various Checks</title>
 <link rel="shortcut icon" href="reports/pic/logo.ico" />
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Keywords" content="southern,railway,monitoring,cli,clis,sona">
	<link rel="stylesheet" type="text/css" href="mystyle.css">
	<link rel="stylesheet" type="text/css" href="footerstyle.css">
  <!-- TO ANIMATE THE NAV BAR TO THE TOP -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

   <?php
    if(isset($_GET['fname'])){ ?>
      
      <script type="text/javascript">   
      $(document).ready(function () {
          // Handler for .ready() called.
          $('html, body').animate({
              scrollTop: $('#my-various-forms').offset().top
          }, 'fast');
      });
    </script>
    <?php
    }else{
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
<?php } ?>
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
          <li><a href=""><logo style="font-weight:bold;">Various Checks</logo><span class="sr-only">(current)</span></a></li>
        </ul>

        <ul class="nav navbar-nav"  style="float:right;" >
        
          
          <li><a href="index.php">Home</a></li>
          <li><a href="footplateinspectionviewpage.php">Foot Plate Inspection</a></li>
          
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
<!--Various FORm -->
<div class="container">
  <div class="rows">
    <div class="col-lg-3" style="padding-top:30px;">
      <h2> Various checks</h2>
      <div class="checks list-group">
        <a class="list-group-item" href="various_checks.php?fname=spm">SPEEDOMETER ANALYSIS</a>
        <a class="list-group-item" href="various_checks.php?fname=vcd">VIGILANCE CONTROL DEVICE</a>
        <a class="list-group-item" href="various_checks.php?fname=rr">RUNNING ROOM</a>
        <a class="list-group-item" href="various_checks.php?fname=cb">CREW BOOKING</a>
        <a class="list-group-item" href="various_checks.php?fname=jss">JOINT SIGNAL SIGHTING</a>
        <a class="list-group-item" href="various_checks.php?fname=adj_div">ADJACENT DIVISION</a>
        <a class="list-group-item" href="various_checks.php?fname=amb_by_speed_gun">SPEED GUN CHECK</a>
        <a class="list-group-item" href="various_checks.php?fname=sec_sfc">SEC/SFC COUNSELLING</a>
        <a class="list-group-item" href="various_checks.php?fname=safety_drive">SAFETY DRIVE</a>
        <a class="list-group-item" href="various_checks.php?fname=sob">STANDING ORDER BOOK</a>
        <a class="list-group-item" href="various_checks.php?fname=safety_seminar">SAFETY SEMINAR</a>
        <a class="list-group-item" href="various_checks.php?fname=tsc">TROUBLESHOOTING CONSOLE</a>
        <a class="list-group-item" href="various_checks.php?fname=mobile_phone_check">MOBILE PHONE CHECK</a>
      </div>
    </div>


    <div class="col-lg-6" style="float:right;padding-top:45px;" id="my-various-forms">
      <div class="form-section panel panel-default" >
        <?php
        //-------------------------PHP CODE TO MANIPULATE FORMS-----------------------------------
        
        $response_msg=5;
        if($fname=='') echo "Select the form on the right side.";
         else{ 
          $fname1 = $fname.".php";
          //-------COMMON DATA FOR ALL FORMS-----
            $modify_set=0;
            $id_set = 0;
            $idu='';
            if(isset($_POST["modify"])){
            $modify_set = 1;
            }

          //-------------END OF COMMON DATA----
          include("checkforms/$fname1");
        }
        
        $msg_from_script = "";
        if(isset($_GET['status'])){
          $response_msg =  $_GET['status'];
          unset($_GET['status']);
        }
        if($response_msg==1){
          $msg_from_script = "Successfully Added";
        }else if($response_msg==2){
          $msg_from_script = "Successfully Updated";
        }else if($response_msg==3){
          $msg_from_script = "Successfully Deleted";
        }else if($response_msg==0){
          $msg_from_script = "Failed, Please try again";
        }else{
          $msg_from_script = "";
        }
        if($response_msg==1||$response_msg==0||$response_msg==2||$response_msg==3){
        ?>
        <div class=" container success-failed-reply" style="text-align:center;margin-left:20px;color:#fff;padding-bottom:5px;padding-top:5px;background-color: #0b1021;width:92%;"><span><?php echo $msg_from_script;?></span></div>
      <?php
    }
        
          //------------------------END OF PHP CODE----------------------
      ?>
      </div>
    </div>
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
  <!-- WRITING SCRIPTS TO ADD VALUES AND DISPLAYIING THEM -->
<script>
  $(document).ready(function(){

    //iterate through each textboxes and add keyup
    //handler to trigger sum event
    calculateSum();
    $(".toBCal").each(function() {

      $(this).keyup(function(){
        calculateSum();
      });
    });

  });

  function calculateSum() {

    var sum = 0;
    //iterate through each textboxes and add the values
    $(".toBCal").each(function() {

      //add only if the value is number
      if(!isNaN(this.value) && this.value.length!=0) {
        sum += parseInt(this.value);
      }

    });
    var sum_res = "Total: "+sum;
    $("#sum").html(sum_res);
  }

  function clear(){
    $("#sum").html("Total: 0");
  }
</script>
<!-- END OF JQERY SCRIPT -->
</body>
</html>