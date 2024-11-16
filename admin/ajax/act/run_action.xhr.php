<?php
if(isset($_GET)){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('admin_inc_path','session_check_nologout.inc.php'));
	$error = []; $data = [];
	
	// validating and sanitizing action doer
	if($adlevel != 3){$error[] = "empty";}
	
	if(empty($error)){
		//Run Action
		$misc = new misc('admin');
		$action = $misc->run_action();
		if($action === true){
			$data["status"] = 'success';$data["message"] = "Success!!!<br>Actions successfully ran";
			//INSERT LOG
			$log = new log('admin');
			$log->brief = 'action was ran';
			$log->details = "ran actions on database data";
			$log->insert_log();
		}elseif($action === false){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occured while running request, refresh page and try again";
		}
	}else{
		$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>You cannot perform this action";
	}
	echo json_encode($data);
}//end of if isset
?>