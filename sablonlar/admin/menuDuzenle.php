<?php

try
{
	include SABLONLAR."/include/header.php"; 

	if(isset($veri["menu"]->menuId)) { ?>
	<div id="sil">
		<a onClick="menuSilmeOnay()" >Menüyü Sil</a>
	</div>
	<?php } ?>
	<br>
	<form action="admin.php?secenek=<?php echo $veri["formSecenek"]; ?>" method="post" id="makaleFormu">
		
		<input type="hidden" name="menuId" value="<?php echo $veri["menu"]->menuId; ?>">
		
		<div id="girdiBaslik">Menü Adı:</div>  <br>
		<input type="text" name="menuAdi" placeholder="Menünün adı.." required value="<?php echo $veri["menu"]->menuAdi; ?>"><br><br>
		
		<div id="girdiBaslik">Menü Sırası:</div>  <br>
		<input type="text" name="pozisyon" placeholder="Menünün pozisyonu.." required value="<?php echo $veri["menu"]->pozisyon; ?>"><br><br>		
		
		<div id="girdiBaslik">Üst Menü:</div> <br>
		<select name="ustMenuId" id="">
			<option value='0' >Yok</option>			
			<?php	
			foreach($veri["ustMenuler"] as $ustMenu)
			{
				if($veri["menu"]->menuId != $ustMenu->menuId) 
				{
					$option = "<option value='$ustMenu->menuId'";
					if($veri["menu"]->ustMenuId == $ustMenu->menuId) $option .= "selected ";
					$option .= ">$ustMenu->menuAdi</option>";
					echo $option;
				}
			}					
			?>				
		</select> <br><br><hr><br>		
		
		<div id="girdiBaslik">Menü İçeriği:</div> <br>
		<textarea name="menuIcerik" id="menuIcerik" cols="80" rows="30" placeholder="Menü tıklandığında gösterilecek içerik.."><?php echo $veri["menu"]->menuIcerik; ?></textarea><br>
		
		<input type="submit" name="kaydet" value="Kaydet">
		<input type="submit" formnovalidate name="iptal" value="İptal">
		
	</form>
	
	<script type="text/javascript">
		tinyMCE.init({			
			selector: '#menuIcerik',
			language: 'tr',
			plugins: 'image, link, lists advlist, table',
			toolbar: 'undo redo | link image | code | numlist bullist',
		});	
	</script>

	<script type="text/javascript">
		function menuSilmeOnay()
		{
			if(confirm("UYARI: Menü Tüm İçerikleriyle Birlikte Silinecek! Emnin Misiniz?"))
				location.href = 'admin.php?secenek=menuSil&menuId=<?php echo $veri["menu"]->menuId; ?>';
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