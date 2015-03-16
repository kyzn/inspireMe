<?php
session_start();
$loggedin=true;

if (empty($_SESSION['UserID'])) {
    $loggedin=false;
}

?>

<html>
<head>
  <meta charset="utf-8">
  <title>inspireMe</title>
</head>
<body>
    <?php if($loggedin){?>

Welcome, <? $_SESSION['UserName'] ?>! <a href="logout.php">Log out?</a>

    <?php }else{?>


<form name="LogForm" method="post" action="login-post.php">
<table style="display: inline-block">
<tr>
<td colspan="3"><strong>Login </strong></td>
</tr>
<tr>
<td>Email</td>
<td>:</td>
<td><input name="LogEmailIn" type="text" id="LogEmailIn"></td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td><input name="LogPasswordIn" type="password" id="LogPasswordIn"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="LogSubmit" value="Login"></td>
</tr>
</table>
</form>

<form name="RegForm" method="post" action="register-post.php">
<table style="display: inline-block">
<tr>
<td colspan="3"><strong>Register</strong></td>
</tr>
<tr>
<td>Email</td>
<td>:</td>
<td><input name="RegEmailIn" type="text" id="RegEmailIn"></td>
</tr>
<tr>
<td>Name</td>
<td>:</td>
<td><input name="RegUserNameIn" type="text" id="RegUserNameIn"></td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td><input name="RegPasswordIn" type="password" id="RegPasswordIn"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="RegSubmit" value="Register"></td>
</tr>
</table>
</form>
    
    <?php }?>


</body>
</html>
