<?php require_once( "db.php" );


public class Group {

	private $name;
	private $description;
	private $members;
	
	public function Group() {
		
	}
	
	public function getName() {
		return $this->name;
	}
	public function getDescription() {
		return $this->description;
	}
	public function getMembers() {
		return $this->members;
	}
	
	public function setMeta() {
		
	}
	public function addMember() {
		
	}
	public function removeMember() {
		
	}
	
	
	private function loadMeta() {
		
	}
	private function loadMembers() {
		
	}
	
	
	public static function removeGroup() {
		
	}
	public static function addGroup() {
		
	}
	public static function addGroup() {
		
	}
	
	
	//#######
	//#
	//#	    Checks if given user is moderator by user id 
	//#
	//#######
	static function isMod( $user ) {
		if(!($db = connectDB()) ) {$this->error=LOGIN_MYSQL_ERROR;return false;}
		if(!($result = $db->query( "SELECT 1 FROM `group_participants` WHERE `user_id` Like '$user' AND `mod` Like 1") ) ) return false;
		return $result->num_rows > 0;
	}
	//#######
	//#
	//#	    Grants moderator rights to User by user id
	//#
	//#######
	public static function grantMod( $user, $usr ) {
		if( Group::isMod( $user ) ) {
			if(!($db = connectDB()) ) {$this->error=LOGIN_MYSQL_ERROR;return false;}
			if(!($result = $db->query( "UPDATE `group_participants` SET `mod`=1 WHERE `user_id` Like '$usr'") ) ) return false;
			$log( "Groups", "$usr granted $user moderator rights" );
			return $result->num_rows > 0;
		}
	}
	//#######
	//#
	//#	    Revokes moderator rights to User by user id
	//#
	//#######
	public static function revokeMod( $user, $usr) {
		if( Group::isMod( $user ) ) {
			if(!($db = connectDB()) ) {$this->error=LOGIN_MYSQL_ERROR;return false;}
			if(!($result = $db->query( "UPDATE `group_participants` SET `mod`=1 WHERE `user_id` Like '$usr'") ) ) return false;
			$log( "Profile", "$usr revoked $user moderator rights" );
			return $result->num_rows > 0;
		}
	}

}

?>
