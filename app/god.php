<?php
session_start();
if(isset($_GET['fname']) && isset($_GET['idu'])){
	$_SESSION['fname'] = $_GET['fname'];
	$_SESSION['idu'] = $_GET['idu'];
	//$loggeduserid_original=$_GET['loggeduserid_original'];
	$fname = $_GET['fname'];
	//$lat=$_GET['lat'];
	//$long=$_GET['long'];
	
	//echo $fname;
	header("location:various_checks.php?fname=$fname");
}
if(isset($_GET['fname1']) && isset($_GET['idu'])){
	$_SESSION['fname1'] = $_GET['fname1'];
	$_SESSION['idu'] = $_GET['idu'];
	$fname = $_GET['fname1'];
	//$lat=$_GET['lat'];
	//$long=$_GET['long'];
	//$loggeduserid_original=$_GET['loggeduserid_original'];
	header("location:footplateinspectionviewpage.php?fname1=$fname");
}
echo "This is god-helping everyone";

?>