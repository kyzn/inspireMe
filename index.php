<?php
session_start();
$loggedin=false;

if (!empty($_SESSION['UserID'])) {
    $loggedin=true;
}

?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="generator" content=
  "HTML Tidy for Linux/x86 (vers 25 March 2009), see www.w3.org" />

  <title>inspireMe</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href=
  "http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type=
  "text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type=
  "text/javascript">
</script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type=
  "text/javascript">
</script>
</head>

<body>
  <div class="container">
    <div class="jumbotron">
      <h1>inspireMe</h1>

      <p>Inspire others, get inspired!</p>
    </div>

    <?php if($loggedin){?>

    <div class="row">
      <div class="col-sm-4">
        <h3>Welcome, <? echo $_SESSION['UserName']; ?>!</h3>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>

        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
      </div>

      <div class="col-sm-4">
        <h3><a href="logout.php">Log out?</a></h3>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>

        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
      </div>

      <div class="col-sm-4">
        <h3>Column 3</h3>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>

        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
      </div>
    </div>
  </div><?php }else{?>

  <div class="row">
    <div class="col-sm-4">
      <h3>Login</h3>

      <form name="LogForm" method="post" action="login-post.php">
        <table style="display: inline-block">
          <tr>
            <td colspan="3"><strong>Login</strong></td>
          </tr>

          <tr>
            <td>Email</td>

            <td>:</td>

            <td><input name="LogEmailIn" type="text" id="LogEmailIn" /></td>
          </tr>

          <tr>
            <td>Password</td>

            <td>:</td>

            <td><input name="LogPassIn" type="password" id="LogPassIn" /></td>
          </tr>

          <tr>
            <td>&nbsp;</td>

            <td>&nbsp;</td>

            <td><input type="submit" name="LogSubmit" value="Login" /></td>
          </tr>
        </table>
      </form>
    </div>

    <div class="col-sm-4">
      <h3>Register</h3>

      <form name="RegForm" method="post" action="register-post.php">
        <table style="display: inline-block">
          <tr>
            <td colspan="3"><strong>Register</strong></td>
          </tr>

          <tr>
            <td>Email</td>

            <td>:</td>

            <td><input name="RegEmailIn" type="text" id="RegEmailIn" /></td>
          </tr>

          <tr>
            <td>Name</td>

            <td>:</td>

            <td><input name="RegUserNameIn" type="text" id="RegUserNameIn" /></td>
          </tr>

          <tr>
            <td>Password</td>

            <td>:</td>

            <td><input name="RegPassIn" type="password" id="RegPassIn" /></td>
          </tr>

          <tr>
            <td>&nbsp;</td>

            <td>&nbsp;</td>

            <td><input type="submit" name="RegSubmit" value="Register" /></td>
          </tr>
        </table>
      </form>
    </div>
    <div class="col-sm-4">
        <h3>Column 3</h3>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>

        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
      </div>
  </div><?php }?>
</body>
</html>
