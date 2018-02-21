<?php require_once( "db.php" );

define( "SURVEY_MYSQL_ERROR", 0 );
define( "SURVEY_NOT_FOUND", 1 );
define( "SURVEY_NOT_VISIBLE", 2 );

	class Survey {

	//#######
	//#
	//#	    Holds the error code
	//#
	//#######
	private $error;

	//#######
	//#
	//#	    Returns the error code
	//#
	//#######
	public function getError() { return $this->error; }

	//#######
	//#
	//#	    Returns the error message
	//#
	//#######
	public function getErrorMessage() {
		switch( $this->error ) {
			case SURVEY_NOT_VISIBLE          : return "Diese Umfrage ist momentan nicht Verfügbar";
			case SURVEY_NOT_FOUND            : return "Diese Umfrage Existiert nicht";
			case SURVEY_MYSQL_ERROR          : return "Es gibt ein Problem mit der Datenbank";
		}
	}

    //#######
	//#
	//#	    Returns list of all avaiable survey, optional also hidden ones
	//#
	//#######
	public static function getSurveys( $hideInvisible=true ) {
		if(!($db = new DB()) ) return false;
		if(!($result = $db->query( "SELECT * FROM `survey_meta`") ) ) return false;
		$ret = []; while(($e = $result->fetch_array(MYSQL_ASSOC))) { $flags = Survey::decodeFlag( $e["survey_visible"] );
            if( !$flags["visible"] && $hideInvisible ) continue; $ret[] = $e; $ret[count($ret)-1]["flags"] = $flags; }
		return $ret;
	}
	//#######
	//#
	//#	    Returns single survey by id, same as new Survey([id])
	//#
	//#######
	public static function getSurvey( $id, $u = false ) {
		return new Survey( $id, $u );
	}
	//#######
	//#
	//#	    Surveys meta data
	//#
	//#######
	protected $id = "";
	protected $title = "";
	protected $description = "";
	protected $visible = false;       // flag value: 1
	protected $votesvisible = false;  // flag value: 3
	protected $voteable = false;      // flag value: 5
	protected $questions = [];
    protected $questionGroup = false;

	public function getID() { return $this->id; }
	public function getTitle() { return $this->title; }
	public function getDescription() { return $this->description; }
	public function isPublic() { return $this->visible; }
	public function isVotePublic() { return $this->votesvisible; }
	public function isVoteable() { return $this->voteable; }
	public function isDownVoteable() { return $this->downvoteable; }
	public function getQuestions() { return $this->questions; }
    public function getQuestionGroup() { return $this->questionGroup; }

	//#######
	//#
	//#	    Sets title and description of the survey
	//#
	//#######
	public function setMeta( $title, $description, $visible, $question_group="" ) {
		if(!($db = new DB()) ) {error_log($db->error); return SURVEY_MYSQL_ERROR;}
		if(!($result = $db->query("UPDATE `survey_meta` SET `survey_title`='§0', `survey_description`='§1', `survey_visible`=§2, `question_group`='§4' WHERE `survey_meta_id` Like §3", [$title, $description, $visible, $this->id, $question_group]) ) ) {$this->error=SURVEY_MYSQL_ERROR; return false;}
		$this->loadMeta();
		return true;
	}
	//#######
	//#
	//#	    Internal function to load the meta data
	//#
	//#######
	protected function loadMeta() {
		if(!($db = new DB()) ) {error_log($db->error); return SURVEY_MYSQL_ERROR;}
		$id = $this->id; if(!($result = $db->query("SELECT * FROM `survey_meta` WHERE `survey_meta_id` Like §0",[$id]) ) ) {$this->error=SURVEY_MYSQL_ERROR; return false;}
		if( $result->num_rows == 0 )  {$this->error=SURVEY_NOT_FOUND; return false;}
		$result = $result->fetch_array(MYSQL_ASSOC);
		$this->title       = $result["survey_title"];
		$this->description = $result["survey_description"];
        if( isset($result["question_group"]) ) if($result["question_group"] != "" ) $this->questionGroup = $result["question_group"];
		$flags = $this->decodeFlag($result["survey_visible"]);
		$this->visible      = $flags["visible"];
		$this->votesvisible = $flags["votesvisible"];
		$this->voteable     = $flags["voteable"];
		$this->downvoteable     = $flags["downvoteable"];
		return true;
	}
	public function decodeFlag( $flag ) {
		$flags = [ "visible"=>false, "votesvisible"=>false, "voteable"=>false, "downvoteable"=>false ];
		$fnames = ["visible","votesvisible","voteable","downvoteable"];
		$f = [1,2,4,8]; 
		for($i=count($f)-1;$i>=0;$i--) if( $flag-$f[$i]>-1) { $flag-=$f[$i]; $flags[$fnames[$i]] = true; }
		return $flags;
	}
	//#######
	//#
	//#	    Internal function to load the questions
	//#
	//#######
	protected function loadQuestionGroup( $user_id = false ) {
		$id = $this->id;
		if( $user_id ) $q = "SELECT CONCAT('§0',pr.`user_id`) AS `question_id`, CONCAT(`FName`,' ',`LName` ) AS `question_title`, COALESCE( `votes`, 0 ) as `votes`, `myvote` FROM `profiles` as pr ".($this->questionGroup=='*'?"":", `group_participants` as gp")." LEFT JOIN ( SELECT *, SUM( `vote_value` ) as votes FROM `survey_votes` LEFT JOIN ( SELECT `vote_value` As `myvote`, `vote_user` as `user`, `vote_question` as `id` FROM `survey_votes` WHERE `vote_user` Like '§1' ) as OwnVotes ON `vote_question` Like `id` GROUP BY `vote_question`) as votes ON `vote_question` LIKE CONCAT('§0',`user_id`) ".($this->questionGroup=='*'?"":" WHERE gp.user_id LIKE pr.`user_id` AND gp.group_id LIKE §2")."
 ORDER BY ".(!$this->votesvisible?"`question_title` ASC":"`votes` DESC");
		else $q = "SELECT CONCAT('§0',`user_id`) AS `question_id`, CONCAT(`FName`,' ',`LName` ) AS `question_title`, SUM(`vote_value`) As votes FROM `profiles`, `survey_questions` WHERE `survey_id` Like §0 AND `vote_question` Like `question_id` GROUP BY `vote_question` ORDER BY `votes` DESC";
		if(!($db = new DB()) ) {error_log($db->error); return SURVEY_MYSQL_ERROR;}
		if(!($result = $db->query( $q, [$id,$user_id,$this->questionGroup] ) ) ) {$this->error=SURVEY_MYSQL_ERROR; return false;}
		if( $result->num_rows == 0 )  {$this->error=SURVEY_NOT_FOUND; return false;}
		$ret = []; while(($e = $result->fetch_array(MYSQL_ASSOC))) { $ret[] = $e; }
		$this->questions = $ret;
	}
    //#######
	//#
	//#	    Internal function to load the questions, based on the userpool
	//#
	//#######
	protected function loadQuestions( $user_id = false ) {
		$id = $this->id;
		if( $user_id ) $q = "SELECT `question_id`, `question_title`,  COALESCE( `votes`, 0 ) as `votes`, `myvote` FROM `survey_questions` LEFT JOIN ( SELECT *, SUM( `vote_value` ) as votes FROM `survey_votes` LEFT JOIN ( SELECT `vote_value` As myvote, `vote_user` as user, `vote_question` as id FROM `survey_votes` WHERE `vote_user` Like '§1' ) as OwnVotes ON `vote_question` Like id GROUP BY `vote_question`) as votes ON `vote_question` LIKE `question_id` WHERE `survey_id` Like §0 ORDER BY ".(!$this->votesvisible?"`question_title` ASC":"`votes` DESC");
		else $q = "SELECT `question_id`, `question_title`, SUM(`vote_value`) As votes FROM `survey_votes`, `survey_questions` WHERE `survey_id` Like §0 AND `vote_question` Like `question_id` GROUP BY `vote_question` ORDER BY `votes` DESC";
		if(!($db = new DB()) ) {error_log($db->error); return SURVEY_MYSQL_ERROR;}
		if(!($result = $db->query( $q, [$id,$user_id] ) ) ) {$this->error=SURVEY_MYSQL_ERROR; error_log($db->error); return false;}
		if( $result->num_rows == 0 )  {$this->error=SURVEY_NOT_FOUND; return false;}
		$ret = []; while(($e = $result->fetch_array(MYSQL_ASSOC))) { $ret[] = $e; }
		$this->questions = $ret;
	}
	//#######
	//#
	//#	    Removes a specific question
	//#
	//#######
	public function removeQuestion( $id ) {
		if(!($db = new DB()) ) return SURVEY_MYSQL_ERROR;
		if(!($result = $db->query("DELETE FROM `survey_questions` WHERE `question_id` Like §0",[$id]) ) ) {$this->error=SURVEY_MYSQL_ERROR; return false;}
		$this->loadQuestions();
		return true;
	}
	//#######
	//#
	//#	    Adds a question to the survey
	//#
	//#######
	public function addQuestion(  $title ) {
		if(!($db = new DB()) ) return SURVEY_MYSQL_ERROR;
		$id = $this->id;
		if(!($result = $db->query("INSERT INTO `survey_questions` (survey_id,question_title) VALUES (§0, '§1' );",[$id,$title]) ) ) {$this->error=SURVEY_MYSQL_ERROR; return false;}
		$this->loadQuestions();
		return true;
	}
	//#######
	//#
	//#	    Set title/subject of specific question
	//#
	//#######
	public function editQuestion( $id, $title ) {
		if(!($db = new DB()) ) return SURVEY_MYSQL_ERROR;
		if(!($result = $db->query("UPDATE `survey_questions` SET `question_title`='§0' WHERE `question_id` Like '§1'",[$title,$id]) ) ) {$this->error=SURVEY_MYSQL_ERROR; return false;}
		$this->loadQuestions();
		return true;
	}
	//#######
	//#
	//#	    Composes loading of meta and questions
	//#
	//#######
	public function Survey( $id, $uid = false ) {
		$this->id = $id;
		$this->loadMeta();
		if($uid != "skip" )
            if( $this->questionGroup ) 
                $this->loadQuestionGroup( $uid );
            else
                $this->loadQuestions( $uid );
	}
	//#######
	//#
	//#	    Deletes a Survey
	//#
	//#######
	public static function deleteSurvey( $id ) {
		if(!($db = new DB()) ) return false;
		if(!($db->query("DELETE FROM `survey_meta`      WHERE `survey_meta_id` Like §0",[$id]) ) ) return false;
		if(!($db->query("DELETE FROM `survey_questions` WHERE `survey_id`  Like §0",[$id]) ) ) return false;
		if(!($db->query("DELETE FROM `survey_votes`     WHERE `survey__id` Like §0",[$id]) ) ) return false;
		return true;
	}
	//#######
	//#
	//#	    Creates and returns a new Survey
	//#
	//#######
	public static function createSurvey( $title, $description, $questionGroup="" ) {
		if(!($db = new DB()) ) return false;
		if(!($result = $db->query("INSERT INTO `survey_meta` ( `survey_title`, `survey_description`, `question_group` ) VALUES ( '§0', '§1', '§2' )",[$title,$description,$questionGroup]) ) ) return false;
		return new Survey( $db->query("SELECT LAST_INSERT_ID()")->fetch_array(MYSQL_NUM)[0] );
	}
	//#######
	//#
	//#	    UP/NEUTRAL/DOWNVOTES a question
	//#
	//#######
	public static function vote( $question_id, $user_id, $vote ) {
		if(!($db = new DB()) ) return false;
		if(!($rslt = $db->query( "SELECT `survey_id` FROM `survey_questions` WHERE `question_id` Like '§0'",[$question_id]) ) ) return false;
        if( $rslt->num_rows == 0 ) {
            //Might be a group survey
            $ref = explode( "/" ,parse_url( $_SERVER["HTTP_REFERER"] )["path"] );
            if($ref[1] == "Surveys" and isset( $ref[2] ) ) $survey_id = $ref[2];
            else return false;
        } else
            if( !($survey_id=$rslt->fetch_array(MYSQL_NUM)[0]) ) return false;
		if( !($s = new Survey( $survey_id, "skip" ) ) ) return false;
		if( !$s->isVoteable() ) return false;
		if( !$s->isDownVoteable() && $vote == -1) $vote = 0;
		if(!($x = $db->query( "UPDATE `survey_votes` SET `vote_value`=§0 WHERE `vote_user` LIKE '§1' AND `vote_question` Like '§2' LIMIT 1",[$vote,$user_id,$question_id]) ) ) return false;
		if( $db->matchedRows() == 0 )
			if(!($x = $db->query( "INSERT INTO `survey_votes` ( `vote_user`, `vote_question`, `vote_value`, `survey__id` ) VALUES ( '§0', '§1', §2, §3 )",[$user_id,$question_id,$vote,$survey_id]) ) ) return false;
		if( $s->isVotePublic() ) return $db->query( "SELECT ownvote, SUM( `vote_value` ) as votes, '§1' as question FROM (SELECT `vote_value` as ownvote FROM `survey_votes` WHERE `vote_question` LIKE '§1' AND `vote_user` LIKE '§0') as ov, `survey_votes` WHERE `vote_question` LIKE '§1'", [$user_id,$question_id] )->fetch_array(MYSQL_ASSOC);
		return true;
	}

}


?>
