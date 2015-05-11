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

	$RegFullName=$_POST['inputFullname'];
	$RegBirthYear=$_POST['inputBirthyear'];
	$RegOccupation=$_POST['inputOccupation'];
	


	if( empty($RegEmail) || empty($RegUserName) || empty($RegPassRaw) || empty($RegFullName) || empty($RegBirthYear) || empty($RegOccupation) ){
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

		
			$stmt = $db->prepare("INSERT INTO Users (Email, UserName, RegDate, Password, FullName, BirthYear, Occupation) VALUES (?,?,NOW(),?,?,?,?);");
			$stmt->execute(array($RegEmail,$RegUserName,$RegPass,$RegFullName,$RegBirthYear,$RegOccupation));
			$user_id = $db->lastInsertId();

			#check if user has any preapproved groups, add if any
			$preapp_query=$db->prepare("SELECT * FROM PreApproved WHERE Email=?");
			$preapp_query->execute(array($RegEmail));

			while($preapp_row = $preapp_query->fetch ( PDO::FETCH_ASSOC ) ) {
				$commid=$preapp_row['CommID'];
				$preappid=$preapp_row['PreAppID'];
				$stmt2 = $db->prepare("INSERT INTO UsersInComms (UserID,CommID,JoinedOn,Role) VALUES (?,?,NOW(),'user');");
				$stmt2->execute(array($user_id,$commid));
				$stmt3 = $db->prepare("DELETE FROM PreApproved WHERE PreAppID=?");
				$stmt3->execute(array($preappid));

			}

			$_SESSION['AlertGreen'] = "Successfully registered! You should login now.";
			header("location:index.php");		

		}
		
		$db=null;//close connection

	}
}
?>