<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";
	if(!($user = Login::checkUser()["user_id"])) return;
	
	if( isset( $_POST["text"] ) ) {
		if( isset( $_POST["comment"] ) ) {
            if( !($c = new Comment( $_POST["comment"] ) ) ) return false;
            if( $c->owner == $user ) $c->editComment( $c->id, $_POST["text"] );
		}
	}
?>
