<?php

require("yapilandirma.php");
session_start();

$secenek = ""; if(isset($_GET["secenek"])) $secenek = $_GET["secenek"];
$oturum = ""; if(isset($_SESSION["oturum"])) $oturum = $_SESSION["oturum"];

if(empty($oturum) && $secenek != "kayit") /************************/
{
	header("Location: admin.php");
	exit();
}

switch($secenek)
{
	case "kayit":
		kayit();
		break;
	case "profilGuncelle":
		profilGuncelle();
		break;
	case "profilSil":
		profilSil();
		break;
	case "yorumYap":
		yorumYap();
		break;
	case "yorumSil":
		yorumSil();
		break;
	default:
		profil();
}

function kayit()
{
	if(empty($_SESSION["oturum"]))	{
		
		$veri = array();
		$veri["baslik"] = "Kullanıcı Kayıt Formu";
		$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];

		if(isset($_POST["kaydol"]))
		{
			$kullanici = new Kullanici($_POST);
			$kullanici->ekle();
			$_SESSION["oturum"] = "kullanici";
			$_SESSION["kullaniciId"] = $kullanici->kullaniciId;

			$veri["mesaj"] = "Kaydınız başarıyla gerçekleşti.";////////////////////
			header("Location: index.php");
		}	
		else
		{
			require(SABLONLAR."/kullanici/kayit.php");
		}	
	}
	else
		header("Location: admin.php");
}

function profilGuncelle()
{
	$veri = array();
	$veri["baslik"] = "Profil Ayarları";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"]; 
	$veri["kullanici"] = Kullanici::tekKullaniciCek($_SESSION["kullaniciId"]); 
	
	if(isset($_POST["mailGuncelle"]))
	{		
		$veri["kullanici"]->formVerileriniSakla($_POST);
		$veri["kullanici"]->guncelle();
		
		$veri["mesaj"] = "Bilgileriniz güncellendi.";
	 	$veri["kullanici"]->yetki == 1 ? header("Location: admin.php") : header("Location: kullanici.php");
	}
	if(isset($_POST["sifreGuncelle"]))
	{	
		if($veri["kullanici"]->sifre == $_POST["eskiSifre"])
		{
			if($_POST["sifre"] == $_POST["sifreTekrar"])
			{				
				$veri["kullanici"]->formVerileriniSakla($_POST);
				$veri["kullanici"]->guncelle();
		
				$veri["mesaj"] = "Bilgileriniz güncellendi.";
	 			$veri["kullanici"]->yetki == 1 ? header("Location: admin.php") : header("Location: kullanici.php");
			}
			else 
			{
				$veri["mesaj"] = "Şifreler uyuşmuyor.";
				header("Location: kullanici.php?secenek=profilGuncelle");	
			}				
		}
		else 
		{
			$veri["mesaj"] = "Mevcut şifre hatalı.";
			header("Location: kullanici.php?secenek=profilGuncelle");	
		}
	}	
	else
	{
		require(SABLONLAR."/kullanici/profilGuncelle.php");
	}
}

function profilSil()
{
	$kullanici = Kullanici::tekKullaniciCek($_SESSION["kullaniciId"]);
	$kullanici->sil();
	
	header("Location: admin.php?secenek=cikis");
}

function yorumYap()
{
	if(isset($_POST["gonder"]))
	{
		$mesaj = new Mesaj($_POST);
		$mesaj->ekle();
		header("Location: index.php?secenek=makaleGoster&makaleId=" . $_POST["makaleId"]);
	}
}

function yorumSil()
{
	if(isset($_GET["mesajId"]))
	{
		$mesaj = Mesaj::tekMesajCek($_GET["mesajId"]);
		$mesaj->sil();
		header("Location: index.php?secenek=makaleGoster&makaleId=$mesaj->makaleId");
	}
}

function profil()
{
	$veri = array();
	$veri["baslik"] = "Kullanıcı Profili";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"]; 	
	$veri["kullanici"] = Kullanici::tekKullaniciCek($_SESSION["kullaniciId"]);	
	
	require(SABLONLAR."/kullanici/profil.php");	
}

?>