# PHP-LDAP

On peut relever certains des attributs classiques :
```
cn = common name - nom commum.

gn = given name - prénom.

sn = surname - surnom

ou = organisational unit – nom du service de l'entreprise

dc = domain component

o = organization name – nom de l'entreprise

uid = UserId - identifiant unique de l'utilisateur

```
En résumé, créer et utiliser un utilisateur spécifique tel que "LogAppliT1" plutôt que de se connecter en tant qu'administrateur est une pratique de sécurité recommandée. Cela limite les risques potentiels, facilite le suivi et l'audit, et permet une meilleure organisation et gestion des tâches liées à l'application.
Dans l'ACL suivante 


Accès à "attr=userPassword":
        "by self write": Permet à l'utilisateur lui-même d'écrire (modifier) la valeur de l'attribut "userPassword". Cela signifie que l'utilisateur peut changer son propre mot de passe.
        "by anonymous auth": Permet à un utilisateur anonyme (non authentifié) d'effectuer une opération d'authentification. Cela peut être utilisé pour permettre à un utilisateur de se connecter et d'accéder à certaines ressources sans fournir d'identifiants spécifiques.
        "by dn="cn=Admin,dc=univ-savoie,dc=iut" write": Autorise l'utilisateur avec le DN (Distinguished Name) "cn=Admin,dc=univ-savoie,dc=iut" à écrire (modifier) la valeur de l'attribut "userPassword". Cela indique qu'un utilisateur spécifique avec le DN mentionné peut changer le mot de passe.
        "by * none": Refuse l'accès à tous les autres utilisateurs, c'est-à-dire que les autres utilisateurs n'ont pas la permission d'accéder ou de modifier l'attribut "userPassword".

 Accès à "*":
        "by self read": Autorise l'utilisateur lui-même à lire (consulter) les informations de la ressource. Cela signifie que l'utilisateur peut voir ses propres données.
        "by dn="cn=Admin,dc=univ-savoie,dc=iut" write": Autorise l'utilisateur avec le DN "cn=Admin,dc=univ-savoie,dc=iut" à écrire (modifier) la ressource. Cela signifie qu'un utilisateur spécifique avec le DN mentionné peut modifier les informations de la ressource.
        "by dn="uid=logAppliT1,ou=application,o=administratif,c=Annecy,dc=univ-savoie,dc=iut" read": Autorise l'utilisateur avec le DN "uid=logAppliT1,ou=application,o=administratif,c=Annecy,dc=univ-savoie,dc=iut" à lire (consulter) les informations de la ressource. Cela signifie qu'un utilisateur spécifique avec le DN mentionné peut accéder en lecture aux informations de la ressource.
        "by * none": Refuse l'accès à tous les autres utilisateurs, c'est-à-dire que les autres utilisateurs n'ont pas la permission d'accéder ou de modifier la ressource.
        
        
Sur LDAPbrowser pour ce connecter en tant que utilisateur
Je séléctionne l'ou la plus prés de l'uitilisateur
Exemple SMAMO
BaseDN : ou=RT2, o=RT, c=Annecy,dc=univ-savoie,dc=iut
UserDN : uid=anas,ou=RT2, o=RT, c=Annecy,dc=univ-savoie,dc=iut
Et le mot de passe

L'utilisateur voit uniquement ses propres informations et peut modifier uniquement son mot de passe

Concernant l'espace Admin
DN  = "cn=Admin,dc=univ-savoie,dc=iut",
uid : uid=logAppliT1,ou=application,o=administratif,c=Annecy,dc=univ-savoie,dc=iut

Voici le script permettant de lister l'ensemble des personnes présent dans LDAP en php
```
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
```
Le code commence par inclure un fichier appelé "ClasseLDAP.php", qui contient probablement la définition de la classe "annuaire" utilisée ultérieurement.

Ensuite, une instance de la classe "annuaire" est créée avec l'adresse IP du serveur LDAP passé en argument.

Les informations d'identification sont définies avec le nom d'utilisateur (dn) et le mot de passe utilisés pour se connecter au serveur LDAP.

Une tentative d'ouverture de la connexion LDAP est effectuée en appelant la méthode "ouverture" de l'objet "$monldap". Si la connexion échoue, un message d'erreur est affiché.

Si la connexion est établie avec succès, une recherche d'objets est effectuée avec un filtre spécifié (dans cet exemple, le filtre est "objectclass=person", ce qui signifie que toutes les entrées de type "person" seront retournées).

Le nombre d'entrées trouvées est affiché, suivi d'un tableau qui affiche les attributs "cn" (nom commun) et "userpassword" de chaque entrée retournée.

### Voir fichier Acces.php et ClasseLDAP

## Authentification Via LDAP php
Tout d'abord nous alons créer un formulaire PHP
```
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title >Login</title>

</head>
<body>
	<p style="center">Login</p>

	<form action="identification.php" id="idFormLog" method="get">
		<table>
			<tr>
				<td>Login:</td><td><input id="idname" name="login" value=""></td>
			</tr>
			<tr>
				<td>Mot de passe:</td>
				<td><input id="idmdp" Name="mdp" type="password" value=""></td>
			</tr>

		</table>
        <button>Envoi</button>
	</form>
</body>
</html>
```
Puis après dans le fichier identification 

```
<!DOCTYPE html>
<html>
<?php
		require_once("ClasseLDAP.php");
		$monldap = new annuaire("10.108.80.3");  // instanciation de la classe (avec l'adresse du serveur ldap)


		//identification
		$dn="uid=".$_GET['login'].",ou=RT2,o=RT,c=Annecy,dc=univ-savoie,dc=iut";
		$passwd = $_GET["mdp"];

		if (!($monldap->ouverture($dn,$passwd))) {
	
			print ("<h4>Impossible de s'authentifier au serveur LDAP.</h4>");
            header("Location:pageErreur.html"); 
			}
			
			
		else {
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
```
En fonction de la réussite cela redirige vers la bonne page

### Modifier mot de passe
On va d'abord créer une page d'authentification
```
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title >Login</title>

</head>
<body>
	<p style="center">Changement de MDP</p>

	<form action="identificationChangeMDP.php" id="idFormLog" method="get">
		<table>
			<tr>
				<td>Login:</td><td><input id="idname" name="login" value=""></td>
			</tr>
			<tr>
				<td>Mot de passe:</td>
				<td><input id="idmdp" Name="mdp" type="password" value=""></td>
			</tr>
			<tr>
				<td>Nouveau mot de passe:</td>
				<td><input id="idmdp" Name="newmdp" type="password" value=""></td>
			</tr>

		</table>
        <button>Changer le MDP</button>
	</form>
</body>
</html>
```
Puis dans la page IdentificationChangeMDP

```
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
		}
	?>

<body>
</body>

</html>
```
Et redirige vers la bonne page
