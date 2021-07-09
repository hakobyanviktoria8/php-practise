<?php
session_start();
$_SESSION["error"] = [];
$user_id = $_SESSION['user_id'];
$img_dir = "Images/gallery/";
$img_name = uniqid().basename($_FILES['image']['name']);                      //Սկզբից գեներացված թիվն է գրում
$img_file = $img_dir.$img_name;
$imageFileType = strtolower(pathinfo($img_file,PATHINFO_EXTENSION));      //EXTENSION վերցնում է նկ ֆորմատը
if($imageFileType != "jpeg" && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif"){
   $_SESSION["error"]["image"] = "File type must be jpeg, jpg, png, gif";
} elseif($_FILES['image']['size'] > 500000000) {
   $_SESSION['error']['image'] = 'File size must not exceed 5mb';
}
if (empty($_SESSION['error'])) {
    if (move_uploaded_file($_FILES['image']['tmp_name'], $img_file)) {  //move_uploaded_file տեղափոխում է ուղարկված ֆայլը
        $readGalleriesJson = file_get_contents("db/gallery.json"); //json ֆայլը կարդալու համար
        $galleriesArray = json_decode($readGalleriesJson, true);            //ձևափոխի json տեքստը ասոցատիվ array.
        $gallery = [];
        $gallery['id'] = uniqid();
        $gallery['user_id'] = $user_id;
        $gallery['img'] = $img_name;
        if (empty($galleriesArray['galleries'])) {
            $galleriesArray['galleries'] =[];
        }
        array_push($galleriesArray['galleries'],$gallery);
        //Save JSON
        $jsonText = json_encode($galleriesArray);
        file_put_contents("db/gallery.json", $jsonText);
    } else {
        $_SESSION['error']['image'] = 'Could not upload file';
    }
}
header('location:profile.php'); die;
?>