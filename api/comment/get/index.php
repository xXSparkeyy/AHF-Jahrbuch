<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";

function renderComments( $comments, $depth=0 ) {
	if( !$comments ) return;
	?>
	<ul class="collapsible" data-collapsible="expandable">
	<?php
	foreach( $comments as $comment ) {
		renderComments(Comment::getAnswers($comment["cid"]), $depth+1);
		$comment = new Comment( $comment["cid"] );
		$p = new Profile( $comment->owner );
		$title = "<a href='/profile/".$p->getID()."/'>".$p->getFirstName()." ".$p->getLastName()."</a>";
		$id = $comment->id;
		$text = $comment->text;
		?>
		<li>
		  <div class="collapsible-header active"><i class="material-icons">account_circle</i><?php echo $title;?></div>
		  <div class="collapsible-body">
		  	<p><?php echo $text;?></p>
		  	<a class="modal-trigger waves-effect waves-light btn" onclick="$('#field_user')[0].value='comment:<?php echo $id;?>'" href="#writecomment">Comment</a>
		  </div>
		</li>
		<?php
	}
	?>
	</ul>
	<?php
}

$user = explode( "/", parse_url($_SERVER["HTTP_REFERER"], PHP_URL_PATH) );
if( isset($user[2]) ) $user = $user[2];
else $user = false;
if( $user ) {
	renderComments( Comment::getComments($user) );
?>
<a class="modal-trigger waves-effect waves-light btn" onclick="$('#field_user')[0].value='user:<?php echo Login::checkUser()['user_id'];?>'" href="#writecomment">Comment</a>
<div id="writecomment" class="modal">
	<div class="modal-content">
	  <form id="createform" method="POST" action="/api/comment/post/"><h4>Schreib etwas (nettes)!</h4>
	  <input type="hidden" id="field_user" name="parent" value="">
	  	<div class="input-field col s12"><textarea id="wfc" type="text" name="text"></textarea><label for="wfc">Beschreibung</label></div>
	</div>
	<div class="modal-footer">
	  <a href="javascript:$('#createform').submit()" class="modal-action waves-effect waves-green btn-flat ">Schicken</a>
	  <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancel</a>
	  </form>
	</div>
</div>

<?php } ?>
