<?php
include("connect2db.php");

if(isset($_GET["id"])){
$cid=$_GET["id"];
$sql="DELETE FROM `clis_details` WHERE `clis_cms_id` LIKE '$cid'";
$res=mysqli_query($conn,$sql);
	if(!$res){
		$response_msg = 1; 
          }
          else{
              header("location:index.php");            
          }
}

?>