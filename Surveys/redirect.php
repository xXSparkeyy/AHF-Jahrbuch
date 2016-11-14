<?php require_once( $_SERVER["DOCUMENT_ROOT"]."/Core/index.php" );
	$user = Login::checkUser();
	if( !$user ) {
		http_response_code( 303 );
		header( "Location: /Signin/");
	} else {
		$user = $user["user_id"];
		if( substr(explode( "?",$_SERVER['REQUEST_URI'] )[0], -1) != "/"  ) {
			http_response_code( 301 );
			header( "Location: ".$_SERVER['REQUEST_URI']."/");
		}
		else {
			$url = explode( "/", explode( "?",$_SERVER['REQUEST_URI'] )[0] );
			$s = Survey::getSurvey( $url[2] );
			if( !$s->isPublic() && !Login::isAdmin($user) ) {
					http_response_code( 303 );
					header( "Location: /Surveys/");
					return;
			}
			$arg = explode( "-", parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY ) );
			if( count( $arg ) == 2 ) {
				$vote = $arg[1]=="up"?1:($arg[1]=="down"?-1:0);
				Survey::vote( $arg[0]*1,$user,$vote );
				http_response_code( 303 );
				header( "Location: /Surveys/".$url[2]);
				return;
			}
			if( $url[3] == "edit" ) {
				if( !Login::isAdmin($user) ) {
					http_response_code( 303 );
					header( "Location: /Surveys/".$url[2] );
					return;
				}
				   define( "SURVEYEDIT", true );
			} else define( "SURVEYEDIT", false );
			$sur = $url[2];
			http_response_code( 200 );
			define( "CMSLOADSUBTPL", "survey.tpl" );
			define( "SURVEY", $sur );
			require_once $_SERVER["DOCUMENT_ROOT"]."/Composer/composer.tpl";
			}
		}

?>
