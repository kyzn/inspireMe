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
    //Now we have the community, we need to check whether user is admin of it.
    //And also community has to be private (so that people can send requests to it)
	
    $stmt=$db->prepare("SELECT C.CommName as cname FROM UsersInComms UC, Comms C WHERE UC.UserID=? AND 
    	UC.CommID=? AND UC.CommID=C.CommID AND C.Privacy='Private' AND UC.Role='admin';");
	$stmt->execute(array($userid,$commid));
	$numrows = $stmt->rowCount();

	if($numrows == 0){ 
		$_SESSION['AlertRed'] = "You don't have rights to access requests page.";
		header("location:index.php");
	}else{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$cname = $row['cname'];
		//Now we know user is the admin, so draw the table.

	?>

	<div class="container">
      <h2>Requests for <?php echo $cname;?></h2>
      <p>Click the approve/delete buttons to take action. Click user names to investigate.</p>                              
      <table class="table table-striped">
        <thead>
          <tr>
            <th>User Name</th>
            <th>Requested On</th>
            <th> </th>
            <th> </th>
          </tr>
        </thead>
        <tbody>

	<?php

$query = "SELECT U.UserID as uid, U.UserName as uname, R.SentOn date FROM Users U, Requests R 
WHERE R.UserID=U.UserID AND R.CommID=".$commid." ORDER BY date ASC;";

foreach($db->query($query) as $row){
	echo"<tr>
	<td><a href='./show_user.php?user_id=".$row['uid']."'>".$row['uname']."</a></td>
	<td>".$row['date']."</td>
	<td><a href='./show_requests_approve.php?user_id=".$row['uid']."&comm_id=".$commid."'>Approve</a></td>
	<td><a href='./show_requests_delete.php?user_id=".$row['uid']."&comm_id=".$commid."'>Delete</a></td>
	</tr>";
}}}
include('footer.php');?>