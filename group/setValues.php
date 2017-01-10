<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";
	if( count( $_POST ) > 0 ) {
		$usr = Login::checkUser()["user_id"];
		$g = isset($_POST["group"])?$_POST["group"]:"";
		//if( Group::isMod($g, $usr) ) {
		if( Login::isAdmin($usr) ) {
			if( isset($_POST["newgroup"]) && isset($_POST["name"]) && isset($_POST["desc"]) ) {
				$g = Group::addGroup( $_POST["name"], $_POST["desc"] );
				if( $g ) {
					$id = $g->getID();
					Log::msg( "Groups", "$usr created Group ".$g->getName() );
					http_response_code( 302 );
					header( "Location: /group/$id/" );
					return;
				}
			}
			if( $g != "" && isset($_POST["changegroup"]) && isset($_POST["name"]) && isset($_POST["desc"]) ) {
				$gr = new Group( $g );
				$o = $gr->getName();
				$gr->setMeta( $_POST["name"], $_POST["desc"] );
				Log::msg( "Groups", "$usr changed Group $o to ".$gr->getName() );
				http_response_code( 302 );
				header( "Location: /group/$g/" );
				return;
			} 
			if( $g != "" && isset($_POST["deletegroup"]) ) {
				$gr = new Group( $g );
				$gr->removeGroup();
				Log::msg( "Groups", "$usr deleted Group ".$gr->getName() );
				http_response_code( 302 );
				header( "Location: /" );
				return;
			}                       

		}
	}
	http_response_code( 302 );
	header( "Location: /profile/me/" );
?>
