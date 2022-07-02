<?php
	class Tris{
		private $tabellaTris;
		public $DIM_TRIS=3;
		public $VUOTA=0;
		public $UTENTE=1;
		public $BOT=2;
		
		public function __construct()
		{
			$this->tabellaTris=array(array($this->VUOTA,$this->VUOTA,$this->VUOTA),
									 array($this->VUOTA,$this->VUOTA,$this->VUOTA),
									 array($this->VUOTA,$this->VUOTA,$this->VUOTA)
									);
		}
		
		public function inserisciMossa($ruolo,$riga,$colonna)
		{
			$this->tabellaTris[$riga][$colonna]=$ruolo;
		}
		public function stampaTabellaTris()
		{
			echo "<table id='tris'>";
			for($i=0;$i<$this->DIM_TRIS;$i++)
			{
				echo "<tr>";
				for($j=0;$j<$this->DIM_TRIS;$j++)
				{
					if($this->tabellaTris[$i][$j]==$this->VUOTA && isset($_SESSION["vittoria"])==false)
						echo "<td><input type='radio' name='inserimento' value='".$i."-".$j."'></td>";
					if($this->tabellaTris[$i][$j]==$this->VUOTA && isset($_SESSION["vittoria"])==true)
						echo "<td><input type='radio' name='inserimento' value='".$i."-".$j."' disabled></td>";
					if($this->tabellaTris[$i][$j]==$this->UTENTE)
						echo "<td><img src='img/".$_SESSION["simboloUtente"]."' width='15px'></td>";
					if($this->tabellaTris[$i][$j]==$this->BOT)
						echo "<td><img src='img/".$_SESSION["simboloBot"]."' width='15px'></td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}
		
		public function vittoria()
		{
			//controllo riga
			for($i=0;$i<$this->DIM_TRIS;$i++)
				if($this->tabellaTris[$i][0]!=$this->VUOTA && $this->tabellaTris[$i][0]==$this->tabellaTris[$i][1] && $this->tabellaTris[$i][1]==$this->tabellaTris[$i][2])
					return $this->tabellaTris[$i][0];
			
			//controllo colonna
			for($j=0;$j<$this->DIM_TRIS;$j++)
				if($this->tabellaTris[0][$j]!=$this->VUOTA && $this->tabellaTris[0][$j]==$this->tabellaTris[1][$j] && $this->tabellaTris[1][$j]==$this->tabellaTris[2][$j])
					return $this->tabellaTris[0][$j];
			
			//controllo diagonale1
			if($this->tabellaTris[0][0]!=$this->VUOTA && $this->tabellaTris[0][0]==$this->tabellaTris[1][1] && $this->tabellaTris[1][1]==$this->tabellaTris[2][2])
				return $this->tabellaTris[0][0];
			
			//controllo diagonale2
			if($this->tabellaTris[0][2]!=$this->VUOTA && $this->tabellaTris[0][2]==$this->tabellaTris[1][1] && $this->tabellaTris[1][1]==$this->tabellaTris[2][0])
				return $this->tabellaTris[0][2];
			
			return -1;
					
		}
		public function getTabellaTris()
		{
			return $this->tabellaTris;
		}
		
		private function mossaBotDifficolta1()
		{
			//generato random
			$libero=false;
			
			do{
				$rigaGenerata=rand(0,2);
				$colonnaGenerata=rand(0,2);
				if($this->tabellaTris[$rigaGenerata][$colonnaGenerata]==$this->VUOTA)
				{
					$this->inserisciMossa($this->BOT,$rigaGenerata,$colonnaGenerata);
					$libero=true;
				}
			}while($libero==false);
		}
		private function mossaBotDifficolta2()
		{
			//difesa
			$posizioneRiga;
			$posizioneColonna;
			
			//controllo riga
			for($i=0;$i<$this->DIM_TRIS;$i++)
			{
				$contRiga=0;
				$posizioneRiga=-1;
				$posizioneColonna=-1;
				for($j=0;$j<$this->DIM_TRIS;$j++)
				{
					if($this->tabellaTris[$i][$j]==$this->UTENTE)
						$contRiga++;
					if($this->tabellaTris[$i][$j]==$this->VUOTA)
					{
						$posizioneRiga=$i;
						$posizioneColonna=$j;
					}
				}
				if($contRiga==2 && $posizioneRiga!=-1 && $posizioneColonna!=-1)
				{
					$this->inserisciMossa($this->BOT,$posizioneRiga,$posizioneColonna);
					return true;
				}
			}
			
			//controllo colonna
			for($j=0;$j<$this->DIM_TRIS;$j++)
			{
				$contColonna=0;
				$posizioneRiga=-1;
				$posizioneColonna=-1;
				for($i=0;$i<$this->DIM_TRIS;$i++)
				{
					if($this->tabellaTris[$i][$j]==$this->UTENTE)
						$contColonna++;
					if($this->tabellaTris[$i][$j]==$this->VUOTA)
					{
						$posizioneRiga=$i;
						$posizioneColonna=$j;
					}
				}
				if($contColonna==2 && $posizioneRiga!=-1 && $posizioneColonna!=-1)
				{
					$this->inserisciMossa($this->BOT,$posizioneRiga,$posizioneColonna);
					return true;
				}
			}
			
			//controllo la diagonale1
			$righeDiagonale1=array(0,1,2);
			$colonneDiagonale1=array(0,1,2);
			$contDiagonale1=0;
			$posizioneRiga=-1;
			$posizioneColonna=-1;
			
			for($i=0;$i<count($colonneDiagonale1);$i++)
			{
				if($this->tabellaTris[$righeDiagonale1[$i]][$colonneDiagonale1[$i]]==$this->UTENTE)
					$contDiagonale1++;
				if($this->tabellaTris[$righeDiagonale1[$i]][$colonneDiagonale1[$i]]==$this->VUOTA)
				{
					$posizioneRiga=$righeDiagonale1[$i];
					$posizioneColonna=$colonneDiagonale1[$i];
				}
			}
			
			if($contDiagonale1==2 && $posizioneRiga!=-1 && $posizioneColonna!=-1)
			{
				$this->inserisciMossa($this->BOT,$posizioneRiga,$posizioneColonna);
				return true;
			}
			
			//controllo la diagonale2
			$righeDiagonale2=array(0,1,2);
			$colonneDiagonale2=array(2,1,0);
			$contDiagonale2=0;
			$posizioneRiga=-1;
			$posizioneColonna=-1;
			
			for($i=0;$i<count($colonneDiagonale2);$i++)
			{
				if($this->tabellaTris[$righeDiagonale2[$i]][$colonneDiagonale2[$i]]==$this->UTENTE)
					$contDiagonale2++;
				if($this->tabellaTris[$righeDiagonale2[$i]][$colonneDiagonale2[$i]]==$this->VUOTA)
				{
					$posizioneRiga=$righeDiagonale2[$i];
					$posizioneColonna=$colonneDiagonale2[$i];
				}
			}
			
			if($contDiagonale2==2 && $posizioneRiga!=-1 && $posizioneColonna!=-1)
			{
				$this->inserisciMossa($this->BOT,$posizioneRiga,$posizioneColonna);
				return true;
			}
			
			return false;
		}
		
		private function mossaBotDifficolta3()
		{
			//attacco e difesa
			
			$posizioneRiga;
			$posizioneColonna;
			
			//attacco
			//controllo riga
			for($i=0;$i<$this->DIM_TRIS;$i++)
			{
				$contRigaBot=0;
				$posizioneRiga=-1;
				$posizioneColonna=-1;
				for($j=0;$j<$this->DIM_TRIS;$j++)
				{
					if($this->tabellaTris[$i][$j]==$this->BOT)
						$contRigaBot++;
					if($this->tabellaTris[$i][$j]==$this->VUOTA)
					{
						$posizioneRiga=$i;
						$posizioneColonna=$j;
					}
				}
				if($contRigaBot==2 && $posizioneRiga!=-1 && $posizioneColonna!=-1)
				{
					$this->inserisciMossa($this->BOT,$posizioneRiga,$posizioneColonna);
					return true;
				}
			}
			
			//controllo colonna
			for($j=0;$j<$this->DIM_TRIS;$j++)
			{
				$contColonnaBot=0;
				$posizioneRiga=-1;
				$posizioneColonna=-1;
				
				for($i=0;$i<$this->DIM_TRIS;$i++)
				{
					if($this->tabellaTris[$i][$j]==$this->BOT)
						$contColonnaBot++;
					if($this->tabellaTris[$i][$j]==$this->VUOTA)
					{
						$posizioneRiga=$i;
						$posizioneColonna=$j;
					}
				}
				if($contColonnaBot==2 && $posizioneRiga!=-1 && $posizioneColonna!=-1)
				{
					$this->inserisciMossa($this->BOT,$posizioneRiga,$posizioneColonna);
					return true;
				}
			}
			
			//controllo la diagonale1
			$righeDiagonale1=array(0,1,2);
			$colonneDiagonale1=array(0,1,2);
			$colonneDiagonale1Bot=0;
			$posizioneRiga=-1;
			$posizioneColonna=-1;
			
			for($i=0;$i<count($colonneDiagonale1);$i++)
			{
				if($this->tabellaTris[$righeDiagonale1[$i]][$colonneDiagonale1[$i]]==$this->BOT)
					$contDiagonale1Bot++;
				if($this->tabellaTris[$righeDiagonale1[$i]][$colonneDiagonale1[$i]]==$this->VUOTA)
				{
					$posizioneRiga=$righeDiagonale1[$i];
					$posizioneColonna=$colonneDiagonale1[$i];
				}
			}
			
			if($contDiagonale1Bot==2 && $posizioneRiga!=-1 && $posizioneColonna!=-1)
			{
				$this->inserisciMossa($this->BOT,$posizioneRiga,$posizioneColonna);
				return true;
			}
			
			//controllo la diagonale2
			$righeDiagonale2=array(0,1,2);
			$colonneDiagonale2=array(2,1,0);
			$contDiagonale2Bot=0;
			$posizioneRiga=-1;
			$posizioneColonna=-1;
			
			for($i=0;$i<count($colonneDiagonale2);$i++)
			{
				if($this->tabellaTris[$righeDiagonale2[$i]][$colonneDiagonale2[$i]]==$this->BOT)
					$contDiagonale2Bot++;
				if($this->tabellaTris[$righeDiagonale2[$i]][$colonneDiagonale2[$i]]==$this->VUOTA)
				{
					$posizioneRiga=$righeDiagonale2[$i];
					$posizioneColonna=$colonneDiagonale2[$i];
				}
			}
			
			if($contDiagonale2Bot==2 && $posizioneRiga!=-1 && $posizioneColonna!=-1)
			{
				$this->inserisciMossa($this->BOT,$posizioneRiga,$posizioneColonna);
				return true;
			}
			
			//se non ho trovato niente da attaccare allora invoca la difesa
			$mossaDifesa=$this->mossaBotdifficolta2();
			return $mossaDifesa;
		}
		
		private function mossaBotDifficolta4()
		{
			$mossaAttaccoDifesa=$this->mossaBotDifficolta3();
			
			//nel caso in cui non ci sia nè da attaccare che da difendere attuo delle strategie
			if($mossaAttaccoDifesa==false)
			{
				$righeAngoli=array(0,0,2,2);
				$colonneAngoli=array(0,2,0,2);
				$righeAngoliOpposti=array(2,2,0,0);
				$colonneAngoliOpposti=array(0,2,0,2);
				
				//alla mossa 2 del bot se il bot ha già messo alla sua mossa 1 su un angolo allora se è libero gioca all'angolo opposto
				if($_SESSION["mosse"]>2 && $_SESSION["mosse"]<=4)
				{
					for($i=0;$i<count($righeAngoli);$i++)
					{
						if($this->tabellaTris[$righeAngoli[$i]][$colonneAngoli[$i]]==$this->BOT && $this->tabellaTris[$righeAngoliOpposti[$i]][$colonneAngoliOpposti[$i]]==$this->VUOTO)
						{
							$this->inserisciMossa($this->BOT,$righeAngoliOpposti[$i],$colonneAngoliOpposti[$i]);
							return true;
						}
					}
				}
					
				//se il bot parte dopo l'utente e l'utente nella mossa 1 ha giocato nell'angolo allora il bot gioca al centro del campo	
				if($_SESSION["mosse"]==2)
				{
					for($i=0;$i<count($righeAngoli);$i++)
					{
						if($this->tabellaTris[$righeAngoli[$i]][$colonneAngoli[$i]]==$this->UTENTE)
						{
							$this->inserisciMossa($this->BOT,1,1);
							return true;
						}
					}
				}
				
				//nel caso sia la prima mossa del bot gioca nell'angolo
				//nel caso l'utente abbia giocato la prima mossa al centro il bot gioca in un angolo
				//nel caso in cui un angolo qualsiasi sia libero il bot gioca in un angolo dato che permette di proteggersi meglio
				for($i=0;$i<count($righeAngoli);$i++)
				{
					if($this->tabellaTris[$righeAngoli[$i]][$colonneAngoli[$i]]==$this->VUOTA)
					{
						$this->inserisciMossa($this->BOT,$righeAngoli[$i],$colonneAngoli[$i]);
						return true;
					}
				}
				return false;
			}
			else
				return true;
		}
		public function mossaBot($difficolta)
		{
			if($difficolta==1)
				$this->mossaBotDifficolta1();
			if($difficolta==2)
			{
				$mossa=$this->mossaBotDifficolta2();

				//se non ho trovato niente allora invoca la mossa della difficolta 1
				if($mossa==false)
					$this->mossaBotdifficolta1();
			}
			if($difficolta==3)
			{
				$mossa=$this->mossaBotDifficolta3();
				
				//se non ho trovato niente allora invoca la mossa della difficolta 1
				if($mossa==false)
					$this->mossaBotdifficolta1();
			}
			if($difficolta==4)
			{
				$mossa=$this->mossaBotDifficolta4();
				
				//se non ho trovato niente allora invoca la mossa della difficolta 1
				if($mossa==false)
					$this->mossaBotdifficolta1();
			}
		}
	}
?>