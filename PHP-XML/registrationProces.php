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
    $doc = new DOMDocument('1.0');      //ստեղծումա doc obekt versian 1.0, XML-ի հետագա աշխատանքի համար
    $xmlFile = "db/users-from-php.xml";       //XML-ի ճանապարհը
    $doc->load($xmlFile);                     //կանչումա load մեթոդը
    if (!check_email_uniqueness($email, $doc)) {          //կանչում է Ֆունկցիա ստուգելով $email-ը $doc-ի մեջ կա թե ոչ
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
        //users-from-php.xml ֆայլում կավելացնի user իր ատրիբուտներով id="" email=""
        $user = $doc->createElement("user");              //ստեղծում է user element
        $user->setAttribute("id", uniqid());            //լրացնել id attribute ունիկալ արժեքով
        $user->setAttribute("email", $email);            //լրացնել email attribute
        //user-ի մեջ ավելացնենք fname
        $fnameElem = $doc->createElement("fname");        //$doc-ի մեջ ստեղծում ենք fname էլեմենտ
        $fnameElem->appendChild($doc->createTextNode($fname)); //$fnameElem ավելացնում ենք երեխա՝ ստեղծելով տեքստային էլեմենտ $fname դաշտով
        $user->appendChild($fnameElem);                       //$user-ի մեջ ավելացնում ենք $fnameElem
        //user-ի մեջ ավելացնենք lname
        $lnameElem = $doc->createElement("lname");
        $lnameElem->appendChild($doc->createTextNode($lname));
        $user->appendChild($lnameElem);
        //user-ի մեջ ավելացնենք address
        $addressElem = $doc->createElement("address");
        $addressElem->appendChild($doc->createTextNode($address));
        $user->appendChild($addressElem);
        //user-ի մեջ ավելացնենք tel
        $telElem = $doc->createElement("tel");
        $telElem->appendChild($doc->createTextNode($tel));
        $user->appendChild($telElem);
        //user-ի մեջ ավելացնենք gender
        $genderElem = $doc->createElement("gender");
        $genderElem->appendChild($doc->createTextNode($gender));
        $user->appendChild($genderElem);
        //user-ի մեջ ավելացնենք bday
        $bdayElem = $doc->createElement("bday");
        $bdayElem->appendChild($doc->createTextNode($bday));
        $user->appendChild($bdayElem);
        //user-ի մեջ ավելացնենք pass
        $passElem = $doc->createElement("pass");
        $passElem->appendChild($doc->createTextNode(crypt($pass)));
        $user->appendChild($passElem);
        //վերցնում է բոլոր էլեմենտները users անունով, կվերադարձնի մեկ էլեմենտանոց ցուցակ՝ մասիվ
        $users = $doc->getElementsByTagName("users");
        $root = $users->item(0); //$root-ը ընդհանուր users-ն է
        $root->appendChild($user);    //որի մեջ ավելացնում ենք user-ներ
        $doc->save($xmlFile);           //և պահում xmlFile-ում
        header('location:login.php');die;
    }
}
?>