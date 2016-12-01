<?php ?>
<form class="container" method="post" action="/Signup/">
	<div class="row s12">
		<div class="input-field col s12 m4 offset-m4 center-align">
          <h1>Registrieren</h1>
        </div>
     </div>
     <div class="row s12">
		<p class="center-align">Benutze deine Moodle Login Daten um dich zu registrieren</p>
     </div>
     <div class="row s12">
        <div class="input-field col s12 m4 offset-m4">
          <input name="user_name" type="text" class="validate">
          <label for="user_name">Benutzername</label>
        </div>
     </div>
     <div class="row s12">
        <div class="input-field col s12 m4 offset-m4">
          <input name="user_pw" type="password" class="validate">
          <label for="user_name">Passwort</label>
        </div>
     </div>
     <?php if(REGISTERERROR) echo '<div class="row s12">
        <p class="col s12 center red-text text-darken-2">
          '.REGISTERERROR.'
        </p>
     </div>'?>
     <div class="row s12">
          <input type="submit" value="Registrieren" id="loginbutton" class="waves-effect waves-light btn green col s12 m4 offset-m4">
	</div>
	<div class="row s12  center-align">
		<i class="italic col s12 m4 offset-m4">Oder</i>
	</div>
	<div class="row s12  center-align">
		<a href="/Signin/" class="waves-effect waves-light green btn col s12 m4 offset-m4">Login</a>
	</div>
</form>
