<?php
	require("Risorse.php");
	session_start();
	
	$tris=$_SESSION["tris"];
	
	if($_SESSION["turno"]=="utente" && isset($_GET["inserimento"]))
	{
		$elementi=split('-',$_GET["inserimento"]);
		$rigaInserita=$elementi[0];
		$colonnaInserita=$elementi[1];
		
		$_SESSION["mosse"]++;
		$tris->inserisciMossa($tris->UTENTE,$rigaInserita,$colonnaInserita);
		
		$vittoria=$tris->vittoria();
		if($vittoria==-1)
		{
			$_SESSION["tris"]=$tris;
			if($_SESSION["mosse"]==9)
			{
				$_SESSION["vittoria"]="Pareggio";
				$_SESSION["pareggi"]++;
			}
			else
				$_SESSION["turno"]="bot";
		}
		else if($vittoria==$tris->UTENTE)
		{
			$_SESSION["vittoria"]="Ha vinto ".$_SESSION["nomeUtente"];
			$_SESSION["vittorieUtente"]++;
		}
	}
		
	if($_SESSION["turno"]=="bot")
	{
		$_SESSION["mosse"]++;
		$tris->mossaBot($_SESSION["difficolta"]);
		
		$vittoria=$tris->vittoria();
		if($vittoria==-1)
		{
			$_SESSION["tris"]=$tris;
			if($_SESSION["mosse"]==9)
			{
				$_SESSION["vittoria"]="Pareggio";
				$_SESSION["pareggi"]++;
			}
			else
				$_SESSION["turno"]="utente";
		}
		else if($vittoria==$tris->BOT)
		{
			$_SESSION["vittoria"]="Ha vinto Bot";
			$_SESSION["vittorieBot"]++;
		}
	}
	header("Location:FormGiocatore.php");
?>