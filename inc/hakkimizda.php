<?php
$data = array(
    "title" => "Hakkımızda Sayfası",
    "mesaj" => "Hakkımızda sayfası mesaj."
);

// index.php üzerinden çağırıldığı için depth=0
$view = new Twiggy(0);
$view->render("inc/hakkimizda.html.twig", $data);
?>
