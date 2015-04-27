<?php
require_once '../../config.php';
require_once '../../lib/fonksiyonlar.php';
require_once '../../lib/SimpleImage.php';
require_once '../../lib/class.image.php';
session_start();
$dosya = ResimIslemleri::imageUpload("dosya", false, array("gif","png","jpg","jpeg"));

if ($dosya[0] == true &&
    isset($_POST["sid"]) &&
    isset($_POST["adi"]) &&
    isset($_POST["gosterim"]) &&
    isset($_POST["baslangic"]) &&
    isset($_POST["bitis"]) &&
    isset($_POST["kod"]) &&
    isset($_POST["link"]) &&
    isset($_FILES["dosya"]) ){

    $sirket_id = $_POST["sid"];
    $adi = $_POST["adi"];
    $gosterim = $_POST["gosterim"];
    $tiklama = "0";
    $baslangic = $_POST["baslangic"];
    $bitis = $_POST["bitis"];
    $kod = $_POST["kod"];
    $href = $_POST["link"];
    $aktif = "1";

    $query = $DB->prepare("
    INSERT INTO reklamlar
    VALUES (null,:id_sirket,:adi,:gosterim,:tiklama,:tarih_baslangic,:tarih_bitis,now(),:dosya,:kod,:href,:aktif)
    ");

    $query->bindParam(':id_sirket',$sirket_id);
    $query->bindParam(':adi',$adi);
    $query->bindParam(':gosterim',$gosterim);
    $query->bindParam(':tiklama',$tiklama);
    $query->bindParam(':tarih_baslangic',$baslangic);
    $query->bindParam(':tarih_bitis',$bitis);

    // TODO: Burasının ileride değişmesi gerekebilir.
    // Reklam dosyaları admin/sirket/upload altına atılıyor.
    $dosyaYolu = "admin/sirket/".$dosya[1];
    $query->bindParam(':dosya',$dosyaYolu);
    $query->bindParam(':kod',$kod);
    $query->bindParam(':href',$href);
    $query->bindParam(':aktif',$aktif);
    $sonuc = $query->execute();

    if ($sonuc) {
        // islem başarılı.
        $mesaj = "basarili";
    }

    else {
        // islem başarısız.
        $mesaj = "basarisiz";
    }
}
else {
    // islem başarısız.
    $mesaj = "basarisiz";
    echo "shit"; die();
}
echo "
<script>
window.location.href = '../index.php?link=reklam&sonuc=$mesaj';
</script>
";
?>