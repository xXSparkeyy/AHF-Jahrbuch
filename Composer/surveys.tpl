<?php ?>
<h1 class="center">Umfragen</h1>
<div class="container" action="#">
<div class="row">
<?php
	$isAdmin = Login::isAdmin($login_user["user_id"]);
	foreach( (Survey::getSurveys(!$isAdmin)) as $survey ) {
		$id     = $survey["survey_meta_id"];
		$title  = $survey["survey_title"];
		$desc   = $survey["survey_description"];
		$visible= ($survey["flags"]["voteable"]?"":"<i class='material-icons'>lock</i>").($survey["flags"]["visible" ]?"":"<i class='material-icons'>visibility_off</i>");
		echo "<div class='col card-panel grey lighten-5 z-depth-1 s12 l8 offset-l2'><h2><a href='$id'>$visible $title</a></h2><p>$desc</p></div>";
	}
	if( $isAdmin ) echo "<form class='col s12 l8 offset-l2' method='post' action='/Surveys/setValues.php'><input class='btn green' type='submit' name='addSurvey' value='Neue Umfrage'><input class='btn green' type='submit' name='addUserSurvey' value='Neue Gruppen Umfrage'></form>";
?>
</div>
</div>
