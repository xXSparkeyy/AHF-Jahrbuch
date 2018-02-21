<?php ?>
<style>
    @media print {
        
        nav, .hidep {
            display: none;
        }
    }
    th, td {
        padding: 0px 5px;
    }
    tr.last {
        border-bottom: dotted 1px black;
        margin-bottom: 2%;
    }
</style>
<div class='container' action='#'>
	<div class='row'>
		    <div class="col s12 hidep">
                <h1>Nutzer Hinzufügen</h1>
                <form action="." method="post">
                    <textarea style="min-width: 100%; max-width: 100%;" name="list" placeholder="Name1 Nachname1<?php echo "\n" ?>Name2 Nachname2<?php echo "\n" ?>(Nur ein Vorname)"></textarea>
                <input type="submit">
                </form>
            </div>
            <div class="col s12">
                <h1 class="hidep">TAN Liste</h1>
                <table id="tanlist">
                <?php foreach( Registration::listTans() as $tan ) {?>
                    <tr>
                        <th>Vorname</th><th>Nachname</th><th>Benutzername</th><th>Schlüssel</th>
                    </tr>
                    <tr>
                        <td><?php echo $tan["name"]; ?></th>
                        <td><?php echo $tan["surname"]; ?></th>
                        <td><?php echo $tan["username"]; ?></th>
                        <td><?php echo $tan["id"]; ?></th>
                    </tr>
                    <tr class="last">
                        <td colspan="4"><i><?php echo Registration::explanation(); ?></i></td>
                    </tr>
                <?php } ?>
                </table>
                <div class="button hidep" onclick="window.print()">Drucken</div>
            </div>
            
	</div>

</div>
