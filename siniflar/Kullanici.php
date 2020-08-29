<?php

class Kullanici
{
	public $kullaniciId = null;
	public $kullaniciAdi = null;
	public $sifre = null;
	public $email = null;
	public $yetki = 0;
	
	public function __construct($veri = array())
	{
		if(isset($veri["kullaniciId"]))  $this->kullaniciId	 = $veri["kullaniciId"];
		if(isset($veri["kullaniciAdi"])) $this->kullaniciAdi = $veri["kullaniciAdi"];  
		if(isset($veri["sifre"])) 	 	 $this->sifre 	 	 = $veri["sifre"];
		if(isset($veri["email"])) 	 	 $this->email 	 	 = $veri["email"];
		if(isset($veri["yetki"])) 	 	 $this->yetki 		 = $veri["yetki"];
	}
	
	public function formVerileriniSakla($gelenVeri)
	{
		$this->__construct($gelenVeri);
	}
	
	public static function tekKullaniciCek($kullaniciId) 
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);		
		$sorgu = "SELECT * FROM tbl_kullanicilar WHERE kullaniciId = :kullaniciId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":kullaniciId", $kullaniciId);
		$komut->execute();
		$satir = $komut->fetch();		
		$bag = null;
		
		if($satir)
			return new Kullanici($satir);
	}
	
	public static function listele()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_kullanicilar ORDER BY kullaniciAdi";
		$komut = $bag->prepare($sorgu);
		$komut->execute();
		
		$kullanicilar = array();
		$toplamKullanici = $komut->rowCount();
		while($satir = $komut->fetch())
		{
			$kullanici = new Kullanici($satir);
			$kullanicilar[] = $kullanici;
		}
		$bag = null;
		
		return array("kullanicilar" => $kullanicilar, "toplamKullanici" => $toplamKullanici);
	}
	
	public function ekle()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "INSERT INTO tbl_kullanicilar(kullaniciAdi, sifre, email, yetki) VALUES(:kullaniciAdi, :sifre, :email, :yetki)";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":kullaniciAdi", $this->kullaniciAdi);
		$komut->bindValue(":sifre"	 	 , $this->sifre);
		$komut->bindValue(":email"		 , $this->email);
		$komut->bindValue(":yetki"		 , $this->yetki);
		$komut->execute();
		$this->kullaniciId = $bag->lastInsertId();
		$bag = null;
	}
	
	public function guncelle()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "UPDATE tbl_kullanicilar SET sifre = :sifre, email = :email, yetki = :yetki WHERE kullaniciId = :kullaniciId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":sifre"	 	, $this->sifre);
		$komut->bindValue(":email"		, $this->email);
		$komut->bindValue(":yetki"		, $this->yetki);
		$komut->bindValue(":kullaniciId", $this->kullaniciId);
		$komut->execute();
		$bag = null;
	}
	
	public function sil()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "DELETE FROM tbl_kullanicilar WHERE kullaniciId = :kullaniciId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue("kullaniciId", $this->kullaniciId);
		$komut->execute();
		$bag = null;
	}
	
	public static function oturumAc(/**/$kullaniciAdi, $sifre)
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_kullanicilar WHERE kullaniciAdi = :kullaniciAdi AND sifre = :sifre";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":kullaniciAdi", $kullaniciAdi);
		$komut->bindValue(":sifre"		 , $sifre);
		$komut->execute();
		$satir = $komut->fetch();		
		$bag = null;
		if($satir) return new Kullanici($satir);
		
	}
}

?>