<?php include 'header.php';

//Control loggedin
if(!$loggedin){
	$_SESSION['AlertRed'] = "You have to be logged in to do that.";
	header("location:index.php");
}

//Control parameters
if (!isset($_GET['comm_id']) || !isset($_GET['user_id'])) {
    $_SESSION['AlertRed'] = "No such community/user can be found.";
	header("location:index.php");
}else{

	$commid=$_GET['comm_id'];
    $ruserid=$_GET['user_id']; //this is different than $userid
	
	//Control admin rights
	$stmt=$db->prepare("SELECT * FROM UsersInComms UC, Comms C WHERE UC.UserID=? AND 
    	UC.CommID=? AND UC.CommID=C.CommID AND C.Privacy='Private' AND UC.Role='admin';");
	$stmt->execute(array($userid,$commid));
	$numrows = $stmt->rowCount();

	if($numrows == 0){ 
		$_SESSION['AlertRed'] = "You don't have rights to access requests page.";
		header("location:index.php");
	}else{

		//Control such request exists
		$stmt=$db->prepare("SELECT * FROM Requests R WHERE R.UserID=? AND R.CommID=?;");
		$stmt->execute(array($ruserid,$commid));
		$numrows = $stmt->rowCount();

		if($numrows == 0){ 
			$_SESSION['AlertRed'] = "Request could not be found.";
			header("location:index.php");
		}else{

			//Remove the request.
			$stmt = $db->prepare("DELETE FROM Requests WHERE UserID=? AND CommID=?;");
			$stmt->execute(array($ruserid,$commid));

			$db=null;
			$_SESSION['AlertGreen'] = "Successfully deleted.";
			header("location:show_requests.php?comm_id=".$commid);		

}}}



include 'footer.php';?>