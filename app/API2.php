<?php
session_start();
$cli_id=$pass= null;
if($_SERVER["REQUEST_METHOD"]=="POST"){
	include 'connect2db.php';
	

	global $cli_id, $pass;
	global $conn;

	$cli_id = $_POST["firstname"];
	$pass = $_POST["lastname"];
	
	 $query = " select * from clis_details where `clis_cms_id`='$cli_id' and `paswd`='$pass'; ";


	$result = mysqli_query($conn, $query);
	$number_of_rows = mysqli_num_rows($result);
	
	$temp_array  = array();

	$temp_array1  = array();


	if($number_of_rows != 0) {
		while ($row = mysqli_fetch_assoc($result)) {

			$temp_arra = $row['clis_cms_id'];
			//setcookie("loginuseridset",$temp_arra,time()+(86400));
			echo "$temp_arra";			
		}
	}else{
		echo"hie";
}
	
	 	
	mysqli_close($conn);
	
}else{
	echo "404 file NOT FOUND";
  }?>
