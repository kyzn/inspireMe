<?php
include 'header.php';

if (! $loggedin) {
   $_SESSION ['AlertRed'] = "You have to be logged in to do that.";
   header ( "location:index.php" );
}

if (! isset ( $_GET ['user_id'] )) {
   $_SESSION ['AlertRed'] = "No such post can be found.";
   // header("location:index.php");
} else {
   $userid = $_GET ['user_id'];
   
   $stmt = $db->prepare ( "SELECT * FROM users WHERE UserID=?" );
   $stmt->execute ( array (
         $userid 
   ) );
   $numrows = $stmt->rowCount ();
   
   if ($numrows == 0) {
      $_SESSION ['AlertRed'] = "No such user can be found.";
      header ( "location:index.php" );
   } else {
      $row = $stmt->fetch ( PDO::FETCH_ASSOC );
      
      $displayedUserID = $row ['UserID'];
      $userEmail = $row ['Email'];
      $userName = $row ['UserName'];
      $regDate = $row ['RegDate'];
      
      // total num of posts
      $stmt = $db->prepare ( "SELECT * FROM posts WHERE UserID=?" );
      $stmt->execute ( array (
            $displayedUserID 
      ) );
      $totalnumofposts = $stmt->rowCount ();
      
      // total num of comments
      $stmt = $db->prepare ( "SELECT * FROM comments WHERE UserID=?" );
      $stmt->execute ( array (
            $displayedUserID 
      ) );
      $totalnumofcomments = $stmt->rowCount ();
      
      // total num of upvotes
      $stmt = $db->prepare ( "SELECT * FROM upvotesforposts WHERE UserID=?" );
      $stmt->execute ( array (
            $displayedUserID 
      ) );
      $totalnumofupvotes = $stmt->rowCount ();
      
      // total num of likes
      $stmt = $db->prepare ( "SELECT * FROM upvotesforcomments WHERE UserID=?" );
      $stmt->execute ( array (
            $displayedUserID 
      ) );
      $totalnumoflikes = $stmt->rowCount ();
      
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
				<!-- 				<li class="list-group-item text-right"><span class="pull-left"><strong>Last -->
				<!-- 							seen</strong></span> Yesterday (?)</li> -->
				<li class="list-group-item text-right"><span class="pull-left"><strong>Contact</strong></span> 
				<?php echo "$userEmail"?>
				</li>

			</ul>

			<!-- 			<div class="panel panel-default"> -->
			<!-- 				<div class="panel-heading"> -->
			<!-- 					Contact <i class="fa fa-link fa-1x"></i> -->
			<!-- 				</div> -->
			<!-- 				<div class="panel-body"> -->
					<?php // echo "$userEmail"?>
					<!-- a href="E-">bootply.com</a> -->
			<!-- 				</div> -->
			<!-- 			</div> -->


			<ul class="list-group">
				<li class="list-group-item text-muted">Activity <i
					class="fa fa-dashboard fa-1x"></i></li>
				<!-- 				<li class="list-group-item text-right"><span class="pull-left"><strong>Shares</strong></span> -->
				<!-- 					125</li> -->
				<li class="list-group-item text-right"><span class="pull-left"><strong>Upvotes</strong></span>
					<?php echo $totalnumofupvotes ?></li>
				<li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span>
					<?php echo $totalnumoflikes ?></li>
				<li class="list-group-item text-right"><span class="pull-left"><strong>Comments</strong></span>
					<?php echo $totalnumofcomments ?></li>
				<!-- 				<li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span> -->
				<!-- 					78</li> -->
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
            <th>Posts ($totalnumofposts)</th>
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
                           <?php
      $query = "SELECT P.PostID pid, P.PostTitle ptitle, C.CreatedOn cdate 
                                        FROM Posts P, Comments C 
                                        WHERE C.UserID=" . $userid . " AND P.PostID=C.PostID 
                                        ORDER BY C.CreatedOn DESC LIMIT 10;";
      
      foreach ( $db->query ( $query ) as $row ) {
         echo "<tr><td><i class='pull-right fa fa-edit'></i>";
         echo $row ['cdate'] . " - Commented on the post 
                                      <a href='./show_post.php?post_id=" . $row ['pid'] . "#comments'>" . $row ['ptitle'] . "</a>";
         echo "</td></tr>";
      }
      ?>
						</tbody>
					</table>
				</div>

				<hr>

				<div class="table-responsive">
					<table class="table table-hover">
						<tbody>
                           <?php
      $query = "SELECT P.PostID pid, P.PostTitle ptitle, C.CreatedOn cdate, U.UserID uid, U.UserName uname
			                                   FROM Posts P, Users U, Comments C 
                                               WHERE P.UserID=" . $userid . " AND P.PostID=C.PostID AND U.UserID=C.UserID
                                               ORDER BY C.CreatedOn DESC LIMIT 10;";
      
      foreach ( $db->query ( $query ) as $row ) {
         if ($row ['uid'] != $userid) {
            echo "<tr><td><i class='pull-right fa fa-edit'></i>";
            echo $row ['cdate'] . " - " . $row ['uname'] . " commented on your post
                                      <a href='./show_post.php?post_id=" . $row ['pid'] . "#comments'>" . $row ['ptitle'] . "</a>";
            echo "</td></tr>";
         }
      }
      ?>
						</tbody>
					</table>
				</div>

				<hr>

				<div class="table-responsive">
					<table class="table table-hover">
						<tbody>
                           <?php
      $query = "SELECT P.PostID pid, P.PostTitle ptitle, UP.CreatedOn udate
			                                   FROM Posts P, Upvotesforposts UP
                                               WHERE UP.UserID=" . $userid . " AND P.PostID=UP.PostID AND UP.IsDeleted=0
                                               ORDER BY UP.CreatedOn DESC LIMIT 10;";
      
      foreach ( $db->query ( $query ) as $row ) {
         echo "<tr><td><i class='pull-right fa fa-edit'></i>";
         echo $row ['udate'] . " - Upvoted the post
              <a href='./show_post.php?post_id=" . $row ['pid'] . "'>" . $row ['ptitle'] . "</a>";
         echo "</td></tr>";
      }
      ?>
						</tbody>
					</table>
				</div>

				<hr>

				<div class="table-responsive">
					<table class="table table-hover">
						<tbody>
                           <?php
      $query = "SELECT P.PostID pid, P.PostTitle ptitle, UP.CreatedOn cdate, U.UserID uid, U.UserName uname
			                                    FROM Posts P, Users U, Upvotesforposts UP
                                                WHERE P.UserID=" . $userid . " AND P.PostID=UP.PostID AND U.UserID=UP.UserID
                                                ORDER BY UP.CreatedOn DESC LIMIT 10;";
      
      foreach ( $db->query ( $query ) as $row ) {
         echo "<tr><td><i class='pull-right fa fa-edit'></i>";
         echo $row ['cdate'] . " - " . $row ['uname'] . " upvoted your post
              <a href='./show_post.php?post_id=" . $row ['pid'] . "'>" . $row ['ptitle'] . "</a>";
         echo "</td></tr>";
      }
      ?>
						</tbody>
					</table>
				</div>

				<hr>

				<div class="table-responsive">
					<table class="table table-hover">
						<tbody>
                           <?php
      $query = "SELECT P.PostID pid, P.PostTitle ptitle, UC.CreatedOn udate
			                                   FROM Posts P, Upvotesforcomments UC, Comments C
                                               WHERE UC.UserID=" . $userid . " AND P.PostID=C.PostID AND UC.CommentID=C.CommentID AND UC.IsDeleted=0
                                               ORDER BY UC.CreatedOn DESC LIMIT 10;";
      
      foreach ( $db->query ( $query ) as $row ) {
         echo "<tr><td><i class='pull-right fa fa-edit'></i>";
         echo $row ['udate'] . " - Liked the comment in the post 
              <a href='./show_post.php?post_id=" . $row ['pid'] . "#comments'>" . $row ['ptitle'] . "</a>";
         echo "</td></tr>";
      }
      ?>
						</tbody>
					</table>
				</div>

				<hr>

				<div class="table-responsive">
					<table class="table table-hover">
						<tbody>
                           <?php
      $query = "SELECT P.PostID pid, P.PostTitle ptitle, UC.CreatedOn cdate, U.UserID uid, U.UserName uname
			                                    FROM Posts P, Users U, Upvotesforcomments UC, Comments C
                                                WHERE C.UserID=" . $userid . " AND UC.CommentID=C.CommentID AND U.UserID=UC.UserID AND P.PostID=C.PostID
				                                ORDER BY UC.CreatedOn DESC";
      
      foreach ( $db->query ( $query ) as $row ) {
         echo "<tr><td><i class='pull-right fa fa-edit'></i>";
         echo $row ['cdate'] . " - ".$row['uname']." liked your comment in the post 
              <a href='./show_post.php?post_id=" . $row ['pid'] . "#comments'>" . $row ['ptitle'] . "</a>";
         echo "</td></tr>";
      }
      ?>
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