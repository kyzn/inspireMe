<?php include('header.php');
if(!$loggedin){
	$_SESSION['AlertRed'] = "You have to be logged in to do that.";
	header("location:index.php");
}


?>

<div class="container">
      <h2>My Communities</h2>
      <p>Click the community name you want to further investigate.</p>                              
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Privacy</th>
          </tr>
        </thead>
        <tbody>

<?php

/*Bring all communities logged in user is a member of*/

$query = "SELECT
C.CommName name, 
C.ShortDesc description, 
C.Privacy privacy,
C.CommID cid
FROM Comms C, UsersInComms UC
WHERE UC.UserID=".$userid." AND UC.CommID=C.CommID
ORDER BY C.CreatedOn DESC;";


foreach($db->query($query) as $row){
	echo"<tr>
	<td><a href='./show_community.php?comm_id=".$row['cid']."'>".$row['name']."</a></td>
	<td>".$row['description']."</td>
	<td>".$row['privacy']."</td>
	</tr>";
}

?>
</tbody></table></div>

<?php include('footer.php');?>