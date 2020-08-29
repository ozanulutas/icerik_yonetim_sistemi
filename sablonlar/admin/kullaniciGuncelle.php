<?php

try
{
	include SABLONLAR."/include/header.php"; 

?>
	<a href="admin.php?secenek=mailGonder&alici=<?php echo $veri["kullanici"]->kullaniciId; ?>">Kullanıcıya Mail Gönder</a>

	<div id="sil">
		<a onClick="kllncSilmeOnay()" >Kullanıcıyı Sil</a>
	</div>

	<form action="admin.php?secenek=kullaniciGuncelle" method="post" id="makaleFormu">
		
		<input type="hidden" name="kullaniciId" value="<?php echo $veri["kullanici"]->kullaniciId; ?>">
		
		<div id="girdiBaslik">Kullanıcı Adı:</div>  <br>
		<?php echo $veri["kullanici"]->kullaniciAdi; ?><br><br>
		
		<div id="girdiBaslik">E-Mail:</div> <br>		
		<?php echo $veri["kullanici"]->email; ?> <br><br>
		
		<div id="girdiBaslik">Yetki:</div> <br>
		<select name="yetki" id="">
			<option value="0" <?php echo ($veri["kullanici"]->yetki == 0) ? "selected" : "" ?> >Kullanıcı</option>
			<option value="1" <?php echo ($veri["kullanici"]->yetki == 1) ? "selected" : "" ?> >Admin</option>
		</select><br><br>
		
		<input type="submit" name="kaydet" value="Kaydet">
		<input type="submit" formnovalidate name="iptal" value="İptal">
		
	</form>

	<script type="text/javascript">
		function kllncSilmeOnay()
		{
			if(confirm("UYARI: Kullanıcı Silinecek! Emnin Misiniz?"))
				location.href = 'admin.php?secenek=kullaniciSil&kullaniciId=<?php echo $veri["kullanici"]->kullaniciId; ?>';
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