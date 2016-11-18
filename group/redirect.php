<?php require_once( $_SERVER["DOCUMENT_ROOT"]."/Core/index.php" );
	$user = Login::checkUser();
	if( !$user ) {
		http_response_code( 302 );
		header( "Location: /Signin/");
	} else {
		$user = $user["user_id"];
		if( substr(explode( "?",$_SERVER['REQUEST_URI'] )[0], -1) != "/"  ) {
			http_response_code( 302 );
			header( "Location: ".$_SERVER['REQUEST_URI']."/");
		}
		else {
			$usr = explode( "/", explode( "?",$_SERVER['REQUEST_URI'] )[0] );
			if( $usr[3] == "edit" ) {
				if( $usr[2] != Login::checkUser()["user_id"] ) {
					http_response_code( 302 );
					header( "Location: /profile/".$usr[2] );
					return;
				}
				   define( "PROFILEEDIT", true );
			} else define( "PROFILEEDIT", false );
			
			$usr = $usr[2];
			if( $usr == "me" ) {
				http_response_code( 302 );
				header( "Location: /profile/$user/");
			} else {
		
				http_response_code( 200 );
				define( "CMSLOADSUBTPL", "profile.tpl" );
				define( "PROFILEUSR", $usr );
				require_once $_SERVER["DOCUMENT_ROOT"]."/Composer/composer.tpl";
			}
		}
		
	}
?>
