

<?php if(empty($_SESSION["oturum"])) { ?>
<div style="text-align: center"><a href="admin.php">Giriş</a> | 
<a href="kullanici.php?secenek=kayit">Kayıt</a></div>
<?php 
} else { ?>
<div style="text-align: center"><a href="admin.php"><?php echo ($_SESSION["oturum"] == "admin") ? "Admin Paneli" : "Profilim"; ?></a></div>
<?php } ?>
<hr>

<?php 
if(isset($_GET["anaMenuId"]) && Menu::altMenuSay($_GET["anaMenuId"]) > 0) {
	$menuler = Menu::listele();
	echo "<h2>".Menu::tekMenuCek($_GET["anaMenuId"])->menuAdi."</h2>";
	Menu::altMenuGoster($menuler["menuler"], $_GET["anaMenuId"], $_GET["anaMenuId"]);
}
else {	
?>	
	<a href="index.php?secenek=arsiv">Makale Arşivi</a><br>

	<h2>Kategoriler</h2>
	<?php
	$kategoriler = Kategori::listele();
	$veri["ktgr"] = $kategoriler["kategoriler"];
	foreach($veri["ktgr"] as $kategori) 
		echo "<a href='index.php?secenek=arsiv&kategoriId=$kategori->kategoriId'>$kategori->kategoriAdi</a><br>";	
	?>

	<h2>Öne Çıkanlar</h2>
	<?php
	$makaleler = Makale::listele(array(GOSTERILEN_MAKALE), null, "goruntulenme");
	$veri["mkl"] = $makaleler["makaleler"];
	foreach($veri["mkl"] as $makale) 
		echo "<a href='index.php?secenek=makaleGoster&makaleId=$makale->makaleId'>$makale->makaleBaslik</a><br>";

	}	
?>
