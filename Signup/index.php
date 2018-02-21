<?php require_once( $_SERVER["DOCUMENT_ROOT"]."/Core/index.php" );
	$u = Login::checkUser();
	if( $u ) {
		header( "Location: /profile/".$u["user_id"] );
	}
	else {
		define( "CMSLOADSUBTPL", "register.tpl" );
		if( isset($_POST["user_tan"]) && isset($_POST["user_pw"]) )
            if( strlen( $_POST["user_pw"] ) < 6 )
                define( "REGISTERERROR", "Passwort zu kurz" );
            else {
			$l = new Registration();
			$l->register( $_POST["user_tan"], $_POST["user_pw"] );
			if( !$l->getError() ) {
                $login = new Login( $l->user, $_POST["user_pw"] );
				$usr = $l->user;
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
