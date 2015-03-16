<?php
session_start();
$loggedin=true;

if (empty($_SESSION['UserID'])) {
    $loggedin=false;
}

if($loggedin){
	echo "Already logged in.";
}else{

	// email, username and password sent from form
	$RegEmail=$_POST['RegEmailIn'];
	$RegUserName=$_POST['RegUserNameIn'];
	$RegPassRaw=$_POST['RegPassIn'];
	$RegPass=md5($RegPassRaw);

	if(empty($RegEmail) || empty($RegUserName) || empty($RegPassRaw)){
		echo "Don't leave fields blank.";
	}else{

		require_once("config.php"); //Get db credentials

		$stmt=$db->prepare("SELECT * FROM Users WHERE Email=?");
		$stmt->execute(array($RegEmail));
		$numrows1 = $stmt->rowCount();
		$stmt=$db->prepare("SELECT * FROM Users WHERE UserName=?");
		$stmt->execute(array($RegUserName));
		$numrows2 = $stmt->rowCount();

		if($numrows1>0 || $numrows2>0){
			echo "Email or username taken.";
		}else{
			$stmt = $db->prepare("INSERT INTO Users (Email, UserName, RegDate, Password) VALUES (?,?,NOW(),?);");
			$stmt->execute(array($RegEmail,$RegUserName,$RegPass));
			echo "Registered.";			
		}

		$db=null;//close connection

	}
}
?>