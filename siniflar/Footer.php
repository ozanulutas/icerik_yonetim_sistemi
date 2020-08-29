<?php

class Footer
{
	public $footerId = null;
	public $footerSol = null;
	public $footerOrta = null;
	public $footerSag = null;
	
	public function __construct($veri = array())
	{
		if(isset($veri["footerId"]))   $this->footerId 	 = $veri["footerId"];
		if(isset($veri["footerSol"]))  $this->footerSol  = $veri["footerSol"];
		if(isset($veri["footerOrta"])) $this->footerOrta = $veri["footerOrta"];
		if(isset($veri["footerSag"]))  $this->footerSag  = $veri["footerSag"];
	}
	
	public function formVerileriniSakla($gelenVeri)
	{
		$this->__construct($gelenVeri);
	}
	
	public static function footerCek()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_footer";
		$komut = $bag->prepare($sorgu);
		$komut->execute();
		$satir = $komut->fetch();
		$bag = null;
		if ($satir)
			return new Footer($satir);
	}
	
	public function guncelle()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "UPDATE tbl_footer SET footerSol = :footerSol, footerOrta = :footerOrta, footerSag = :footerSag WHERE footerId = :footerId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":footerSol" , $this->footerSol);
		$komut->bindValue(":footerOrta", $this->footerOrta);
		$komut->bindValue(":footerSag" , $this->footerSag);
		$komut->bindValue(":footerId"  , $this->footerId);
		$komut->execute();
		$bag = null;
	}
	
	public static function goster()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$footer = Footer::footerCek();
		echo "<div id='footer'>"; 
		echo "<div>$footer->footerSol</div>";
		echo "<div>$footer->footerOrta</div>";
		echo "<div>$footer->footerSag</div>";
		echo "</div>";
		$bag = null;
	}
	
}

?>
