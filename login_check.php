<?php
include('header.php');

if($loggedin){
	//Already logged in
	$_SESSION['AlertRed'] = "You're already logged in.";
	header("location:index.php");

}else{

	// email and password sent from form
	$LogEmail=$_POST['inputEmail'];
	$LogPassRaw=$_POST['inputPassword'];
	$LogPass=md5($LogPassRaw);

	if(empty($LogEmail) || empty($LogPassRaw)){
			$_SESSION['AlertRed'] = "Don't leave blank fields.";
			header("location:login.php");
	}else{

		require_once("config.php"); //Get db credentials

		$stmt=$db->prepare("SELECT UserID,UserName FROM Users WHERE Email=? AND Password=?");
		$stmt->execute(array($LogEmail,$LogPass));
		$numrows = $stmt->rowCount();

		if($numrows == 1){ //Match. Successful login
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$_SESSION['UserID'] = $row['UserID'];
			$_SESSION['UserName'] = $row['UserName'];
			$_SESSION['AlertGreen'] = "Successfully logged in!";
			header("location:index.php");
	
		}else {
			$_SESSION['AlertRed'] = "Wrong username or password";
			header("location:login.php");
		}

		$db=null;//close connection
	}
}
?>