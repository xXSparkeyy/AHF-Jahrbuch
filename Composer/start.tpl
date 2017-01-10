<?php ?>
<div class='container' action='#'>
	<div class='row'>
		<?php if (Login::isAdmin(Login::checkUser()['user_id'])){ ?>
			<div class='col s6'>
				<ul class='collection with-header'>
					<li class='collection-header'><h5>Benutzer (<?php $profiles = Profile::listProfiles( ); echo count( $profiles ) ?>)</h5></li>
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
		
		
		<style>
			@keyframes spacken {
				000% { left: 10%; top: 3%; }
				020% { left: 46%; top: 0%; }
				040% { left: 36%; top: 25%; }
				060% { left: 0%; top: 50%; }
				080% { left: 50%; top: 0%; }
				100% { left: 19%; top: 33%; }
			}
			@keyframes bgspacken {
				000% { background: #FFF; }
				010% { background: transparent; }
				020% { background: #FF0; }
				030% { background: transparent; }
				040% { background: #0FF; }
				050% { background: transparent; }
				060% { background: #F0F; }
				070% { background: transparent; }
				080% { background: #00F; }
				090% { background: transparent; }
				100% { background: #F00; }
			}
			video { width: 40%; position: fixed; 
				animation: spacken;			
				animation-duration: 3s;
				animation-iteration-count: infinite;
				animation-direction: alternate-reverse;
				animation-timing-function: cubic-bezier(0.45, -0.89, 0.69, 2.89);
			}
			#background {
				width: 100%; left: 0;
				height: 100%; top: 0;
				position: fixed;
				animation: bgspacken;			
				animation-duration: 1s;
				animation-iteration-count: infinite;
				animation-direction: alternate;
				animation-timing-function: cubic-bezier(0.45, -0.89, 0.69, 2.89);
			}
			#leave {
				text-align: center;
				position: fixed;
				width: 100%;
				top: 40%;
			}
		</style>
		
		<div id="background" onclick="copyMV()"><video id="v1" autoplay="true" loop="true" src="/trippycatshit.webm"></video></div>
		<h1 id="leave"><a href="/profile/me/">Zum verlassen hier klicken</a></h1>
		
		<script>
			function copyMV() {
				var x = document.getElementById("v1").cloneNode(); x.setAttribute("muted", "true");document.getElementById("background").appendChild(x)
			}
		</script>
		
		<?php } ?>
	</div>

</div>
