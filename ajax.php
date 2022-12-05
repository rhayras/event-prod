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
	echo json_encode($result);
}