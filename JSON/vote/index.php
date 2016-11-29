<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";

if( $user = Login::checkUser()["user_id"] ) {
	$question = $_GET["question"];
	$value = $_GET["value"];
	echo json_encode( Survey::vote( $question,$user,$value ) );
	return;
}
echo "false";
?>
