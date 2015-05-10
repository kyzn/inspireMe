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
      
   $stmt = $db->prepare ( "SELECT * FROM posts WHERE PostID=?" );
   $stmt->execute ( array (
         $postid 
   ) );
   $numrows = $stmt->rowCount ();
   
   if ($numrows == 0) {
      $_SESSION ['AlertRed'] = "No such post can be found.";
      // header ( "location:index.php" );
   } else {
      $row = $stmt->fetch ( PDO::FETCH_ASSOC );
      
      $postTitle = $row ['PostTitle'];
      $postContent = $row ['PostText'];
      $postCreationDate = $row ['CreatedOn'];
      $nextPostId = $row ['NextPostID'];
      $prevPostId = $row ['PrevPostID'];
      
      $commId = $row ['CommID'];
      
      $stmt = $db->prepare ( "SELECT * FROM comments WHERE PostID=?" );
      $stmt->execute ( array (
            $postid 
      ) );
      $numcomments = $stmt->rowCount ();
      
      // Let's start drawing the page
      ?>
<!-- Body -->
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<article>
				<h1>
				     <?php echo "<a href='./show_post.php?post_id=".$postid."'>".$postTitle."</a>"; ?>				     					
				</h1>

				<div class="row">
					<div class="col-sm-6 col-md-6">
						<span class="glyphicon glyphicon-folder-open"></span> &nbsp;<a
							href="#">Signs</a> &nbsp;&nbsp;<span
							class="glyphicon glyphicon-bookmark"></span> <a href="#">Aries</a>,
						<a href="#">Fire</a>, <a href="#">Mars</a>
					</div>
					<div class="col-sm-6 col-md-6">
						<span class="glyphicon glyphicon-pencil"></span> <a
							href="show_post.php#comments"><?php echo "$numcomments Comments" ?></a>
						&nbsp;&nbsp;<span class="glyphicon glyphicon-time"></span> <?php echo "$postCreationDate"?>
					</div>
				</div>

				<hr>

				<img src="http://placehold.it/900x300" class="img-responsive"> <br />

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
         echo "<li class='next disabled'><a href='./show_post.php?post_id=" . $nextPostId . "'>Next<span aria-hidden='true'>&rarr;</span></a></li>";
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

			<ul id="comments" class="comments">
			   
			   <?php
      $query = "SELECT C.CommentID cid, C.CommentText ctext, C.CreatedOn cdate, U.UserName uname, U.UserID uid
			FROM Comments C, Users U WHERE C.UserID=U.UserID AND C.PostID=" . $postid . ";";
      
      foreach ( $db->query ( $query ) as $row ) {
         echo "<li class='comment'>
                  <div class='clearfix'>
      				<h4 class='pull-left'><a href='./show_user.php?user_id=" . $row ['uid'] . "'>" . $row ['uname'] . "</a></h4>
					<p class='pull-right'>" . $row ['cdate'] . "</p>
                  </div>
         		  <p>
				    <em>" . $row ['ctext'] . "</em>
					</p>
               </li>";
      }
      ?>			   

			</ul>

			<!-- Comment form -->
			<div class="well">
				<h4>Leave a comment</h4>
				<form role="form" class="clearfix">
					<div class="col-md-12 form-group">
						<label class="sr-only" for="email">Comment</label>
						<textarea class="form-control" id="comment" placeholder="Comment"></textarea>
					</div>
					<div class="col-md-12 form-group text-right">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
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
					<li class="list-group-item"><a href="singlepost.html">1. Aries Sun
							Sign March 21 - April 19</a></li>
					<li class="list-group-item"><a href="singlepost.html">2. Taurus Sun
							Sign April 20 - May 20</a></li>
					<li class="list-group-item"><a href="singlepost.html">3. Gemini Sun
							Sign May 21 - June 21</a></li>
					<li class="list-group-item"><a href="singlepost.html">4. Cancer Sun
							Sign June 22 - July 22</a></li>
					<li class="list-group-item"><a href="singlepost.html">5. Leo Sun
							Sign July 23 - August 22 </a></li>
				</ul>
			</div>

			<!-- Categories -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Categories</h4>
				</div>
				<ul class="list-group">
					<li class="list-group-item"><a href="#">Signs</a></li>
					<li class="list-group-item"><a href="#">Elements</a></li>
					<li class="list-group-item"><a href="#">Planets</a></li>
					<li class="list-group-item"><a href="#">Cusps</a></li>
					<li class="list-group-item"><a href="#">Compatibility</a></li>
				</ul>
			</div>

			<!-- Tags -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Tags</h4>
				</div>
				<div class="panel-body">
					<ul class="list-inline">
						<li><a href="#">Aries</a></li>
						<li><a href="#">Fire</a></li>
						<li><a href="#">Mars</a></li>
						<li><a href="#">Taurus</a></li>
						<li><a href="#">Earth</a></li>
						<li><a href="#">Moon</a></li>
						<li><a href="#">Gemini</a></li>
						<li><a href="#">Air</a></li>
						<li><a href="#">Mercury</a></li>
						<li><a href="#">Cancer</a></li>
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