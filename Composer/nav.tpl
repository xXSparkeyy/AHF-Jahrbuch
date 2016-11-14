<?php ?>
<nav>
	<div class="nav-wrapper light-green">
		<a href="#!" class="brand-logo"><?php echo Login::isAdmin(Login::checkUser()["user_id"])?"Im Admin modus sieht alles kacke aus":"Jahrbuch"; ?></a>
		<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		<ul class="right hide-on-med-and-down">
			<li><a href="/search/"><i class="material-icons left">search</i>Suche</a></li>
			<li><a href="/Surveys/"><i class="material-icons left">assignment</i>Umfragen</a></li>
			<li><a href="<?php $user = Login::checkUser(); echo $user?"/profile/".$user["user_id"]:"/Signin/" ?>"><i class="material-icons left">account_circle</i><?php $user = Login::checkUser();if( $user ) { $u = new Profile( $user["user_id"] ); echo $u->getFirstName()." ".$u->getLastName(); } else { echo "Anmelden"; } ?></a></li>
		</ul>
		<ul class="side-nav" id="mobile-demo">
			<li><a href="/search/"><i class="material-icons left">search</i>Suche</a></li>
			<li><a href="/Surveys/"><i class="material-icons left">assignment</i>Umfragen</a></li>
			<li><a href="<?php $user = Login::checkUser(); echo $user?"/profile/".$user["user_id"]:"/Signin/" ?>"><i class="material-icons left">account_circle</i><?php $user = Login::checkUser();if( $user ) { $u = new Profile( $user["user_id"] ); echo $u->getFirstName()." ".$u->getLastName(); } else { echo "Anmelden"; } ?></a></li>
		</ul>
	</div>
</nav>
