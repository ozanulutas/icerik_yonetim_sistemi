<?php 

try
{
	include SABLONLAR."/include/header.php"; 
	
	?>
	
	<div id='yayinTarihi'><?php echo $veri["makale"]->yayinTarihi; ?></div>
	<div id='yayinTarihi'>Toplam <?php echo $veri["makale"]->goruntulenme; ?> kez görüntülendi</div>
	<h1><?php echo $veri["makale"]->makaleBaslik; ?></h1>
	<span id='kategori'>Kategori:</span> 
	<?php if(isset($veri["makale"]->kategoriId)) { ?>
			<a href='index.php?secenek=arsiv&kategoriId=<?php echo $veri["kategori"]->kategoriId; ?>'>
				<span id='kategoriLink'><?php echo $veri["kategori"]->kategoriAdi; ?></span>
			</a>
	<?php } ?>
	<p><?php echo $veri["makale"]->makaleOzet; ?></p>
	<?php echo $veri["makale"]->makaleIcerik; ?> 


	<div id="makaleFormu" style="width: 100%; float: left">
		<br><hr><br>
		<?php if(isset($_SESSION["oturum"])) {?>
		<form action="kullanici.php?secenek=yorumYap" method="post" >
			<input type="hidden" name="makaleId" value="<?php echo $veri["makale"]->makaleId; ?>">
			<input type="hidden" name="kullaniciId" value="<?php echo $_SESSION["kullaniciId"]; ?>">

			<div id="girdiBaslik">Yorumunuz:</div><br>  <br>
			<textarea name="mesaj" id="makaleFormu" cols="30" rows="10" placeholder="Yorum yazın.." required></textarea>
			<br>
			<input type="submit" value="Gönder" name="gonder">
		</form>
		<br><hr><br>
		<?php } ?>	
		
		<div id='yayinTarihi'>Toplam <?php echo $veri["toplamMesaj"]; ?> yorum yapılmış.</div>
		<div id="girdiBaslik">Yorumlar:</div>  <br><br>
		
		
		<?php foreach($veri["mesajlar"] as $mesaj) { 
		if(isset($_SESSION["oturum"]) && ($_SESSION["oturum"] == "admin" || $_SESSION["kullaniciId"] == $mesaj->kullaniciId)) 
			echo "<span id='sil'><a onClick='mesajSilmeOnay()'>Yorumu Sil</a></span><br>"; 
		echo Kullanici::tekKullaniciCek($mesaj->kullaniciId)->kullaniciAdi;	?> tarafından yazılmış. 
		<span style="float: right"><?php echo $mesaj->tarih; ?></span>
		
		<div id="yorumlar">
			<p><?php echo $mesaj->mesaj; ?></p>
		</div>
		<?php } ?>
		
	</div>

	<script>
		function mesajSilmeOnay()
		{
			if(confirm("UYARI: Yorumunuz Silinecek! Emnin Misiniz?"))
				location.href = 'kullanici.php?secenek=yorumSil&mesajId=<?php echo $mesaj->mesajId; ?>';
		}
	</script>
	

<?php
	
	
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	echo "HATA:" . $hata->getMessage();
}

?>
