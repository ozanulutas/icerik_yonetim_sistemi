<?php

try
{
	include SABLONLAR."/include/header.php"; echo $veri["mesaj"]; 

?>
	
	
		<div id="girisFormu">
			
			<form action="admin.php?secenek=giris" method="post">			
				Kullanıcı Adı <br>
				<input type="text" name="kullaniciAdi" placeholder="Kullanıcı Adınız.." required><br>
				Şifre <br>
				<input type="password" name="sifre" placeholder="Şifreniz.." required>
				<input type="submit" value="Giriş" name="giris">
			</form>
			<br>
			Üye değil misiniz? Hemen <a href="kullanici.php?secenek=kayit">üye olun</a>!
		</div>
	
	
	<?php
	
	
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	"HATA: ".$hata->getMessage();
}

?>