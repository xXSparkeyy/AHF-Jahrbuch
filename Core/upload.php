<?php
class Upload{
  static function showUploadSection($name, $group = ""){
    echo '
    <form id="imguploader'.$name.'" action="/media-upload/upload.php" method="POST" enctype="multipart/form-data">
      <label for="fselect'.$name.'"><a class="waves-effect waves-light btn">1. Select File(s)</a></label>
      <input id="fselect'.$name.'" style="position:fixed;top:-100%" type="file" name="'.$name.'[]" multiple="multiple"/>
      <input type="hidden" name="group" value='.$group.'  />
      <label for="uploadbutton'.$name.'"><a class="waves-effect waves-light btn">2. Upload File(s)</a></label>
      <input style="position:fixed;top:-100%" type="submit" id="uploadbutton'.$name.'" name="submit" value="Upload" />
    </form>
    <br>
    <div id="preview'.$name.'" style="display:none"></div>
    <div id="loading'.$name.'" style="display:none">Lädt hoch...</div>
';
  }




}
?>
