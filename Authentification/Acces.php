<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Acces admin au LDAP avec PHP</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php
        require_once("ClasseLDAP.php");
        $monldap = new annuaire("10.108.80.3");  // instanciation de la classe (avec l'adresse du serveur ldap)

        //identification
        $dn="uid=logAppliT1,ou=application,o=administratif,c=Annecy,dc=univ-savoie,dc=iut";
        $passwd="mdpAppli";

        if (!($monldap->ouverture($dn,$passwd))) {
			print ("<h4>Impossible de s'authentifier au serveur LDAP.</h4>"); }
        else {
			$filtre="objectclass=person";  // on recherche toutes les personnes
                        //$filtre="sn=A*";             // on recherche tous les nom commencant par A
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
				echo "<td>cn</td>";
				echo "<td>pwd</td>";
				echo "</tr>";
				for ($i=0; $i<$n; $i++) {
					echo "<tr>";
					echo "<td>".$monldap->getLigneAttribut($i,"cn")."</td>";
					echo "<td>".$monldap->getLigneAttribut($i,"userpassword")."</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
        }
    ?>
  </body>
</html>
