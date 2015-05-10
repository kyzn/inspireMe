<?php include('header.php');
if(!$loggedin){
	$_SESSION['AlertRed'] = "You have to be logged in to do that.";
	header("location:index.php");
}?>

<div class="container">

      <form class="form-signin" method="post" action="create_community_check.php">
        <h2 class="form-signin-heading">Create Community</h2>
        <label for="inputName" class="sr-only">Community name</label>
        <input type="name" name="inputName" class="form-control" 
        maxlength=127 placeholder="Community name" required autofocus>
        <label for="inputDesc" class="sr-only">Description</label>
        <input type="name" name="inputDesc" class="form-control" 
        maxlength=1023 placeholder="Description" required>
        <label for="inputPrivacy" class="sr-only">Privacy</label>
        <div class="radio">
 			<label><input type="radio" name="inputPrivacy" value="public" required>Public (Anyone can join, anyone can read)</label>
		</div>
		<div class="radio">
  			<label><input type="radio" name="inputPrivacy" value="private" required>Private (Approve to join, members can read)</label>
		</div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
      </form>

    </div> <!-- /container -->


<?php include('footer.php');?>