<?php

require("yapilandirma.php");
session_start();

$secenek = ""; if(isset($_GET["secenek"])) $secenek = $_GET["secenek"];
$oturum = ""; if(isset($_SESSION["oturum"])) $oturum = $_SESSION["oturum"];

if(empty($oturum)) /************************/
{
	giris();
	exit();
}

if($oturum == "kullanici") header("Location: kullanici.php");

							
switch ($secenek)
{
	case "giris":
		giris();
		break;
	case "cikis":
		cikis();
		break;
	case "makaleEkle":
		makaleEkle();
		break;
	case "makaleGuncelle":
		makaleGuncelle();
		break;
	case "makaleSil":
		makaleSil();
		break;
	case "kategoriListele":
		kategoriListele();		
		break;
	case "kategoriEkle":
		kategoriEkle();
		break;
	case "kategoriGuncelle":
		kategoriGuncelle();
		break;
	case "kategoriSil":
		kategoriSil();
		break;
	case "kullaniciListele":
		kullaniciListele();
		break;
	case "kullaniciGuncelle":
		kullaniciGuncelle();
		break;
	case "kullaniciSil":
		kullaniciSil();
		break;
	case "menuEkle":
		menuEkle();
		break;
	case "menuListele":
		menuListele();
		break;
	case "menuGuncelle":
		menuGuncelle();
		break;
	case "menuSil":
		menuSil();
		break;
	case "footerGuncelle":
		footerGuncelle();
		break;
	case "headerGuncelle":
		headerGuncelle();
		break;
	case "mailGonder":
		mailGonder();
		break;	
	case "stilGuncelle":
		stilGuncelle();
		break;
	case "resimYukle":
		resimYukle();
		break;
	default:
		makaleListele();
}

function giris()
{
	$veri = array();
	$veri["baslik"] = "Kullanıcı Girişi";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"]; 
	$veri["mesaj"] = "";
		
	if(isset($_POST["giris"]))
	{
		$kullanici = Kullanici::oturumAc($_POST["kullaniciAdi"], $_POST["sifre"]);		
		
		if(isset($kullanici))
		{
			$_SESSION["kullaniciId"] = $kullanici->kullaniciId;
			$_SESSION["oturum"] = ($kullanici->yetki == 1) ? "admin" : "kullanici";
			
			if 		($_SESSION["oturum"] == "admin") 	 header("Location: admin.php");				
			else if ($_SESSION["oturum"] == "kullanici") header("Location: kullanici.php");	/**/		
		}
		else
		{
			$veri["mesaj"] = "Kullanıcı adı veya şifre hatalı!";
			require(SABLONLAR."/admin/giris.php");
		}
	}
	else
	{
		require(SABLONLAR."/admin/giris.php");
	}
}

function cikis()
{
	unset($_SESSION["oturum"]);
	unset($_SESSION["kullaniciId"]);
	header("Location: admin.php");
}

function makaleEkle()
{
	$veri = array();
	$veri["baslik"] = "Yeni Makale";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
	$veri["formSecenek"] = "makaleEkle";
	
	if(isset($_POST["kaydet"]))
	{
		$makale = new Makale();
		if(empty($_POST["yayinTarihi"])) $_POST["yayinTarihi"] = date("Y-m-d");
		if(empty($_POST["kategoriId"])) $_POST["kategoriId"] = 7;
		$makale->formVerileriniSakla($_POST);
		$makale->ekle();
		
		$veri["mesaj"] = "Yeni makale eklendi.";/************************/
		header("Location: admin.php");
	}
	else if(isset($_POST["iptal"]))
	{
		header("Location: admin.php");
	}
	else
	{
		$veri["makale"] = new Makale();
		$kategoriler = Kategori::listele();
		$veri["kategoriler"] = $kategoriler["kategoriler"];
		require(SABLONLAR."/admin/makaleDuzenle.php"); /************************/
	}
}

function makaleGuncelle()
{
	$veri = array();
	$veri["baslik"] = "Makale Düzenle";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
	$veri["formSecenek"] = "makaleGuncelle";
	
	if(isset($_POST["kaydet"]))
	{
		if(empty($_POST["yayinTarihi"])) $_POST["yayinTarihi"] = date("Y-m-d");
		$makale = Makale::tekMakaleCek($_POST["makaleId"]);
		$makale->formVerileriniSakla($_POST);
		//$makale = new Makale($_POST);		
		$makale->guncelle();
		
		$veri["mesaj"] = "Makale güncellendi";
	 	header("Location: admin.php");
	}
	else if(isset($_POST["iptal"]))
	{
		header("Location: admin.php");
	}
	else
	{
		$veri["makale"] = Makale::tekMakaleCek($_GET["makaleId"]);
		$kategoriler = Kategori::listele();
		$veri["kategoriler"] = $kategoriler["kategoriler"];
		require(SABLONLAR."/admin/makaleDuzenle.php"); 
	}
}

function makaleSil()
{
	if(isset($_GET["makaleId"]))
	{
		$veri = array();

		$makale = Makale::tekMakaleCek($_GET["makaleId"]);
		$makale->sil();

		$veri["mesaj"] = "Makale Silindi.";
	}
	header("Location: admin.php");		
}

function makaleListele()
{
	$veri = array();
	$makaleler = Makale::listele();
	$veri["makaleler"] = $makaleler["makaleler"];
	$veri["toplamMakale"] = $makaleler["toplamMakale"];
	
	$kategoriler = Kategori::listele();
	$veri["kategoriler"] = $kategoriler["kategoriler"];
	foreach($veri["kategoriler"] as $kategori)
		$veri["kategoriler"][$kategori->kategoriId] = $kategori->kategoriAdi;		
	
	$veri["baslik"] = "Makaleler";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
		
	require(SABLONLAR."/admin/makaleListele.php");	
}

function kategoriListele()
{
	$veri = array();
	$kategoriler = Kategori::listele();
	$veri["kategoriler"] = $kategoriler["kategoriler"];
	$veri["toplamKategori"] = $kategoriler["toplamKategori"];
	$veri["baslik"] = "Kategoriler";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
	
	require(SABLONLAR."/admin/kategoriListele.php");	
}

function kategoriEkle()
{
	$veri = array();
	$veri["baslik"] = "Yeni Kategori";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
	$veri["formSecenek"] = "kategoriEkle";
	
	if(isset($_POST["kaydet"]))
	{
		$kategori = new Kategori($_POST);
		$kategori->ekle();
		$veri["mesaj"] = "Yeni kategori eklendi.";/************************/
		header("Location: admin.php?secenek=kategoriListele");
	}
	else if(isset($_POST["iptal"]))
	{
		header("Location: admin.php?secenek=kategoriListele");
	}
	else
	{
		$veri["kategori"] = new Kategori();
		require(SABLONLAR."/admin/kategoriDuzenle.php");	
	}		
}

function kategoriGuncelle()
{
	$veri = array();
	$veri["baslik"] = "Kategori Düzenle";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
	$veri["formSecenek"] = "kategoriGuncelle";
	
	if(isset($_POST["kaydet"]))
	{
		$kategori = new Kategori($_POST);
		//$kategori = Kategori::tekKategoriCek($_POST["kategoriId"]);
		//$kategori->formVerileriniSakla($_POST);
		$kategori->guncelle();
		
		$veri["mesaj"] = "Kategori güncellendi.";
	 	header("Location: admin.php?secenek=kategoriListele");
	}
	else if(isset($_POST["iptal"]))
	{
		header("Location: admin.php?secenek=kategoriListele");
	}
	else
	{
		$veri["kategori"] = Kategori::tekKategoriCek($_GET["kategoriId"]);
		require(SABLONLAR."/admin/kategoriDuzenle.php"); 
	}
}

function kategoriSil()
{
	if(isset($_GET["kategoriId"]))
	{
		$veri = array();
	
		$kategori = Kategori::tekKategoriCek($_GET["kategoriId"]);
		if($kategori->kategoriId != 7) $kategori->sil();	

		$veri["mesaj"] = "Kategori Silindi.";
			
	}
	header("Location: admin.php?secenek=kategoriListele");	
}

function kullaniciListele()
{
	$veri = array();
	$kullanicilar = Kullanici::listele();
	$veri["kullanicilar"] = $kullanicilar["kullanicilar"];
	$veri["toplamKullanici"] = $kullanicilar["toplamKullanici"];
	$veri["baslik"] = "Kullanıcılar";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
		
	require(SABLONLAR."/admin/kullaniciListele.php");
}

function kullaniciGuncelle()
{
	$veri = array();
	$veri["baslik"] = "Kullanıcı Güncelle";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
	
	if(isset($_POST["kaydet"]))
	{
		$kullanici = Kullanici::tekKullaniciCek($_POST["kullaniciId"]);
		$kullanici->formVerileriniSakla($_POST);
		$kullanici->guncelle();
		
		$veri["mesaj"] = "Kullanıcı güncellendi.";
	 	header("Location: admin.php?secenek=kullaniciListele");
	}
	else if(isset($_POST["iptal"]))
	{
		header("Location: admin.php?secenek=kullaniciListele");
	}
	else
	{
		$veri["kullanici"] = Kullanici::tekKullaniciCek($_GET["kullaniciId"]);
		require(SABLONLAR."/admin/kullaniciGuncelle.php"); 
	}
}

function kullaniciSil()
{
	if(isset($_GET["kullaniciId"]))
	{
		$veri = array();

		$kullanici = Kullanici::tekKullaniciCek($_GET["kullaniciId"]);
		$kullanici->sil();

		$veri["mesaj"] = "Kullanici Silindi.";
	}
	header("Location: admin.php?secenek=kullaniciListele");	
}

function menuEkle()
{
	$veri = array();
	$veri["baslik"] = "Yeni Menü";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
	$veri["formSecenek"] = "menuEkle";
	
	if(isset($_POST["kaydet"]))
	{
		$menu = new Menu($_POST);
		$menu->ekle();
		$veri["mesaj"] = "Yeni menü eklendi.";/************************/
		header("Location: admin.php?secenek=menuListele");
	}
	else if(isset($_POST["iptal"]))
	{
		header("Location: admin.php?secenek=menuListele");
	}
	else
	{
		$veri["menu"] = new Menu();
		$ustMenuler = Menu::listele();
		$veri["ustMenuler"] = $ustMenuler["menuler"];
		require(SABLONLAR."/admin/menuDuzenle.php");	
	}	
}

function menuListele()
{
	$veri = array();
	$menuler = Menu::listele();
	$veri["menuler"] = $menuler["menuler"];
	$veri["toplamMenu"] = $menuler["toplamMenu"];
	
	/**/foreach($veri["menuler"] as $menu)
	{
		if($menu->ustMenuId != 0)
		{
			$ustMenu = Menu::tekMenuCek($menu->ustMenuId);
			if(isset($ustMenu))
				$veri["ustMenu"][$menu->menuId] = $ustMenu->menuAdi;
		}		
	}	
	
	$veri["baslik"] = "Menüler";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
		
	require(SABLONLAR."/admin/menuListele.php");
}

function menuGuncelle()
{
	$veri = array();
	$veri["baslik"] = "Menu Düzenle";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
	$veri["formSecenek"] = "menuGuncelle";
	
	if(isset($_POST["kaydet"]))
	{
		$menu = new Menu($_POST);
		//$menu = Menu::tekMenuCek($_POST["menuId"]);
		//$menu->formVerileriniSakla($_POST);
		$menu->guncelle();
		
		$veri["mesaj"] = "Menü güncellendi.";
	 	header("Location: admin.php?secenek=menuListele");
	}
	else if(isset($_POST["iptal"]))
	{
		header("Location: admin.php?secenek=menuListele");
	}
	else
	{
		$veri["menu"] = Menu::tekMenuCek($_GET["menuId"]);
		$ustMenuler = Menu::listele();
		$veri["ustMenuler"] = $ustMenuler["menuler"];
		require(SABLONLAR."/admin/menuDuzenle.php"); 
	}
}

function menuSil()
{
	if(isset($_GET["menuId"]))
	{
		$veri = array();

		$menu = Menu::tekMenuCek($_GET["menuId"]);
		$menu->sil();

		$veri["mesaj"] = "Menu Silindi.";
	}
	header("Location: admin.php?secenek=menuListele");	
}

function footerGuncelle()
{
	$veri = array();
	$veri["baslik"] = "Footer İçeriğini Düzenle";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
	$veri["formSecenek"] = "footerGuncelle";
	$veri["visibility"] = "display: none";
	
	if(isset($_POST["kaydet"]))
	{
		$footer = Footer::footerCek();
		$footer->formVerileriniSakla($_POST);
		$footer->guncelle();
		
		$veri["mesaj"] = "Footer içeriği güncellendi.";
	 	header("Location: admin.php?secenek=footerGuncelle");/**/
	}
	else if(isset($_POST["iptal"]))
	{
		header("Location: admin.php?secenek=footerGuncelle");
	}
	else
	{
		$veri["footer"] = $footer = Footer::footerCek();
		
		if(isset($_POST["footerSol"]) || isset($_POST["footerOrta"]) || isset($_POST["footerSag"]))
		{
			foreach ($_POST as $name => $value)
			{
				$veri["textareaName"] = $name;
				$veri["footerPozisyon"] = $value;
			}				
			
			if(isset($_POST["footerSol"])) $veri["footerIcerik"] = $veri["footer"]->footerSol;			
			else if(isset($_POST["footerOrta"])) $veri["footerIcerik"] = $veri["footer"]->footerOrta;
			else if(isset($_POST["footerSag"])) $veri["footerIcerik"] = $veri["footer"]->footerSag;
		}
		else
		{
			$veri["footerIcerik"] = $veri["footer"]->footerSol;
			$veri["textareaName"] = "footerSol";
			$veri["footerPozisyon"] = "SOL";
		}
		require(SABLONLAR."/admin/footerGuncelle.php");
	}
	
	
}

function headerGuncelle()
{
	$veri = array();
	$veri["baslik"] = "Header İçeriğini Düzenle";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
	
	$veri["header"] = Header::headerCek();	
	$resimler = Resim::listele();
	$veri["resimler"] = $resimler["resimler"];
	$veri["toplamResim"] = $resimler["toplamResim"];
	
	if(isset($_POST["kaydet"]))
	{
		$header = Header::headerCek();
		$header->formVerileriniSakla($_POST);
		$header->guncelle();
		
		$veri["mesaj"] = "Header içeriğini güncellendi.";/**/
		
	 	header("Location: admin.php?secenek=headerGuncelle");
	}
	else if(isset($_POST["resimYukle"])) resimYukle();
	else if(isset($_POST["sil"])) resimSil();
	else if(isset($_POST["iptal"]))
	{
		header("Location: admin.php?secenek=headerGuncelle");
	}
	else
	{		
		$veri["header"] = Header::headerCek();
		require(SABLONLAR."/admin/headerGuncelle.php"); 
	}
}

function mailGonder()
{
	$veri = array();
	$veri["baslik"] = "Mail Gönder";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];
	$veri["formSecenek"] = "mailGonder";
	
	if(isset($_GET["alici"]))
	{
		$veri["alici"] = $_GET["alici"];
		if($_GET["alici"] == "tumKullanicilar")
		{
			$kullanicilar = Kullanici::listele();
			$veri["kullanicilar"] = $kullanicilar["kullanicilar"];
		}
		else
		{
			$veri["kullanicilar"] = Kullanici::tekKullaniciCek($_GET["alici"]);
		}
	}	
	
	if(isset($_POST["gonder"]))
	{
		require 'kutuphaneler/PHPMailer-master/src/PHPMailer.php';
		require 'kutuphaneler/PHPMailer-master/src/Exception.php';	
		require 'kutuphaneler/PHPMailer-master/src/SMTP.php';/**/

		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail->SMTPDebug = 3; //SMTP debugging etkinleştirildi.    
		$mail->isSMTP();  //PHPMailer, SMTP'yi kullanabilecek şekilde ayarlandı.    
		$mail->Host = "smtp.gmail.com"; //SMTP host adı  
		$mail->SMTPAuth = true; // SMTP hostu kimlik doğrulama istiyorsa true yapılmalı          
		$mail->Username = "nku.deneme@gmail.com";  // Kullanıcı adı               
		$mail->Password = "123123deneme"; // Şifre      
		//$mail->SMTPSecure = "tls"; // Eğer SMTP TLS şifreleme istiyorsa   
		$mail->Port = 587; // Bağlanılacak TCP portu    
		$mail->CharSet = 'UTF-8';

		$mail->From = "nku.deneme@gmail.com"; 
		$mail->FromName = BASLIK;

		$mail->smtpConnect(
			array(
				"ssl" => array(
					"verify_peer" => false,
					"verify_peer_name" => false,
					"allow_self_signed" => true
				)
			)
		);
		
		$alicilar = $_POST["alici"];
		$veri["alicilar"] = explode(",", $alicilar);
		foreach($veri["alicilar"] as $alici)
		{
			if($alici != "")
			{
				$mail->addAddress($alici, "");
			}				
		}		
		
		$mail->isHTML(true);

		$mail->Subject = $_POST["konu"];
		$mail->Body = $_POST["mailIcerik"];
		$mail->AltBody = filter_var($_POST["mailIcerik"], FILTER_SANITIZE_STRING);

		if(!$mail->send()) 
			$veri["mesaj"] = "Mail gönderirken hata oluştu: " . $mail->ErrorInfo;
		else 
			$veri["mesaj"] = "Mail başarıyla gönderildi.";
			
		$mail->clearAddresses();
			
		echo "<script>window.location.assign('admin.php?secenek=kullaniciListele')</script>";
	}
	else if(isset($_POST["iptal"]))
	{
		header("Location: admin.php?secenek=kullaniciListele");
	}
	else
	{
		require(SABLONLAR."/admin/mailGonder.php");	
	}	
}

function stilGuncelle()
{
	$veri = array();
	$veri["baslik"] = "Şablon Görünümünü Düzenle";
	$veri["sayfaBasligi"] = BASLIK . " | " . $veri["baslik"];	
		
	if(isset($_POST["kaydet"]))
	{		
		foreach($_POST as $name => $value)		
		{
			Stil::guncelle($name, $value.";");			
		}			
		
		$veri["mesaj"] = "Şablon görünümü güncellendi.";		
	 	header("Location: admin.php?secenek=stilGuncelle");
	}	
	else if(isset($_POST["iptal"]))
	{
		header("Location: admin.php?secenek=stilGuncelle");
	}
	else
	{			
		$stiller = Stil::listele();		
		require(SABLONLAR."/admin/stilGuncelle.php"); 
	}
}

function resimYukle()
{	
	$hedefKlasor = RESIMLER. "/header/";
	$hedefDosya = $hedefKlasor . basename($_FILES["resimYol"]["name"]);
	$yukle = 1;
	$dosyaTuru = strtolower(pathinfo($hedefDosya,PATHINFO_EXTENSION));
	
	if (file_exists($hedefDosya)) // Aynı isimde bir dosya var mı? 
	{
	    $veri["mesaj"] = "Bu isimde bir dosya zaten var.";
	    $yukle = 0;
	}	
	if ($_FILES["resimYol"]["size"] > 500000)  // Dosya boyut kontrolü
	{
	    $veri["mesaj"] = "Dosya boyutu 500 kb'dan büyük olamaz.";
	    $yukle = 0;
	}	
	if($dosyaTuru != "jpg" && $dosyaTuru != "png" && $dosyaTuru != "jpeg" && $dosyaTuru != "gif")  // Format kontrolü
	{
	    $veri["mesaj"] = "Sadece JPG, JPEG, PNG & GIF dosyaları yüklenebilir.";
	    $yukle = 0;
	}		
	if ($yukle == 0) 
	{		
	  	$veri["mesaj"] = "Dosyanız yüklenemedi.";	
	} 
	else
	{		
	  	if (move_uploaded_file($_FILES["resimYol"]["tmp_name"], $hedefDosya)) 
		{
			$veri["mesaj"] = basename($_FILES["resimYol"]["name"]) . " resmi başarıyla yüklendi.";
			
			$veri["resimYol"] = $hedefDosya;
			$rsm = new Resim($veri);
			$rsm->ekle();
	  	} 
	  	else 
	  	{
			$veri["mesaj"] = "Resmi yüklenirken bir hata oluştu.";
	  	}
	} 
	header("Location: admin.php?secenek=headerGuncelle");
}

function resimSil()
{
	$veri = array();
	
	if($_POST["resimId"] != 13)
	{		
		$resim = Resim::tekResimCek($_POST["resimId"]);
		unlink($resim->resimYol);
		$resim->sil();

		$veri["mesaj"] = "Resim Silindi.";
	}
	header("Location: admin.php?secenek=headerGuncelle");
}

?>