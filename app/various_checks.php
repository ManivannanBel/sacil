<?php
  session_start();
  //------------------function to extract cli cms id
    
  //-----------------------------------------------
  $cli_id = "";
  $cli_id1 = "";
  $clicmsid = "";
  $lim = 10;
  $cli_id = 'ctrl1';
  $dloc="x,x";
  $lat="";
  $long="";
  $user="user";
  $loc="Location";
  //echo "welcomre".$_GET['loggeduserid_original']."<br>";
    if(isset($_POST['loggeduserid_original'])||isset($_COOKIE[$user])){

      if(isset($_POST['loggeduserid_original'])){
                  $cli_id= $_POST['loggeduserid_original'];
                  //echo "post is chaling $cli_id <br>";
                setcookie($user, $cli_id);
              }
                else if(isset($_COOKIE[$user])){
                $cli_id=$_COOKIE[$user];
                //echo "cookie is working $cli_id <br>";
                }
                
           
      }
      //------------Location tracking-------------------
              if(isset($_COOKIE[$loc])||(isset($_POST['lat'])&&isset($_POST['long']))){
                  if(isset($_POST['lat'])&&isset($_POST['long'])){
                  $lat=$_POST['lat'];
                  $long=$_POST['long'];
                  $dloc=$_POST['lat'].",".$_POST['long'];
                  setcookie($loc, $dloc);
                }
                else if (isset($_COOKIE[$loc])){
                $dloc=$_COOKIE[$loc];
              }
            }
 
//echo "<br>Current ID:".$cli_id;
 $fname = '';
  if(isset($_GET['fname'])){
    $fname = $_GET['fname'];
   
  }
  
?>
<html>
<head>
	<title>Various Checks</title>
  <link rel="shortcut icon" href="pic/titlepic.ico" />
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


<div class="content">
  <?php
  if(isset($cli_id)){

   ?>
<!--Various FORm -->

  

    <div  id="my-various-forms">
      <div class="form-section panel panel-default" >
        <?php
        //-------------------------PHP CODE TO MANIPULATE FORMS-----------------------------------
        include("connect2db.php");
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- WRITING SCRIPTS TO ADD VALUES AND DISPLAYIING THEM -->
<script>
  $(document).ready(function(){
      calculateSum();
    //iterate through each textboxes and add keyup
    //handler to trigger sum event
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