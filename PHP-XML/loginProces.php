<?php
include('functions.php');
session_start();
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $_SESSION['email'] = $email;
    $pass = trim($_POST['pass']);
    $_SESSION['pass'] = $pass;
    $_SESSION['error'] = [];
    if (!isset($email) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error']['email'] = 'Enter valid email';
    }
    if (!isset($pass) || empty($pass) || strlen($pass) < 4) {
        $_SESSION['error']['pass'] = 'Enter valid password';
    }
    if (!empty($_SESSION['error'])) {
        header('location:login.php');
        die;
    } else {
        $user = get_user_by_attr("email", $email);       //կանչում է Ֆունկցիան տալով email-ը
        if ($user == null) {
            $_SESSION['error']['email'] = 'User Not found by email';
            header('location:login.php');die;
        }
        $userPass = $user->getElementsByTagName("pass")->item(0)->nodeValue; //getElementsByTagName վերադարձնում է pass-ի մասիվ, մեկ էլեմենտանոց է, վերցնում ենք Օ-ի արժեքը nodeValue-ով
        if (password_verify($pass, $userPass)) {                                //համեմատում է crypt եղած $pass նոր $userPass հետ
            $_SESSION['user_id'] = $user->getAttribute("id");                  //Սեսյայի մեջ պահում է օգտագործողի id-ն.
            header('location:profile.php');
            die;
        } else {
            $_SESSION['error']['pass'] = 'Password is not correct';
            header('location:login.php');
            die;
        }
    }
}
?>