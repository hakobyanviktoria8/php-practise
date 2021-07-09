<?php
session_start();
$gallery_id = $_GET["gallery_id"];
$doc = new DOMDocument('1.0');           //ստեղծումա DOM obekt,որը պարունակում է xml-ը
$xmlFile = "db/gallery.xml";            //XML-ի ճանապարհը
$doc->load($xmlFile);
//Fetch user galleries
$galleries = $doc->getElementsByTagName("gallery");
foreach ($galleries as $gallery) {
    if($gallery_id == $gallery->getAttribute("id")){
        $img_name = $gallery->getElementsByTagName('img')->item(0)->nodeValue;
        unlink('Images/gallery/'.$img_name);
        $doc->getElementsByTagName('galleries')->item(0)->removeChild ($gallery);
    }
}
$doc->save($xmlFile);
header('location:profile.php'); die;
