<?php
	$q = explode( "/", $_SERVER['REQUEST_URI'] );
	$q=isset($q[2])?$q[2]:"";
?>
<div class="container" action="#">
	<form id="searchform" action="#" class="row">
		<div class="input-field">

		  		<i class="material-icons float_l search_icon">search</i>
					<span>
						<input id="search" class="search_bar" type="search" value="<?php echo $q;?>">
					</span>

		</div>
 	</form>
 	<div id="searchresult">
 	 	
	<script>
 		$("#searchform")[0].onsubmit = function( e ) {
 			e.preventDefault();
 			var query = $("#search")[0].value;
 			history.replaceState( query, "Suche", "/search/"+query );
 			doSearch( query )
 		}
 		window.addEventListener("popstate", function(e) {
    		doSearch( e.state )
		});
 		function doSearch( q ) {
 			var x = new XMLHttpRequest()
 			x.open( "GET", "/api/search/?query="+q )
 			x.onreadystatechange = function() {
 				if( x.readyState == 4 ) {
 					$("#searchresult")[0].innerHTML = x.responseText;
 				}
 			}
 			x.send()
 		}
 		document.body.onload = function(e) { doSearch( "<?php echo $q;?>" ); }
 	</script>
</div>
