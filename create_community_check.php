<?php include('header.php');
if(!$loggedin){
	$_SESSION['AlertRed'] = "You have to be logged in to do that.";
	header("location:index.php");
}else{

	// email, username and password sent from form
	$CommName=$_POST['inputName'];
	$CommDesc=$_POST['inputDesc'];
	$CommPriv=$_POST['inputPrivacy'];

	if(empty($CommName) || empty($CommDesc) || empty($CommPriv)){
			$_SESSION['AlertRed'] = "Don't leave blank fields.";
			header("location:create_community.php");
	}else{

		require_once("config.php"); //Get db credentials

		$stmt=$db->prepare("SELECT * FROM Comms WHERE CommName=?");
		$stmt->execute(array($CommName));
		$numrows = $stmt->rowCount();
		
		if($numrows1>0){
			$_SESSION['AlertRed'] = "Community with the same name already exists.";
			header("location:create_community.php");
		}else{
		
			//Create community
			$stmt = $db->prepare("INSERT INTO Comms (CommName,ShortDesc,Privacy,CreatedOn) VALUES (?,?,?,NOW());");
			$stmt->execute(array($CommName,$CommDesc,$CommPriv));
			$commid = $db->lastInsertId();

			//and add the user who created it as the first member.
			$stmt = $db->prepare("INSERT INTO UsersInComms (UserID,CommID,JoinedOn,Role) VALUES (?,?,NOW(),'admin');");
			$stmt->execute(array($userid,$commid));

			$_SESSION['AlertGreen'] = "Successfully created community $CommName!";
			header("location:index.php");		

		}
		
		$db=null;//close connection

	}
}
?>