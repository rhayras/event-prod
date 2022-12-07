<?php


include('../db.php');


$date = date('Y-m-d',strtotime("+1 day"));
// echo $date;

$sql = "SELECT appointments.*,events.Event as eventName,events.Status as eventStatus,places.Place FROM appointments 
        	JOIN events ON events.ID = appointments.Event 
        	JOIN places ON places.ID = appointments.AppointmentPlace WHERE appointments.Status = 'Approved' AND appointments.AppointmentDate = '".$date."' ";
$process = $db->query($sql);
if($process->num_rows > 0){
	while($info = $process->fetch_assoc()){
		$recipient = $info['Email'];
		$subject = "Appointment Reminder";

		$html = "Good Day ".$info['FullName']."<br/>";
		$html .= "<p>We would like to remind you that you have appointment with us tomorrow. Please see the details below.</p>";

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

		$html .= "<br/><p>We're excited to be part of your wonderful event. <br/>See you!</p>";

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
	}
}
