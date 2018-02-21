<?php require_once( $_SERVER["DOCUMENT_ROOT"]."/Core/index.php" );
	$u = Login::checkUser();
	if( !$u ) {
		header( "Location: /Signin" );
	}
    if( !Login::isAdmin($u["user_id"]) ) {
        header( "Location: /profile/".$u["user_id"] );
    }
	else {
		define( "CMSLOADSUBTPL", "tanmngr.tpl" );
		if( isset( $_POST["list"] ) ) {
            $data = explode( "\n", $_POST["list"] );
            $list = [];
            foreach( $data as $e ) {
                $fname = explode(" ", $e );
                $lname = str_replace( "\t", "", $fname[1] );
                $fname = str_replace( "\t", "", $fname[0] );
                $list[] = [ "firstname"=>$fname, "lastname"=>$lname ];
            }
            Registration::createTans( $list );
            header( "Location: ." );
            exit;
        }

		
		require_once( $_SERVER["DOCUMENT_ROOT"]."/Composer/composer.tpl" );
	}
?>
