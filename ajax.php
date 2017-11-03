<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
if($_POST['avail']){
	$_SESSION['travelerRes'][]=array("availability"=>$_POST['avail'],"roomType"=>$_POST['roomType'],"numberGuests"=>$_POST['numberGuests']);
	$count = count($_SESSION['travelerRes']);
	$_SESSION['countTraveler']=$count;
	echo $count;
}

if($_POST['id']!=NULL){
	$id = $_POST['id'];
	if(!empty($_SESSION['travelerRes'][$id])){
		$sum = 0;
		unset($_SESSION['travelerRes'][$id], $id);
        $_SESSION['travelerRes'] = array_values($_SESSION['travelerRes']);
		$count = count($_SESSION['travelerRes']);
		$_SESSION['countTraveler']=$count;
		echo $count;
	}
}

?>