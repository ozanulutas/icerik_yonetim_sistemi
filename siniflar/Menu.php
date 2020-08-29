<?php

class Menu
{
	public $menuId = null;
	public $menuAdi = null;
	public $ustMenuId = null;
	public $pozisyon = 0;	
	public $menuIcerik = null;
	

	public function __construct($veri = array())
	{
		if(isset($veri["menuId"])) 	   $this->menuId    = $veri["menuId"];
		if(isset($veri["menuAdi"]))    $this->menuAdi   = $veri["menuAdi"]; 
		if(isset($veri["ustMenuId"]))  $this->ustMenuId = $veri["ustMenuId"];
		if(isset($veri["pozisyon"]))   $this->pozisyon  = $veri["pozisyon"];		
		if(isset($veri["menuIcerik"])) $this->menuIcerik  = $veri["menuIcerik"];		
	}
	
	public function formVerileriniSakla($gelenVeri)
	{
		$this->__construct($gelenVeri);
	}
	
	public static function tekMenuCek($menuId) 
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_menuler WHERE menuId = :menuId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":menuId", $menuId);
		$komut->execute();
		$satir = $komut->fetch();		
		$bag = null;
		
		if($satir)
			return new Menu($satir);
	}
	
	public static function listele()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT * FROM tbl_menuler ORDER BY pozisyon"; 
		$komut = $bag->prepare($sorgu);
		$komut->execute();
		
		$menuler = array();
		$toplamMenu = $komut->rowCount();
		while($satir = $komut->fetch())
		{
			$menu = new Menu($satir);
			$menuler[] = $menu;
		}
		$bag = null;
		
		return array("menuler" => $menuler, "toplamMenu" => $toplamMenu);
	}
	
	public function ekle()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "INSERT INTO tbl_menuler(menuAdi, ustMenuId, pozisyon, menuIcerik) VALUES(:menuAdi, :ustMenuId, :pozisyon, :menuIcerik)";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":menuAdi"   , $this->menuAdi);
		$komut->bindValue(":ustMenuId" , $this->ustMenuId); 
		$komut->bindValue(":pozisyon"  , $this->pozisyon);
		$komut->bindValue(":menuIcerik", $this->menuIcerik);
		$komut->execute();
		$bag = null;
	}
	
	public function guncelle()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "UPDATE tbl_menuler SET menuAdi = :menuAdi, ustMenuId = :ustMenuId, pozisyon = :pozisyon, menuIcerik = :menuIcerik WHERE menuId = :menuId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":menuAdi"   , $this->menuAdi);
		$komut->bindValue(":ustMenuId" , $this->ustMenuId);
		$komut->bindValue(":pozisyon"  , $this->pozisyon);
		$komut->bindValue(":menuIcerik", $this->menuIcerik);
		$komut->bindValue(":menuId"	   , $this->menuId);
		$komut->execute();
		$bag = null;
	}
	
	public function sil()
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "DELETE FROM tbl_menuler WHERE menuId = :menuId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue("menuId", $this->menuId);
		$komut->execute();
		$bag = null;
	}
	
	public static function goster($derinlik = 1)
	{
		$menuler = Menu::listele();
	
		foreach($menuler["menuler"] as $menu)
		{
			if($menu->ustMenuId == 0) // Ana menüyse
			{				
				echo "<li><a href='index.php?secenek=menuIcerikGoster&menuId=$menu->menuId&anaMenuId=$menu->menuId'>$menu->menuAdi</a>";
				$anaMenuId = $menu->menuId;
				Menu::altMenuGoster($menuler["menuler"], $menu->menuId, $anaMenuId, $derinlik);
				echo "</li>";
			}
		}
	}
	
	public static function altMenuGoster($menuler, $menuId, $anaMenuId, $derinlik = 1) // Alt Menu göster
	{	
		echo "<ul>";
		foreach($menuler as $menu)
		{
			if($menu->ustMenuId == $menuId)
			{
				echo "<li><a href='index.php?secenek=menuIcerikGoster&menuId=$menu->menuId&anaMenuId=$anaMenuId'>$menu->menuAdi</a>";
				if($derinlik == 1)
					Menu::altMenuGoster($menuler, $menu->menuId, $anaMenuId);
				echo "</li>";
			}
		}
		echo "</ul>";
	}
	
	public static function altMenuSay($menuId)/**/
	{
		$bag = new PDO(DB_HOST, DB_KA, DB_SIFRE);
		$sorgu = "SELECT COUNT(*) FROM tbl_menuler WHERE ustMenuId = :menuId";
		$komut = $bag->prepare($sorgu);
		$komut->bindValue(":menuId", $menuId);
		$komut->execute();
		$satirSayisi = $komut->fetchColumn();
		return $satirSayisi;
	}
	
}

?>
