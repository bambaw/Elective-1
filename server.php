<?php 	
	session_start();
	$db = mysqli_connect('localhost', 'root', '', 'appointment');
	// initialize variables
	$name = "";
	$date = "";
	$agent = "";
	$time = "";
	$query ="";
	$id = 0;
	$cid = 0;
	$update = false;

	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$date = $_POST['date'];
		$agent = $_POST['agent'];
		$time = $_POST['time'];
		$result = mysqli_query($db,"SELECT * FROM appointment,agent where appointment.agentID=agent.agentID && agent.agentName='$agent'; ");
		if(!$result) {
		    $_SESSION['message'] = "Error Connecting";
		} 
		else {
		    if(mysqli_num_rows($result) > 0) {
				$result = mysqli_query($db,"SELECT * FROM appointment,time where appointment.timeID=time.timeID && time.time='$time'; ");
				if(mysqli_num_rows($result) > 0) {
					$result = mysqli_query($db,"SELECT * FROM appointment,schedule where appointment.schedID=schedule.schedID && schedule.schedDate='$date'; ");
					if(mysqli_num_rows($result) > 0) {
		       			$_SESSION['message'] = "Appointment is already taken";
		       			header('location: index.php');
		       		}
		       		else{
						mysqli_query($db, "INSERT INTO client (clientName) VALUES ('$name');"); 
						mysqli_query($db,"INSERT INTO appointment (clientID,agentID,timeID,schedID) values ((select client.clientID from client where client.clientName='$name'),(select agent.agentID from agent where agent.agentName='$agent'),(select time.timeID from time where time.time='$time'),(select schedule.schedID from schedule where schedule.schedDate='$date'));");
						$_SESSION['message'] = "Appointment Made"; 
						header('location: index.php');	
			       		}	
		       	}
		       	else {
					mysqli_query($db, "INSERT INTO client (clientName) VALUES ('$name') ;"); 
					mysqli_query($db,"INSERT INTO appointment (clientID,agentID,timeID,schedID) values ((select client.clientID from client where client.clientName='$name'),(select agent.agentID from agent where agent.agentName='$agent'),(select time.timeID from time where time.time='$time'),(select schedule.schedID from schedule where schedule.schedDate='$date'));");
					$_SESSION['message'] = "Appointment Made"; 
					header('location: index.php');
		       	}
		    } else {
				mysqli_query($db, "INSERT INTO client (clientName) VALUES ('$name');"); 
				mysqli_query($db,"INSERT INTO appointment (clientID,agentID,timeID,schedID) values ((select client.clientID from client where client.clientName='$name'),(select agent.agentID from agent where agent.agentName='$agent'),(select time.timeID from time where time.time='$time'),(select schedule.schedID from schedule where schedule.schedDate='$date'));");
				$_SESSION['message'] = "Appointment Made"; 
				header('location: index.php');// Good to go...
	    }
	} 
		
    }
	if (isset($_POST['editsubmit'])) {
		$id = $_POST['currentid'];
	    $cid = $_POST['currentcid'];
		$name = $_POST['currentname'];
		$date = $_POST['currentdate'];
		$agent = $_POST['currentagent'];
		$time = $_POST['currenttime'];
		$result = mysqli_query($db,"SELECT * FROM appointment,agent where appointment.agentID=agent.agentID && agent.agentName='$agent'; ");
		if(!$result) {
		    $_SESSION['message'] = "Error Connecting";
		} 
		else {
		    if(mysqli_num_rows($result) > 0) {
				$result = mysqli_query($db,"SELECT * FROM appointment,time where appointment.timeID=time.timeID && time.time='$time'; ");
				if(mysqli_num_rows($result) > 0) {
					$result = mysqli_query($db,"SELECT * FROM appointment,schedule where appointment.schedID=schedule.schedID && schedule.schedDate='$date'; ");
					if(mysqli_num_rows($result) > 0) {
		       			$_SESSION['message'] = "Appointment is already taken";
		       			header('location: index.php');
		       		}
		       		else{
						if ($name!==''){
						mysqli_query($db, "UPDATE client set clientName='$name' where client.clientID='$cid';");
						}
						mysqli_query($db,"UPDATE appointment set agentID=(select agent.agentID from agent where agent.agentName='$agent' && appointment.appointID = '$id'),timeID=(select time.timeID from time where time.time='$time' && appointment.appointID = '$id'),schedID=(select schedule.schedID from schedule where schedule.schedDate='$date' && appointment.appointID = '$id') where appointment.appointID='$id' ;");
						$_SESSION['message'] = "$Changes Made";
						header('location: index.php');
			       		}	
		       	}
		       	else {
					if ($name!==''){
						mysqli_query($db, "UPDATE client set clientName='$name' where client.clientID='$cid';");
						}
					mysqli_query($db,"UPDATE appointment set agentID=(select agent.agentID from agent where agent.agentName='$agent' && appointment.appointID = '$id'),timeID=(select time.timeID from time where time.time='$time' && appointment.appointID = '$id'),schedID=(select schedule.schedID from schedule where schedule.schedDate='$date' && appointment.appointID = '$id') where appointment.appointID='$id' ;");
					$_SESSION['message'] = "Changes Made";
					header('location: index.php');
		       	}
		    } else {
				if ($name!==''){
						mysqli_query($db, "UPDATE client set clientName='$name' where client.clientID='$cid';");
						}
				mysqli_query($db,"UPDATE appointment set agentID=(select agent.agentID from agent where agent.agentName='$agent' && appointment.appointID = '$id'),timeID=(select time.timeID from time where time.time='$time' && appointment.appointID = '$id'),schedID=(select schedule.schedID from schedule where schedule.schedDate='$date' && appointment.appointID = '$id') where appointment.appointID='$id';");
				$_SESSION['message'] = "Changes Made";
				header('location: index.php');
	    }
	} 
	} 
	if (isset($_POST['delete'])) {
			$id = $_POST['currentid'];
			mysqli_query($db, "DELETE FROM appointment where appointment.appointID='$id';"); 
			$_SESSION['message'] = "Deleted";
			header('location: index.php');
	}

?>