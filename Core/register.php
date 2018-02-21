<?php require_once( "db.php" );

define( "TAN_LOGIN_OK",                 0 );
define( "TAN_NOT_FOUND",                1 );
define( "REGISTRATION_SUCCESSFULL",     2 );
define( "REGISTRATION_USER_EXISTS",     3 );
define( "REGISTRATION_WRITE_SQL_ERROR", 4 );

class Registration {

	//#######
	//#
	//#	    Holds the error code
	//#
	//#######
	private $error;

    public function explanation() {return "Registriere dich auf bit.ly/Gw5Hf mit diesen Daten und wähle ein Passwort."; }
	
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
			case TAN_NOT_FOUND            : return "Die TAN wurde nicht gefunden";
            case REGISTRATION_USER_EXISTS : return "Dieser Nutzer Existiert bereits";
		}
	}

    //#######
	//#
	//#	    Generates TANs
	//#
	//#######

    public function createTANs( $list ) { // $list contains [firstname, lastname]
        $db = new DB();
        if( !$db ) {error_log($db->error);return REGISTRATION_WRITE_SQL_ERROR;}
        foreach( $list as $entry ) {
            Registration::createTAN( $db, $entry["firstname"], $entry["lastname"] );
        }
    }

    //#######
	//#
	//#	    Generates TAN
	//#
	//#######

    static function kii($len = 8) {
        $k="";
        $kons = [1,5,9,15,21];
        for( $i = 0; $i < $len; $i++ ) {
            $k.= $i%2==0?chr(64+$kons[random_int(0,4)]):chr(random_int(65,90));
        }
        return $k;
    }

    public function createTAN( $db, $fnm, $lnm ) { // $list contains [firstname, lastname]
        $username = Registration::generateUsername( $db, $fnm, $lnm );
        $id = Registration::kii();
        if(!($result = $db->query( "INSERT INTO `login_tan` (`id`,`username`,`name`,`surname`) VALUES ('§0', '§1', '§2', '§3')",[$id,$username,$fnm,$lnm] ) ) ) {error_log($db->error);return; }
    }
	
    //#######
	//#
	//#	    Lists TANs
	//#
	//#######

    static function listTans() {
        $db = new DB();
        if( !$db ) {error_log($db->error);return REGISTRATION_WRITE_SQL_ERROR;}
        if(!($result = $db->query( "SELECT `*` FROM `login_tan`",  []) ) ) {error_log($db->error);return; }
        return $db->resultToArray( $result );
    }
	
	//#######
	//#
	//#	    Generates User ID
	//#
	//#######

    protected function generateUsername( $db, $name, $surname ) {
        $result;$user;
        $salt = 0;
        do {
           $user = $name.$surname.($salt==0?"":$salt);
           if(!($result = $db->query( "SELECT `user_id` FROM `profiles` WHERE `user_id` Like '§0'",[$user] ) ) ) {error_log($db->error);return; }
           $salt++;
        } while( $result->num_rows != 0 );
        return $user;
    }
	

    public $user = false;

	//#######
	//#
	//#	    Checks TAN
	//#
	//#######

    protected function tanLogin( $tan ) {
        $db = new DB();
        if( !$db ) {error_log($db->error);return REGISTRATION_WRITE_SQL_ERROR;}
        if(!($result = $db->query( "SELECT `*` FROM `login_tan` WHERE `id` Like '§0'",[$tan] ) ) ) {error_log($db->error);return REGISTRATION_WRITE_SQL_ERROR;}
        if( $result->num_rows == 0 ) return TAN_NOT_FOUND;
        $result = $db->resultToArray( $result, 1 )[0];
        //$this->generateUsername( $db, $result["name"], $result["surname"] );                ############# MOVE TO CREATE TANS
        $this->user = $result["username"];        
        $result["status"] = TAN_LOGIN_OK;
        if(!($rslt = $db->query( "DELETE FROM `login_tan` WHERE `id` Like '§0'",[$tan] ) ) ) {error_log($db->error);return REGISTRATION_WRITE_SQL_ERROR;}
        return $result;
    }
	
	protected function writeEntry( $nm, $pw, $fn, $ln ) {
		//$pw = password_hash($pw, PASSWORD_DEFAULT);
		$db = new DB();
		if( !$db ) {error_log($db->error);return REGISTRATION_WRITE_SQL_ERROR;}
		if(!($result = $db->query( "SELECT `id` FROM `login_info` WHERE `id` Like '§0'",[$nm] ) ) ) {error_log($db->error);return REGISTRATION_WRITE_SQL_ERROR;}
		if( $result->num_rows > 0 ) return REGISTRATION_USER_EXISTS;
		if(!($result = $db->query( "INSERT INTO `login_info` ( id, password ) VALUES ( '§0', '§1' )",[$nm,$pw] ) ) )   {error_log($db->error);return REGISTRATION_WRITE_SQL_ERROR;}
		if(!($result = $db->query( "SELECT `user_id` FROM `profiles` WHERE `user_id` Like '§0'",[$nm] ) ) ) {error_log($db->error);return REGISTRATION_WRITE_SQL_ERROR;}
		if( $result->num_rows == 0 ) if(!($result = $db->query( "INSERT INTO `profiles` ( user_id, fname, lname ) VALUES ( '§0', '§1', '§2' )",[$nm,$fn,$ln] ) ) ) {error_log($db->error);return REGISTRATION_WRITE_SQL_ERROR;}
		return REGISTRATION_SUCCESSFULL;
	}
	
	//#######
	//#
	//#	    Merges all the steps and checks for errors
	//#
	//#######
	public function register( $tan, $password ) {
		$tanLogin = $this->tanLogin( $tan );
        
		if( $tanLogin["status"] != TAN_LOGIN_OK ) {
			$this->error = $tanLogin;
			return false;
		}
		$status = $this->writeEntry( $this->user, $password, $tanLogin["name"], $tanLogin["surname"] );
		if( $status != REGISTRATION_SUCCESSFULL ) {
			$this->error = $status;
			return false;
		}
		return true;
	}
	
}


?>
