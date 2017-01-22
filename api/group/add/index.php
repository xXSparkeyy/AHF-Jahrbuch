<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";
	$usr = Login::checkUser()["user_id"];
	if( isset($_GET["user"]) && isset($_GET["user"]) ) {
		$user = $_GET["user"];
		$group = $_GET["group"];
		if( Group::isMod( $group, $usr ) ) {
			$u = Group::_addMember( $user, $group );
			if( $u ) {
				echo json_encode( array("name"=>$u->getFirstName()." ".$u->getLastName(), "img"=>$u->getAvatar() ) );
				return;
			}
		}
	}
	echo "false";
?>
