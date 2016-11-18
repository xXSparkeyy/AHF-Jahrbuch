<?php
	$s = new Survey( SURVEY, Login::checkUser()["user_id"] );
	if( SURVEYEDIT ) echo '<form method="POST" action="/Surveys/setValues.php" id="editform">';
?>
<div class="container" action="#">
<div class="row">
<h1 class="center s12 l8 offset-l2"><?php if( SURVEYEDIT ) echo "<input type='text' name='title' value='".$s->getTitle()."'>"; else echo $s->getTitle(); if( !SURVEYEDIT && Login::isAdmin(Login::checkUser()) ) echo '<a href="edit/" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">edit</i></a>'?></h1>
<h5 class="center s12 l8 offset-l2"><?php if( SURVEYEDIT ) echo "<input type='text' name='desc'  value='".$s->getDescription()."'>"; else echo $s->getDescription(); ?></h5>
<br><br><br><br><br>
<?php
	if( SURVEYEDIT ) {
		echo "<p class='center green-text lighten-1'>Leave blank to delete</p><script>
				function save() {
					document.getElementById('editform').submit();
				}
				function add() {
					var o = document.createElement('div');
					document.getElementById('questions').insertBefore( o, document.getElementById('questions').childNodes[0]);
					o.outerHTML = \"<div class='col card-panel grey lighten-5 z-depth-1 s12 l8 offset-l2'><h4><input name='new[]' type='text' value=''></h4></div>\";
				}
			</script>";
		echo '<ul><li><a href="javascript:add()" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
			  <a href="javascript:save()" class="btn-floating btn-large waves-effect waves-light orange"><i class="material-icons">save</i></a>
			  <a href="/Surveys/'.SURVEY.'/" class="btn-floating btn-large waves-effect waves-light blue"><i class="material-icons">list</i></a></li></ul>
		<input type="hidden" value="'.SURVEY.'" name="survey_id"><input id="muckefuck" type="checkbox" name="visib" '.($s->isPublic()?"checked":"").'><label style="margin-right: 1%" for="muckefuck">Öffentlich</label><div id="questions">';
	}
	foreach( ($s->getQuestions()) as $question ) {
		$id     = $question["question_id"];
		$title  = $question["question_title"];
		$votes  = $question["votes"]?$question["votes"]:0;
		$myvote = $question["myvote"];
		$up = $myvote==1 ?"light-green-text":"";
		$down = $myvote==-1?"red-text darken-2":"";
		if( SURVEYEDIT ) echo "<div class='col card-panel grey lighten-5 z-depth-1 s12 l8 offset-l2'><h4><input name='$id' type='text' value='$title'></h4></div>";
		else echo "<div class='col card-panel grey lighten-5 z-depth-1 s12 l8 offset-l2'><h4><span style='float: right'>$votes<a href='?$id-up' style='font-size: inherit' class='material-icons $up'>expand_less</a><a href='?$id-down' style='font-size: inherit' class='material-icons $down'>expand_more</a></span>$title</h4></div>";
	}
	if( SURVEYEDIT ) echo "</div></form>";
?>
</pre>
</div>
</div>
