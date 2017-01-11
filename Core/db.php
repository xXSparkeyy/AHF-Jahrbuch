<?php require_once( "ngit_sqlcreds.php" );
	if( isset($_COOKIE["debug"]) ) ini_set( "display_errors", "1" );
	else ini_set( "display_errors", "0" );

	class DB extends mysqli {
		
		function connect() {
			parent::connect(YB_HOST, YB_USER, YB_PASSWD, YB_TABLE);
			if( $this->connect_errno ) {
				error_log( $this->connect_error );
				return False;
			}
			return true;
		}
		function matchedRows() {
			preg_match_all ('/(\S[^:]+): (\d+)/', $this->info, $matches); 
			$info = array_combine ($matches[1], $matches[2]);
			return $info["Rows matched"];
		}
		
		public function query( $query, $params=[] ) {
				for($i=0;$i<count($params);$i++) {
					$query = str_replace( "§$i", $this->real_escape_string($params[$i]), $query );
				}
				return parent::query( $query );
		}
		function DB() {
			$this->connect();
		}
	}
?>
