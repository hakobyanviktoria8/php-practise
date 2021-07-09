<?php
session_start();
include("functions.php");
$user_id = $_SESSION['user_id'];
$img_dir = "Images/avatars/";
$img_name = uniqid().basename($_FILES['image']['name']);                       //Սկզբից գեներացված թիվն է գրում
$img_file = $img_dir.$img_name;
$imageFileType = strtolower(pathinfo($img_file,PATHINFO_EXTENSION));   //EXTENSION վերցնում է նկ ֆորմատը
$_SESSION['error'] = "";
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
        $readUsersJson = file_get_contents("db/users.json"); //json ֆայլը կարդալու համար
        $usersArray = json_decode($readUsersJson, true);            //ձևափոխի json տեքստը ասոցատիվ array.
        $user = &get_user_by_attr("id", $user_id, $usersArray);        //կանչում է Ֆ
        $user["avatar"] = $img_name;
        $jsonText = json_encode($usersArray);                             //Usersը փոխարինում է json տեքստի.
        file_put_contents("db/users.json", $jsonText); //պահպանում է usersը users.jsoni մեջ
        if($_SESSION['avatar'] != null && !empty($_SESSION['avatar'])){
            $avatar = $_SESSION['avatar'];
            unlink($img_dir.$avatar);
        }
    } else {
        $_SESSION['error']['image'] = 'Could not upload the filed';
    }
}
header('location:profile.php'); die;