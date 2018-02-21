<?php require_once( "db.php" );

/*

	Introducing Comments,
	The new convenient way of innovative but intuitive communication between humans like us.
	Get in touch easily and express youself easier than ever!
	
		~ Comments, leading a new path ~
	
*/
class Comment { // Somewhat like just ordinary comments, but way cooler
	
	static function writeComment($from,$to,$blob) {
		return Comment::answerComment( $from, $to, $blob, true );
	}
	static function getComments($for) {
		if( !($db=new DB()) ) return false;
		if(!($result=$db->query( "SELECT * FROM `comments` WHERE `receiver_id` Like \"§0\"", [$for] ) ) ) return false;
		return $db->resultToArray($result);
	}
	static function getAnswers($for) {
		if( !($db=new DB()) ) return false;
		if(!($result=$db->query( "SELECT * FROM `comments` WHERE `parent_comment` Like §0", [$for] ) ) ) return false;
		return $db->resultToArray($result);
	}
	/*function acceptBabble( $id ) {
		if( !($db=new DB()) ) return false;
		if(!($db->query( "", [] ) ) return false;
		return true;
	}*/
	static function deleteComment( $id ) {
		if( !($db=new DB()) ) return false;
		if(!($db->query( "DELETE FROM `comments` WHERE `cid` LIKE §0", [$id] ) ) ) return false;
		return true;
	}
	static function deleteWithChildren($id) {
        echo $id;
		$children = Comment::getAnswers($id);
		foreach( $children as $child ) { Comment::deleteWithChildren($child); }
		Comment::deleteComment($id);
	}
	static function answerComment( $from, $id, $blob, $root=false ) {
		if( !($db=new DB()) ) return false;
		$user = $root?$id:"NULL";
		$id   = $root?"NULL":$id;
		if(!($db->query( "INSERT INTO `comments` SET `owner_id`=\"§0\",`receiver_id`=\"§1\",`parent_comment`=§2,`text`=\"§3\"", [$from,$user,$id,$blob] ) ) ) return false;
		return true;
	}
    static function editComment( $id, $blob ) {
		if( !($db=new DB()) ) return false;
		if(!($db->query( "UPDATE `comments` SET `text`=\"§1\" WHERE `cid` Like '§0'", [$id,$blob],true ) ) ) return false;
		return true;
	}
    static function findRoot( $id ) {
		if( !($db=new DB()) ) return false;
        $tr = 0;
        do {
		    if(!($rslt = $db->query( "SELECT `receiver_id`, `parent_comment` FROM `comments` WHERE `cid` LIKE '§0'", [$id] ) ) ) return false;
            $cm = $db->resultToArray( $rslt, 1 )[0];
            $id = $cm["parent_comment"];
            $tr++;
        } while( $cm["receiver_id"] == "NULL" && $id != "NULL" && $tr < 1000  );
		return $cm["receiver_id"];
	}
	
	public $id;
	public $owner;
	public $parent;
	public $receiver;
	public $text;
	
	public function Comment( $id ) {
		if( !($db=new DB()) ) return false;
		if(!($result=$db->query( "SELECT * FROM `comments` WHERE `cid` Like §0", [$id] ) ) ) return false;
		$res = $db->resultToArray($result,1)[0];
		$this->owner    = $res["owner_id"];
		$this->receiver = $res["receiver_id"];
		$this->parent   = $res["parent_comment"];
		$this->text     = $res["text"];
		$this->id       = $res["cid"];
	}

    public static function javascript() {
        ?>
function writeComment( text, target ) {
		var x = new XMLHttpRequest();
		x.open( "POST", "/api/comment/post/" );
        x.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded" );
		x.onreadystatechange = function() {
			if( x.readyState == 4 ) loadComments();
		}
		x.send( "text="+text+(target?"&parent="+target:"&user="+user ) );
	}
    function editComment( text, comment ) {
		var x = new XMLHttpRequest();
		x.open( "POST", "/api/comment/edit/" );
        x.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded" );
		x.onreadystatechange = function() {
			if( x.readyState == 4 ) loadComments();
		}
		x.send( "text="+text+"&comment="+comment );
	}
    function deleteComment( id ) {
		var x = new XMLHttpRequest();
		x.open( "POST", "/api/comment/delete/" );
        x.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded" );
		x.onreadystatechange = function() {
			if( x.readyState == 4 ) loadComments();
		}
		x.send( "comment="+id );
	}
	function loadComments() {
		var x = new XMLHttpRequest();
		x.open( "POST", "/api/comment/get/");
		x.onreadystatechange = function() {
			if( x.readyState == 4 ) { $("#comments")[0].innerHTML = x.responseText; $(".modal-trigger").leanModal(); $('.collapsible').collapsible(); }
		}
		x.send();
	}
<?php
    }	
		
}
