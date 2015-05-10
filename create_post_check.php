<?php include('header.php');
if(!$loggedin){
	$_SESSION['AlertRed'] = "You have to be logged in to do that.";
	header("location:index.php");
}else{

	// email, username and password sent from form
	$commid=$_SESSION['comm_id'];
	unset($_SESSION['comm_id']);
	$posttitle=$_POST['inputTitle'];
	$posttext=$_POST['inputPost'];
	$posttags=$_POST['inputTags'];
	$tags_arr = explode(",", $posttags);


	if(empty($commid) || empty($posttitle) || empty($posttext) || empty($posttags)){
			$_SESSION['AlertRed'] = "Don't leave blank fields.";
			header("location:create_post.php");
	}else{

		$stmt=$db->prepare("INSERT INTO Posts (PostText,PostTitle,UserID,CommID,CreatedOn) VALUES (?,?,?,?,NOW());");
		$stmt->execute(array($posttext,$posttitle,$userid,$commid));
		$post_id = $db->lastInsertId();

		#add tags
		$stmt=$db->prepare("INSERT INTO TagsForPosts (PostID, CreatedOn, Tag) VALUES (?,NOW(),?);");
		foreach($tags_arr as $tag){
			$stmt->execute(array($post_id,$tag));
		}

		$_SESSION['AlertGreen'] = "Successfully created post $posttitle!";
		header("location:show_community.php?comm_id=".$commid);		

		$db=null;//close connection


	}
}?>