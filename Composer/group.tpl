<?php
	$group = new Group( GROUP );
	$usr = $login_user["user_id"];
?>
<br><br><br><br>
<div class="container">
	<img src="http://i.imgur.com/jtkTPvb.gif" class="right" id="loading">
	<div class="row">
		<div class="col s10 offset-s2 m4 offset-m4">
			<h1 class="center"><?php echo $group->getName(); ?></h1>
			<h5 class="center">- <?php echo $group->getDescription(); ?> -</h5>
		</div>
     </div>
     <div class="row">
			 <div class='col s12'>
 				<ul class="tabs">
 					<li class="tab col s6"><a href="#members" class="active">Mitglieder</a></li>
 					<li class="tab col s6"><a href="#images">Bilder</a></li>
 				</ul>
 				<div id="members" class="col s12" style="margin: 0 auto;">
 						<ul class='collection'>
 							<div id="memberparent">
								<style>
									.group-member       .controls {
										position: absolute;
										top: 0; left: 0;
										width: 100%;
										opacity: 0;
										transition: opacity 0.3s linear;
										padding: 20% 10%;
									}
									.group-member:hover .controls {
										opacity: 1;
									}
									.modbutton {
								 		background: grey !important;
								 	}
								 	.modbutton[enabled] {
								 		background: #ffeb3b !important;
								 	}
								</style>
								<?php
								foreach($group->getMembers() as $member ) {
									$name = $member->getFirstName()." ".$member->getLastName();
									$id = $member->getID();
									$img = $member->getAvatar();
									$controls = !Group::isMod(GROUP,$login_user["user_id"])?"":'
									<div class="controls">
											<a id="modbutton'.$id.'" href="javascript:'.(Group::isMod(GROUP,$id,true)?"revokeMod('$id')\" enabled":"grantMod('$id')\"").' class="modbutton btn-floating btn-large waves-effect waves-light red left"><i class="material-icons">star</i></a>
											<a href="javascript:kick(\''.$id.'\')" class="btn-floating btn-large waves-effect waves-light red right"><i class="material-icons">block</i></a>
										</div>';
								echo "
								<div id='member$id' class='col s6 m4 l3' style=\"padding: 2%\">
									<div style=\"position: relative\" class='card-panel grey lighten-5 z-depth-1 group-member'>
										<div style=\"position: relative\"><a href=\"/profiles/$id/\"><div style=\"background: url($img)\" class=\"avatar circle\"></div></a></div>
										<h4 class=\"center\">$name</h4>
										$controls
									</div>
								</div>";
								}
								if( Group::isMod(GROUP,$login_user["user_id"]) ) echo '<div id="addmembercard" class="col s6 m4 l3" style="padding: 2%">
									<div style="position: relative" class="card-panel grey lighten-5 z-depth-1 group-member">
										<div style="position: relative"><a class="modal-trigger" href="#adduserview"><div style="background: url(/media-upload/data/add.svg)" class="avatar circle"></div></a></div>
										<h4 class="center">Benutzer Hinzufügen</h4>
									</div>
								</div>';
								?>
								
 							</div>
 						</ul>
 					</div>
 				
 					<script>
						 function grantMod( id ) {
						 	var adb = document.getElementById( "modbutton"+id )
						 	var x = new XMLHttpRequest()
						 	x.open( "GET", "/JSON/grantmod/?group=<?php echo GROUP; ?>&user="+id  );
						 	x.onreadystatechange = function() {
						 		if( x.readyState == 4 && x.status == 200 ) {
						 			var a = true;//eval(x.responseText);
						 			if( a ) { adb.href="javascript:revokeMod('"+id+"')"; adb.setAttribute("enabled","")}
						 			else    { adb.href="javascript:grantMod('"+id+"')";  adb.removeAttribute("enabled")}
						 		}
						 	}
						 	x.send();
						 }
						 function revokeMod( id ) {
						 	var adb = document.getElementById( "modbutton"+id )
						 	var x = new XMLHttpRequest()
						 	x.open( "GET", "/JSON/revokemod/?group=<?php echo GROUP; ?>&user="+id );
						 	x.onreadystatechange = function() {
						 		if( x.readyState == 4 && x.status == 200 ) {
						 			var a = false;//eval(x.responseText);
						 			if( a ) { adb.href="javascript:revokeMod('"+id+"')"; adb.setAttribute("enabled","")}
						 			else    { adb.href="javascript:grantMod('"+id+"')";  adb.removeAttribute("enabled")}
						 		}
						 	}
						 	x.send();
						 }
						 function kick( id ) {
						 	var adb = document.getElementById( "member"+id )
						 	var x = new XMLHttpRequest()
						 	x.open( "GET", "/JSON/removefromgroup/?group=<?php echo GROUP; ?>&user="+id );
						 	x.onreadystatechange = function() {
						 		if( x.readyState == 4 && x.status == 200 ) {
						 			var name = adb.getElementsByTagName("h4")[0].innerText
						 			adb.remove();
						 			document.getElementById( "addlist" ).innerHTML+="<li style='font-size: 140%;' id='addmbmr"+id+"' style='padding: 1%'><a href=\"javascript:add('"+id+"')\"><i style='vertical-align: middle;font-size: inherit'class=\"material-icons\">add_circle_outline</i> "+name+"</a></li>";
						 		}
						 	}
						 	x.send();
						 }
						 function add( id ) {
						 	var adb = document.getElementById( "addmbmr"+id )
						 	var x = new XMLHttpRequest()
						 	x.open( "GET", "/JSON/addtogroup/?group=<?php echo GROUP; ?>&user="+id );
						 	x.onreadystatechange = function() {
						 		if( x.readyState == 4 && x.status == 200 ) {
						 			adb.remove();
						 			eval( "var m = "+x.responseText )
									var o = document.createElement('div');
									o.innerHTML = "<div id='member"+id+"' class='col s6 m4 l3' style=\"padding: 2%\"><div style=\"position: relative\" class='card-panel grey lighten-5 z-depth-1 group-member'><div style=\"position: relative\"><a href=\"/profiles/"+id+"/\"><div style=\"background: url("+m.img+")\" class=\"avatar circle\"></div></a></div><h4 class=\"center\">"+m.name+"</h4><div class=\"controls\"><a id=\"modbutton"+id+"\" href=\"javascript:grantMod('"+id+"')\" class=\"modbutton btn-floating btn-large waves-effect waves-light red left\"><i class=\"material-icons\">star</i></a><a href=\"javascript:kick('"+id+"')\" class=\"btn-floating btn-large waves-effect waves-light red right\"><i class=\"material-icons\">block</i></a></div></div></div>"
						 			o = o.firstChild;
						 			document.getElementById( "memberparent" ).insertBefore(o,document.getElementById( "addmembercard" ))
						 		}
						 	}
						 	x.send();
						 }
     				</script>
 					
 					<div id="groups" class="col s12">
 						<ul class='collection with-header'>
 							<div align="center">
							<a  href="#uploadview" class="waves-effect waves-light btn center modal-trigger" style="width: 100%;"><i class="material-icons left">cloud</i>Bilder hochladen</a>
 							</div>
							<div id="gallery">
							<?php
						try{
							$dir = new DirectoryIterator('../media/img/'.$group->getID());
							foreach ($dir as $fileinfo) {
									if (!$fileinfo->isDot()) {
										$path = '/media/img/';
										$path .= $group->getID().'/';
										$path .= $fileinfo->getFilename();

										?>
											<img src="<?php echo $path ?>" class="materialboxed responsive-img" style="margin:0" alt=""  width="200px" width="200px">
											<?php
									}
							}

						}catch(Exception $e)
						{
						}

							?>
						</div>
 						</ul>
 					</div>

 			</div>
     </div>
</div>
</div>
<div id="uploadview" class="modal bottom-sheet">
    <div class="modal-content">
      <h4>Profilbild hochladen:</h4>
      <?php Upload::showUploadSection('group', $group->getID());?>

    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Abbrechen</a>
    </div>
  </div>
	<div id="adduserview" class="modal modal-fixed-footer">
	    <div class="modal-content">
	      <h4>Benutzer hinzufügen:</h4>
	      <ul id="addlist" style="padding-left: 1%;">
	      <?php
				$res = Profile::listProfiles();
				foreach( $res as $itm ) {
					$name = $itm["FName"]." ".$itm["LName"];
					$link = $itm["user_id"];
					if( $group->isMember($link) ) continue;
					echo "<li style='font-size: 140%;' id='addmbmr$link' style='padding: 1%'><a href=\"javascript:add('$link')\"><i style='vertical-align: middle;font-size: inherit'class=\"material-icons\">add_circle_outline</i> $name</a></li>";
				}?>
			</ul>
	    </div>
	    <div class="modal-footer">
	      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Abbrechen</a>
	    </div>
	  </div>
