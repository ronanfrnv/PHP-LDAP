<!DOCTYPE html>
<html>
<?php
		require_once("ClasseLDAP.php");
		$monldap = new annuaire("10.108.80.3");  // instanciation de la classe (avec l'adresse du serveur ldap)


		//identification
		$dn="uid=".$_GET['login'].",ou=RT2,o=RT,c=Annecy,dc=univ-savoie,dc=iut";
		$passwd = $_GET["mdp"];
		$newpasswd = $_GET["newmdp"];

		if (!($monldap->ouverture($dn,$passwd))) {
	
			print ("<h4>Impossible de s'authentifier au serveur LDAP.</h4>");
            header("Location:pageErreur.html"); 
			}
			
			
		else {
			$monldap->setPassword($newpasswd);
			$filtre="objectclass=person";  // on recherche toutes les personnes
						//$filtre="sn=A*";             // on recherche tous les nom commencant par A
			echo "Recherche des objets avec le filtre : ".$filtre."<br>";
			//lance la recherche
			$n = $monldap->recherche("dc=univ-savoie,dc=iut",$filtre);
			header("Location:page1.html");

			if ($n==0) {
				print ("<h4>Il n'y a aucune réponse à la recherche demandée.</h4>");
				
			}
		}
	?>

<body>
</body>

</html>

