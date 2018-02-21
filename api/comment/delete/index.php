<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";
	if(!($user = Login::checkUser()["user_id"])) return;
	if( isset( $_POST["comment"] ) ) {
        if( !($c = new Comment( $_POST["comment"] ) ) ) return false;
        if( $c->findRoot( $c->id ) == $user || $c->owner == $user ) $c->deleteWithChildren( $c->id );
	}
?>
