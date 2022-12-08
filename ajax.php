<?php
include("db.php");

$base = "http://localhost/event-prod/";

$action = isset($_GET['action']) ? $_GET['action'] : "";

if($action != ""){
	$result = array();
	if($action == "loginAdmin"){
		$email = $_POST['email'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM users WHERE Email = '".$email."'";
		$process = $db->query($sql);
		if($process->num_rows > 0){
			$row = $process->fetch_assoc();
			if(password_verify($password,$row['Password'])){
				$_SESSION['userid'] = $row['ID'];
				$result['success'] = true;
			}else{
				$result['success'] = false;
				$result['msg'] = "Authentication Failed! Please try again.";
			}

		}else{
			$result['success'] = false;
			$result['msg'] = "User not found!";
		}
	}
	elseif($action == "deleteCategory"){
		$id = $_POST['id'];

		$delete = "DELETE FROM categories WHERE ID = ".$id;
		$process = $db->query($delete);
		if($process){
			$result['success'] = true;
		}else{
			$result['success'] = false;
			$result['msg'] = $delete;
		}
	}
	elseif($action == "deleteInclussion"){
		$id = $_POST['id'];

		$delete = "DELETE FROM offers WHERE ID = ".$id;
		$process = $db->query($delete);
		if($process){
			$result['success'] = true;
		}else{
			$result['success'] = false;
			$result['msg'] = $delete;
		}
	}
	elseif($action == "deleteImage"){
		$id = $_POST['id'];

		$delete = "DELETE FROM gallery WHERE ID = ".$id;
		$process = $db->query($delete);
		if($process){
			$result['success'] = true;
		}else{
			$result['success'] = false;
			$result['msg'] = $delete;
		}
	}
	elseif($action == "deleteplace"){
		$id = $_POST['id'];

		$delete = "DELETE FROM places WHERE ID = ".$id;
		$process = $db->query($delete);
		if($process){
			$result['success'] = true;
		}else{
			$result['success'] = false;
			$result['msg'] = $delete;
		}
	}
	elseif($action == "deleteEvent"){
		$id = $_POST['id'];

		$delete = "DELETE FROM events WHERE ID = ".$id;
		$process = $db->query($delete);
		if($process){

			$deletePackage = "DELETE FROM packages WHERE Event = ".$id;
			$processPackage = $db->query($deletePackage);
			if($processPackage){
				$result['success'] = true;
			}else{
				$result['success'] = false;
				$result['msg'] = $deletePackage;
			}

		}else{
			$result['success'] = false;
			$result['msg'] = $delete;
		}
	}
	elseif($action == "getAvailableTime"){
		$date = $_POST['date'];
		$output = "";
		$output .= "<br/>";
		$takenArray = array();
		$sql = "SELECT * FROM appointments WHERE AppointmentDate = '".date('Y-m-d',strtotime($date))."' AND Status = 'Approved'";
		$processSql = $db->query($sql);
		if($processSql->num_rows > 0){
			while($row = $processSql->fetch_assoc()){
				$takenArray[] = $row['AppointmentTime'];
			}
		}

		$staticTime = array('8:00am-10:00am','10:00am-12:00pm','01:00pm-03:00pm','03:00pm-05:00pm');
		$x = 0;
		foreach($staticTime as $time){

			$checked = ($x == 0) ? "checked" : ""; 
			if(!in_array($time, $takenArray)){
				$output .= '<div class="form-group">';
				$output .= "<input ".$checked." type='radio' name='time' id='time".$time."' value='".$time."' />";
				$output .= "<label for='time".$time."' style='margin-left:10px;margin-bottom:10px;'>".$time."</label>";
				$output .= '</div>';
			}else{
				$output .= '<div class="form-group">';
				$output .= "<label  style='margin-left:10px;margin-bottom:10px;text-decoration:line-through;color:#153D28;' title='Time not available;'>".$time."</label>";
				$output .= '</div>';
			}
			$x++;
		}
		$result['output'] = $output;
	}
	elseif($action == "saveAppointment"){
		$eventDate = $_POST['eventDate'];
		$appointmentDate = $_POST['appointmentDate'];
		$eventType = $_POST['eventType'];
		$time = $_POST['time'];
		$place = $_POST['place'];
		$fullname = $_POST['fullname'];
		$email = $_POST['email'];
		$contact = $_POST['contact'];
		$address = $db->escape_string(trim($_POST['address']));

		$sql = "INSERT INTO appointments (Event,EventDate,AppointmentDate,AppointmentTime,AppointmentPlace,FullName,Email,Contact,Address,DateTimeAdded)
		VALUES ('".$eventType."','".$eventDate."','".$appointmentDate."','".$time."','".$place."','".$fullname."','".$email."','".$contact."','".$address."','".date('Y-m-d H:i:s')."')
		";

		$process = $db->query($sql);
		if($process){
			$result['success'] = true;
		}else{
			$result['success'] = false;
			$result['msg'] = "Something went wrong. Please try again later.";
		}
	}
	elseif($action == "approveAppointment"){
		$id = $_POST['id'];

		$sql = "SELECT appointments.*,events.Event as eventName,events.Status as eventStatus,places.Place FROM appointments 
        	JOIN events ON events.ID = appointments.Event 
        	JOIN places ON places.ID = appointments.AppointmentPlace WHERE appointments.ID = ".$id;
    	$process = $db->query($sql);
    	$info = $process->fetch_assoc();



    	$update = "UPDATE appointments set Status = 'Approved' WHERE ID = ".$id;
    	$processUpdate = $db->query($update);
    	if($processUpdate){
    		$recipient = $info['Email'];
			$subject = "Appointment Approved";

			$html = "Good Day ".$info['FullName']."<br/>";
			$html .= "<p>Thank you for taking time to set an appointment with us. We're glad to inform you that your appointment was approved!<br/> Please see details below</p>";

			$html .= "<table>
				<tr>
					<td>Event:</td>
					<td>".$info['eventName']."</td>
				</tr>
				<tr>
					<td>Event Date:</td>
					<td>".date('M d, Y',strtotime($info['EventDate']))."</td>
				</tr>
				<tr>
					<td>Appointment Information:</td>
					<td>".date('M d, Y',strtotime($info['AppointmentDate']))." - ".$info['AppointmentTime']."<br/><small>(".$info['Place'].")</small></td>
				</tr>
				<tr>
					<td>Appointment Status:</td>
					<td>APPROVED</td>
				</tr>
			</table>";

			$html .= "<br/><p>We're excited to be part of your wonderful event. <br/>See you soon!</p>";

			$scriptUrl = "https://script.google.com/macros/s/AKfycbyL8Cx4ani95yDgOR06ZBajmQILAuy4PsSgvCPiT2bG4KLasQGbauiGF82MEis4cX0oJg/exec";

			$data = array(
			   "recipient" => $recipient,
			   "subject" => $subject,
			   "body" => $html,
			   "isHTML" => 'true'
			);

			$ch = curl_init($scriptUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$emailsend = curl_exec($ch);

			$result['success'] = $emailsend;
    	}else{
    		$result['success'] = false;
    		$result['msg'] = $update;
    	}
	}
	elseif($action == "declineAppointment"){
		$id = $_POST['id'];
		$reason = $db->escape_string(trim($_POST['reason']));

		$sql = "SELECT appointments.*,events.Event as eventName,events.Status as eventStatus,places.Place FROM appointments 
        	JOIN events ON events.ID = appointments.Event 
        	JOIN places ON places.ID = appointments.AppointmentPlace WHERE appointments.ID = ".$id;
    	$process = $db->query($sql);
    	$info = $process->fetch_assoc();

		$update = "UPDATE appointments set Status = 'Declined', DeclineReason = '".$reason."'";
		$process = $db->query($update);
		if($process){
			$recipient = $info['Email'];
			$subject = "Appointment Declined";

			$html = "Good Day ".$info['FullName']."<br/>";
			$html .= "<p>Thank you for taking time to set an appointment with us. We're sorry, unfortunately your appointment was declined.<br/> Please see details below</p>";

			$html .= "<table>
				<tr>
					<td>Event:</td>
					<td>".$info['eventName']."</td>
				</tr>
				<tr>
					<td>Event Date:</td>
					<td>".date('M d, Y',strtotime($info['EventDate']))."</td>
				</tr>
				<tr>
					<td>Appointment Information:</td>
					<td>".date('M d, Y',strtotime($info['AppointmentDate']))." - ".$info['AppointmentTime']."<br/><small>(".$info['Place'].")</small></td>
				</tr>
				<tr>
					<td>Appointment Status:</td>
					<td>Declined</td>
				</tr>
				<tr>
					<td>Reason:</td>
					<td>".$reason."</td>
				</tr>
			</table>";

			$html .= "<br/><p>Once again, thank you for your time</p>";

			$scriptUrl = "https://script.google.com/macros/s/AKfycbyL8Cx4ani95yDgOR06ZBajmQILAuy4PsSgvCPiT2bG4KLasQGbauiGF82MEis4cX0oJg/exec";

			$data = array(
			   "recipient" => $recipient,
			   "subject" => $subject,
			   "body" => $html,
			   "isHTML" => 'true'
			);

			$ch = curl_init($scriptUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$emailsend = curl_exec($ch);

			$result['success'] = $emailsend;
		}else{
    		$result['success'] = false;
    		$result['msg'] = $update;
    	}
	}
	elseif($action == "viewAppointment"){
		$id = $_POST['id'];
		$output = "";
		$sql = "SELECT appointments.*,events.Event as eventName,events.Status as eventStatus,places.Place FROM appointments 
        	JOIN events ON events.ID = appointments.Event 
        	JOIN places ON places.ID = appointments.AppointmentPlace WHERE appointments.ID = ".$id;
    	$process = $db->query($sql);
    	$info = $process->fetch_assoc();

    	$status = "";
		if($info['Status'] == "Pending") { $status = "<span class='badge bg-warning'>Pending</span>";}
		if($info['Status'] == "Approved") { $status = "<span class='badge bg-info'>Approved</span>";}
		if($info['Status'] == "Declined") { $status = "<span class='badge bg-danger'>Declined</span>";}
		if($info['Status'] == "EventBooked") { $status = "<span class='badge bg-info'>Date Booked</span>";}
		if($info['Status'] == "EventCancelled") { $status = "<span class='badge bg-danger'>Cancelled</span>";}
		if($info['Status'] == "Done") { $status = "<span class='badge bg-success'>Done</span>";}

    	$output .= "<div class='table-responsive'>";
    		$output .= "<table class='table table-bordered'>";
    			$output .= 
				"<tr>
					<td>Name</td>
					<td>".$info['FullName']."</td>
				</tr>";
    			$output .= 
				"<tr>
					<td>Email</td>
					<td>".$info['Email']."</td>
				</tr>";
    			$output .= 
				"<tr>
					<td>Contact</td>
					<td>".$info['Contact']."</td>
				</tr>";
    			$output .= 
				"<tr>
					<td>Event</td>
					<td>".$info['eventName']."</td>
				</tr>";
    			$output .= 
				"<tr>
					<td>Event Date</td>
					<td>".date('M d, Y',strtotime($info['EventDate']))."</td>
				</tr>";
    			$output .= 
				"<tr>
					<td>Appointment</td>
					<td>".date('M d, Y',strtotime($info['AppointmentDate']))." - ".$info['AppointmentTime']."<br/><small>(".$info['Place'].")</small></td>
				</tr>";
    			$output .= 
				"<tr>
					<td>Status</td>
					<td>".$status."</td>
				</tr>";
    		$output .= "</table>";
    	$output .= "</div>";
    	$result['output'] = $output;
	}
	elseif($action == "bookedEvent"){
		$id = $_POST['id'];

		$sql = "SELECT appointments.*,events.Event as eventName,events.Status as eventStatus,places.Place FROM appointments 
        	JOIN events ON events.ID = appointments.Event 
        	JOIN places ON places.ID = appointments.AppointmentPlace WHERE appointments.ID = ".$id;
    	$process = $db->query($sql);
    	$info = $process->fetch_assoc();


    	$update = "UPDATE appointments set Status = 'EventBooked' WHERE ID = ".$id;
    	$processUpdate = $db->query($update);
    	if($processUpdate){
    		$recipient = $info['Email'];
			$subject = "Booking Approved";

			$html = "Good Day ".$info['FullName']."<br/>";
			$html .= "<p>We appreciate you taking the time to speak with us about your special event. Your event date was now reserved for you! Kindly see the details below</p>";

			$html .= "<table>
				<tr>
					<td>Event:</td>
					<td>".$info['eventName']."</td>
				</tr>
				<tr>
					<td>Event Date:</td>
					<td>".date('M d, Y',strtotime($info['EventDate']))."</td>
				</tr>
				<tr>
					<td>Appointment Information:</td>
					<td>".date('M d, Y',strtotime($info['AppointmentDate']))." - ".$info['AppointmentTime']."<br/><small>(".$info['Place'].")</small></td>
				</tr>
				<tr>
					<td>Appointment Status:</td>
					<td>EVENT BOOKED</td>
				</tr>
			</table>";

			$html .= "<br/><p>Thank you for trusting us to manage your wonderful event. <br/>See you soon!</p>";

			$scriptUrl = "https://script.google.com/macros/s/AKfycbyL8Cx4ani95yDgOR06ZBajmQILAuy4PsSgvCPiT2bG4KLasQGbauiGF82MEis4cX0oJg/exec";

			$data = array(
			   "recipient" => $recipient,
			   "subject" => $subject,
			   "body" => $html,
			   "isHTML" => 'true'
			);

			$ch = curl_init($scriptUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$emailsend = curl_exec($ch);

			$result['success'] = $emailsend;
    	}else{
    		$result['success'] = false;
    		$result['msg'] = $update;
    	}
	}
	elseif($action == "cancelBooking"){
		$id = $_POST['id'];

    	$update = "UPDATE appointments set Status = 'EventCancelled' WHERE ID = ".$id;
    	$processUpdate = $db->query($update);
    	if($processUpdate){
			$result['success'] = true;
    	}else{
    		$result['success'] = false;
    		$result['msg'] = $update;
    	}
	}
	elseif($action == "bookedDates"){
		$bookedDates = array();
		$sql = "SELECT * FROM appointments WHERE Status = 'EventBooked' ";
		$process = $db->query($sql);
		if($process->num_rows > 0){
			while($result = $process->fetch_assoc()){
				$bookedDates[] = $result['EventDate'];
			}
		}

		$result['bookedDates'] = $bookedDates;
	}
	elseif($action == "bookedDatesCalendar"){
		$events = array();
		$sql = "SELECT appointments.*,events.Event as eventName,events.ID as eventID FROM appointments JOIN events ON appointments.Event = events.ID WHERE appointments.Status = 'EventBooked' ";
		$process = $db->query($sql);
		if($process->num_rows > 0){
			while($result = $process->fetch_assoc()){
				$events[] = array('id' => $result['ID'],'title' => $result['eventName'],'start' => $result['EventDate']);
			}
		}

		$result['events'] = $events;
	}
	elseif($action == "appointmentsToday"){
		$output = "";
		$output = "<br/>";

		$sql = "SELECT appointments.*,events.Event as eventName,events.ID as eventID FROM appointments JOIN events ON appointments.Event = events.ID WHERE appointments.Status = 'Approved' AND appointments.AppointmentDate = '".date('Y-m-d')."' ";
		$process = $db->query($sql);
		if($process->num_rows > 0){
			$output .= "<ul>";
			while($row = $process->fetch_assoc()){
				$output .= "<li>";
					$output .= "<b>".$row['AppointmentTime']."</b> (".$row['eventName'].")<br/><small>".$row['FullName']." ".$row['Contact']."</small>";
				$output .= "</li>";
			}
			$output .= '</ul>';
		}else{
			$output .= "<h4>No appointment today.</h4>";
		}

		$result['output'] = $output;
	}
	elseif($action == "eventsToday"){
		$output = "";
		$output = "<br/>";

		$sql = "SELECT appointments.*,events.Event as eventName,events.ID as eventID FROM appointments JOIN events ON appointments.Event = events.ID WHERE appointments.Status = 'EventBooked' AND appointments.EventDate = '".date('Y-m-d')."' ";
		$process = $db->query($sql);
		if($process->num_rows > 0){
			$output .= "<ul>";
			while($row = $process->fetch_assoc()){
				$output .= "<li>";
					$output .= "<b>".$row['AppointmentTime']."</b> (".$row['eventName'].")<br/><small>".$row['FullName']." ".$row['Contact']."</small>";
				$output .= "</li>";
			}
			$output .= '</ul>';
		}else{
			$output .= "<h4>No event today.</h4>";
		}

		$result['output'] = $output;
	}
	elseif($action == "markAsDone"){
		$id = $_POST['id'];


		$sql = "SELECT appointments.*,events.Event as eventName,events.Status as eventStatus,places.Place FROM appointments 
        	JOIN events ON events.ID = appointments.Event 
        	JOIN places ON places.ID = appointments.AppointmentPlace WHERE appointments.ID = ".$id;
    	$process = $db->query($sql);
    	$info = $process->fetch_assoc();

		$update = "UPDATE appointments set Status = 'Done' WHERE ID = ".$id;
		$process = $db->query($update);
		if($process){
			$recipient = $info['Email'];

			$link = $base."feedback-form.php?eid=".base64_encode($recipient);


			$subject = "Feedback Form";

			$html = "Good Day ".$info['FullName']."<br/>";
			$html .= "<p>Thank you for trusting us to be your coordinator. That was a great experience and a wonderful event! We would like you to have your feedback with our service.<br/> Kindly visit the link below to submit your feedback.</p>";

			$html .= "<a href='".$link."' target='_blank'>Go to Feedback form</a>";
			$html .= "<br/><br/>Once again, Thank you and see you again!";


			$scriptUrl = "https://script.google.com/macros/s/AKfycbyL8Cx4ani95yDgOR06ZBajmQILAuy4PsSgvCPiT2bG4KLasQGbauiGF82MEis4cX0oJg/exec";

			$data = array(
			   "recipient" => $recipient,
			   "subject" => $subject,
			   "body" => $html,
			   "isHTML" => 'true'
			);

			$ch = curl_init($scriptUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$emailsend = curl_exec($ch);

			$result['success'] = $emailsend;
		}else{
    		$result['success'] = false;
    		$result['msg'] = $update;
    	}
	}
	elseif($action == "showFeedback"){
		$id = $_POST['id'];

    	$update = "UPDATE feedbacks set Status = 1 WHERE ID = ".$id;
    	$processUpdate = $db->query($update);
    	if($processUpdate){
			$result['success'] = true;
    	}else{
    		$result['success'] = false;
    		$result['msg'] = $update;
    	}
	}
	elseif($action == "hideFeedback"){
		$id = $_POST['id'];

    	$update = "UPDATE feedbacks set Status = 0 WHERE ID = ".$id;
    	$processUpdate = $db->query($update);
    	if($processUpdate){
			$result['success'] = true;
    	}else{
    		$result['success'] = false;
    		$result['msg'] = $update;
    	}
	}
	
	echo json_encode($result);
}