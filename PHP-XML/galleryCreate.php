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
        $doc = new DOMDocument('1.0');           //ստեղծումա DOM obekt,որը պարունակում է xml-ը
        $xmlFile = "db/gallery.xml";            //XML-ի ճանապարհը
        $doc->load($xmlFile);                    //DOM-ի մեջ ավելացնում է $xmlFile
        //Create gallery element with id, user_id and image name.
        $galleryElem = $doc->createElement("gallery");      //gallery.xml-ի մեջ ստեղծումա gallery էլեմենտ
        $galleryElem->setAttribute("id", uniqid());        //տալով ունիկալ id
        $galleryElem->setAttribute("user_id", $user_id);    //ավելացնում է նաև user_id ատրիբուտ
        $imgElem = $doc->createElement("img");              //ստեղծումա img էլլեմենտ
        $imgElem->appendChild($doc->createTextNode($img_name));   //img-ի մեջ անունա գրում
        $galleryElem->appendChild($imgElem);                     //gallery-ի մեջ ավելացնում է img
        //Add gallery to galleries
        $galleriesElem = $doc->getElementsByTagName("galleries")->item(0);//գտնում է galleries-ի առաջին էլեմենտը
        $galleriesElem->appendChild($galleryElem);          //և ավելացնում է gallery-ին
        //Save xml
        $doc->save($xmlFile);
    } else {
        $_SESSION['error']['image'] = 'Could not upload file';
    }
}
header('location:profile.php'); die;
?>