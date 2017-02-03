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
		<div class="comment_wrapper"><h5><?php echo $title;?> wrote...</h5>
		<p><?php echo $text;?></p><span class="float_r"><?php 

		if($usr == $comment->owner || $usr == $comment->receiver){
	echo '<i class="material-icons">delete</i>';
	if($usr = Login::checkUser()["user_id"] == $comment->owner){
		echo '<i class="material-icons">edit</i>';
}	
	echo '</span>';
}

		 $answers = Comment::getAnswers($comment->id); if(count($answers)>0) {?>
		<ul class="collapsible" data-collapsible="expandable">
		<li class="<?php echo ($depth % 2 != 0)? 'crazy-color':'decent-color';?>">
		  <div class="collapsible-header">Comments on Comment</div>
		  <div class="collapsible-body">
		  	<?php renderComments($answers, $depth+1); ?>
		  </div>
		</li>
		</ul>
		
		<?php } ?>
		<a class="modal-trigger waves-effect waves-light btn" onclick="$('#field_user')[0].value='comment:<?php echo $id;?>'" href="#writecomment">Comment</a></div>
		<?php
	}
	?>
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
<a class="modal-trigger waves-effect waves-light btn col s12" onclick="$('#field_user')[0].value='user:<?php echo $user;?>'" href="#writecomment">New Comment</a>
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
