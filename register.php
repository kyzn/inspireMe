<?php include('header.php');?>

 <div class="container">

      <form class="form-signin" method="post" action="register_check.php">
        <h2 class="form-signin-heading">Register</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="name" name="inputUsername" class="form-control" placeholder="Username" required>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
      </form>

    </div> <!-- /container -->


<?php include('footer.php');?>