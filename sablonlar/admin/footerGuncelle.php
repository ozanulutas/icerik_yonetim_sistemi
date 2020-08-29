<?php

try
{
	include SABLONLAR."/include/header.php"; 

?>
	
	<p id="footerTalimat">Footer'ın Düzenlemek İstediğiniz Bölümünü Seçin:</p>
	<div id="footer">
		<form action="admin.php?secenek=footerGuncelle" method="post">

			<div><input type="submit" name="footerSol" value="SOL" style="<?php if(isset($veri["textareaName"])) if($veri["textareaName"] == "footerSol") echo "text-shadow: 2px 2px 4px #000000;"; ?>"></div>
			<div><input type="submit" name="footerOrta" value="ORTA" style="<?php if(isset($veri["textareaName"])) if($veri["textareaName"] == "footerOrta") echo "text-shadow: 2px 2px 4px #000000;"; ?>"></div>
			<div><input type="submit" name="footerSag" value="SAĞ" style="<?php if(isset($veri["textareaName"])) if($veri["textareaName"] == "footerSag") echo "text-shadow: 2px 2px 4px #000000;"; ?>"></div>	

		</form>
	</div><br><br><br><br><hr><br>
		
	
	<form action="admin.php?secenek=footerGuncelle" method="post" id="makaleFormu" name="footerFormu">
					
		<div id="girdiBaslik"><?php if(isset($veri["footerPozisyon"])) echo $veri["footerPozisyon"]; ?> Footer İçeriği:</div> <br>
		<textarea name="<?php echo $veri["textareaName"]; ?>" id="footerIcerik" cols="80" rows="15" placeholder="Footer'da yer almasını istediğiniz içerik.."><?php echo $veri["footerIcerik"]; ?></textarea><br>
		
		<input type="submit" name="kaydet" value="Kaydet">
		<input type="submit" formnovalidate name="iptal" value="İptal">
		
	</form>
	
	<script type="text/javascript">
		tinyMCE.init({			
			selector: '#footerIcerik',
			content_style: "body { font-size: 14pt; font-family: Calibri; background-color: white; }",
			language: 'tr',
			plugins: 'image, link, lists',
			toolbar: 'undo redo | link image',
						
		});	
	</script>
		
<?php
	
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	"HATA: ".$hata->getMessage();
}

?>