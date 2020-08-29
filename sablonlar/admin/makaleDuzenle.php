<?php

try
{
	include SABLONLAR."/include/header.php"; 

	if(isset($veri["makale"]->makaleId)) { ?>
	<div id="sil">
		<a onClick="mklSilmeOnay()">Makaleyi Sil</a>
	</div>
	<?php } ?>
	<br>
	<form action="admin.php?secenek=<?php echo $veri["formSecenek"]; ?>" method="post" id="makaleFormu">
		
		<input type="hidden" name="makaleId" value="<?php echo $veri["makale"]->makaleId; ?>">
		
		<div id="girdiBaslik">Makale Başlığı:</div>  <br>
		<input type="text" name="makaleBaslik" placeholder="Başlık.."  value="<?php echo $veri["makale"]->makaleBaslik; ?>" required><br><br>
		
		<div id="girdiBaslik">Makale Özeti:</div> <br>		
		<textarea name="makaleOzet" id="makaleOzet" cols="80" rows="5" placeholder="Özet.." ><?php echo $veri["makale"]->makaleOzet; ?></textarea><br><br>
		
		<div id="girdiBaslik">Makale İçeriği:</div> <br>
		<textarea name="makaleIcerik" id="makaleIcerik" cols="80" rows="30" placeholder="Makale İçeriği.."><?php echo $veri["makale"]->makaleIcerik; ?></textarea><br>
		
		<div id="girdiBaslik">Kategori:</div> <br>
		<select name="kategoriId" id="">			
			<?php
			$opt0 = "<option value='' disabled ";
			if(empty($veri["makale"]->kategoriId)) $opt0 .= "selected ";
			$opt0 .= ">Kategori</option>";
			echo $opt0;
	
			foreach($veri["kategoriler"] as $kategori)
			{
				$option = "<option value='$kategori->kategoriId'";
				if($veri["makale"]->kategoriId == $kategori->kategoriId) $option .= "selected ";
				$option .= ">$kategori->kategoriAdi</option>";
				echo $option;
			}						
			?>					
		</select> <br><br>
		
		<div id="girdiBaslik">Yayınlanma Tarihi:</div> <br>
		<input type="date" name="yayinTarihi" placeholder="YYYY-MM-DD" value="<?php echo $veri["makale"]->yayinTarihi; ?>" ><br><br>
		
		<input type="submit" name="kaydet" value="Kaydet">
		<input type="submit" formnovalidate name="iptal" value="İptal">
		
	</form>
	
	<script type="text/javascript">
		tinyMCE.init({			
			selector: '#makaleIcerik',
			content_style: "body { font-size: 14pt; font-family: Calibri; background-color: white; }",
			language: 'tr',
			plugins: 'image, link, lists advlist, table', 
			toolbar: 'undo redo | link image | code | numlist bullist'			
		});	
	</script><!---->

	<script type="text/javascript">
		function mklSilmeOnay()
		{
			if(confirm("UYARI: Makale Silinecek! Emnin Misiniz?"))
				location.href = 'admin.php?secenek=makaleSil&makaleId=<?php echo $veri["makale"]->makaleId; ?>';
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