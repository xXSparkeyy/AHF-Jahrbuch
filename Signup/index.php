<?php require_once( $_SERVER["DOCUMENT_ROOT"]."/Core/index.php" );
	$u = Login::checkUser();
	if( $u ) {
		header( "Location: /profile/".$u["user_id"] );
	}
	else {
		define( "CMSLOADSUBTPL", "register.tpl" );
		if( isset($_POST["user_name"]) && isset($_POST["user_pw"]) ) {
			$l = new Registration();
			$l->register( $_POST["user_name"], $_POST["user_pw"] );
			$login = new Login( $_POST["user_name"], $_POST["user_pw"] );
			if( !$l->getError() ) {
				$usr = $login->user;
				Log::msg( "Profile", "$usr joined" );
				header( "Location: /profile/$usr/edit/" );
				return;
			}
			else {
				define( "REGISTERERROR", $l->getErrorMessage() );
			}
		}
		else {
			define( "REGISTERERROR", false );
		}
		
		require_once( $_SERVER["DOCUMENT_ROOT"]."/Composer/composer.tpl" );
	}
?>
