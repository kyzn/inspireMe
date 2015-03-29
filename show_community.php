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
		$commname=$row['CommName'];
		$shortdesc=$row['ShortDesc'];

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

		//Check whether user is admin of the page or not.
		$stmt=$db->prepare("SELECT * FROM UsersInComms WHERE CommID=? AND UserID=? AND Role='admin';");
		$stmt->execute(array($commid,$userid));
		$numrows = $stmt->rowCount();
		if($numrows==0){ $admin=false; }else{ $admin=true; }

		//Let's start drawing the page
		echo "<div class='container'><h2>".$commname."</h2><p>".$shortdesc." </p><p><i>";

		
		//Handling the buttons (join-joined-request-pending)

		if($admin){
			echo "<a href='./show_requests.php?comm_id=".$commid."'>Click here to see requests to join</a>";
		}
		else if($joined){
			echo "Joined";	
		}else if(!$private){
			echo "<a href='./join.php?comm_id=".$commid."'>Click here to join</a>";
		}else if($pending){
			echo "Request Pending";
		}else{
			echo "<a href='./join.php?comm_id=".$commid."'>Click here to send a join request</a>";
		}
		
		echo "</i></p>";



		//Handling the posts

		if(!(!$joined && $private)){

			echo "	
      		<table class='table table-striped'>
        	<thead>
          	<tr>
            <th>Post Title</th>
            <th>Author</th>
          	</tr>
        	</thead>
        	<tbody>";


			$query = "SELECT P.PostID pid, P.PostTitle ptitle, U.UserName uname, U.UserID uid 
			FROM Posts P, Users U WHERE P.UserID=U.UserID AND P.CommID=".$commid.";";


			foreach($db->query($query) as $row){
				echo"<tr>
				<td><a href='./show_post.php?post_id=".$row['pid']."'>".$row['ptitle']."</a></td>
				<td><a href='./show_user.php?user_id=".$row['uid']."'>".$row['uname']."</a></td>
				</tr>";
			}

		}
	}
}

$db=null;
?>
</tbody></table></div>

<?php include('footer.php');?>