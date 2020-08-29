<?php

class Makale
{
	public $makaleId = null;
	public $makaleBaslik = null;
	public $makaleOzet = null;
	public $makaleIcerik = null;
	public $yayinTarihi = null;
	public $yayinla = null;
	public $kategoriId = null;	
	public $goruntulenme = 0;	
	
	public function __construct($veri = array())
	{
		if(isset($veri["makaleId"])) 	 $this->makaleId 	 = $veri["makaleId"];
		if(isset($veri["makaleBaslik"])) $this->makaleBaslik = $veri["makaleBaslik"];  
		if(isset($veri["makaleOzet"])) 	 $this->makaleOzet 	 = $veri["makaleOzet"];
		if(isset($veri["makaleIcerik"])) $this->makaleIcerik = $veri["makaleIcerik"];
		if(isset($veri["yayinTarihi"]))  $this->yayinTarihi  = $veri["yayinTarihi"];
		if(isset($veri["yayinla"])) 	 $this->yayinla 	 = $veri["yayinla"];
		if(isset($veri["kategoriId"]))   $this->kategoriId 	 = $veri["kategoriId"];
		if(isset($veri["goruntulenme"])) $this->goruntulenme = $veri["goruntulenme"];	
	}
	
	public function formVerileriniSakla($gelenVeri)
	{
		$this->__construct($gelenVeri);
	}
	
	public static function tekMakaleCek($makaleId) // Id'si verilen makaleyi gösterir
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_makaleler WHERE makaleId = :makaleId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":makaleId", $makaleId);
		$komut->execute();
		$satir = $komut->fetch();		
		$bag = null;
		
		if($satir)
			return new Makale($satir);
	}
	
	public static function listele($limit = array(1000000), $kategoriId = null, $orderBy = null) 
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		
		$siralama = (isset($orderBy)) ? "goruntulenme" : "yayinTarihi";
		$kategoriSorgu = (isset($kategoriId)) ? "WHERE kategoriId = :kategoriId" : "";	
		
		$sorgu = "SELECT COUNT(*) FROM tbl_makaleler";
		$komut = $bag->prepare($sorgu);
		$komut->execute();
		$toplamMakale = $komut->fetchColumn();
		$toplamSayfa = ceil($toplamMakale / GOSTERILEN_MAKALE);
		
		$sorgu = "SELECT * FROM tbl_makaleler $kategoriSorgu ORDER BY $siralama DESC LIMIT"; 
		$sorgu .= (empty($limit[1])) ? " :limit" : " :limit, :gosterilenMakale";		
			
		$komut = $bag->prepare($sorgu);
		if(isset($kategoriId)) $komut->bindValue(":kategoriId", $kategoriId);
		$komut->bindValue(":limit", $limit[0], PDO::PARAM_INT);
		if(isset($limit[1])) $komut->bindValue(":gosterilenMakale", $limit[1], PDO::PARAM_INT);
		$komut->execute();
		
		$makaleler = array(); 
		while($satir = $komut->fetch())
		{
			$makale = new Makale($satir);
			$makaleler[] = $makale;			
		}
		$bag = null;
		
		return (array("makaleler" => $makaleler, "toplamMakale" => $toplamMakale, "toplamSayfa" => $toplamSayfa));	
	}
	
	public function ekle()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "INSERT INTO tbl_makaleler(makaleBaslik, makaleOzet, makaleIcerik, yayinTarihi, yayinla, kategoriId, goruntulenme) VALUES(:makaleBaslik, :makaleOzet, :makaleIcerik, :yayinTarihi, :yayinla, :kategoriId, :goruntulenme)";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":makaleBaslik", $this->makaleBaslik);
		$komut->bindValue(":makaleOzet"	 , $this->makaleOzet);
		$komut->bindValue(":makaleIcerik", $this->makaleIcerik);
		$komut->bindValue(":yayinTarihi" , $this->yayinTarihi);
		$komut->bindValue(":yayinla"	 , $this->yayinla);
		$komut->bindValue(":kategoriId"	 , $this->kategoriId);
		$komut->bindValue(":goruntulenme", $this->goruntulenme);
		$komut->execute();	/**************************************************/
		$bag = null;
	}
	
	public function guncelle()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "UPDATE tbl_makaleler SET makaleBaslik = :makaleBaslik, makaleOzet = :makaleOzet, makaleIcerik = :makaleIcerik, yayinTarihi = :yayinTarihi, yayinla = :yayinla, kategoriId = :kategoriId, goruntulenme = :goruntulenme WHERE makaleId = :makaleId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":makaleBaslik", $this->makaleBaslik);
		$komut->bindValue(":makaleOzet"	 , $this->makaleOzet);
		$komut->bindValue(":makaleIcerik", $this->makaleIcerik);
		$komut->bindValue(":yayinTarihi" , $this->yayinTarihi);
		$komut->bindValue(":yayinla"	 , $this->yayinla);
		$komut->bindValue(":kategoriId"	 , $this->kategoriId);
		$komut->bindValue(":goruntulenme", $this->goruntulenme);
		$komut->bindValue(":makaleId"	 , $this->makaleId);
		$komut->execute();
		$bag = null;
	}
	
	public function sil()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "DELETE FROM tbl_makaleler WHERE makaleId = :makaleId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":makaleId", $this->makaleId);
		$komut->execute();
		$bag = null;
	}
	
}

?>


