<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";
	if(!($usr = Login::checkUser()["user_id"])) return;
	if( isset($_GET["user"]) && isset($_GET["user"]) ) {
		$user = $_GET["user"];
		$group = $_GET["group"];
		if( Group::isMod( $group, $usr ) ) {
			echo Group::revokeMod( $usr, $user, $group )?"true":"false";
		}
	}
	return false;
?>
