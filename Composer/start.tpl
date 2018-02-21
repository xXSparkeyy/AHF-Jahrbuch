<?php ?>
<div class='container' action='#'>
	<div class='row'>
		<?php if (Login::isAdmin(Login::checkUser()['user_id'])){ ?>
			<div class='col s6'>
				<ul class='collection with-header'>
					<li class='collection-header'><h5>Benutzer (<?php $profiles = Profile::listProfiles( ); echo count( $profiles ) ?>)
                    <a href="/Signup/Tanmanager/" style="vertical-align:middle;font-size:inherit" class="material-icons">add_circle_outline</a>                    
                    </h5></li>
						<div class='dashboard_info_container'>
			    <?php
						foreach( $profiles as $itm ) {
							$name = $itm['FName']." ".$itm['LName'];
							$id = $itm['user_id'];
							echo "
							<a href='/profile/$id/'><li class='collection-item '>
								<h5><i class='material-icons left'>account_circle</i><span class='title'>$name</span></h5>
							</li></a>
							";
						}
						?> 
						</div>
			  </ul>
			</div>
			<div class='col s6'>
				<ul class='collection with-header'>
					<li class='collection-header'><h5>Log's</h5></li>
					<div class='dashboard_info_container'>
					<?php
						$res = Log::getMessages( );
						foreach( $res as $itm ) {
							$name = $itm['name'];
							$content = $itm['content'];
							$date = $itm['date'];
							echo "
							<li class='collection-item'>
								<span class='title grey-text'>[$name]</span> <span>$content</span> <span class='light-green-text right'>($date)</span>
								</p>
							</li>
							";
						}
						?>
					</div>

				</ul>
			</div>
			<div class='col s12'>
				<ul class="tabs">
					<li class="tab col s6"><a href="#surveys" class="active">Umfragen (<?php $surveys = Survey::getSurveys( false ); echo count( $surveys ) ?>)</a></li>
					<li class="tab col s6"><a href="#groups">Gruppen (<?php $groups = Group::getGroups(); echo count( $groups ) ?>)</a></li>
				</ul>
				<div id="surveys" class="col s12">
						<ul class='collection'>
							<div class='dashboard_info_container'>
							<?php

								foreach( $surveys as $itm ) {
									$title = $itm['survey_title'];
									$desc = $itm['survey_description'];
									$id = $itm['survey_meta_id'];
									echo "

									<a href='/Surveys/$id/'><li class='collection-item'>
										<b class='title'>$title</b>
										<p>$desc</p>
									</li></a>

									";
								}
								?>
							</div>

						</ul>
					</div>
					<div id="groups" class="col s12">
						<ul class='collection with-header'>
							<div class='dashboard_info_container'>
							<?php

								foreach( $groups as $itm ) {
									$name = $itm['name'];
									$desc = $itm['description'];
									$id = $itm['group_id'];
									echo "
									<a href='/group/$id/'><li class='collection-item'>
										<b class='title'>$name</b>
										<p>$desc</p>
									</li></a>
									";
								}
								?>
							</div>
						</ul>
						<a class="modal-trigger waves-effect waves-light btn" href="#addgroup">Add group</a>

					  <div id="addgroup" class="modal">
						<div class="modal-content">
						  <form id="createform" method="POST" action="/group/setValues.php"><h4>Create new Group</h4>
						  <div class="input-field col s12"><input id="cfn" type="text" name="name"><label for="cfn">Name der Gruppe</label></div>
						  <div class="input-field col s12"><input id="cfd" type="text" name="desc"><label for="cfd">Beschreibung</label></div>
						  <input type="hidden" name="newgroup" value="true">
						  </form>
						</div>
						<div class="modal-footer">
						  <a href="javascript:$('#createform').submit()" class="modal-action waves-effect waves-green btn-flat ">Create</a>
						  <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancel</a>
						</div>
					  </div>
					</div>

			</div>
			
			  
		<?php }else{ ?>
		<h1>Abschluss 2017</h1>
		<?php foreach(Profile::listProfiles() as $usr ) {
				$member = new Profile( $usr["user_id"], false );
				$name = $member->getFirstName()." ".$member->getLastName();
				$id = $member->getID();
				$img = $member->getAvatar();?>
			<div class="col s6 m4 l3" style="padding: 2%; min-height: 400px;">
				<a href="/profile/<?php echo $id;?>/"><div style="position: relative" class="card-panel grey lighten-5 z-depth-1 group-member">
					<div style="position: relative"><div style="background: url(<?php echo $img;?>)" class="avatar circle"></div></div>
					<h4 class="center">
						<?php echo $name;?>
					</h4>
				</div></a>
			</div>
		
		<?php }} ?>
	</div>

</div>
