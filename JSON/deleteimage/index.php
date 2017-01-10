<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";
	$usr = Login::checkUser()["user_id"];
	if( isset($_GET["image"]) ) {
		$group = $_GET["group"];
		if( Group::isMod( $group, $usr ) ) {
			unlink($_SERVER["DOCUMENT_ROOT"]."/media-upload/data/$group/".$_GET["image"]);
		}
	}
	echo "false";
?>
