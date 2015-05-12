<?php

include ('header.php');
if (! $loggedin) {
   $_SESSION ['AlertRed'] = "You have to be logged in to do that.";
   header ( "location:index.php" );
} else {   
   $commentid = $_POST ['commentid'];
   $postid = $_POST ['postid'];
   // $userid is given
   
   $stmt = $db->prepare ( "SELECT * FROM UpvotesForComments WHERE CommentID=? AND UserID=?" );
   $stmt->execute ( array (
         $commentid,
         $userid 
   ) );
   
   $row = $stmt->fetch ( PDO::FETCH_ASSOC );
   
   if (empty ( $row )) {
      // add new
      $stmt = $db->prepare ( "INSERT INTO UpvotesForComments (CommentID,UserID,CreatedOn,IsDeleted) VALUES (?,?,NOW(),0);" );
      $stmt->execute ( array (
            $commentid,
            $userid
      ) );
   } else {
      $isdeleted = $row['IsDeleted'];
      
      if($isdeleted == 1)
      {
         $stmt = $db->prepare ( "UPDATE UpvotesForComments SET IsDeleted=0 WHERE CommentID=? AND UserID=?" );
         $stmt->execute ( array (
               $commentid,
               $userid
         ) );
      }
      else
      {
         $stmt = $db->prepare ( "UPDATE UpvotesForComments SET IsDeleted=1 WHERE CommentID=? AND UserID=?" );
         $stmt->execute ( array (
               $commentid,
               $userid
         ) );
      }
   }
   
   $db = null; // close connection
   
   // $_SESSION['AlertGreen'] = "Successfully upvoted post!!";
   header ( "location:show_post.php?post_id=" . $postid."#Comments" );
}
?>