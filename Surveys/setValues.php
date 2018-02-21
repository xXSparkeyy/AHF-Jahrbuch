<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";
	ini_set( "display_errors", "1" );
	$usr = Login::checkUser()["user_id"];
	if( isset($_POST["addSurvey"]) ) {
		$s = Survey::createSurvey( "New Survey", "Looks like some pretty nice space, why not insert a description here?" );
		http_response_code( 302 );
		header( "Location: /Surveys/".$s->getID()."/edit/" );
		Log::msg( "Survey", "$usr added a Survey" );
		return;
	}
    if( isset($_POST["addUserSurvey"]) ) {
		$s = Survey::createSurvey( "New Survey", "Looks like some pretty nice space, why not insert a description here?", "*" );
		http_response_code( 302 );
		header( "Location: /Surveys/".$s->getID()."/edit/" );
		Log::msg( "Survey", "$usr added a Survey" );
		return;
	}
	if( count( $_POST ) > 0 && Login::isAdmin($usr ) ) {
		$sid = $_POST["survey_id"];
		$survey = new Survey( $sid );
		$title= "";
		$desc = "";
		$visib= 0;
        $gp = "";
		foreach( $_POST as $id => $value ) {
			if( $id == "survey_id" ) { continue; }
			if( $id == "title" ) { $title = $value; continue; }
			if( $id == "desc"  ) { $desc  = $value; continue; }
            if( $id == "group" ) { $gp    = $value; continue; }
			if( $id == "flag" ) { foreach( $value as $i ) { $visib+=$i; } continue; }
			if( $id == "new"   ) {
				foreach( $value as $t ) {
					if( $t != "" ) $survey->addQuestion( $t );
				}
				continue;
			}
			if( $value == "" ) {
				$survey->removeQuestion($id);
				continue;
			}
			$survey->editQuestion($id,$value);
		}
		$survey->setMeta( $title, $desc, $visib, $gp );
		Log::msg( "Survey", "$usr edited Survey $sid" );
	}
	http_response_code( 302 );
	header( "Location: /Surveys/".$_POST["survey_id"]."/edit/" );
?>
