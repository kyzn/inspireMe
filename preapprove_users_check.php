<?php include('header.php');
if(!$loggedin){
	$_SESSION['AlertRed'] = "You have to be logged in to do that.";
	header("location:index.php");
}else{

	$commid=$_SESSION['comm_id'];
	unset($_SESSION['comm_id']);

	$mails_in = $_POST['inputMail'];
	$mails_arr = explode(",", $mails_in);

	if(empty($mails_in)){
			$_SESSION['AlertRed'] = "Don't leave blank fields.$mails_in";
			header("location:index.php");
	}else{


		foreach($mails_arr as $mail){
			$mail=trim($mail);
			
			#does given address belongs to an already existing account?
			$stmt=$db->prepare("SELECT * FROM Users WHERE Email=?");
			$stmt->execute(array($mail));
			$numrows = $stmt->rowCount();
			
			if($numrows==1){#yes, address belongs to some user
				#does this user is already a member?
				$row = $stmt->fetch ( PDO::FETCH_ASSOC );
        		$user_id=$row['UserID'];

        		$stmt2=$db->prepare("SELECT * FROM UsersInComms WHERE UserID=? AND CommID=?");
        		$stmt2->execute(array($user_id,$commid));
        		$numrows2=$stmt2->rowCount();

        		if($numrows2==1){#yes, this guy is already a member. 
        			$_SESSION['AlertRed'] .="$mail was already inspring your beautiful community!<br>";
        		}else{#nope, not a member. add him and remove a pending request if exist.
        			$stmt3 = $db->prepare("INSERT INTO UsersInComms (UserID,CommID,JoinedOn,Role) VALUES (?,?,NOW(),'user');");
					$stmt3->execute(array($user_id,$commid));
					$_SESSION['AlertGreen'] = "$mail is added to your glorious group.<br>";

					$stmt4 = $db->prepare("DELETE FROM Requests WHERE UserID=? AND CommID=?");
					$stmt4->execute(array($user_id,$commid));

        		}


			}else{#nope, address belongs to no-one.
				#check if address is added before (waiting for register)

				$stmt5 = $db->prepare("SELECT * FROM PreApproved WHERE CommID=? AND Email=?");
				$stmt5->execute(array($commid,$mail));
				$numrows5=$stmt5->rowCount();

				if($numrows5>0){
					$_SESSION['AlertRed'] .="$mail was PreApproved before (and not registered yet).<br>";
				}else{

				#add address to PreApproveds
				$stmt6 = $db->prepare("INSERT INTO PreApproved (CommID,AddedOn,Email) VALUES (?,NOW(),?);");
				$stmt6->execute(array($commid,$mail));

				$_SESSION['AlertGreen'] .="$mail is not registered to inspireMe yet, but we PreApproved him/her just in case he/she changes his/her mind..<br>";

			}}}}}
		
		$db=null;//close connection
		header("location:./show_community.php?comm_id=$commid");		

?>