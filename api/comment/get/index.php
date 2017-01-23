<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";

function renderComments( $comments, $depth=0 ) {
	if( !$comments ) return;
	?>
	<?php
	foreach( $comments as $comment ) {
		$comment = new Comment( $comment["cid"] );
		$p = new Profile( $comment->owner );
		$title = "<a href='/profile/".$p->getID()."/'>".$p->getFirstName()." ".$p->getLastName()."</a>";
		$id = $comment->id;
		$text = $comment->text;
		?>
		<h5><i class="material-icons">account_circle</i><?php echo $title;?></h5>
		<p><?php echo $text;?></p>
		<?php $answers = Comment::getAnswers($comment->id); if(count($answers)>0) {?>
		<ul class="collapsible" data-collapsible="expandable">
		<li style="padding-left: <?php echo $depth*10;?>px">
		  <div class="collapsible-header">Comments</div>
		  <div class="collapsible-body">
		  	<?php renderComments($answers, $depth+1); ?>
		  </div>
		</li>
		</ul>
		<?php } ?>
		<a class="modal-trigger waves-effect waves-light btn" onclick="$('#field_user')[0].value='comment:<?php echo $id;?>'" href="#writecomment">Comment</a>
		<?php
	}
	?>
	
	<br>
	<?php
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
<a class="modal-trigger waves-effect waves-light btn" onclick="$('#field_user')[0].value='user:<?php echo $user;?>'" href="#writecomment">Comment</a>
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
