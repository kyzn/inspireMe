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
    $_SESSION['comm_id']=$commid;
    $userid=$_SESSION['UserID'];

		$stmt=$db->prepare("SELECT C.CommName cname FROM UsersInComms UC, Comms C
			WHERE C.CommID=? AND UC.CommID=C.CommID AND UC.UserID=?;"); 
		#will return empty set if user is not in the community
		#otherwise we will have the commname.
		$stmt->execute(array($commid,$_SESSION['UserID']));
		$numrows = $stmt->rowCount();

		if($numrows == 0){
			$_SESSION['AlertRed'] = "You are not authorized to post in that community.";
			header("location:index.php");
		}else{
			$row = $stmt->fetch ( PDO::FETCH_ASSOC );
			$cname=$row['cname'];

			?>
			<div class="container">
	     	<form class="form-signin" method="post" action="create_post_check.php">
        	<h2 class="form-signin-heading">Create Post</h2>
			<?php
			echo "<p> for <a href=\"./show_community.php?comm_id=$commid\">$cname</a></p>";
		
		?>

        
        <label for="inputTitle" class="sr-only">Post title</label>
        <input type="name" name="inputTitle" class="form-control" 
        maxlength=128 placeholder="Post title" required autofocus>
        <label for="inputPost" class="sr-only">Post</label>
        <textarea rows="5" name="inputPost" class="form-control" 
        maxlength=720 placeholder="Post (max 720 char)" required></textarea>
        <label for="tags" class="sr-only">Tags</label>
        <textarea rows="2" name="inputTags" class="form-control" 
        maxlength=512 placeholder="Tags (seperated by comma)" required></textarea>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
      </form>

    </div> <!-- /container -->


<?php }} include('footer.php');?>