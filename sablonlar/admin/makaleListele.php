<?php

try
{
	include SABLONLAR."/include/header.php"; 

?>	

	<div id='yayinTarihi'>Toplam Makale Sayısı: <?php echo $veri["toplamMakale"]; ?></div>

	<table id='makaleTablo'><tr><th>Başlık</th><th>Kategori</th><th>Yayınlanma Tarihi</th></tr>
		
	<?php foreach($veri["makaleler"] as $makale)
	{ ?>
		<tr id="makaleSec" onClick="location='admin.php?secenek=makaleGuncelle&makaleId=<?php echo $makale->makaleId ?>'">
			<td><?php echo $makale->makaleBaslik ?></td>
			<td><?php if(isset($makale->kategoriId)) echo $veri["kategoriler"][$makale->kategoriId] ?></td>
			<td><?php echo $makale->yayinTarihi ?></td>
		</tr>
	<?php
	}
	
	echo "</table>";
	
	
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	"HATA: ".$hata->getMessage();
}

?>
