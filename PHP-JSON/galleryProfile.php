<?php
include('functions.php');
session_start();
$user_id = $_SESSION['user_id'];
$gallery_id = $_GET["gallery_id"];
$readGalleriesJson = file_get_contents("db/gallery.json"); //json ֆայլը կարդալու համար
$galleriesArray = json_decode($readGalleriesJson, true);            //ձևափոխի json տեքստը ասոցատիվ array.
$galleries = $galleriesArray["galleries"];
foreach ($galleries as $gallery) {
    if($gallery_id == $gallery["id"]){
        $img_name = $gallery['img'];
        copy('Images/gallery/'.$img_name,'Images/avatars/'.$img_name);
        $readUsersJson = file_get_contents("db/users.json"); //ստանում է json ֆայլը որպես տող
        $usersArray = json_decode($readUsersJson, true); //ձևափոխի json տեքստը ասոցատիվ array.
        $user = &get_user_by_attr("id", $user_id, $usersArray);
        $user['avatar'] = $img_name;
        if($_SESSION['avatar'] != null && !empty($_SESSION['avatar'])){
            $avatar = $_SESSION['avatar'];
            unlink('Images/avatars/'.$avatar);
        }
        $jsonText = json_encode($usersArray); //Usersը փոխարինում է json տեքստի.
        file_put_contents("db/users.json", $jsonText); //պահպանում է usersը users.jsoni մեջ                                //պահպանենք փոփոխությունը
    }
}
header('location:profile.php'); die;

