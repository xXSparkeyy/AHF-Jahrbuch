<?php require_once( $_SERVER["DOCUMENT_ROOT"]."/Core/index.php" );
	$user = Login::checkUser();
	if( !$user ) {
		http_response_code( 302 );
		header( "Location: /Signin/");
	} else {
		if( substr(explode( "?",$_SERVER['REQUEST_URI'] )[0], -1) != "/"  ) {
			http_response_code( 302 );
			header( "Location: ".$_SERVER['REQUEST_URI']."/");
		}
		else {
			$user = $user["user_id"];
			$url = explode( "/", explode( "?",$_SERVER['REQUEST_URI'] )[0] );
			if( $url[3] == "edit" ) {
				if( !Group::isMod( $user ) ) {
					http_response_code( 302 );
					header( "Location: /profile/".$usr[2] );
					return;
				}
				   define( "GROUPEDIT", true );
			} else define( "GROUPEDIT", false );
			
		
				http_response_code( 200 );
				define( "CMSLOADSUBTPL", "profile.tpl" );
				define( "GROUPUSR", $url[2] );
				require_once $_SERVER["DOCUMENT_ROOT"]."/Composer/composer.tpl";
			
		}
		
	}
?>
