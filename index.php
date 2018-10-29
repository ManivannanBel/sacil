<html>
<head>
  <title>CLI Monitoring</title>
  <link rel="shortcut icon" href="reports/pic/logo.ico" />

  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="Keywords" content="southern,railway,monitoring,cli,clis,sona,daya, dayanand, dayanand raut, sagar, sagar poudel, ragas, raj, raj shikhar, raj shikhar tandukar, aparna, aparna c, aparna chandrasekharan, vishnu, vishu raj, vishnu sivakumar, railway,">
  <link rel="stylesheet" type="text/css" href="mystyle.css">
  <link rel="stylesheet" type="text/css" href="footerstyle.css">
  
  </head>
  <body onscroll="myFunction()">

<?php
//---------------HEADER--------------
session_start();
include("connect2db.php");
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
          <li><a href=""><logo style="font-weight:bold;">HOME</logo><span class="sr-only">(current)</span></a></li>
        </ul>

        <ul class="nav navbar-nav"  style="float:right;" >
        
          
          <li><a href="footplateinspectionviewpage.php">Foot Plate Inspection</a></li>
          <li><a href="various_checks.php">Various Checks</a></li>
          <li><a href="activity_log.php">Activity Log</a></li>
          <li><a href="clis_profile.php">Profile</a></li>
          <li><a href="add_comments.php">Add comments</a></li>
          
        </ul>
      </div>
    </div>
  </nav>
</div>
</header>
<div class="content">
<!--Row wise content-->
<div class="container">
  <div class="rows">
    <div class="col-lg-4">
              <!--LOGIN FORM -->
        <?php
          
          include("login.php");

        ?>
        <!--END OF LOGIN FORM -->
    </div>
    <div class="col-lg-8" >
      <h3>Online web based Integrated Performance Assessment & Monitoring System for Loco running staff (IPMAS)</h3>
      
        <p  style="text-align:justify">Continuous monitoring and upgradation in the enginemanship and safety 
          consciousness among the running staff can only be achieved by keeping constant vigil on their 
          driving techniques and compliance of safety rules. System of monitoring of LP & ALPs by Chief 
          Loco Inspectors (CLIs) is in place since long.  To improve further, an online web based Integrated 
          Performance Assessment & Monitoring System in the form of Web Portal & Android Application (App)
           has been developed by SA division in collaboration with <a href="http://www.sonatech.ac.in/" target="_blank">SONA College of Technology</a>. Based on reports
            generated through portal and App, a number of corrective actions can be taken to improve the performance
             of LPs, ALPs through CLIs.</p>
    </div>
  </div>
</div>
<!--end-->

<div class = "container">
  <h3>Detailed Description</h3>
  <p style="text-align:justify">
    In railway parlance, 'Footplating' is used to denote onboard inspection in the cab of
     a running locomotive/Trains. This is one of the most essential and effective safety
      inspections conducted periodically by officers and CLIs to monitor enginemanship and 
      other attributes of Loco Pilots (LPs) and Asst Loco Pilots (ALPs). The portal and the 
      App facilitate an on-line monitoring of LP & ALPs on various performance parameters & attributes,
       e.g. efficient & safe driving techniques, safety & trouble-shooting knowledge, alertness, etc. 
       in a user-friendly format for identifying & improving the weak areas of crew and improvement thereof.
        This information is transferred to the web hosting server on real time basis. The Portal and the App 
        thereby bolster the supervision of safety related attributes of running staff. Various useful reports
         on performance of running staff can be generated in tabular & graphical form for taking a pinpointed 
         and focussed corrective action to improve upon the performance/weak-areas of crew.
  </p>
</div>
</div>
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