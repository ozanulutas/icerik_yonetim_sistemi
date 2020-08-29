<?php

try
{
	include SABLONLAR."/include/header.php"; 
	
	$fontlar = array("Arial", "Times New Roman", "Constantia", "Courier New", "Consolas", "Calibri", "Verdana", "Georgia", "Monospace", "Comic Sans MS");

?>
	
	<form action="admin.php?secenek=resimYukle" method="post" id="makaleFormu" enctype="multipart/form-data">
		<div id="girdiBaslik">Yüklemek İçin Bir Resim Seçin:</div> <br>
		<input type="file" name="resimYol" accept="image/*" required> <br><br>		
		<input type="submit" name="kaydet" value="Yükle">	
	</form> 
	<br><hr><br>

	
	<form action="admin.php?secenek=headerGuncelle" method="post" id="makaleFormu" enctype="multipart/form-data">
		
		<div id="girdiBaslik">Header Başlığı:</div>  <br>
		<input type="text" name="headerBaslik" placeholder="Header bölümünde yazmasını istediğiniz başlık.." value="<?php echo $veri["header"]->headerBaslik; ?>"><br><br>
		
				
		<div id="girdiBaslik">Header Logosu:</div> 		
		<div id="resmiSil"><input type="submit" name="sil" value="Resmi Sil"></div><br>
		
		<div id="headerResimListe">			
		<?php foreach($veri["resimler"] as $resim) { ?>
			<div id="headerResimSec">				
				<div><img src="<?php echo $resim->resimYol; ?>" ></div>
				
				<input type="radio" name="resimId" id="resimId" onClick="idAl(this.id)" value="<?php echo $resim->resimId; ?>" <?php echo ($resim->resimId == $veri["header"]->resimId) ? "checked" : ""; ?> >
			</div> 
		<?php } ?>	
		</div>	
		
		<br><br>		
		<input type="submit" name="kaydet" value="Kaydet">
		<input type="submit" formnovalidate name="iptal" value="İptal">
		
	</form>
	

<?php
	
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	"HATA: ".$hata->getMessage();
}

?>