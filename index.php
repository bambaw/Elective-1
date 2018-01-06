<?php  include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Appointment Setter</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<?php if (isset($_SESSION['message'])): ?>
	<div class="msg">
		<?php 
			echo $_SESSION['message']; 
			unset($_SESSION['message']);
		?>
	</div>
	<?php endif ?>
	<section class="container-fluid">
	<section class="text-center" id ="title-button"><button class="btn btn-lg btn-primary btn-block" id="btnapp">Set an appointment</button></section>
	<section id ="form">
	<section class="text-center"><h2>Set an appointment</h2></section>
	<form action="server.php" class="form-appoint" method="post" >
		<input type="" class="form-control" name="name" placeholder="name" value="" required>
		<select class="form-control" value="agent" name="agent" required>
			<option value="">Agent</option>
			<option value="Noe Jay D. Torres">Noe Jay D. Torres</option>
			<option value="Julius Narvasa">Julius Narvasa</option>
			<option value="Shaniah Caralde">Shaniah Caralde</option>
		</select>
		<select class="form-control" name="time" required>
			<option value="">Time</option>
			<option value="8:00-9:00 AM">8:00-9:00 AM</option>
			<option value="9:00-10:00 AM">9:00-10:00 AM</option>
			<option value="10:00-11:00 AM">10:00-11:00 AM</option>
			<option value="1:00-2:00 PM">1:00-2:00 PM</option>
			<option value="2:00-3:00 PM">2:00-3:00 PM</option>
			<option value="3:00-4:00 PM">3:00-4:00 PM</option>
			<option value="4:00-5:00 PM">4:00-5:00 PM</option>
		</select>	
		<select class="form-control" name="date" required>
			<option value="">Date</option>
			<option value="2018-04-01">2018-04-01</option>
			<option value="2018-04-02">2018-04-02</option>
			<option value="2018-04-03">2018-04-03</option>
			<option value="2018-04-04">2018-04-04</option>
			<option value="2018-04-05">2018-04-05</option>
		</select>
		<button class="btn btn-lg btn-primary btn-block" type=submit name="submit">submit</button>
	</form>
	</section>
	<section class="text-center">
	<button class="btn btn-md btn-primary" id ="btnshow">Check Appointments</button>
	<button class="btn btn-md btn-primary" id ="btnhide">Hide Appointments</button>	
	</section>
	<div class="table-data mt-2" >
            <div class="row">        
                <table class="table table-hover" id="t-record">
                    <thead>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Agent</th>
                        <th>Time</th>
                        <th>Date</th>
                    </thead>
                    <tbody>
                    	<?php $results = mysqli_query($db, "SELECT appointment.appointID,client.clientID,client.clientName,agent.agentName,time.time,schedule.schedDate FROM client,agent,time,schedule,appointment where client.clientID = appointment.clientID && agent.agentID = appointment.agentID && time.timeID = appointment.timeID && schedule.schedID = appointment.schedID"); ?>
                    	<?php while ($row = mysqli_fetch_array($results)) { ?>
							<tr>
							<form action="server.php" class="form-appoint" method="post">
								<td ><?php echo $row['appointID']; ?><input type="" id="hidden" class="id" name="id" value="<?php echo $row['appointID']; ?>">
									<input type="" id="hidden" class="cid" value="<?php echo $row['clientID']; ?>" name="cid" >
								</td>
								<td><div id="notedit"><?php echo $row['clientName']; ?></div><input type="" class="form-control name" name="editname" id="edit" placeholder="name" value="" > 		
								</td>
								<td><div id="notedit"><?php echo $row['agentName']; ?></div>
								<select class="form-control agent" value="agent" id="edit" name="editagent" >
									<option value="">Agent</option>
									<option value="Noe Jay D. Torres">Noe Jay D. Torres</option>
									<option value="Julius Narvasa">Julius Narvasa</option>
									<option value="Shaniah Caralde">Shaniah Caralde</option>
								</select>	
								</td>
								<td><div id="notedit"><?php echo $row['time']; ?></div>
									<select class="form-control time" id="edit" name="edittime" >
										<option value="">Time</option>
										<option value="8:00-9:00 AM">8:00-9:00 AM</option>
										<option value="9:00-10:00 AM">9:00-10:00 AM</option>
										<option value="10:00-11:00 AM">10:00-11:00 AM</option>
										<option value="1:00-2:00 PM">1:00-2:00 PM</option>
										<option value="2:00-3:00 PM">2:00-3:00 PM</option>
										<option value="3:00-4:00 PM">3:00-4:00 PM</option>
										<option value="4:00-5:00 PM">4:00-5:00 PM</option>
									</select>
								</td>
								<td><div id="notedit"><?php echo $row['schedDate']; ?></div>
									<select class="form-control date" id="edit" name="editdate">
										<option value="">Date</option>
										<option value="2018-04-01">2018-04-01</option>
										<option value="2018-04-02">2018-04-02</option>
										<option value="2018-04-03">2018-04-03</option>
										<option value="2018-04-04">2018-04-04</option>
										<option value="2018-04-05">2018-04-05</option>
									</select>
								</td>
								<td>
									<a class="btn btn-xs btn-primary btn-block btnedit" id="notedit">Edit</a>
									<button type="submit" class="btn btn-xs btn-primary btn-block" id="edit" name="edit">Done</button>
								</td>
								<td>
									<button typle="submit" class="btn btn-xs btn-danger btn-block btndel" id="notedit" name="delete">Delete</button>
								</td>
							</form>
							</tr>
						<?php } ?>
                    </tbody>
                </table>
            </div>
	</section>
	<script type="text/javascript" 	src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</body>
</html>