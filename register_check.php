<?php
include('header.php');

if($loggedin){
	//Already logged in
	$_SESSION['AlertRed'] = "You're already logged in.";
	header("location:index.php");

}else{

	// email, username and password sent from form
	$RegEmail=$_POST['inputEmail'];
	$RegUserName=$_POST['inputUsername'];
	$RegPassRaw=$_POST['inputPassword'];
	$RegPass=md5($RegPassRaw);

	if(empty($RegEmail) || empty($RegUserName) || empty($RegPassRaw)){
			$_SESSION['AlertRed'] = "Don't leave blank fields.";
			header("location:register.php");
	}else{

		$stmt=$db->prepare("SELECT * FROM Users WHERE Email=?");
		$stmt->execute(array($RegEmail));
		$numrows1 = $stmt->rowCount();
		$stmt=$db->prepare("SELECT * FROM Users WHERE UserName=?");
		$stmt->execute(array($RegUserName));
		$numrows2 = $stmt->rowCount();

		if($numrows1>0){
			$_SESSION['AlertRed'] = "E-mail address belongs to some other user. ";
			header("location:register.php");
		}if($numrows2>0){
			$_SESSION['AlertRed'] .= "Username belongs to some other user.";
			header("location:register.php");
		}if($numrows1==0 && $numrows2==0){
		
			$stmt = $db->prepare("INSERT INTO Users (Email, UserName, RegDate, Password) VALUES (?,?,NOW(),?);");
			$stmt->execute(array($RegEmail,$RegUserName,$RegPass));

			$_SESSION['AlertGreen'] = "Successfully registered! You should login now.";
			header("location:index.php");		

		}
		
		$db=null;//close connection

	}
}
?>