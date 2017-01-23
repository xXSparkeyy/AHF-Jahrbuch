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
		
		public function query( $query, $params=[], $echo=false ) {
				for($i=0;$i<count($params);$i++) {
					$query = str_replace( "§$i", $this->real_escape_string($params[$i]), $query );
				}
				if($echo) echo $query;
				return parent::query( $query );
		}
		public function resultToArray($result,$limit=-1) {
			$ret = []; $x=0;while(($e = $result->fetch_array(MYSQL_ASSOC))&&$x!=$limit) {$ret[] = $e; $x++; }
			return $ret;
		}
		function DB() {
			$this->connect();
		}
	}
?>
