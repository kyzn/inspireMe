<?php
include 'header.php';

// if (! $loggedin) {
// $_SESSION ['AlertRed'] = "You have to be logged in to do that.";
// header ( "location:index.php" );
// }

if (! isset ( $_GET ['user_id'] )) {
   $_SESSION ['AlertRed'] = "No such post can be found.";
   // header("location:index.php");
} else {
   $userid = $_GET ['user_id'];
   
   require_once ("database/config.php"); // Get db credentials
   
   $stmt = $db->prepare ( "SELECT * FROM users WHERE UserID=?" );
   $stmt->execute ( array (
         $userid 
   ) );
   $numrows = $stmt->rowCount ();
   
   if ($numrows == 0) {
      $_SESSION ['AlertRed'] = "No such user can be found.";
      // header ( "location:index.php" );
   } else {
      $row = $stmt->fetch ( PDO::FETCH_ASSOC );
      
      $userEmail = $row ['Email'];
      $userName = $row ['UserName'];
      $regDate = $row ['RegDate'];
      
      ?>

<hr>
<div class="container">
	<div class="row">
		<div class="col-sm-10">
			<h1><?php echo "$userName"?></h1>
		</div>
		<div class="col-sm-2">
			<a href="index.php" class="pull-right"><img title="profile image"
				class="img-rounded img-responsive" src="im_logo.png"></a>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-3">
			<!--left col-->

			<ul class="list-group">
				<li class="list-group-item text-muted">Profile</li>
				<li class="list-group-item text-right"><span class="pull-left"><strong>Joined</strong></span>
					<?php echo "$regDate"?></li>
				<li class="list-group-item text-right"><span class="pull-left"><strong>Last
							seen</strong></span> Yesterday (?)</li>
				<li class="list-group-item text-right"><span class="pull-left"><strong>Real
							name</strong></span> Ibrahim Cimentepe (?)</li>

			</ul>

			<div class="panel panel-default">
				<div class="panel-heading">
					Contact <i class="fa fa-link fa-1x"></i>
				</div>
				<div class="panel-body">
					<?php echo "$userEmail"?>
					<!-- a href="E-">bootply.com</a> -->
				</div>
			</div>


			<ul class="list-group">
				<li class="list-group-item text-muted">Activity <i
					class="fa fa-dashboard fa-1x"></i></li>
				<li class="list-group-item text-right"><span class="pull-left"><strong>Shares</strong></span>
					125</li>
				<li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span>
					13</li>
				<li class="list-group-item text-right"><span class="pull-left"><strong>Comments</strong></span>
					37</li>
				<li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span>
					78</li>
			</ul>

			<div class="panel panel-default">
				<div class="panel-heading">Communities</div>
				<div class="panel-body">
				  <?php
      $query = "SELECT C.CommID cid, C.CommName cname
      FROM Comms C, Usersincomms U WHERE C.CommID=U.CommID AND U.UserID=" . $userid . ";";
      
      foreach ( $db->query ( $query ) as $row ) {
         echo "<p>
					<h4>
                        <a href='./show_community.php?comm_id=" . $row ['cid'] . "'>" . $row ['cname'] . "</a></td>
				    </h4>
			   </p>";
      }
      
      ?>
				
				
<!-- 					<p>
					<h3>

						<a href='./join.php?comm_id=1'>John</a>
					</h3>
					</p>
					<p>
					
					
					<h3>

						<a href='./join.php?comm_id=1'>John</a>
					</h3>
					</p>
					<p>
					
					
					<h3>

						<a href='./join.php?comm_id=1'>John</a>
					</h3>
					</p> -->
				</div>
			</div>

		</div>
		<!--/col-3-->
		<div class="col-sm-9">

			<div class="tab-content">
				<div class="tab-pane active" id="home">
					<div class="table-responsive">
						<?php
      
      echo "
      		<table class='table table-striped'>
        	<thead>
          	<tr>
            <th>Posts</th>
            <th>Date</th>
          	</tr>
        	</thead>
        	<tbody>";
      
      $query = "SELECT P.PostID pid, P.PostTitle ptitle, P.CreatedOn pdate
			FROM Posts P WHERE P.UserID=" . $userid . ";";
      
      foreach ( $db->query ( $query ) as $row ) {
         echo "<tr>
				<td><a href='./show_post.php?post_id=" . $row ['pid'] . "'>" . $row ['ptitle'] . "</a></td>
               <td>" . $row ['pdate'] . "</td>
				</tr>";
      }
      ?>
						</tbody>
						</table>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-4 col-md-offset-4 text-center">
							<ul class="pagination" id="myPager"></ul>
						</div>
					</div>
				</div>
				<!--/table-resp-->

				<hr>

				<h4>Recent Activity</h4>

				<div class="table-responsive">
					<table class="table table-hover">

						<tbody>
							<tr>
								<td><i class="pull-right fa fa-edit"></i> Today, 1:00 - Keanu
									Reeves liked your post.</td>
							</tr>
							<tr>
								<td><i class="pull-right fa fa-edit"></i> Today, 12:23 - Chloe
									Grace Moretz liked and shared your post.</td>
							</tr>
							<tr>
								<td><i class="pull-right fa fa-edit"></i> Today, 12:20 - You
									posted a new blog entry title "Why social media is".</td>
							</tr>
							<tr>
								<td><i class="pull-right fa fa-edit"></i> Yesterday - Uskudarli
									liked your post.</td>
							</tr>
							<tr>
								<td><i class="pull-right fa fa-edit"></i> 2 Days Ago - Jhonny
									Depp liked your post.</td>
							</tr>
							<tr>
								<td><i class="pull-right fa fa-edit"></i> 2 Days Ago - Nicole
									Kidman liked your post.</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!--/tab-pane-->
		</div>
		<!--/tab-content-->

	</div>
	<!--/col-9-->
</div>
<!--/row-->

<?php
   }
}
?>

<?php include 'footer.php';?>