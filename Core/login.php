<?php require_once( "db.php" );


define( "LOGIN_HASH_VALIDATION_OK",    0 );
define( "LOGIN_HASH_VALIDATION_ERROR", 1 );
define( "LOGIN_TOKEN_OK",              2 );
define( "LOGIN_SQL_ERROR",             3 );

class Login {
	
	//#######
	//#
	//#	    Holds the error code
	//#
	//#######
	private $error;
	
	public $user;
	
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
			case LOGIN_HASH_VALIDATION_ERROR: return "Nutzername oder Kennwort ist Falsch";
			case LOGIN_SQL_ERROR:       return "Es gibt ein Problem mit der Datenbank";
		}
	}
	//#######
	//#
	//#	    Check if the hash genererated by client from md5([username][password][timestamp]) fits with any user
	//#
	//#######
	function validateHash( $username, $password, $legacylogin=true ) {
		$db = new DB();
		if( !$db ) return [ "status"=>LOGIN_SQL_ERROR, "user"=>"" ];
		if( !($result = $db->query("Select `id`, `password` FROM `login_info` WHERE `id` Like '§0'",[$username]) ) ) return [ "status"=>LOGIN_SQL_ERROR, "user"=>" " ];
		if( $result->num_rows == 0 ) return [ "status"=>LOGIN_HASH_VALIDATION_ERROR, "user"=>"" ];
		$user = $result->fetch_array(MYSQL_ASSOC);
		if( password_verify( $password, $user["password"] ) || ( ( md5( $password ) == $user["password"] || $password == $user["password"] ) && $legacylogin ) ) return [ "status"=>LOGIN_HASH_VALIDATION_OK, "user"=>$user["id"] ];
		return [ "status"=>LOGIN_HASH_VALIDATION_ERROR, "user"=>"" ];
	}
	//#######
	//#
	//#	    Creates and returns a login token, which is valid for 5 minutes
	//#
	//#######
	function createToken( $user_id ) {
		if( !($db = new DB() ) ) return ["status"=>LOGIN_SQL_ERROR,"value"=>""];
		$token = md5( rand() );
		while( $this->checkToken( $token !== False ) ) $token = md5( rand() );
		if(!$db->query( "INSERT INTO `login_tokens` ( user_id, token, expires ) VALUES ( '§0', '§1', DATE_ADD(NOW(), INTERVAL 5 MINUTE) )",[$user_id,$token] ) ) return ["status"=>LOGIN_SQL_ERROR,"value"=>""];
		return ["status"=>LOGIN_TOKEN_OK,"value"=>$token];
	}
	//#######
	//#
	//#	    Checks if token is valid and refreshes the token, if expired. Returns token and user_id ( and expiring date )
	//#
	//#######
	function checkToken( $token ) {
		if( !($db = new DB() ) ) return False;
		if(!($result = $db->query( "SELECT * FROM `login_tokens` WHERE `token` Like '§0'",[$token] ) ) ) return False;
		if( $result->num_rows == 0 ) return False;
		$result = $result->fetch_array(MYSQL_ASSOC);
		if( strtotime( $result["expires"] ) < strtotime( "now" ) ) {
			$result["token"] = $this->refreshToken( $token );
		}
		unset($result["expires"]);
		return $result;
	}
	//#######
	//#
	//#	    Deletes a specific Token
	//#
	//#######
	function deleteToken( $token ) {
		if( !($db = new DB() ) ) return False;
		if(!$db->query( "DELETE FROM `login_tokens` WHERE `token` Like '§0' ",[$token] ) ) return False;
		return True;
	}
	//#######
	//#
	//#	    Deletes and creates a fresh token, which is returned
	//#
	//#######
	function refreshToken( $token ) {
		if( !($db = new DB() ) ) return False;
		if(!($result = $db->query( "SELECT `user_id`, `token` FROM `login_tokens` WHERE `token` Like '§0'",[$token] ) ) ) return False;
		if(!($t = $this->createToken( $result->fetch_array(MYSQLI_ASSOC)["user_id"] ))) return False;
		if(!$this->deleteToken( $token )) return False;
		setCookie( "login", $t["value"], time()+365*24*60*60, "/" );
		return $t["value"];
	}
	//#######
	//#
	//#	    Delets token and unsets Cookie
	//#
	//#######
	function logout( $token ) {
		if( !$this->deleteToken( $token ) ) return False;
		setCookie( "login", "", time()-1, "/" );
		return True;
	}
	//#######
	//#
	//#	    Deletets all token for specific user ( eg to logoff from ALL devices )
	//#
	//#######
	function clearTokens( $user_id ) {
		if( !($db = new DB() ) ) return False;
		if(!$db->query( "DELETE FROM `login_tokens` WHERE `user_id` Like '§0' ", [$user_id] ) ) return False;
		return True;
	}
	//#######
	//#
	//#	    Clears all old tokens for specific user ( eg to clean up )
	//#
	//#######
	function clearOldTokens($user_id) {
		if( !($db = new DB() ) ) return False;
		if(!$db->query( "DELETE FROM `login_tokens` WHERE `user_id` Like '§0' AND `expires` < NOW() ", [$user_id] ) ) return False;
		return True;
	}
	//#######
	//#
	//#	    Composes hash validation and token creation, which is set as cookie then
	//#
	//#######
	function login( $username=false, $password=false ) {
		if( !$username || !$password ) return; //If called on construct
		$validation = $this->validateHash( $username, $password );
		if( $validation["status"] != LOGIN_HASH_VALIDATION_OK ) {
			$this->error = $validation["status"];
			return False;
		}
		$this->user = $username;
		/*if( !$this->clearTokens( $validation["user"] ) ) {
			$this->error = LOGIN_SQL_ERROR;
			return false;
		}*/
		if( ( $usr = Login::checkUser() ) ) {
			$this->refreshToken( $usr["token"] );
			return;
		}
		$token = $this->createToken( $validation["user"] );
		if( $token["status"] == LOGIN_SQL_ERROR ) {
			$this->error = $token["status"];
			return false;
		}
		setCookie( "login", $token["value"], time()+365*24*60*60, "/" );
	}
	//#######
	//#
	//#	    Returns user id from login cookie or False, if not logged in or valid
	//#
	//#######
	public static function checkUser() {
		$l = new Login();
		if( !isset($_COOKIE["login"]) ) return False;
		$user = $l->checkToken( $_COOKIE["login"] );
		if(!$user) return false;
		$_COOKIE["login"] = $user["token"];
		return $user;
	}
	//#######
	//#
	//#	    Checks if given user is admin by user id ### Its not in the user table for better overview ( eg somebody gave max wiens admin rights, then something happend and one can quickly see the mistake)
	//#
	//#######
	public static function isAdmin( $user ) {
		if(!($db = new DB()) ) return false;
		if(!($result = $db->query( "SELECT * FROM `login_admin` WHERE `login_admin_id` Like '§0' ",[$user]) ) ) return false;
		return $result->num_rows > 0;
	}
	//#######
	//#
	//#	    Grants admin rights to User by user id
	//#
	//#######
	public static function grantAdmin( $user, $usr ) {
		if( Login::isAdmin( $usr ) ) {
			if(!($db = new DB()) ) return false;
			if(!($result = $db->query( "DELETE FROM `login_admin` WHERE `login_admin_id` LIKE '§0'",[$user]) ) ) return false;
			if(!($result = $db->query( "INSERT INTO `login_admin` ( `login_admin_id` ) VALUES ( '§0' )",[$user]) ) ) return false;
			Log::msg( "Privileges", "$usr granted $user admin rights" );
			return Login::isAdmin( $user );
		}
	}
	//#######
	//#
	//#	    Revokes admin rights to User by user id
	//#
	//#######
	public static function revokeAdmin( $user, $usr) {
		if( Login::isAdmin( $usr ) ) {
			if(!($db = new DB()) ) return false;
			if(!($result = $db->query( "DELETE FROM `login_admin` WHERE `login_admin_id` LIKE '§0'",[$user]) ) ) return false;
			Log::msg( "Privileges", "$usr revoked $user admin rights" );
			return Login::isAdmin( $user );
		}
	}
	
}

?>
