<?php require_once( $_SERVER["DOCUMENT_ROOT"]."/Core/index.php" );
	$u = Login::checkUser();
	if( $u ) {
		header( "Location: /profile/".$u["user_id"] );
	}
	else {
		define( "CMSLOADSUBTPL", "register.tpl" );
		if( $_POST["user_name"] && $_POST["user_pw"] ) {
			$l = new Registration();
			$l->register( $_POST["user_name"], $_POST["user_pw"] );
			if( !$l->getError() ) {
				$usr = $l->user;
				$log( "Profile", "$usr joined" );
				header( "Location: /profile/$usr/edit/" );
				break;
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
