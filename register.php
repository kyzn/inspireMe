<?php include('header.php');?>

 <div class="container">

      <form class="form-signin" method="post" action="register_check.php">
        <h2 class="form-signin-heading">Register</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="inputEmail" class="form-control" 
        maxlength=255 placeholder="Email address" required autofocus>
        
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="name" name="inputUsername" class="form-control" 
        maxlength=32 placeholder="Username" required>

        <label for="inputFullname" class="sr-only">Full name</label>
        <input type="name" name="inputFullname" class="form-control" 
        maxlength=128 placeholder="Full name" required>

        <label for="inputBirthyear" class="sr-only">Birth year</label>
        <input type="number" name="inputBirthyear" class="form-control" 
        maxlength=4 placeholder="Birth year" required>

        <label for="inputOccupation" class="sr-only">Occupation</label>
        <input type="name" name="inputOccupation" class="form-control" 
        maxlength=128 placeholder="Occupation" required>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="inputPassword" class="form-control" 
        maxlength=16 placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
      </form>

    </div> <!-- /container -->


<?php include('footer.php');?>