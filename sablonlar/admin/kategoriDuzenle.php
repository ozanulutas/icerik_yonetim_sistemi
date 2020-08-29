<?php

try
{
	include SABLONLAR."/include/header.php"; 

	if(isset($veri["kategori"]->kategoriId)) { ?>
	<div id="sil">
		<a onClick="ktgrSilmeOnay()">Kategoriyi Sil</a>
	</div>
	<?php } ?>
	<br>
	<form action="admin.php?secenek=<?php echo $veri["formSecenek"]; ?>" method="post" id="makaleFormu">
		
		<input type="hidden" name="kategoriId" value="<?php echo $veri["kategori"]->kategoriId; ?>">
		
		<div id="girdiBaslik">Kategorinin Adı:</div>  <br>
		<input type="text" name="kategoriAdi" placeholder="Kategori Adı.." value="<?php echo $veri["kategori"]->kategoriAdi; ?>"><br><br>
		
		<div id="girdiBaslik">Kategorinin Açıklaması:</div> <br>		
		<textarea name="kategoriAciklama" id="kategoriAciklama" cols="80" rows="5" placeholder="Açıklama.."><?php echo $veri["kategori"]->kategoriAciklama; ?> </textarea><br><br>
		
		<input type="submit" name="kaydet" value="Kaydet">
		<input type="submit" formnovalidate name="iptal" value="İptal">
		
	</form>

	<script type="text/javascript">
		function ktgrSilmeOnay()
		{
			if(confirm("UYARI: Kategori Silinecek! Emnin Misiniz?"))
				location.href = 'admin.php?secenek=kategoriSil&kategoriId=<?php echo $veri["kategori"]->kategoriId; ?>';
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