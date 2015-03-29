<?php include('header.php');
if(!$loggedin){
	$_SESSION['AlertRed'] = "You have to be logged in to do that.";
	header("location:index.php");
}else{

	// email, username and password sent from form
	$commid=$_POST['inputCommunity'];
	$posttitle=$_POST['inputTitle'];
	$posttext=$_POST['inputPost'];

	if(empty($commid) || empty($posttitle) || empty($posttext)){
			$_SESSION['AlertRed'] = "Don't leave blank fields.";
			header("location:create_post.php");
	}else{

		require_once("config.php"); //Get db credentials

		$stmt=$db->prepare("INSERT INTO Posts (PostText,PostTitle,UserID,CommID,CreatedOn) VALUES (?,?,?,?,NOW());");
		$stmt->execute(array($posttext,$posttitle,$userid,$commid));
		$db=null;//close connection


		$_SESSION['AlertGreen'] = "Successfully created post $posttitle!";
		header("location:show_community.php?comm_id=".$commid);		

		$db=null;//close connection


	}
}?>