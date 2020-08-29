<?php

class Mesaj
{
	public $mesajId = null;
	public $mesaj = null;
	public $tarih = null;
	public $kullaniciId = null;
	public $makaleId = null;
	
	public function __construct($veri = array())
	{
		if(isset($veri["mesajId"])) 	$this->mesajId 	   = $veri["mesajId"];
		if(isset($veri["mesaj"])) 	 	$this->mesaj 	   = $veri["mesaj"];
		if(isset($veri["tarih"])) 		$this->tarih 	   = $veri["tarih"];
		if(isset($veri["kullaniciId"])) $this->kullaniciId = $veri["kullaniciId"];
		if(isset($veri["makaleId"])) 	$this->makaleId	   = $veri["makaleId"];
	}
	
	public function formVerileriniSakla($gelenVeri)
	{
		$this->__construct($gelenVeri);
	}
	
	public static function tekMesajCek($mesajId)
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_mesajlar WHERE mesajId = :mesajId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":mesajId", $mesajId);
		$komut->execute();
		$satir = $komut->fetch();
		$bag = null;
		if ($satir)
			return new Mesaj($satir);
	}
	
	public static function listele($makaleId)
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_mesajlar WHERE makaleId = :makaleId ORDER BY tarih DESC";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":makaleId", $makaleId);
		$komut->execute();
		
		$mesajlar = array();
		$toplamMesaj = $komut->rowCount();
		while($satir = $komut->fetch())
		{
			$mesaj = new Mesaj($satir);
			$mesajlar[] = $mesaj;
		}
		$bag = null;
		
		return array("mesajlar" => $mesajlar, "toplamMesaj" => $toplamMesaj);
	}
	
	public function ekle()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "INSERT INTO tbl_mesajlar(mesaj, tarih, kullaniciId, makaleId) VALUES(:mesaj, :tarih, :kullaniciId, :makaleId)";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":mesaj"	 	, $this->mesaj);
		$komut->bindValue(":tarih"		, date('d-m-y h:i:s'));
		$komut->bindValue(":kullaniciId", $this->kullaniciId);
		$komut->bindValue(":makaleId"	, $this->makaleId);
		$komut->execute();
		$bag = null;
	}
	
	public function guncelle()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "UPDATE tbl_mesajlar SET mesaj = :mesaj, tarih = :tarih WHERE mesajId = :mesajId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":mesaj"	, $this->mesaj);
		$komut->bindValue(":tarih"  , date('d-m-y h:i:s'));
		$komut->bindValue(":mesajId", $this->mesajId);
		$komut->execute();
		$bag = null;
	}
	
	public function sil()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "DELETE FROM tbl_mesajlar WHERE mesajId = :mesajId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue("mesajId", $this->mesajId);
		$komut->execute();
		$bag = null;
	}
}

?>