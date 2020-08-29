<?php

require("yapilandirma.php");
session_start();

$secenek = ""; if(isset($_GET["secenek"])) $secenek = $_GET["secenek"];

switch($secenek)
{
	case "arsiv":
		arsiv();
		break;
	case "makaleGoster":
		makaleGoster();
		break;
	case "menuIcerikGoster":
		menuIcerikGoster();
		break;
	default:
		anaSayfa();
}

function arsiv()
{
	$veri = array();
	$makaleler = array();
	$veri["baslik"] = "Makale Arşivi";
	
	$kategoriler = Kategori::listele();
	$veri["kategoriler"] = $kategoriler["kategoriler"];
	foreach($veri["kategoriler"] as $kategori)
		$veri["kategoriler"][$kategori->kategoriId] = $kategori->kategoriAdi;
	
	$veri["kategoriId"] = null; 
	if(isset($_GET["kategoriId"])) 
	{
		$veri["kategoriId"] = $_GET["kategoriId"];
		$veri["baslik"] = $veri["kategoriler"][$veri["kategoriId"]];		
	}
	
	$sayfaNo = (isset($_GET["sayfaNo"])) ? $_GET["sayfaNo"] : 1;
	$ofset = ($sayfaNo - 1) * GOSTERILEN_MAKALE;
				
	$makaleler = Makale::listele(array($ofset, GOSTERILEN_MAKALE), $veri["kategoriId"]);
	$veri["makaleler"] = $makaleler["makaleler"];
	$veri["toplamMakale"] = $makaleler["toplamMakale"];	
	$veri["toplamSayfa"] = $makaleler["toplamSayfa"];	
	
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
	
	require(SABLONLAR."/arsiv.php");
}

function makaleGoster()
{	
	$makaleId = (isset($_GET["makaleId"])) ? $_GET["makaleId"] : "";
	$veri = array();
	$veri["makale"] = Makale::tekMakaleCek($makaleId);
	$veri["makale"]->goruntulenme++;
	$veri["makale"]->guncelle();
	
	$veri["kategori"] = Kategori::tekKategoriCek($veri["makale"]->kategoriId);
	$mesajlar = Mesaj::listele($makaleId);
	$veri["mesajlar"] = $mesajlar["mesajlar"];
	$veri["toplamMesaj"] = $mesajlar["toplamMesaj"];
		
	$veri["sayfaBasligi"] = BASLIK." | ".$veri["makale"]->makaleBaslik;
	
	require(SABLONLAR."/makaleGoster.php");
}

function menuIcerikGoster()
{
	$menuId = (isset($_GET["menuId"])) ? $_GET["menuId"] : "";
	$veri["menu"] = Menu::tekMenuCek($menuId);
	$veri["baslik"] = $veri["menu"]->menuAdi;
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
	
	require(SABLONLAR."/menuIcerikGoster.php");
}

function anaSayfa()
{
	$veri = array();
	$makaleler = Makale::listele(array(GOSTERILEN_MAKALE));
	$veri["makaleler"] = $makaleler["makaleler"];
	
	$kategoriler = Kategori::listele();
	$veri["kategoriler"] = $kategoriler["kategoriler"];
	foreach($veri["kategoriler"] as $kategori)
		$veri["kategoriler"][$kategori->kategoriId] = $kategori->kategoriAdi;	
	
	$veri["sayfaBasligi"] = BASLIK;
	
	require(SABLONLAR."/anaSayfa.php");
}



?>