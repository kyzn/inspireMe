<?php include('header.php');
if(!$loggedin){
	$_SESSION['AlertRed'] = "You have to be logged in to do that.";
	header("location:index.php");
}else{

	// email, username and password sent from form
	$commid=$_SESSION['comm_id'];
	unset($_SESSION['comm_id']);
	$followup=$_SESSION['followup'];
	unset($_SESSION['followup']);
	if($followup){
		$ppid=$_SESSION['ppid'];
		unset($_SESSION['ppid']);
	}

	$posttitle=$_POST['inputTitle'];
	$posttext=$_POST['inputPost'];
	$posttags=$_POST['inputTags'];
	$tags_arr = explode(",", $posttags);


	if(empty($commid) || empty($posttitle) || empty($posttext) || empty($posttags)){
			$_SESSION['AlertRed'] = "Don't leave blank fields.";
			header("location:create_post.php");
	}else{

		if($followup){
			$stmt=$db->prepare("INSERT INTO Posts (PostText,PostTitle,UserID,CommID,CreatedOn,PrevPostID) VALUES (?,?,?,?,NOW(),?);");
			$stmt->execute(array($posttext,$posttitle,$userid,$commid,$ppid));
		}else{
			$stmt=$db->prepare("INSERT INTO Posts (PostText,PostTitle,UserID,CommID,CreatedOn) VALUES (?,?,?,?,NOW());");
			$stmt->execute(array($posttext,$posttitle,$userid,$commid));
		}
		
		$post_id = $db->lastInsertId();

		if($followup){
			$stmt=$db->prepare("UPDATE Posts SET NextPostID=? WHERE PostID=?");
			$stmt->execute(array($post_id,$ppid));
		}

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