<?php
session_start();
include("functions.php");
$user_id = $_SESSION['user_id'];
$img_dir = "Images/avatars/";
$img_name = $_SESSION["avatar"];
$img_file = $img_dir.$img_name;
$readUsersJson = file_get_contents("db/users.json"); //ստանում է json ֆայլը որպես տող
$usersArray = json_decode($readUsersJson, true); //ձևափոխի json տեքստը ասոցատիվ array.
$user = &get_user_by_attr("id", $user_id, $usersArray);        //կանչում է Ֆ դիմացից & նշանը, որ թարմացրած տարբերակը պահի
unset($user['avatar']);
$jsonText = json_encode($usersArray); //հետ է վերադարձնում ասոցատիվ զանգվածը տողի
file_put_contents("db/users.json", $jsonText); //պահպանում է usersը users.json ֆայլի մեջ
if($_SESSION['avatar'] != null && !empty($_SESSION['avatar'])){
    unlink($img_dir.$img_name);
    $_SESSION['avatar'] = null;
}

header('location:profile.php'); die;