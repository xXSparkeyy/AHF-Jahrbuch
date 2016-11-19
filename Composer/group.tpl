<?php
	$group = new Group( GROUP );
?>
<br><br><br><br>
<div class="container">
	<div class="row">
		<div class="col s10 offset-s2 m4 offset-m4">
			<h1 class="center"><?php echo $group->getName(); ?></h1>
			<h5 class="center">- <?php echo $group->getDescription(); ?> -</h5>
		</div>
     </div>
     <div class="row">
     	<?php
     	foreach($group->getMembers() as $member ) {
     		$name = $member->getFirstName()." ".$member->getLastName();
			echo "
			<div class='col s6 m3' style=\"padding: 2%\">
				<div class='card-panel grey lighten-5 z-depth-1'>
					<img src=\"https://cdn3.iconfinder.com/data/icons/avatar-set/512/Avatar02-512.png\" class=\"circle responsive-img\">
					<h4 class=\"center\">$name</h4>
				</div>
			</div>";
		}
		?>
     </div>
</div>
