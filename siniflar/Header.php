<?php

class Header
{
	public $headerId = null;
	public $headerBaslik = null;
	public $resimId = null;
	
	public function __construct($veri = array())
	{
		if(isset($veri["headerId"]))     $this->headerId 	 = $veri["headerId"];
		if(isset($veri["headerBaslik"])) $this->headerBaslik = $veri["headerBaslik"];
		if(isset($veri["resimId"]))      $this->resimId 	 = $veri["resimId"];	
	}
	
	public function formVerileriniSakla($gelenVeri)
	{
		$this->__construct($gelenVeri);
	}
	
	public static function headerCek()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_header";
		$komut = $bag->prepare($sorgu);
		$komut->execute();
		$satir = $komut->fetch();
		$bag = null;
		if ($satir)
			return new Header($satir);
	}
	
	public function guncelle()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "UPDATE tbl_header SET headerBaslik = :headerBaslik, resimId = :resimId WHERE headerId = :headerId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":headerBaslik" , $this->headerBaslik);
		$komut->bindValue(":resimId", $this->resimId);		
		$komut->bindValue(":headerId" , $this->headerId);
		$komut->execute();
		$bag = null;
	}
	
	public static function goster()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		
		$header = Header::headerCek();
		$resimler = Resim::listele();
		
		foreach($resimler["resimler"] as $resim)
			$resimYol[$resim->resimId] = $resim->resimYol;			
				
		echo "<a href='index.php'>"; 
		echo "<div id='header'>"; 
		if($header->resimId != 13 && isset($header->resimId))
			echo "<img src='".$resimYol[$header->resimId]."' alt='' id='logo'>";
		echo "<span id=''>$header->headerBaslik</span>";
		echo "</div>";
		echo "</a>";	
		
		$bag = null;
	}
	
}

?>

