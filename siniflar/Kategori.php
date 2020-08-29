<?php

class Kategori
{
	public $kategoriId = null;
	public $kategoriAdi = null;
	public $kategoriAciklama = null;
	
	public function __construct($veri = array())
	{
		if(isset($veri["kategoriId"])) 		 $this->kategoriId 		 = $veri["kategoriId"];
		if(isset($veri["kategoriAdi"])) 	 $this->kategoriAdi 	 = $veri["kategoriAdi"];
		if(isset($veri["kategoriAciklama"])) $this->kategoriAciklama = $veri["kategoriAciklama"];
	}
	
	public function formVerileriniSakla($gelenVeri)
	{
		$this->__construct($gelenVeri);
	}
	
	public static function tekKategoriCek($kategoriId)
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_kategoriler WHERE kategoriId = :kategoriId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":kategoriId", $kategoriId);
		$komut->execute();
		$satir = $komut->fetch();
		$bag = null;
		if ($satir)
			return new Kategori($satir);
	}
	
	public static function listele()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_kategoriler ORDER BY kategoriAdi";
		$komut = $bag->prepare($sorgu);
		$komut->execute();
		
		$kategoriler = array();
		$toplamKategori = $komut->rowCount();
		while($satir = $komut->fetch())
		{
			$kategori = new Kategori($satir);
			$kategoriler[] = $kategori;
		}
		$bag = null;
		
		return array("kategoriler" => $kategoriler, "toplamKategori" => $toplamKategori);
	}
	
	public function ekle()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "INSERT INTO tbl_kategoriler(kategoriAdi, kategoriAciklama) VALUES(:kategoriAdi, :kategoriAciklama)";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":kategoriAdi"	 , $this->kategoriAdi);
		$komut->bindValue(":kategoriAciklama", $this->kategoriAciklama);
		$komut->execute();
		$bag = null;
	}
	
	public function guncelle()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "UPDATE tbl_kategoriler SET kategoriAdi = :kategoriAdi, kategoriAciklama = :kategoriAciklama WHERE kategoriId = :kategoriId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":kategoriAdi"	 , $this->kategoriAdi);
		$komut->bindValue(":kategoriAciklama", $this->kategoriAciklama);
		$komut->bindValue(":kategoriId"	 	 , $this->kategoriId);
		$komut->execute();
		$bag = null;
	}
	
	public function sil()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "DELETE FROM tbl_kategoriler WHERE kategoriId = :kategoriId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue("kategoriId", $this->kategoriId);
		$komut->execute();
		$bag = null;
	}
}

?>