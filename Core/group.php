<?php require_once( "db.php" );

class Group {

	private $id;
	private $name;
	private $description;
	private $members;

	public function Group( $id ) {
		$this->id = $id;
		$this->loadMeta();
		$this->loadMembers();
	}

	public static function getGroups() {
		if(!($db = new DB()) ) return false;
		if(!($result = $db->query( "SELECT * FROM `group_meta`") ) ) return false;
		$ret = []; while(($e = $result->fetch_array(MYSQL_ASSOC))) { $ret[] = $e; }
		return $ret;
	}
	public static function getGroup( $id ) {
		return new Group( $id );
	}

	private function loadMeta() {
		$db = new DB();
		$id = $this->id;
		if( !($r = $db->query( "SELECT * FROM `group_meta` WHERE `group_id` Like §0", [$id] ) ) ) return;
		if( !($r = $r->fetch_array(MYSQL_ASSOC)) ) return;
		$this->name = $r["name"];
		$this->description = $r["description"];
	}
	private function loadMembers() {
		if(!($db = new DB()) ) return false;
		$id = $this->id;
		if(!($result = $db->query( "SELECT `user_id` FROM `group_participants` WHERE `group_id` Like §0",[$id]) ) ) return false;
		$ret = []; while(($e = $result->fetch_array(MYSQL_ASSOC))) {
			try { $p = new Profile( $e["user_id"], false ); }
			catch( Exception $e ) { continue; }
			$ret[] = $p;
		}
		$this->members = $ret;
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
	public function getID() {
		return $this->id;
	}

	public function setMeta( $name, $dsc ) {
		$db = new DB();
		$id = $this->id; $db->query( "UPDATE `group_meta` SET `name`='§0', `description`='§1' WHERE `group_id` Like §2", [$name,$dsc,$id] );
		$this->loadMeta();
	}
	public function addMember( $user ) {
		return Group::_addMember($user,$this->id);
	}
	public function removeMember( $user ) {
		return Group::_removeMember($user,$this->id);
	}
	public static function _addMember( $user, $id ) {
		$db = new DB();
		if( Group::_isMember( $user, $id ) ) return new Profile($user, false);
		$db->query( "INSERT INTO `group_participants` (`group_id`, `user_id`, `mod`) VALUES ('§0','§1', 0)", [$id,$user] );
		return new Profile($user, false);
	}
	public static function _removeMember( $user, $id ) {
		$db = new DB();
		return $db->query( "DELETE FROM `group_participants` WHERE `group_id` LIKE '§1' AND `user_id` LIKE '§0'", [$user,$id] );
	}

	public function removeGroup() {
        print_r( "Removingggg" );
		$db = new DB();
		$id = $this->id; $db->query( "DELETE FROM `group_meta` WHERE `group_id` Like §0", [$id] );
		$db->query( "DELETE FROM `group_participants` WHERE `group_id` Like §0", [$id] );
	}
	public static function createGroup( $name, $desc ) {
		$db = new DB();
		if( !$db->query( "INSERT INTO `group_meta` SET `name`='§0', `description`='§1'", [$name,$desc] ) ) return false;
		return new Group( $db->query("SELECT LAST_INSERT_ID()")->fetch_array(MYSQL_NUM)[0] );
	}
	public static function addGroup( $name, $desc ) {
		return Group::createGroup( $name, $desc );
	}


	public function isMember( $user ) {
		return Group::_isMember($user,$this->id);
	}
	public static function _isMember( $user, $id ) {
		if(!($db = new DB()) ) return false;
		if(!($result = $db->query( "SELECT 1 FROM `group_participants` WHERE `group_id` Like '§0' AND `user_id` Like '§1'",[$id,$user]) ) ) return false;
		return $result->num_rows > 0;
	}
	public static function inGroups($user) {
		if(!($db = new DB()) ) return false;
		if(!($result = $db->query( "SELECT * FROM `group_meta` as a LEFT JOIN `group_participants` as b ON a.`group_id` LIKE b.`group_id` WHERE b.`user_id` LIKE '§0'",[$user]) ) ) return false;
		$ret = []; while(($e = $result->fetch_array(MYSQL_ASSOC))) { $ret[] = $e; }
		return $ret;
	}
	//#######
	//#
	//#	    Checks if given user is moderator by user id
	//#
	//#######
	public static function isMod( $group, $user, $ignoreadmin=false ) {
		if( Login::isAdmin($user) && !$ignoreadmin ) return true;
		if(!($db = new DB()) ) return false;
		if(!($result = $db->query( "SELECT 1 FROM `group_participants` WHERE `group_id` Like '§0' AND `user_id` Like '§1' AND `mod` Like 1",[$group,$user]) ) ) return false;
		return $result->num_rows > 0;
	}
	public static function hasModPriv( $group, $user ) {
		Group::isMod( $group, $user, true );
	}
	//#######
	//#
	//#	    Grants moderator rights to User by user id
	//#
	//#######
	public static function grantMod(  $usr, $user, $group ) {
		if( !Group::isMod( $group, $usr ) ) return false;
			if(!($db = new DB()) ) return false;
			$result = $db->query( "UPDATE `group_participants` SET `mod`=1 WHERE `group_id` Like '§0' AND `user_id` Like '§1'",[$group,$user]);
			Log::msg( "Groups", "$usr granted $user moderator rights in $group" );
			return true;
	}
	//#######
	//#
	//#	    Revokes moderator rights to User by user id
	//#
	//#######
	public static function revokeMod(  $usr, $user, $group ) {
			if( !Group::isMod( $group, $usr ) ) return false;
			if(!($db = new DB()) ) return false;
			$result = $db->query( "UPDATE `group_participants` SET `mod`=0 WHERE `group_id` Like '§0' AND `user_id` Like '§1'",[$group,$user]);
			Log::msg( "Groups", "$usr revoked $user moderator rights in $group" );
			return true;
	}

}

?>
