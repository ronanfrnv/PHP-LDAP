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

