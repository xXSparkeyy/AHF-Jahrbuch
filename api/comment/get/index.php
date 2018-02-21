<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";

function renderComments( $comments, $depth=0 ) {
	if( !$comments ) return;
	?>
	<?php
	$usr = Login::checkUser()["user_id"];
	foreach( $comments as $comment ) {
		$comment = new Comment( $comment["cid"] );
		$p = new Profile( $comment->owner );
		$title = "<a href='/profile/".$p->getID()."/'>".$p->getFirstName()." ".$p->getLastName()."</a>";
		$id = $comment->id;
		$text = $comment->text;
		?>
		<div class="comment_wrapper"><h7><?php echo $title;?></h7>
		<p id="<?php echo $comment->id; ?>_content"><?php echo $text;?></p><span class="float_r">
	<a class="modal-trigger" onclick="$('#editmode')[0].value = 0; $('#field_user')[0].value='comment:<?php echo $id;?>'" href="#writecomment">
		<i class="material-icons">reply</i>
	</a>
	<?php
		if($usr == $comment->owner || $usr == $comment->findRoot( $comment->id ) ){
	echo '<a class="material-icons modal-trigger" href="#deletegroup" onclick="$(\'#commdel\')[0].onclick=function(){deleteComment( '.$comment->id.' )}" >delete</a>';
	if($usr = Login::checkUser()["user_id"] == $comment->owner){
		echo '<a class="modal-trigger" href="#writecomment" onclick="$(\'#editmode\')[0].value = 1; $(\'#field_user\')[0].value=\''.$comment->id.'\'; $(\'#wfc\')[0].value = $(\'#'.$comment->id.'_content\')[0].innerText"><i class="material-icons">edit</i></a>';
}	
	echo '</span>';
}

		 $answers = Comment::getAnswers($comment->id); if(count($answers)>0) {?>
		<ul class="collapsible" data-collapsible="expandable">
		<li class="<?php echo ($depth % 2 == 0)?"crazy":"decent";?>-color itm">
		  <div class="collapsible-header"><i class="material-icons">&#xE315;</i> <?php echo count($answers); ?> Antworte(n)</div>
		  <div class="collapsible-body"><br>
		  	<?php renderComments($answers, $depth+1); ?>
		  </div>
		</li>
		</ul>
		<br>
		<?php }
		
	}
}
if(!($usr = Login::checkUser()["user_id"])) return;
if( isset($_GET["user"] ) ) $user = $_GET["user"];
else {
	$user = explode( "/", parse_url($_SERVER["HTTP_REFERER"], PHP_URL_PATH) );
	if( isset($user[2]) ) $user = $user[2];
	else $user = false;
}
if( $user ) {
	renderComments( Comment::getComments($user) );
?>
<br><br>
<a class="modal-trigger waves-effect waves-light btn col s12" onclick="$('#editmode')[0].value = 0; $('#field_user')[0].value='user:<?php echo $user;?>'" href="#writecomment">Schreib was!</a>
<div id="writecomment" class="modal">
	<div class="modal-content">
	  <form id="createform" method="POST" action="/api/comment/post/"><h4>Schreib etwas (nettes)!</h4>
	  <input type="hidden" id="field_user" name="parent" value="">
      <input type="hidden" id="editmode" name="parent" value="0">
	  	<div class="input-field col s12"><textarea id="wfc" type="text" name="text"></textarea><label for="wfc">Beschreibung</label></div>
	</div>
	<div class="modal-footer">
	  <a href="#!" onclick="($('#editmode')[0].value == 1?editComment:writeComment)( $('#wfc')[0].value, $('#field_user')[0].value )" class="modal-close waves-effect waves-green btn-flat ">Abschicken</a>
	  <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Abbrechen</a>
	  </form>
	</div>
</div>
<div id="deletegroup" class="modal">
	<div class="modal-content">
		<h4>Möchtest du den Kommentar löschen?</h4>
	</div>
	<div class="modal-footer">
	  <a id="commdel" href="#!" class="modal-close waves-effect waves-green btn-flat ">Löschen</a>
	  <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Abbrechen</a>
	</div>
  </div>

<?php } ?>
