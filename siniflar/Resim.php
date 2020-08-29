<?php

class Resim
{
	public $resimId = null;
	public $resimYol = null;
	
	public function __construct($veri = array())
	{
		if(isset($veri["resimId"]))  $this->resimId  = $veri["resimId"];
		if(isset($veri["resimYol"])) $this->resimYol = $veri["resimYol"];
	}
	
	/*public function formVerileriniSakla($gelenVeri)
	{
		$this->__construct($gelenVeri);
	}*/
	
	public static function tekResimCek($resimId)
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_resimler WHERE resimId = :resimId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":resimId", $resimId);
		$komut->execute();
		$satir = $komut->fetch();
		$bag = null;
		if ($satir)
			return new Resim($satir);
	}
	
	public static function listele()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_resimler";
		$komut = $bag->prepare($sorgu);
		$komut->execute();
		
		$resimler = array();
		$toplamResim = $komut->rowCount();
		while($satir = $komut->fetch())
		{
			$resim = new Resim($satir);
			$resimler[] = $resim;
		}
		$bag = null;
		
		return array("resimler" => $resimler, "toplamResim" => $toplamResim);
	}
	
	public function ekle()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "INSERT INTO tbl_resimler(resimYol) VALUES(:resimYol)";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":resimYol", $this->resimYol);
		$komut->execute();
		$bag = null;
	}
	
	public function sil()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "DELETE FROM tbl_resimler WHERE resimId = :resimId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue("resimId", $this->resimId);
		$komut->execute();
		$bag = null;
	}
	
}

?>