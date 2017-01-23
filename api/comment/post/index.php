<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";
	if(!($user = Login::checkUser()["user_id"])) return;
	
	if( isset( $_POST["text"] ) ) {
		if( isset( $_POST["parent"] ) ) {
			$parent = explode( ":", $_POST["parent"] );
			if( $parent[0] == "comment" )
				echo Comment::answerComment( $user, $parent[1], $_POST["text"] );
			if( $parent[0] == "user" )
				echo Comment::writeComment ( $user, $parent[1], $_POST["text"] );
		}
	}
	http_response_code( 302 );
	header("Location: ".$_SERVER["HTTP_REFERER"]."#comments");
?>
