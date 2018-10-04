<?php
session_start();
$islogged = 0;
$flag = 0;
$ResultSet = [];
$message="";
include("connect2db.php");
if(isset($_SESSION['loggeduser_original'])||isset($_SESSION['logged_controller_id'])){
		$islogged  = 1;
    if(isset($_SESSION['loggeduser_original'])){
    $role = "CLI";
    $userid=$_SESSION['loggeduserid_original'];
    $column_id = "clis_cms_id";
    $table = "clis_details";
}else if(isset($_SESSION['logged_controller_id'])){
  $role = "TLC";
  $userid=$_SESSION['logged_controller_id'];
  $column_id = "controller_id";
   $table = 'controller_details';
}


$bypass = ['id','paswd'];
$sql="SELECT * FROM $table WHERE $column_id LIKE '$userid' ";
$res1 = mysqli_query($conn,$sql);
if($res1){
    $row=mysqli_fetch_assoc($res1);
    foreach ($row as $key => $value) {
      if(in_array($key, $bypass)) continue;
      if($key == 'clis_cms_id'||$key=='controller_id') $key = "ID";
      if($key == 'clis_name'||$key=='controller_name') $key = "Name";
      $ResultSet[$key] = $value;
    }
    $ResultSet['Role'] = $role;
                  
} 
} // closing the condition for logged in
?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<link rel="shortcut icon" href="reports/pic/logo.ico" />
	<link rel="stylesheet" type="text/css" href="mystyle.css">
	<link rel="stylesheet" type="text/css" href="footerstyle.css">
 <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript"> 
      $(document).ready( function() {
        $('#deletesuccess').delay(3000).fadeOut();
      });
    </script>
<style type="text/css">
th{
  text-transform: uppercase;
}
</style>
</head>
<body>
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
          <li><a href="index.php"><logo style="font-weight:bold;">Profile</logo><span class="sr-only">(current)</span></a></li>
        </ul>

        <ul class="nav navbar-nav"  style="float:right;" >
        
          <li><a href="index.php">Home</a></li>
          <li><a href="footplateinspectionviewpage.php">Foot Plate Inspection</a></li>
          <li><a href="various_checks.php">Various Checks</a></li>
          
          
          
        </ul>
      </div>
    </div>
  </nav>
</div>
</header>
<div class="container">
<?php

    if($islogged==1){
      if(!empty($ResultSet)){
 ?>
	<div class="panel panel-default" style="margin-top: 50px;">
		<div class="panel-heading">
			<h3 class="panel-title">CLIS Profile</h3>
		</div>
	<div class="panel-body">	
    <p><center><img src="pic/propic.png"></center></p>
 
  <table class="table table-bordered">
    <?php
      $n = $ResultSet['Name']; $id1 = $ResultSet['ID'];
      echo"<tr><th>ID</th><td>$id1</td></tr>";
      echo"<tr><th>Name</th><td>$n</td></tr>";
      foreach ($ResultSet as $h => $d) {
        if(in_array($h, array('ID', 'Name'))) continue;
        echo"<tr><th> $h </th> <td> $d </td> </tr>";
      }
    ?>
  </table>
  <?php 
  include("changepass.php");
    //---------------------password change confirmation message-----
    if(isset($_POST['change_submit'])){
    if($flag==1){
          $message="Password Changed";
    }else if ($flag==0){
            $message =" Invalid current password. Please try again!!!";

    }
    else{
      $message="";
    }
    }
//---------------------------------------------------------------

    //--------------in case of changed password------------
          if($message!='') echo "
          <div class='container success-failed-reply'  id='deletesuccess' 
          style='text-align:center;margin-left:20px;color:#fff;padding-bottom:5px;padding-top:5px;background-color: #0b1021;width:92%;'>
          <span>$message</span>
          </div>
          ";
         
?>
		</div>
	</div>
<?php 
} //resultset not empty
} //islogged on
else{
  include("unloggedpage.php");
}

  ?>
</div>


<?php
      
        //---------------FOOTER--------------
          include("footer.php");
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>