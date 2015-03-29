<?php include('header.php');
if(!$loggedin){
	$_SESSION['AlertRed'] = "You have to be logged in to do that.";
	header("location:index.php");
}

//If user is in zero communities, redirect back to index.


require_once("config.php"); //Get db credentials

		$stmt=$db->prepare("SELECT C.CommName cname, C.CommID cid 
			FROM UsersInComms UC, Comms C 
			WHERE UC.CommID=C.CommID AND UC.UserID=?;");
		$stmt->execute(array($userid));
		$numrows = $stmt->rowCount();

		if($numrows == 0){ //Match. Successful login
			$_SESSION['AlertRed'] = "You are in no communities to post yet.";
			header("location:index.php");
		}else{

			?>
			<div class="container">
	     	<form class="form-signin" method="post" action="create_post_check.php">
        	<h2 class="form-signin-heading">Create Post</h2>
			<?php

			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				?>
				<div class="radio">
 				<label><input type="radio" name="inputCommunity" 
 				value="<?php echo $row['cid'];?>" required><?php echo $row['cname'];?>
 				</label></div>
				<?php
			}
			?>

        
        <label for="inputTitle" class="sr-only">Post title</label>
        <input type="name" name="inputTitle" class="form-control" 
        maxlength=128 placeholder="Post title" required autofocus>
        <label for="inputPost" class="sr-only">Post</label>
        <textarea rows="5" name="inputPost" class="form-control" 
        maxlength=720 placeholder="Post (max 720 char)" required></textarea>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
      </form>

    </div> <!-- /container -->


<?php } include('footer.php');?>