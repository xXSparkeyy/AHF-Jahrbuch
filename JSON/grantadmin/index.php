<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";
	$usr = Login::checkUser()["user_id"];
	if( isset($_GET["user"]) && isset($_GET["user"]) ) {
		$user = $_GET["user"];
		$group = $_GET["group"];
		if( Group::isMod( $usr ) ) {
			echo !Group::grantMod( $usr, $user, $group )?"true":"false";
		}
	}
	return false;
?>
