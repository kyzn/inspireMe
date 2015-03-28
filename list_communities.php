<?php include('header.php');
if(!$loggedin){
	$_SESSION['AlertRed'] = "You have to be logged in to do that.";
	header("location:index.php");
}


?>

<div class="container">
      <h2>Communities</h2>
      <p>Click the community name you want to further investigate.</p>                              
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Privacy</th>
            <th>Membership</th>
          </tr>
        </thead>
        <tbody>

<?php

/*Here, what looks like a complicated SQL query is actually pretty simple.
First, it brings all communities in the database.
Then, we check for the logged in user's situation (returned in membership col)
There are four possible results:
1) user, to mean that logged in user is a member but not an admin
2) admin, to mean that user is the admin
3) requested, to mean that community is private and user sent a join request
4) null, to mean that user does not belong to the community
a possible fifth state: expired compare UsersInComms.ValidUntil vs NOW()*/

include_once("config.php"); //Get db credentials

$query = "SELECT 
  C.CommName name, 
  C.ShortDesc description, 
  C.Privacy privacy,
  C.CommID cid,
  IF(
    EXISTS(
      SELECT * FROM Users U, UsersInComms UC 
      WHERE U.UserID = UC.UserID 
      AND UC.CommID = C.CommID 
      AND U.UserID = ".$userid." ),
    ( SELECT UC.Role FROM Users U, UsersInComms UC 
      WHERE U.UserID = UC.UserID 
      AND UC.CommID = C.CommID 
      AND U.UserID = ".$userid." ),
      IF(
          EXISTS(
              SELECT * 
              FROM Requests R 
              WHERE R.UserID=".$userid." 
              AND R.CommID=C.CommID),
          'pending',
          NULL
      )
    ) membership
FROM Comms C
ORDER BY C.CreatedOn DESC;";


foreach($db->query($query) as $row){
	echo"<tr>
	<td><a href='./show_community.php?comm_id=".$row['cid']."'>".$row['name']."</a></td>
	<td>".$row['description']."</td>
	<td>".$row['privacy']."</td>
	<td>".$row['membership']."</td>
	</tr>";
}

$db=null;
?>
</tbody></table></div>

<?php include('footer.php');?>