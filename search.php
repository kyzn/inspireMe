<?php include('header.php');

if (isset($_GET['keyword'])) {
  $keyword=$_GET['keyword'];#if anything is passed through ?keyword=abcd, use it.
}else if(isset($_POST['inputKeyword'] ) ){
  $keyword=$_POST['inputKeyword'];#if not, check the form value
}else{
  $_SESSION['AlertRed'] = "Did you.. Did you just try a search with no keyword? Why would you ever do that?";
  header("location:index.php");
}

#now we have the keyword. (it works in two ways. 1: call search.php?keyword=abcd directly. 2: fill the form at the header)

#places we will look for logged in users
#1 Comms.CommName + Comms.ShortDesc
#2 TagsForComms.Tag
#3 Users.UserName + Users.FullName

#4 Posts.PostText + Posts.PostTitle
#5 TagsForPosts.Tag
#6 Comments.CommentText

#guest will be able to search through 1,2,3
#users will be able to search through 4,5,6 if community is public or private and joined
  

#start drawing table
?>
<div class="container">
<table class='table table-striped'>
          <thead>
            <tr>
            <th>Result</th>
            <th>Type</th>
            </tr>
          </thead>
          <tbody>
<?php

#1: Comms.CommName + Comms.ShortDesc

$query = "SELECT * FROM Comms C WHERE C.CommName LIKE '%".$keyword."%' OR C.ShortDesc LIKE '%".$keyword."%';";

foreach ( $db->query ( $query ) as $row ) {
  echo "<tr>
        <td><a href='./show_community.php?comm_id=" . $row ['CommID'] . "'>" . $row ['CommName'] . "</a> (".$row['ShortDesc'].")</td>
        <td>Community Name - Description</td>
        </tr>";
   }



#2: TagsForComms.Tag

$query = "SELECT C.CommID as cid, C.CommName as cname, T.Tag as tag 
FROM Comms C,TagsForComms T WHERE C.CommID=T.CommID AND T.Tag LIKE '%".$keyword."%';";

foreach ( $db->query ( $query ) as $row ) {
  echo "<tr>
        <td><a href='./show_community.php?comm_id=" . $row ['cid'] . "'>" . $row ['cname'] . "</a> (".$row['tag'].")</td>
        <td>Tag for Community</td>
        </tr>";
   }



#3: Users.UserName + Users.FullName

$query = "SELECT * FROM Users WHERE UserName LIKE '%".$keyword."%' OR FullName LIKE '%".$keyword."%';";

foreach ( $db->query ( $query ) as $row ) {
  echo "<tr>
        <td><a href='./show_user.php?user_id=" . $row ['UserID'] . "'>" . $row ['UserName'] . "</a> (".$row['FullName'].")</td>
        <td>User Name - Full Name</td>
        </tr>";
   }



#rest will work only if logged-in
   if($loggedin){


#4 Posts.PostText + Posts.PostTitle
#check for privacy-membership

$query="
SELECT P.PostTitle as pt, P.PostID as pid, C.CommID as cid, C.CommName as cname
FROM UsersInComms UC, Comms C, Posts P
WHERE (C.Privacy='public' OR (UC.CommID=C.CommID AND UC.UserID=".$userid."))
AND (P.PostText LIKE '%".$keyword."%' OR P.PostTitle LIKE '%".$keyword."%') 
GROUP BY P.PostID";

#echo $query; #for debug purposes

foreach ( $db->query ( $query ) as $row ) {
  echo "<tr>
        <td><a href='./show_post.php?post_id=" . $row ['pid'] . "'>" . $row ['pt'] . "</a> (at <a href='./show_community.php?comm_id=".$row['cid']."'>".$row['cname']."</a>)</td>
        <td>Post Title - Post Text</td>
        </tr>";
   }


#5 TagsForPosts.Tag
#check for privacy-membership

$query="
SELECT P.PostTitle as pt, P.PostID as pid, C.CommID as cid, C.CommName as cname, T.Tag as tag
FROM UsersInComms UC, Comms C, Posts P, TagsForPosts T
WHERE (C.Privacy='public' OR (UC.CommID=C.CommID AND UC.UserID=".$userid."))
AND (T.Tag LIKE '%".$keyword."%' OR T.Tag LIKE '%".$keyword."%')
AND T.PostID=P.PostID
GROUP BY P.PostID";

foreach ( $db->query ( $query ) as $row ) {
  echo "<tr>
        <td><a href='./show_post.php?post_id=" . $row ['pid'] . "'>" . $row ['pt'] . "</a> (at <a href='./show_community.php?comm_id=".$row['cid']."'>".$row['cname']."</a>, tagged ".$row['tag'].")</td>
        <td>Tag for Post</td>
        </tr>";
   }


#5 Comments.CommentText
#check for privacy-membership

$query="
SELECT P.PostTitle as pt, P.PostID as pid, C.CommID as cid, C.CommName as cname, M.CommentText as comment
FROM UsersInComms UC, Comms C, Posts P, Comments M
WHERE (C.Privacy='public' OR (UC.CommID=C.CommID AND UC.UserID=".$userid."))
AND (M.CommentText LIKE '%".$keyword."%')
AND M.PostID=P.PostID
GROUP BY P.PostID";

foreach ( $db->query ( $query ) as $row ) {
  echo "<tr>
        <td><a href='./show_post.php?post_id=" . $row ['pid'] . "'>" . $row ['pt'] . "</a> (at <a href='./show_community.php?comm_id=".$row['cid']."'>".$row['cname']."</a>)</td>
        <td>Comment</td>
        </tr>";
   }






}#loggedin check

#close the table

   ?>
   </tbody></table></div>
   <?php





include('footer.php');?>



