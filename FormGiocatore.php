<?php
require("Risorse.php");
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Tris</title>
		<link type="text/css" href="Stile.css" rel="stylesheet">
		
		<?php
			if(isset($_GET["personalizza"]))
			{
				$_SESSION["nomeUtente"]=$_GET["nomeUtente"];
				$_SESSION["simboloUtente"]=$_GET["iconaUtente"];
				$_SESSION["simboloBot"]=$_GET["iconaBot"];
				
			}
			if(isset($_GET["partita"]))
			{
				$_SESSION["tris"]=$tris;
				$_SESSION["mosse"]=0;
				
				if(isset($_GET["turno"]) && isset($_GET["difficolta"]))
				{
					$_SESSION["turno"]=$_GET["turno"];
					$_SESSION["difficolta"]=$_GET["difficolta"];
				}
				else
				{
					$_SESSION["turno"]="utente";
					$_SESSION["difficolta"]=1;
				}
				unset($_SESSION["vittoria"]);
				
				if($_SESSION["turno"]=="bot")
					header("Location:Elabora.php");
			}
			else
			{
				if(isset($_SESSION["vittoria"]))
					echo "<h1 id='vittoria'>".$_SESSION["vittoria"]."</h1>";
			
				if(isset($_SESSION["tris"]))
					$tris=$_SESSION["tris"];
				else
				{
					$_SESSION["tris"]=$tris;
					$_SESSION["difficolta"]=1;
					$_SESSION["mosse"]=0;
					$_SESSION["turno"]="utente";
					$_SESSION["vittorieUtente"]=0;
					$_SESSION["vittorieBot"]=0;
					$_SESSION["pareggi"]=0;
					$_SESSION["nomeUtente"]="Utente";
					$_SESSION["simboloUtente"]="icona1.jpg";
					$_SESSION["simboloBot"]="icona2.jpg";
				}
			}
			
		?>
	</head>
	<body>
		<?php
			echo "<h1>Gioco del TRIS (Livello difficoltà ".$_SESSION["difficolta"].")</h1>";
			echo "<b>".$_SESSION["nomeUtente"]."=</b><img src='img/".$_SESSION["simboloUtente"]."' width='15px'>";
			echo "<b>   Bot=</b><img src='img/".$_SESSION["simboloBot"]."' width='15px'>";
			echo "<p>Mosse effettuate ".$_SESSION["mosse"]."</p>";
		?>
		<form method="GET" action="Elabora.php">
			<?php
				$tris->stampaTabellaTris();
				echo "<br>";
				if(isset($_SESSION["vittoria"]))
					echo "<input type='submit' name='azione' value='Invio mossa' disabled>";
				else
					echo "<input type='submit' name='azione' value='Invio mossa'>";
			?>
		</form>
		<br>
		
		<h1>Avvio nuova partita</h1>
		<form method="GET" action="FormGiocatore.php">
			Scegli chi inizia la partita:
			<select name="turno">
				<?php
					echo "<option value='utente'>".$_SESSION["nomeUtente"]."</option>";
				?>
				<option value="bot">Bot</option>
			</select>
			<br>
			<br>
			Scegli il livello di difficoltà
			<br>
			<input type="radio" name="difficolta" value="1">Livello 1:Casuale
			<br>
			<input type="radio" name="difficolta" value="2">Livello 2:Difesa
			<br>
			<input type="radio" name="difficolta" value="3">Livello 3:Attacco e Difesa
			<br>
			<input type="radio" name="difficolta" value="4">Livello 4:Difficile
			<br>
			<br>
			<input type="submit" name="partita" value="Nuova Partita">
		</form>
		
		<br>
		<h1>Personalizza la grafica</h1>
		<form method="GET" action="FormGiocatore.php">
			Scegli il nome dell'utente:
			<input type="text" name="nomeUtente">
			<br>
			<?php
				$icone=array("icona1.jpg","icona2.jpg","icona3.jpg","icona4.jpg","icona5.jpg");
				echo "<br>";
				echo "Scegli l'icona per ".$_SESSION["nomeUtente"]."<br>";
				
				for($i=0;$i<count($icone);$i++)
				{
					echo "<input type='radio' name='iconaUtente' value='".$icone[$i]."'>";
					echo "<img src='img/".$icone[$i]."' width='15px'>";
				}
				
				echo "<br>";
				echo "<br>";
				echo "Scegli l'icona per il Bot<br>";
				
				for($i=0;$i<count($icone);$i++)
				{
					echo "<input type='radio' name='iconaBot' value='".$icone[$i]."'>";
					echo "<img src='img/".$icone[$i]."' width='15px'>";
				}
				echo "<br>";
				echo "<br>";
			?>
			
			<input type="submit" name="personalizza" value="Salva">
		</form>
		<h1>Statistiche risultati</h1>
		<?php
			echo "<p>Vittorie ".$_SESSION["nomeUtente"].": ".$_SESSION["vittorieUtente"]."</p>";
			echo "<p>Vittorie Bot: ".$_SESSION["vittorieBot"]."</p>";
			echo "<p>Pareggi: ".$_SESSION["pareggi"]."</p>";
		?>
	</body>
</html>