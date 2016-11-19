<?php ?>
<div class='container' action='#'>
	<div class='row'>
		<?php if (Login::isAdmin(Login::checkUser()['user_id'])){ ?>
			<div class='col s6'>
				<ul class='collection with-header'>
					<li class='collection-header'><h4>Benutzer</h4></li>

			    <?php
						$res = Search::forUsers( '' );
						foreach( $res as $itm ) {
							$s = $itm['title'];
							$a = $itm['link'];
							echo "
							<li class='collection-item avatar '>
								<a href='/profil/$a'>
								<img src='images/yuna.jpg' alt='' class='circle'>
								<span class='title'>$s</span>
								<p>First Line <br>
								</p>
								</a>
							</li>
							";
						}
						?>

			  </ul>
			</div>
		<?php }else{ ?>
		<h1 class='center s12 l8 offset-l2'>Jahrbuch seite des MH27 Abschluss Jahres</h1>
		<h5 class='center s12 l8 offset-l2'>Logge dich ein oder registriere dich ( 4 free ) um den vollen inhalt zu genießen.<br>Das desing is ( schlampig ) mit http://materializecss.com/navbar.html gemacht, so schlampig das hier ne verlinkung fehlt.</h5>
		<?php } ?>
	</div>

</div>
