<?php
class Upload{
  static function showUploadSection($name, $group = ""){
    echo '
    <form id="imguploader'.$name.'" action="/media-upload/upload.php" method="POST" enctype="multipart/form-data">
      <input type="file" name="'.$name.'[]" id="'.$name.'" multiple="multiple"/>
      <input type="text" style="display:none;" name="group" value='.$group.'  />
      <input type="submit" id="uploadbutton'.$name.'" name="submit" value="Upload" />
    </form>
    <div id="preview'.$name.'" style="display:none"></div>
    <div id="loading'.$name.'" style="display:none"></div>
';
  }




}
?>
