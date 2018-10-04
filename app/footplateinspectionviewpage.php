             <?php
              session_start();
              $cli_id = null;
             $dloc="x,x";
             $user="user";
             $loc="Location";
            if(isset($_POST['loggeduserid_original'])||isset($_COOKIE[$user])){
                if(isset($_POST['loggeduserid_original'])){
                 $cli_id= $_POST['loggeduserid_original'];
                 //echo " post working $cli_id<br> ";
                setcookie($user, $cli_id);
              }
                else if(isset($_COOKIE[$user])){
                $cli_id=$_COOKIE[$user];
               // echo "cookie working $cli_id<br>";
                }
              }
              
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
              $response_msg=5;
              include("connect2db.php");
              //-------COMMON DATA FOR ALL FORMS-----
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
  <link rel="shortcut icon" href="pic/titlepic.ico" />
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Keywords" content="southern,railway,monitoring,cli,clis,sona">
	<link rel="stylesheet" type="text/css" href="mystyle.css">
	<link rel="stylesheet" type="text/css" href="footerstyle.css">
  <!-- TO ANIMATE THE NAV BAR TO THE TOP -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    
   <script type="text/javascript">
    function enable_disable(){
      $('#obs1').attr('disabled', 'disabled');
      return false;
    }

    function enableObs(){
        $('#obs1').removeAttr('disabled');
        $('#obs2').removeAttr('disabled');
        $('#obs3').removeAttr('disabled');
        
        return false;

    }
    function disableObs(){
        $('#obs1').attr('disabled', 'disabled');
        $('#obs2').attr('disabled', 'disabled');
        $('#obs3').attr('disabled', 'disabled');
        return false;

    }
      $(document).ready(function(){
        $('input:radio').click(function() {
              if ($(this).val() == 'Enable') {
                enableObs();
              } else if ($(this).val() == 'Disable') {
                disableObs();
              } 
            });
      });

  </script>

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


<div class="content">
  <?php
  if(isset($cli_id)){
   ?>
  
  
<!--two forms -->
<div>

  <div class="rows">
    <?php
      include("footplate/footplate.php");
    ?>
  </div>
</div>
<!--End of forms -->
<div class="container" id = "myresult">
  
<?php
if($modify_set==1){
?>
<script type="text/javascript">
  $('html,body').animate({scrollTop:$("#myresult").offset().top}, 'slow');
</script>
<?php
}
?>

    <?php
  if($modify_set==1){
  //----------------------------LIST OF RECORDS----------------------------
    echo "<hr><br>";
    $select_query = "SELECT * FROM `foot_plate_inspection` WHERE `date` LIKE '%$date%' AND
     `loco_no` LIKE '%$locono%' AND `train_no` LIKE '%$trainno%' AND `from_station` LIKE '%$from%' AND 
     `to_station` LIKE '%$to%' AND `lps_name` LIKE '%$lpsname%' AND `lps_cms_id` LIKE '%$lpscmsid%' AND 
     `safey_cate` LIKE '%$safetycat%' AND `alps_name` LIKE '%$alpsname%' 
    AND `alps_cms_id` LIKE '%$alpscmsid%' AND `departure` LIKE '%$departure%' AND `arrival` LIKE '%$arrival%' AND `clis_cms_id`='$cli_id' order by `id` desc limit 5";
    $query_result = mysqli_query($conn,$select_query);
    if(mysqli_num_rows($query_result)>0){
      echo '<div class="checks list-group">';
      while($row = mysqli_fetch_assoc($query_result)){
        $id1 = $row["id"];
        
        echo '<a class="list-group-item" href="god.php?fname1=footplateinspection&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>date:</b>" . format_output($row["date"]). "&nbsp<b>loco_no:</b> " . format_output($row["loco_no"]). "&nbsp<b>departure:</b> ".format_output($row["departure"])."&nbsp<b>arrival:</b> ".format_output($row["arrival"])."</a>";
      }
      echo '</div>';
    }else{
    echo "Zero records found";
  }
    }
  //-------------------------------END OF RECORDS-------------------------
    
  ?>
  
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

</body>
</html>