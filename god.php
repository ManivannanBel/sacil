<?php
//---------------------------
include("connect2db.php");

//-------------------------
session_start();
if(isset($_GET['fname']) && isset($_GET['idu'])){
	$_SESSION['fname'] = format_input($_GET['fname']);
	$_SESSION['idu'] = format_input($_GET['idu']);
	$fname = format_input($_GET['fname']);
	header("location:various_checks.php?fname=$fname");
}
if(isset($_GET['fname1']) && isset($_GET['idu'])){
	$_SESSION['fname1'] = format_input($_GET['fname1']);
	$_SESSION['idu'] = format_input($_GET['idu']);
	$fname = format_input($_GET['fname1']);
	header("location:footplateinspectionviewpage.php?fname1=$fname");
}
echo "This is god-helping everyone";

?>