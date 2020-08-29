<?php

try
{
	include SABLONLAR."/include/header.php"; 
	
?>		
	
	<div id='yayinTarihi'>Toplam Kategori Sayısı: <?php echo $veri["toplamKategori"]; ?></div>
	<table id='makaleTablo'><tr><th>Kategori Adı</th></tr>
		
	<?php foreach($veri["kategoriler"] as $kategori)
	{ ?>
		<tr id="makaleSec" onClick="location='admin.php?secenek=kategoriGuncelle&kategoriId=<?php echo $kategori->kategoriId ?>'"><td><?php echo $kategori->kategoriAdi ?></td></tr><?php	
	}
	
	echo "</table>";
	
	
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	"HATA: ".$hata->getMessage();
}

?>