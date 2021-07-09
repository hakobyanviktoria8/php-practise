<?php
//օգտագործվում է registrationProces.php-ում
function check_email_uniqueness($email, $usersArray) {
    foreach ($usersArray["users"] as $user) {
        if ($email == $user["email"])   //եթե կա վերադարձնի false
            return false;
    }
    return true;
}
//օգտագործվում է loginProces.php
function &get_user_by_attr($attrName, $attrValue, &$usersArray=null) {
    if ($usersArray == null) {
        $readUsersJson = file_get_contents("db/users.json"); //json ֆայլը կարդալու համար
        $usersArray = json_decode($readUsersJson, true); //ձևափոխի json տեքստը php array
    }
    $users = &$usersArray["users"];
    foreach ($users as &$user) {
        if ($attrValue == $user[$attrName]) {   //("test@test.com" == $user->getAttribute("email")) or ("21312sdasd" == $user->getAttribute("id"))
            return $user;
        }
    }
    return null;
}
