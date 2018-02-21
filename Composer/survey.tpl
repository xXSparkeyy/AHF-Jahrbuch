<?php
	$s = new Survey( SURVEY, $login_user["user_id"] );
	$survey_id = $s->getID();
	if( SURVEYEDIT ) echo '<form method="POST" action="/Surveys/setValues.php" id="editform">';
?>
<div class="container" action="#">
<div class="row">
<h1 class="center s12 l8 offset-l2"><?php if( SURVEYEDIT ) echo "<input type='text' name='title' value='".$s->getTitle()."'>"; else echo $s->getTitle();?></h1>
<h5 class="center s12 l8 offset-l2">- <?php if( SURVEYEDIT ) echo "<input type='text' name='desc'  value='".$s->getDescription()."'>"; else echo $s->getDescription(); ?> -</h5>
<?php
if( !SURVEYEDIT && Login::isAdmin( $login_user["user_id"] ) ) {
		echo '<ul><li><a href="#deletegroup" class="modal-trigger btn-floating btn-large waves-effect waves-light red"><i class="material-icons">delete</i></a>
			  <a href="edit/" class="btn-floating btn-large waves-effect waves-light orange"><i class="material-icons">edit</i></a></li></ul>';
	}
?>
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
		echo '<ul><li><a href="/Surveys" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">undo</i></a>';
        if( !$s->getQuestionGroup() ) echo '<a href="javascript:add()" class="btn-floating btn-large waves-effect waves-light green"><i class="material-icons">add</i></a>';
		echo '	  <a href="javascript:save()" class="btn-floating btn-large waves-effect waves-light orange"><i class="material-icons">save</i></a>
			  <a href="/Surveys/'.SURVEY.'/" class="btn-floating btn-large waves-effect waves-light blue"><i class="material-icons">list</i></a><a href="#deletegroup" class="modal-trigger btn-floating btn-large waves-effect waves-light red"><i class="material-icons">delete</i></a></li></ul>
		<input type="hidden" value="'.SURVEY.'" name="survey_id"><input id="muckefuck" type="checkbox" name="flag[]" value="1" '.($s->isPublic()?"checked":"").'><label style="margin-right: 1%" for="muckefuck">Öffentlich</label><input id="muckefuck1" type="checkbox" name="flag[]" value="2" '.($s->isVotePublic()?"checked":"").'><label style="margin-right: 1%" for="muckefuck1">Ergebnis Sichtbar</label><input id="muckefuck2" type="checkbox" value="4" name="flag[]" '.($s->isVoteable()?"checked":"").'><label style="margin-right: 1%" for="muckefuck2">Abstimmen möglich</label><input id="muckefuck3" type="checkbox" value="8" name="flag[]" '.($s->isDownVoteable()?"checked":"").'><label style="margin-right: 1%" for="muckefuck3">Downvotes möglich</label>';
	}
    if( !($s->getQuestionGroup() && SURVEYEDIT) ) {
	echo '<div id="questions">';
	foreach( ($s->getQuestions()) as $question ) {
		$id     = $question["question_id"];
		$title  = $question["question_title"];
		$votes  = $question["votes"]?$question["votes"]:0;
		$myvote = $question["myvote"];
		$up = $myvote==1 ?"light-green-text":"";
		$down = $myvote==-1?"red-text":"";
		if( SURVEYEDIT ) echo "<div class='col card-panel grey lighten-5 z-depth-1 s12 l8 offset-l2'><h4><input name='$id' type='text' value='$title'></h4></div>";
		else { ?>
			<div id="<?php echo $id; ?>" class='col card-panel grey lighten-5 z-depth-1 s12 l8 offset-l2'>
				<h4>
					<span style='float: right'>
						<?php if( $s->isVotePublic() || Login::isAdmin($login_user["user_id"]) ) echo "<span id='votes_$id' class='votes'>$votes</span>";?>
						<?php if( $s->isVoteable()  ) echo "<a id='up_$id' href='javascript:vote(\"$id\",1)' style='font-size: inherit' class='material-icons $up'>expand_less</a><a id='down_$id' href='javascript:vote(\"$id\",-1)' style='font-size: inherit' class='material-icons $down'>expand_more</a>";?>
					</span>
					<?php echo $title; ?>
				</h4>
			</div>
	<?php }
	}
    }
	else {
    $groups = Group::getGroups(); array_unshift( $groups, array("group_id"=>"*", "name"=>"Alle", "description"=>"") );
    ?>
					<div id="groups" class="col s12">
						<ul>
							<?php

								foreach( $groups as $itm ) {
									$name = $itm['name'];
									$desc = $itm['description'];
									$id = $itm['group_id'];
									?><li class='card-panel'>
                                        <input name="group" value="<?php echo $id; ?>" type="radio" id="seff<?php echo $id; ?>" <?php if( $id == $s->getQuestionGroup() ) echo "checked" ?> />
                                        <label style="margin-right: 1%" for="seff<?php echo $id; ?>"><?php echo $name; ?></label><?php
								}
								?>
                       </ul>
    <?php
    }
	if( SURVEYEDIT ) echo "</div></form>";
if( Login::isAdmin($login_user["user_id"])  ) {?>

  <div id="deletegroup" class="modal">
	<div class="modal-content">
		<h4>Are you sure?</h4>
	</div>
	<div class="modal-footer">
	  <a href="/Surveys/<?php echo SURVEY; ?>/delete/" class="modal-action waves-effect waves-green btn-flat ">Delete</a>
	  <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancel</a>
	</div>
  </div>
  <?php } ?>
</div>
<script>
	function vote( question, value ) {
		var x = new XMLHttpRequest()
		x.open( "GET", "/api/vote?value="+value+"&question="+question )
		x.onreadystatechange = function () {
			if( x.readyState != 4 ) return
			var r = JSON.parse( x.responseText )
            console.log( r.question, x );
			if( r ) {
				document.getElementById( "votes_"+r.question ).innerText = r.votes
					document.getElementById( "up_"+r.question   ).setAttribute( "class", r.ownvote ==  1? "material-icons light-green-text":"material-icons" )
					document.getElementById( "down_"+r.question ).setAttribute( "class", r.ownvote == -1? "material-icons red-text":"material-icons" )
			}
			<?php if( $s->isVotePublic() ) {?>
			var questions = document.getElementById( "questions" )
			var o = document.getElementById( r.question ).cloneNode(true)
			document.getElementById( r.question ).remove()
			for( i = 0; i < questions.children.length; i++ ) {
				e = questions.children[i]
				if( e.getElementsByClassName( "votes" ).length > 0 ) if( e.getElementsByClassName( "votes" )[0].innerText*1 < r.votes*1 ) {
					questions.insertBefore( o, e )
					return
				}
			}
			questions.appendChild( o )
			<?php } ?>
		}
		x.send();
	}
</script>
</div>
</div>
