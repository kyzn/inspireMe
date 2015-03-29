<?php include('header.php');
if(!$loggedin){
	$_SESSION['AlertRed'] = "You have to be logged in to do that.";
	header("location:index.php");
}

if (!isset($_GET['comm_id'])) {
    $_SESSION['AlertRed'] = "No such community can be found.";
	header("location:index.php");
}else{
    $commid=$_GET['comm_id'];
    //Check if there is a community with that id
	
	require_once("config.php"); //Get db credentials

    $stmt=$db->prepare("SELECT * FROM Comms WHERE CommID=?");
	$stmt->execute(array($commid));
	$numrows = $stmt->rowCount();
	
	if($numrows==0){
		$_SESSION['AlertRed'] = "No such community can be found.";
		header("location:index.php");
	}else{
		//Save the privacy setting of the group aside
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row['Privacy']=='private'){$private=true;}else{$private=false;}

		//Check whether user is joined to the community.
		$stmt=$db->prepare("SELECT * FROM UsersInComms WHERE CommID=? AND UserID=?");
		$stmt->execute(array($commid,$userid));
		$numrows = $stmt->rowCount();
		if($numrows==0){ $joined=false; }else{ $joined=true; }

		//Check whether user has a pending request for given community.
		$stmt=$db->prepare("SELECT * FROM Requests WHERE CommID=? AND UserID=?");
		$stmt->execute(array($commid,$userid));
		$numrows = $stmt->rowCount();
		if($numrows==0){ $pending=false; }else{ $pending=true; }

		if($joined){
			$_SESSION['AlertRed'] = "You are already a member.";
			header("location:show_community.php?comm_id=".$commid);
		}else if(!$private){
			$stmt = $db->prepare("INSERT INTO UsersInComms (UserID,CommID,JoinedOn,Role) VALUES (?,?,NOW(),'user');");
			$stmt->execute(array($userid,$commid));
			$_SESSION['AlertGreen'] = "Successfully joined.";
			header("location:show_community.php?comm_id=".$commid);	
		}else if($pending){
			$_SESSION['AlertRed'] = "You already have a pending request.";
			header("location:show_community.php?comm_id=".$commid);
		}else{
			$stmt=$db->prepare("INSERT INTO Requests (UserID,CommID,SentOn) VALUES (?,?,NOW());");
			$stmt->execute(array($userid,$commid));
			$_SESSION['AlertGreen'] = "Successfully submitted the request.";
			header("location:show_community.php?comm_id=".$commid);	
		}

	}

}

$db=null;?>