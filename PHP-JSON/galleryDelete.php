<?php
session_start();
$gallery_id = $_GET["gallery_id"];
$readGalleriesJson = file_get_contents("db/gallery.json"); //json ֆայլը կարդալու համար
$galleriesArray = json_decode($readGalleriesJson, true);       //ձևափոխի json տեքստը ասոցատիվ array.
$galleries = &$galleriesArray["galleries"];
foreach ($galleries as $key =>$gallery) {
    if($gallery_id == $gallery["id"]){
        $img_name = $gallery['img'];
        unlink('Images/gallery/'.$img_name);
        unset($galleries[$key]);
    }
}
$jsonText = json_encode($galleriesArray);
file_put_contents("db/gallery.json", $jsonText);

header('location:profile.php'); die;
