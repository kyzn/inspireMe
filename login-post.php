<?php
session_start();
$loggedin=true;

if (empty($_SESSION['UserID'])) {
    $loggedin=false;
}

if($loggedin){
	echo "Already logged in.";
}else{

	// email and password sent from form
	$LogEmail=$_POST['LogEmailIn'];
	$LogPassRaw=$_POST['LogPassIn'];
	$LogPass=md5($LogPassRaw);

	if(empty($LogEmail) || empty($LogPassRaw)){
		echo "Don't leave fields blank.";
	}else{

		require_once("config.php"); //Get db credentials

		$stmt=$db->prepare("SELECT UserID,UserName FROM Users WHERE Email=? AND Password=?");
		$stmt->execute(array($LogEmail,$LogPass));
		$numrows = $stmt->rowCount();

		if($numrows == 1){ //Match. Successful login
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$_SESSION['UserID'] = $row['UserID'];
			$_SESSION['UserName'] = $row['UserName'];
			header("location:index.php");
	
		}else {
			echo "Wrong username or password";
		}

		$db=null;//close connection
	}
}
?>