<?php

class Stil
{
	public $stilId = null;
	public $etiket = null;
	public $ozellik = null;
	public $deger = null;
	public $stilAciklama = null;
	
	public function __construct($veri = array())
	{
		if(isset($veri["stilId"]))  	 $this->stilId 	     = $veri["stilId"];
		if(isset($veri["etiket"]))  	 $this->etiket 		 = $veri["etiket"];
		if(isset($veri["ozellik"]))  	 $this->ozellik		 = $veri["ozellik"];
		if(isset($veri["deger"])) 	 	 $this->deger  		 = $veri["deger"];
		if(isset($veri["stilAciklama"])) $this->stilAciklama = $veri["stilAciklama"];
	}
	
	public function formVerileriniSakla($gelenVeri)
	{
		$this->__construct($gelenVeri);
	}
	
	public static function tekStilCek($stilId)
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_stil WHERE stilId = :stilId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":stilId", $stilId, PDO::PARAM_INT);
		$komut->execute();
		$satir = $komut->fetch();
		$bag = null;
		if ($satir)
			return new Stil($satir);
	}
	
	public static function listele(/*$etiket = null,*/ $dist = null)
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		
		//$where = (empty($etiket)) ? "" : "WHERE etiket = :etiket";
		$sorgu = "SELECT * FROM tbl_stil"; //$where
		if(isset($dist)) $sorgu = "SELECT DISTINCT etiket FROM tbl_stil";//"SELECT COUNT(*), etiket, ozellik, deger  FROM tbl_stil GROUP BY etiket";
		$komut = $bag->prepare($sorgu);
		//if(isset($etiket)) $komut->bindValue(":etiket", $etiket);
		$komut->execute();
		
		$stiller = array();
		$satirlar = array();
		while($satir = $komut->fetch())
		{
			$stil = new Stil($satir);
			$stiller[] = $stil;
			//$satirlar[] = $satir;
			$etiketler[] = new Stil($satir);
		}
		$bag = null;
		
		if(isset($dist)) return $etiketler;//$satirlar;
		else return $stiller;
	}
	
	public static function guncelle($stilId, $deger)
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "UPDATE tbl_stil SET deger = :deger WHERE stilId = :stilId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":deger" , $deger);
		$komut->bindValue(":stilId", $stilId);
		$komut->execute();
		$bag = null;
	}
	
	public static function goster()
	{				
		$stiller = Stil::listele();
		$etiketler = Stil::listele(/*null,*/ "etiket");		
		
		echo "<style type='text/css'>";
		foreach($etiketler as $etiket)
		{
			
			echo $etiket->etiket."{";
			foreach($stiller as $stil) 
			{
				if ($stil->etiket == $etiket->etiket)
					echo $stil->ozellik . $stil->deger;
			}
			echo "}";
		}
		echo "</style>";		
	}
	
}

?>