<?php require_once( $_SERVER["DOCUMENT_ROOT"]."/Core/index.php" );
	$u = Login::checkUser();
	if( $u ) {
		header( "Location: /profile/".$u["user_id"] );
	}
	else {
		define( "CMSLOADSUBTPL", "login.tpl" );
		if( isset( $_POST["username"] ) && isset( $_POST["password"] ) ) {
			$l = new Login( $_POST["username"], $_POST["password"] );
			if( !$l->getError() ) {
				header( "Location: /profile/".$l->user );
				return;
			}
			else {
				define( "LOGINERROR", $l->getErrorMessage() );
			}
		}
		else {
			define( "LOGINERROR", false );
		}
		
		require_once( "../Composer/composer.tpl" );
	}
?>
