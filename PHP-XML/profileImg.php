<?php
session_start();
include("functions.php");
$user_id = $_SESSION['user_id'];
$img_dir = "Images/avatars/";
$img_name = uniqid().basename($_FILES['image']['name']);                       //Սկզբից գեներացված թիվն է գրում
$img_file = $img_dir.$img_name;
$imageFileType = strtolower(pathinfo($img_file,PATHINFO_EXTENSION));   //EXTENSION վերցնում է նկ ֆորմատը
//Validation image
if($imageFileType!="jpeg" && $imageFileType!="jpg" && $imageFileType!="png" && $imageFileType!="gif"){
    $_SESSION['error']['image'] = "File type must be jpeg, jpg, png, gif";
} else {
    if(!$_FILES['image']['size'] >= 500000000) {
        $_SESSION['error']['image'] = 'File size must not exceed 5mb';
    }
}
//create profile image
if(empty($_SESSION['error'])){
    if(move_uploaded_file($_FILES['image']['tmp_name'],$img_file )) { //Save avatar image in avatars file
        //save image name in xml
        $doc = new DOMDocument('1.0');           //ստեղծումա DOM obekt,որը պարունակում է xml-ը
        $xmlFile = "db/users-from-php.xml";            //XML-ի ճանապարհը
        $doc->load($xmlFile);                          //DOM-ի մեջ ավելացնում է $xmlFile
        $user = get_user_by_attr("id", $user_id, $doc);        //կանչում է Ֆ
        $avatarElements = $user->getElementsByTagName("avatar");       //user-ի մեջ ավելացնում է avatar
        if ($avatarElements->length == 0) {                //եթե մինչ այդ avatar չկար
            $avatarElem = $doc->createElement("avatar");   //ստեղծի avatar
            $avatarElem -> appendChild($doc->createTextNode($img_name));   //մեջը գրի նկարի անունը
            $user->appendChild($avatarElem);                  //ավելացրու user-ի մեջ
        } else {
            $avatarElements->item(0)->nodeValue = $img_name;    //հակառակ դեպքում վերցրու Օ-րդ անդամի անունը դիր նկարի անունը
        }
        $doc->save($xmlFile);                                //պահպանենք փոփոխությունը
        if($_SESSION['avatar'] != null && !empty($_SESSION['avatar'])){
            $avatar = $_SESSION['avatar'];
            unlink($img_dir.$avatar);
        }
    } else {
        $_SESSION['error']['image'] = 'Could not upload the filed';
    }
}
header('location:profile.php'); die;