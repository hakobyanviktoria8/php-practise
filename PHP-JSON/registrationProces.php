<?php
include('functions.php');
session_start();
if (isset($_POST['submit'])) {
    $fname = trim($_POST['fname']);
    $_SESSION['fname'] = $fname;
    $lname = trim($_POST['lname']);
    $_SESSION['lname'] = $lname;
    $address = trim($_POST['address']);
    $_SESSION['address'] = $address;
    $tel = trim($_POST['tel']);
    $_SESSION['tel'] = $tel;
    $email = trim($_POST['email']);
    $_SESSION['email'] = $email;
    $gender = trim($_POST['gender']);
    $_SESSION['gender'] = $gender;
    $bday = trim($_POST['bday']);
    $_SESSION['bday'] = $bday;
    $pass = trim($_POST['pass']);
    $_SESSION['pass'] = $pass;
    $repass = trim($_POST['repass']);
    $_SESSION['repass'] = $repass;
    $_SESSION['error'] = [];
    if(!isset($fname) || empty($fname) || strlen($fname) < 3 || !preg_match("/^[a-zA-Z ]*$/", $fname)){
        $_SESSION['error']['fname'] = 'Enter valid first name';
    }
    if(!isset($lname) || empty($lname) || strlen($lname) < 3 || !preg_match("/^[a-zA-Z ]*$/", $lname)){
        $_SESSION['error']['lname'] = 'Enter valid last name';
    }
    if (!isset($address) || empty($address)){
        $_SESSION['error']['address'] = 'Enter valid address';
    }
    if (!isset($tel) || empty($tel) || !preg_match("/0[0-9]{2}\-[0-9]{2}\-[0-9]{2}\-[0-9]{2}/", $tel)){
        $_SESSION['error']['tel'] = 'Enter valid Phone Number';
    }
    if (!isset($email) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error']['email'] = 'Enter valid email';
    }
    $readUsersJson = file_get_contents("db/users.json"); //json ֆայլը կարդալու համար
    $usersArray = json_decode($readUsersJson, true); //ձևափոխի json տեքստը php array.
    if (!check_email_uniqueness($email, $usersArray)) {          //կանչում է Ֆունկցիա ստուգելով $email-ը $doc-ի մեջ կա թե ոչ
        $_SESSION['error']['email'] = 'Email already used';
    }
    if(!isset($gender) || empty($gender)){
        $_SESSION['error']['gender'] = 'Enter gender';
    }
    if (!preg_match("/[0-9]{4}\-[0-9]{2}\-[0-9]{2}/", $bday)){
        $_SESSION['error']['bday'] = 'Enter birthday';
    }
    if (!isset($pass) || empty($pass) || strlen($pass) < 4 || $pass != $repass) {
        $_SESSION['error']['pass'] = 'Enter valid password';
    }
    if(!empty($_SESSION['error'])){           //եթե error կլինի հետ կուղարկի registration.php
        header('location:registration.php');die;
    } else{
        $user = [];
        $user["id"] = uniqid();
        $user["fname"] = $fname;
        $user["lname"] = $lname;
        $user["address"] = $address;
        $user["tel"] = $tel;
        $user["email"] = $email;
        $user["gender"] = $gender;
        $user["bday"] = $bday;
        $user["pass"] = crypt($pass);
        array_push($usersArray["users"], $user);
        $jsonText = json_encode($usersArray);                  //Usersը փոխարինում է json տեքստի.
        file_put_contents("db/users.json", $jsonText); //պահպանում է usersը users.jsoni մեջ
        header('location:login.php');die;
    }
}
?>