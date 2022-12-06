<?php
include("db.php");

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

		$staticTime = array('8:00am-10:00am','10:00am-12:00am','01:00pm-03:00pm','03:00pm-05:00pm');

		foreach($staticTime as $time){

			if(!in_array($time, $takenArray)){
				$output .= '<div class="form-group">';
				$output .= "<input type='radio' name='time' id='time".$time."' value='".$time."' />";
				$output .= "<label for='time".$time."' style='margin-left:10px;margin-bottom:10px;'>".$time."</label>";
				$output .= '</div>';
			}else{
				$output .= '<div class="form-group">';
				$output .= "<label  style='margin-left:10px;margin-bottom:10px;text-decoration:line-through;color:#153D28;' title='Time not available;'>".$time."</label>";
				$output .= '</div>';
			}
		}
		$result['output'] = $output;
	}
	echo json_encode($result);
}