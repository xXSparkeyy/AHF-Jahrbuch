<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";
	if( count( $_GET ) > 0 ) {
		$usr = Login::checkUser()["user_id"];
		$p = new Profile( $usr );
		$firstname= "";
		$lastname = "";
		foreach( $_GET as $id => $value ) {
			if( $id == "firstname" ) { $firstname=$value; continue; }
			if( $id == "lastname"  ) { $lastname =$value; continue; }
			foreach( $p->getFields() as $field ) {
				if( $field["field_id"] == $id ) {
					switch( $field["field_type"] ) {
						case 1:
							$p->changeField( $id, $value );
						break;
						case 4:
							$p->changeField( $id, $value );
						break;
						case "2":
							$p->changeField( $id, explode( "|", $field["field_opt"] )[$value] );
						break;
						case "3":
							$v = explode( "|", $field["field_opt"] );
							$s = []; foreach( $value as $i ) {
								$s[] = $v[$i];
							} 
							$p->changeField( $id, implode("|", $s) );
						break;
					}
				}
			}
		}
		$p->changeInfo( $firstname, $lastname );
		$log( "Profile", "$usr changed her/his profile" );
	}
	http_response_code( 302 );
	header( "Location: /profile/me/" );
?>
