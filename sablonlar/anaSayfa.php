<?php 

try
{
	include SABLONLAR."/include/header.php"; 
	
	
	echo "<div id='makaleler'>";	
	
	foreach($veri["makaleler"] as $makale)
	{ ?>

		<h1><a href='index.php?secenek=makaleGoster&makaleId=<?php echo $makale->makaleId; ?>'><?php echo $makale->makaleBaslik; ?></a></h1>

		<p><?php echo $makale->makaleOzet; ?></p>

		<span id='kategori'>Kategori:</span> 
		<?php if(isset($makale->kategoriId)) echo "<a href='index.php?secenek=arsiv&kategoriId=$makale->kategoriId'><span id='kategoriLink'>".$veri["kategoriler"][$makale->kategoriId]."</span></a>"; ?>

		<div id='yayinTarihi'><?php echo $makale->yayinTarihi; ?></div>

	<?php	
	}
	echo "</div>";	
		
	
	include SABLONLAR."/include/footer.php"; 
}
catch(PDOException $hata)
{
	echo "HATA:" . $hata->getMessage();
}

?>
	
