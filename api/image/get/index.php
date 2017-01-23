<?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php"; $login_user = Login::checkUser(); ?>
<?php if( !$login_user ) {
		echo "<h1>Bitte anmelden.</h1>";
		return;
	}
	if(isset($_GET["group"])) {
		$group = $_GET["group"];
	} else {
		try {
			$ref = explode( "/" ,parse_url( $_SERVER["HTTP_REFERER"] )["path"] );
			if( $ref[1] != "group") return;
			$group = $ref[2];
		}
		catch(Exception $e) {}
	}
	
	if( !$group      ) return;
	if( $group==""   ) return;
	if( $group=="."  ) return;
	if( $group==".." ) return;
	$ret = [];
	try{
		$path = '/media-upload/data/'.$group."/";
		$dir = new DirectoryIterator($_SERVER["DOCUMENT_ROOT"].$path);
		foreach ($dir as $fileinfo) {
				if (!$fileinfo->isDot()) {
					$img = $path.$fileinfo->getFilename();
					//TEST img
					$ret[] = $img;
				}
		}

	}catch(Exception $e)
	{
	}
	echo json_encode( $ret )
?>
