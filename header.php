<?php
session_start(); 
$loggedin=false; 
$username="";
$userid=0;

if (!empty($_SESSION['UserID'])){ 
	$loggedin=true;
	$username=$_SESSION['UserName'];
	$userid=$_SESSION['UserID'];
}
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>inspireMe</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="./css/style.css" type="text/css" />
  <script src="./js/jquery.min.js" type="text/javascript">
</script>
  <script src="./js/bootstrap.min.js" type="text/javascript">
</script>
</head>

<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./">inspireMe</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">

      	<?php if($loggedin){?>

        <li><a href="./list_communities.php">Communities</a></li>
		<li><a href="./create_community.php">Create Community</a></li>
        <li><a href="./create_post.php">Add Post</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="./show_user.php?user_id=<?php echo $userid;?>"><b><?php echo $username;?></b></a></li>
        <li><a href="./logout.php">Log out</a></li>

      	<?php }else{?>

      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="./login.php">Login</a></li>
        <li><a href="./register.php">Register</a></li>

      	<?php }?>

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->

</nav>

  <?php
  //If there are any alerts given in the session, print them to screen.
  //So add write your success messages into $_SESSION['AlertGreen'];
  //and write your error messages into $_SESSION['AlertRed'];

  if (!empty($_SESSION['AlertGreen'])){ ?>
  
<div class="alert alert-success alert-dismissible" role="alert"><?php echo $_SESSION['AlertGreen']; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

  <?php unset($_SESSION['AlertGreen']); }

  if (!empty($_SESSION['AlertRed'])) { ?>

<div class="alert alert-danger alert-dismissible" role="alert"><?php echo $_SESSION['AlertRed'];?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

</div>
  <?php unset($_SESSION['AlertRed']); } ?>