<?php
include 'header.php';

// TODO if private, look for $loggedin
// if (! $loggedin) {
// $_SESSION ['AlertRed'] = "You have to be logged in to do that.";
// header ( "location:index.php" );
// }

if (! isset ( $_GET ['post_id'] )) {
   $_SESSION ['AlertRed'] = "No such post can be found.";
   // header("location:index.php");
} else {
   $postid = $_GET ['post_id'];
   
   $stmt = $db->prepare ( "SELECT P.PostTitle as ptitle, P.PostText as ptext,
   P.CreatedOn as pdate, P.NextPostID as pnext, P.PrevPostID as pprev, U.UserID as uid,
   U.UserName as uname, P.CommID as commid FROM Posts P, Users U 
      WHERE P.PostID=? AND P.UserID=U.UserID" );
   $stmt->execute ( array (
         $postid 
   ) );
   $numrows = $stmt->rowCount ();
   
   if ($numrows == 0) {
      $_SESSION ['AlertRed'] = "No such post can be found.";
      // header ( "location:index.php" );
   } else {
      $row = $stmt->fetch ( PDO::FETCH_ASSOC );
      
      $postTitle = $row ['ptitle'];
      $postContent = $row ['ptext'];
      $postCreationDate = $row ['pdate'];
      $nextPostId = $row ['pnext'];
      $prevPostId = $row ['pprev'];
      $uid = $row['uid'];
      $uname = $row['uname'];
      $commid = $row['commid'];
      
      $commId = $row ['CommID'];
      
      $stmt = $db->prepare ( "SELECT * FROM Comments WHERE PostID=?" );
      $stmt->execute ( array (
            $postid 
      ) );
      $numComments = $stmt->rowCount ();
      
      $stmt = $db->prepare ( "SELECT * FROM UpvotesForPosts WHERE PostID=? && IsDeleted=0" );
      $stmt->execute ( array (
            $postid 
      ) );
      $numofupvotes = $stmt->rowCount ();
      
      // Let's start drawing the page
      ?>
<!-- Body -->
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<article>
				<form role="form" class="clearfix" method="post"
					action="change_post_vote_check.php">
								    <?php
      $stmt = $db->prepare ( "SELECT * FROM UpvotesForPosts WHERE PostID=? AND UserID=?" );
      $stmt->execute ( array (
            $postid,
            $userid 
      ) );
      
      $row = $stmt->fetch ( PDO::FETCH_ASSOC );
      
      if (! empty ( $row ) && $row ['IsDeleted'] == 0) {
         echo "<button type='submit' class='btn btn-default btn-lg active'>";
         echo "<span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span>";
      } else {
         echo "<button type='submit' class='btn btn-default btn-lg'>";
         echo "<span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span>";
      }
      echo "Upvote</button>";
      
      echo "<input type='hidden' name='postid' value=" . $postid . ">";
      
      ?>
				</form>
				<h1>
				     <?php echo "<a href='./show_post.php?post_id=".$postid."'>".$postTitle."</a>"; ?>				     					
				</h1>

				<div class="row">
					<div class="col-sm-6 col-md-6">

						<span class="glyphicon glyphicon-pencil"></span> <?php echo "$numofupvotes Upvotes" ?>
						<a href="show_post.php?post_id=<?php echo "$postid" ?>#Comments"><?php echo "$numComments Comments" ?></a>
						&nbsp;&nbsp;
					</div>
					<div class="col-sm-6 col-md-6">
						<span style="float: right" class="glyphicon glyphicon-time"> <?php echo "$postCreationDate"?> by <a href="./show_user.php?user_id=<?php echo $uid;?>"><?php echo $uname;?></a></span>
						<!-- 						<span class="glyphicon glyphicon-folder-open"></span> &nbsp;<a -->
						<!-- 							href="#">Signs</a> &nbsp;&nbsp;<span -->
						<!-- 							class="glyphicon glyphicon-bookmark"></span> <a href="#">Aries</a>, -->
						<!-- 						<a href="#">Fire</a>, <a href="#">Mars</a> -->
					</div>
				</div>

				<hr>

				<!-- 			Issue #16 Add Image or Video Link to the post	                
                <img src="http://placehold.it/900x300" class="img-responsive"> <br /> -->

				<p class="lead">
				<?php
      echo $postContent;
      ?>
				</p>

				<hr>
			</article>

			<ul class="pager">
			   <?php
      if (empty ( $prevPostId )) {
         echo "<li class='previous disabled'><a href='./show_post.php?post_id=" . $prevPostId . "'><span aria-hidden='true'>&larr;</span>Previous</a></li>";
      } else {
         echo "<li class='previous'><a href='./show_post.php?post_id=" . $prevPostId . "'><span aria-hidden='true'>&larr;</span>Previous</a></li>";
      }
      
      if (empty ( $nextPostId )) {
         if($uid==$userid){
            echo "<li class='next'><a href='./create_post.php?comm_id=".$commid."&prev_post_id=" . $postid . "'>Write Follow-up Story!<span aria-hidden='true'>&rarr;</span></a></li>";
         }else{
            echo "<li class='next disabled'><a href='./show_post.php?post_id=" . $nextPostId . "'>Next<span aria-hidden='true'>&rarr;</span></a></li>";
         }
      } else {
         echo "<li class='next'><a href='./show_post.php?post_id=" . $nextPostId . "'>Next<span aria-hidden='true'>&rarr;</span></a></li>";
      }
      ?>
			   
			</ul>

			<ul class="pager">			   
			   <?php
      echo "<li class='previous'><a href='./show_community.php?comm_id=" . $commId . "'><span aria-hidden='true'>&larr;</span>Back to community page</a></li>";
      ?>
			</ul>

			<hr />

			<ul id="Comments" class="Comments">
			   
			   <?php
      $query = "SELECT C.CommentID cid, C.CommentText ctext, C.CreatedOn cdate, U.UserName uname, U.UserID uid
			FROM Comments C, Users U WHERE C.UserID=U.UserID AND C.PostID=" . $postid . ";";
      foreach ( $db->query ( $query ) as $row ) {
         $commentid = $row['cid'];
         
         echo " <div class='clearfix'>
      				<h4 class='pull-left'><a href='./show_user.php?user_id=" . $row ['uid'] . "'>" . $row ['uname'] . "</a> says :</h4>
					<p class='pull-right'>" . $row ['cdate'] . "</p>
                  </div>
                  <div class='panel-heading' style='overflow:auto; 
                                             text-overflow: ellipsis; 
                                             white-space: text-justify;'>";
         ?>
         <form role="form" class="clearfix" method="post"
					action="change_comment_vote_check.php">
								    <?php
         $stmt = $db->prepare ( "SELECT * FROM UpvotesForComments WHERE CommentID=? && IsDeleted=0" );
         $stmt->execute ( array (
               $commentid 
         ) );
         $numofupvotesforcomment = $stmt->rowCount ();
         
         $stmt = $db->prepare ( "SELECT * FROM UpvotesForComments WHERE CommentID=? AND UserID=?" );
         $stmt->execute ( array (
               $commentid,
               $userid 
         ) );
         
         $crow = $stmt->fetch ( PDO::FETCH_ASSOC );
         
         if (! empty ( $crow ) && $crow ['IsDeleted'] == 0) {
            echo "<button type='submit' class='btn btn-default btn-circle active'>";
            echo "<span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span>";
         } else {
            echo "<button type='submit' class='btn btn-default btn-circle'>";
            echo "<span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span>";
         }
         echo $numofupvotesforcomment." Likes</button>";
         echo "<input type='hidden' name='commentid' value=" . $commentid . ">";
         echo "<input type='hidden' name='postid' value=" . $postid . ">";
         ?>
				</form>         
         <?php
         echo "<span>" . $row ['ctext'] . "</span></div>";
      }
      ?>			   

			</ul>

			<!-- Comment form -->
			<div class="well">
				<h4>Leave a comment</h4>
				<form role="form" class="clearfix" method="post"
					action="add_comment_check.php">
					<div class="col-md-12 form-group">
						<label class="sr-only" for="email">Comment</label>
						<textarea class="form-control" id="comment" name="inputComment"
							placeholder="Comment"></textarea>
					</div>
					<div class="col-md-12 form-group text-right">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
					<input type="hidden" name="postid" value="<?php echo $postid;?>">
				</form>
			</div>
		</div>
		<div class="col-md-4">

			<!-- Latest Posts -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Latest Posts</h4>
				</div>
				<ul class="list-group">
				  <?php 
				  $query = "SELECT * FROM Posts WHERE CommID=" . $commId . " ORDER BY CreatedOn DESC LIMIT 5;";
				  foreach ( $db->query ( $query ) as $row ) {
				     echo "<li class='list-group-item'><a href='./show_post.php?post_id=".$row['PostID']."'>";
				     echo $row['PostTitle'];
				     echo "</a></li>";
				  }
				  ?>
				</ul>
			</div>

			<!-- Categories -->
			<!--  			<div class="panel panel-default"> -->
			<!-- 				<div class="panel-heading"> -->
			<!-- 					<h4>Categories</h4> -->
			<!-- 				</div> -->
			<!-- 				<ul class="list-group"> -->
			<!-- 					<li class="list-group-item"><a href="#">Signs</a></li> -->
			<!-- 					<li class="list-group-item"><a href="#">Elements</a></li> -->
			<!-- 					<li class="list-group-item"><a href="#">Planets</a></li> -->
			<!-- 					<li class="list-group-item"><a href="#">Cusps</a></li> -->
			<!-- 					<li class="list-group-item"><a href="#">Compatibility</a></li> -->
			<!-- 				</ul> -->
			<!-- 			</div> -->

			<!-- Tags -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Tags</h4>
				</div>
				<div class="panel-body">
					    <?php
      $query = "SELECT T.TagID tid, T.TAG tag
			                     FROM TagsForPosts T WHERE T.PostID=" . $postid . ";";
      
      $stmt = $db->prepare ( $query );
      $stmt->execute ();
      $numrows = $stmt->rowCount ();
      
      if ($numrows == 0) {
         echo "No Tags found";
         ;
      } else {
         echo "<ul class='list-inline'>";
         foreach ( $db->query ( $query ) as $row ) {
            echo "<li><a href='./search.php?keyword=". $row ['tag'] ."'>" . $row ['tag'] . "</a></li>";
            // search #21, searched tag
         }
         echo "</ul>";
      }
      ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap Script file -->
<script src="lib/jquery-2.0.3.min.js"></script>
<script src="lib/bootstrap-3.0.3/js/bootstrap.min.js"></script>

<?php
   }
}

?>

<?php include 'footer.php';?>