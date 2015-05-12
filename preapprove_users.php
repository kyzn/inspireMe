<?php include('header.php');
if(!$loggedin){
    $_SESSION['AlertRed'] = "You have to be logged in to do that.";
    header("location:index.php");
}

if (!isset($_GET['comm_id'])) {
    $_SESSION['AlertRed'] = "No such community can be found.";
    header("location:index.php");
}else{
    $commid=$_GET['comm_id'];
    //Check if there is a community with that id
    
    $stmt=$db->prepare("SELECT * FROM Comms WHERE CommID=?");
    $stmt->execute(array($commid));
    $numrows = $stmt->rowCount();

    if($numrows==0){
        $_SESSION['AlertRed'] = "No such community can be found.";
        header("location:index.php");
    }else{
        $row = $stmt->fetch ( PDO::FETCH_ASSOC );
        $cname=$row['CommName'];

        //Check whether user is admin of the page or not.
        $stmt=$db->prepare("SELECT * FROM UsersInComms WHERE CommID=? AND UserID=? AND Role='admin';");
        $stmt->execute(array($commid,$userid));
        $numrows = $stmt->rowCount();
        if($numrows==0){ $admin=false; }else{ $admin=true; }

            if(!$admin){
                $_SESSION['AlertRed'] = "You are not authorized to complete the action.";
                header("location:index.php");
            }else{
                $_SESSION['comm_id']=$commid;

                ?>

                <div class="container">
            <form class="form-signin" method="post" action="preapprove_Users_check.php">
            <h2 class="form-signin-heading">Preapprove Users</h2>
            <?php
            echo "<p> for <a href=\"./show_community.php?comm_id=$commid\">$cname</a></p>";
        
        ?>

        
        <label for="inputMail" class="sr-only">Emails</label>
        <textarea rows="10" name="inputMail" class="form-control" 
        placeholder="Email Addresses (seperated by comma, no spaces)" required></textarea>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
      </form>

    </div> <!-- /container -->


<?php }}} include('footer.php');?>