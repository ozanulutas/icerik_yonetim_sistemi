<?php 

try
{
	include SABLONLAR."/include/header.php"; 
	
	?>

	<div id='makaleler'><div id='yayinTarihi'>Toplam Makale Sayısı: <?php echo $veri["toplamMakale"]; ?></div>
	
	<?php
	foreach($veri["makaleler"] as $makale)
	{?>
		<h1><a href='index.php?secenek=makaleGoster&makaleId=<?php echo $makale->makaleId; ?>'><?php echo $makale->makaleBaslik; ?></a></h1>
		<span id='kategori'>Kategori:</span> 
		<?php if(isset($makale->kategoriId)) echo "<a href='index.php?secenek=arsiv&kategoriId=$makale->kategoriId'><span id='kategoriLink'>".$veri["kategoriler"][$makale->kategoriId]."</span></a>"; ?>
		<p><?php echo $makale->makaleOzet; ?></p>
		<div id='yayinTarihi'><?php echo $makale->yayinTarihi; ?></div>
	<?php
	} ?>
		
 	</div>
	
	<div id="sayfalar">
	<ul>
		<a href="<?php echo ($sayfaNo <= 1) ? "#" : "index.php?secenek=arsiv&sayfaNo=".($sayfaNo - 1); ?>"><li>&lsaquo;</li></a>		
        <a href="index.php?secenek=arsiv&sayfaNo=1"><li>1.</li>  </a>    
        <a href="index.php?secenek=arsiv&sayfaNo=<?php echo $veri["toplamSayfa"]; ?>"><li><?php echo $veri["toplamSayfa"]; ?>.</li></a>
		<a href="<?php echo ($sayfaNo >= $veri["toplamSayfa"]) ? "#" : "index.php?secenek=arsiv&sayfaNo=".($sayfaNo + 1); ?>"><li>&rsaquo;</li></a>
    </ul>
	</div>
		
	<?php
	
	include SABLONLAR."/include/footer.php"; 
}
catch(PDOException $hata)
{
	echo "HATA:" . $hata->getMessage();
}

?>
	
