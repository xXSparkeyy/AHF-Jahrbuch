<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";
	if(!($usr = Login::checkUser()["user_id"])) return;
	if( isset($_GET["image"]) ) {
		$group = $_GET["group"];
		if( Group::isMod( $group, $usr ) ) {
			unlink($_SERVER["DOCUMENT_ROOT"].$_GET["image"]);
		}
	}
	echo "false";
?>
