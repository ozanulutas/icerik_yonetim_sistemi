<?php

try
{
	include SABLONLAR."/include/header.php"; 

?>	
	
	<a href="admin.php?secenek=mailGonder&alici=tumKullanicilar">Tüm Kullanıcılara Mail Gönder</a>

	<div id='yayinTarihi'>Toplam Kullanıcı Sayısı: <?php echo $veri["toplamKullanici"]; ?></div>

	<table id='makaleTablo'><tr><th>Kullanıcı Adı</th><th>E-Mail</th><th>Yetki</th></tr>
		
	<?php 
	
	foreach($veri["kullanicilar"] as $kullanici)
	{ 
		if($kullanici->kullaniciId != $_SESSION["kullaniciId"])
		{
		?>
		<tr id="makaleSec" onClick="location='admin.php?secenek=kullaniciGuncelle&kullaniciId=<?php echo $kullanici->kullaniciId; ?>'">
			<td><?php echo $kullanici->kullaniciAdi; ?></td>
			<td><?php echo $kullanici->email; ?></td>
			<td><?php echo ($kullanici->yetki == 0) ? "Kullanıcı" : "Admin"; ?></td>
		</tr>
	<?php
		}
	}
	
	echo "</table>";
	
	
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	"HATA: ".$hata->getMessage();
}

?>
