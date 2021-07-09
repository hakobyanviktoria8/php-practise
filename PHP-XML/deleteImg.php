<?php
session_start();
include("functions.php");
$user_id = $_SESSION['user_id'];
$img_dir = "Images/avatars/";
$img_name = $_SESSION["avatar"];
$img_file = $img_dir.$img_name;
$doc = new DOMDocument('1.0');           //ստեղծումա DOM obekt,որը պարունակում է xml-ը
$xmlFile = "db/users-from-php.xml";            //XML-ի ճանապարհը
$doc->load($xmlFile);                          //DOM-ի մեջ ավելացնում է $xmlFile
$user = get_user_by_attr("id", $user_id, $doc);        //կանչում է Ֆ
$avatar = $user->getElementsByTagName('avatar')->item(0);
$oldavatar = $user->removeChild($avatar);
if ($oldavatar == null) {
    $_SESSION["error"]["image"] = "Could not remove image";
} else {
    $doc->save($xmlFile);
    if($_SESSION['avatar'] != null && !empty($_SESSION['avatar'])){
        unlink($img_dir.$img_name);
        $_SESSION['avatar'] = null;
    }
}

header('location:profile.php'); die;