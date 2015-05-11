<?php include('header.php');
if(!$loggedin){
	$_SESSION['AlertRed'] = "You have to be logged in to do that.";
	header("location:index.php");
}else{

    $commenttext = $_POST['inputComment'];
    $postid = $_POST['postid'];
	// $userid is given

	if(empty($commenttext)){
			$_SESSION['AlertRed'] = "Don't leave blank fields.";
			header("location:show_post.php?post_id=".$postid);
	}else{

		$stmt=$db->prepare("INSERT INTO Comments (CommentText,UserID,PostID,CreatedOn) VALUES (?,?,?,NOW());");
		$stmt->execute(array($commenttext,$userid,$postid));
		$db=null;//close connection


		// $_SESSION['AlertGreen'] = "Successfully created comment $commenttext!";
		header("location:show_post.php?post_id=".$postid);		

		$db=null;//close connection
	}
}?>