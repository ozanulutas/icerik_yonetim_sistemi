<?php

try
{
	include SABLONLAR."/include/header.php"; 

	
	if ($veri["kullanici"]->yetki != 1) { ?>
	<div id="sil"><a onClick="prflSilmeOnay()">Profili Sil</a></div> <?php } ?>
	
	
	<h2>Şifremi Değiştir</h2>

	<form action="kullanici.php?secenek=profilGuncelle" method="post" id="makaleFormu">
		<div id="girdiBaslik">Mevcut Şifre</div> <br>
		<input type="password" name="eskiSifre" required placeholder="Eski şirenizi girin.."> <br><br>
		<div id="girdiBaslik">Yeni Şifre</div> <br>
		<input type="password" name="sifre" required placeholder="Yeni şirenizi girin.."> <br><br>
		<div id="girdiBaslik">Yeni Şifre Tekrar</div> <br>
		<input type="password" name="sifreTekrar" required placeholder="Yeni şirenizi tekrar girin.."> <br><br>
		<input type="submit" name="sifreGuncelle" value="Kaydet">
	</form>
	<br><hr>

	<h2>E-Mail Adresimi Değiştir</h2>
	<form action="kullanici.php?secenek=profilGuncelle" method="post" id="makaleFormu">
		<div id="girdiBaslik">Mail Adresim</div> <br>
		<input type="text" name="email" value="<?php echo $veri["kullanici"]->email; ?>" placeholder="E-mail adresinizi girin.."> <br><br>		
		<input type="submit" name="mailGuncelle" value="Kaydet" >		
	</form>
	
	
	<script type="text/javascript">
		function prflSilmeOnay()
		{
			if(confirm("UYARI: Profiliniz Silinecek! Emnin Misiniz?"))
				location.href = 'kullanici.php?secenek=profilSil';
		}	
	</script>


<?php
	
	
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	"HATA: ".$hata->getMessage();
}

?>
