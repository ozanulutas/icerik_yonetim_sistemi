<?php

try
{
	include SABLONLAR."/include/header.php"; 
	
?>		
	
	<div id='yayinTarihi'>Toplam Menü Sayısı: <?php echo $veri["toplamMenu"]; ?></div>
	<table id='makaleTablo'><tr><th>Menü Adı</th><th>Üst Menü</th><th>Pozisyon</th></tr>
		
	<?php foreach($veri["menuler"] as $menu)
	{ ?>
		<tr id="makaleSec" onClick="location='admin.php?secenek=menuGuncelle&menuId=<?php echo $menu->menuId ?>'">
			<td><?php echo $menu->menuAdi; ?></td>
			<td><?php echo (isset($veri["ustMenu"][$menu->menuId])) ? $veri["ustMenu"][$menu->menuId] : "Yok" ?></td>
			<td><?php echo $menu->pozisyon; ?></td>
		</tr><?php	
	}
	
	echo "</table>";
	
	
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	"HATA: ".$hata->getMessage();
}

?>