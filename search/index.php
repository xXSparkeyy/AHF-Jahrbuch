<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/login.php";
	$user = Login::checkUser();
	if( !$user ) {
		http_response_code( 302 );
		header( "Location: /Signin/");
		return;
	}
	define( "CMSLOADSUBTPL", "searchresult.tpl" );
	require_once $_SERVER["DOCUMENT_ROOT"]."/Composer/composer.tpl";
?>
