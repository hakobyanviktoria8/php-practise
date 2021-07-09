<?php
include('functions.php');
session_start();
$user_id = $_SESSION['user_id'];
$gallery_id = $_GET["gallery_id"];
$doc = new DOMDocument('1.0');
$xmlFile = "db/gallery.xml";
$doc->load($xmlFile);
$galleries = $doc->getElementsByTagName("gallery");
foreach ($galleries as $gallery) {
    if($gallery_id == $gallery->getAttribute("id")){
        $img_name = $gallery->getElementsByTagName('img')->item(0)->nodeValue;
        copy('Images/gallery/'.$img_name,'Images/avatars/'.$img_name);
        $docUsers = new DOMDocument('1.0');
        $xmlFileForUsers = "db/users-from-php.xml";
        $docUsers->load($xmlFileForUsers);
        $user = get_user_by_attr("id", $user_id, $docUsers);
        $avatarElements = $user->getElementsByTagName("avatar");
        $avatar = null;
        if ($avatarElements->length == 0) {                //եթե մինչ այդ avatar չկար
            $avatarElem = $docUsers->createElement("avatar");   //ստեղծի avatar
            $avatarElem -> appendChild($docUsers->createTextNode($img_name));   //մեջը գրի նկարի անունը
            $user->appendChild($avatarElem);                  //ավելացրու user-ի մեջ
        } else {
            $avatarElements->item(0)->nodeValue = $img_name;    //հակառակ դեպքում վերցրու Օ-րդ անդամի անունը դիր նկարի անունը
        }
        if($_SESSION['avatar'] != null && !empty($_SESSION['avatar'])){
            $avatar = $_SESSION['avatar'];
            unlink('Images/avatars/'.$avatar);
        }
        $docUsers->save($xmlFileForUsers);                                //պահպանենք փոփոխությունը
    }
}
header('location:profile.php'); die;

