<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title >Login</title>

</head>
<body>
	<p style="center">Recherche de personne</p>

	<form action="" method="get" >
		<table>
			<tr>
				<td>Login:</td><td><input id="idname" name="login" value=""></td>
			</tr>
		</table>
        <button>Envoi</button>
	</form>
</body>
</html>
<!DOCTYPE html>
<html>
<body>
</body>

</html>
<?php
    $valeur = $_GET['login'];
    require_once("ClasseLDAP.php");
        $monldap = new annuaire("10.108.80.3");  // instanciation de la classe (avec l'adresse du serveur ldap)

        //identification
        $dn="uid=logAppliT1,ou=application,o=administratif,c=Annecy,dc=univ-savoie,dc=iut";
        $passwd="mdpAppli";

        if (!($monldap->ouverture($dn,$passwd))) {
			print ("<h4>Impossible de s'authentifier au serveur LDAP.</h4>"); }
        else {
			
            $filtre="uid={$valeur}*";             // A modiier en fonction de ce qu'on recherche
			echo "Recherche des objets avec le filtre : ".$filtre."<br>";
			//lance la recherche
			$n = $monldap->recherche("dc=univ-savoie,dc=iut",$filtre);

			if ($n==0) {
				print ("<h4>Il n'y a aucune réponse à la recherche demandée.</h4>");
			}

			// affichage des résultats
			else {
				echo "Le nombre d'entrées retournées est ".$n."<p>";
				echo "<table>";
				echo "<tr>";  //Ligne entete de tableau
				echo "<td>uid</td>";
				echo "<td>mail</td>";
				echo "</tr>";
				for ($i=0; $i<$n; $i++) {
					echo "<tr>";
					echo "<td>".$monldap->getLigneAttribut($i,"uid")."</td>";
					echo "<td>".$monldap->getLigneAttribut($i,"mail")."</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
        }
?>
