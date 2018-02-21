  <?php require_once $_SERVER["DOCUMENT_ROOT"]."/Core/index.php";
	ini_set("upload_max_filesize", "8M");

	function codeToMessage($code) 
    { 
        switch ($code) { 
            case UPLOAD_ERR_INI_SIZE: 
                $message = "Das Bild ist zu Groß! Maximale Größe: ".ini_get("upload_max_filesize"); 
                break; 
            case UPLOAD_ERR_FORM_SIZE: 
                $message = "Das Bild ist zu Groß!";
                break; 
            case UPLOAD_ERR_PARTIAL: 
                $message = "Das Bild wurde nicht vollstandig hochgeladen"; 
                break; 
            case UPLOAD_ERR_NO_FILE: 
                $message = "Es Wurde kein Bild hochgeladen!"; 
                break; 
            case UPLOAD_ERR_NO_TMP_DIR: 
                $message = "Interner Fehler ( 1 )"; 
                break; 
            case UPLOAD_ERR_CANT_WRITE: 
                $message = "Interner Fehler ( 2 )"; 
                break; 
            case UPLOAD_ERR_EXTENSION: 
                $message = "Format nicht zulässig!"; 
                break; 

            default: 
                $message = "Interner Fehler ( 3 )"; 
                break; 
        } 
        return $message; 
    } 
    
    function crandom_bytes($n=5) {
    	$ret = "";for( $i=0;$i<$n;$i++)$ret+=chr(rand(65,90)); return $ret;
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      $r = $_SERVER["DOCUMENT_ROOT"];
      if(isset($_FILES['profil'])){
        $statement = Login::checkUser()["user_id"];
        $upload_type = 'profil';
      }else if(isset($_FILES['group'])){
        $statement = $_POST['group'];
        $upload_type = 'group';
      }else if(isset($_FILES['profilkind'])){
        $statement = Login::checkUser()["user_id"];
        $upload_type = 'profilkind';
      } else {echo codeToMessage(UPLOAD_ERR_NO_FILE); return; }
      if (!file_exists("$r/media-upload/data/$statement")) {
        mkdir("$r/media-upload/data/$statement", 0777, true);
      }
      $max_size = 6500*6500;
      $extensions = array('jpeg', 'jpg', 'png', 'gif');
      $dir = "$r/media-upload/data/$statement/";
      $count = 0;
        // loop all files
        foreach ( $_FILES[$upload_type]['name'] as $i => $name ) {

		// if file not uploaded then skip it
        if ( $_FILES[$upload_type]['error'][$i] != 0 ) {
        	echo codeToMessage( $_FILES[$upload_type]['error'][$i] )."<br>";
          continue;
        }
          
        // if file not uploaded then skip it
        if ( !is_uploaded_file($_FILES[$upload_type]['tmp_name'][$i]) )
          continue;

          // skip large files
        if ( $_FILES[  $upload_type]['size'][$i] >= $max_size )
          continue;

        // skip unprotected files
        if( !in_array(strtolower(pathinfo($name, PATHINFO_EXTENSION)), $extensions) )
          continue;


          if($upload_type == 'profil' && file_exists($dir."avatar.jpg") ) unlink($dir."avatar.jpg");
          if($upload_type == 'profilkind' && file_exists($dir."avatar_kind.jpg") ) unlink($dir."avatar_kind.jpg");

          switch (strtolower(pathinfo($name, PATHINFO_EXTENSION))) {
              case 'jpg':
              case 'jpeg':
                 $image = imagecreatefromjpeg($_FILES[$upload_type]['tmp_name'][$i]);
              break;
              case 'gif':
                 $image = imagecreatefromgif($_FILES[$upload_type]['tmp_name'][$i]);
              break;
              case 'png':
                 $image = imagecreatefrompng($_FILES[$upload_type]['tmp_name'][$i]);
              break;
          }
          if($upload_type == 'profil'){
          	$exportpath = $dir."avatar".".jpg";
          }else if($upload_type == 'profilkind'){
            $exportpath = $dir."avatar_kind".".jpg";
          }else if($upload_type == 'group') {
            $exportpath = $dir.time().".".Login::checkUser()["user_id"].".".crandom_bytes(5).".jpg";
          } else continue;

          if( imagejpeg($image, $exportpath, 100) ) $count++;
      }

      echo "$count Bild".($count!=1?"er":"")." erfolgreich hochgeladen!";

    }
    
 ?>
