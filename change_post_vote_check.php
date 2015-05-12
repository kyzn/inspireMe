<?php

include ('header.php');
if (! $loggedin) {
   $_SESSION ['AlertRed'] = "You have to be logged in to do that.";
   header ( "location:index.php" );
} else {
   
   $postid = $_POST ['postid'];
   // $userid is given
   
   $stmt = $db->prepare ( "SELECT * FROM UpvotesForPosts WHERE PostID=? AND UserID=?" );
   $stmt->execute ( array (
         $postid,
         $userid 
   ) );
   
   $row = $stmt->fetch ( PDO::FETCH_ASSOC );
   
   if (empty ( $row )) {
      // add new
      $stmt = $db->prepare ( "INSERT INTO UpvotesForPosts (PostID,UserID,CreatedOn,IsDeleted) VALUES (?,?,NOW(),0);" );
      $stmt->execute ( array (
            $postid,
            $userid
      ) );
   } else {
      $isdeleted = $row['IsDeleted'];
      
      if($isdeleted == 1)
      {
         $stmt = $db->prepare ( "UPDATE UpvotesForPosts SET IsDeleted=0 WHERE PostID=? AND UserID=?" );
         $stmt->execute ( array (
               $postid,
               $userid
         ) );
      }
      else
      {
         $stmt = $db->prepare ( "UPDATE UpvotesForPosts SET IsDeleted=1 WHERE PostID=? AND UserID=?" );
         $stmt->execute ( array (
               $postid,
               $userid
         ) );
      }
   }
   
   $db = null; // close connection
   
   // $_SESSION['AlertGreen'] = "Successfully upvoted post!!";
   header ( "location:show_post.php?post_id=" . $postid );
}
?>