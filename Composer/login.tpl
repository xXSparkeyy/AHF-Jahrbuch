<?php ?>
<form class="container" action="#">
	<div class="row s12">
		<div class="input-field col s12 m4 offset-m4 center-align">
          <h1>Login</h1>
        </div>
     </div>
     <div class="row s12">
        <div class="input-field col s12 m4 offset-m4">
          <input id="user_name" type="text" class="validate">
          <label for="user_name">Benutzername</label>
        </div>
     </div>
     <div class="row s12">
        <div class="input-field col s12 m4 offset-m4">
          <input id="user_pw" type="password" class="validate">
          <label for="user_name">Passwort</label>
        </div>
     </div>
     <?php if(LOGINERROR) echo '<div class="row s12">
        <p class="col s12 center red-text text-darken-2">
          '.LOGINERROR.'
        </p>
     </div>'?>
     <div class="row s12">
          <a id="loginbutton" class="waves-effect waves-light btn green col s12 m4 offset-m4">Login</a>
	</div>
	<div class="row s12  center-align">
		<i class="italic col s12 m4 offset-m4">Oder</i>
	</div>
	<div class="row s12  center-align">
		<a href="/Signup" class="waves-effect waves-light btn green col s12 m4 offset-m4">Registrieren</a>
	</div>
</form>
<form id="loginform" class="hide" method="post" action="/Signin/">
	<input id="loginhash" type="text" name="loginhash" value="">
</form>
<script src="http://www.myersdaily.org/joseph/javascript/md5.js"></script>
<script>
	document.getElementById( "loginbutton" ).onclick = function() {
		var n = document.getElementById( "user_name" ).value
		var p = md5(document.getElementById( "user_pw"   ).value)
		document.getElementById( "loginhash" ).value = n+p;
		document.getElementById( "loginform" ).submit();
	}
</script>
