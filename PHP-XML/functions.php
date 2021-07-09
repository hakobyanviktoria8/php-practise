<?php
//օգտագործվում է registrationProces.php-ում
function check_email_uniqueness($email, $doc) {
    $users = $doc->getElementsByTagName("user");    //$users-ի մեջ գտնի բոլոր user-ները և ցիկլով անցնի ստուգի $email
    foreach ($users as $user) {
        if ($email == $user->getAttribute("email"))   //եթե կա վերադարձնի false
            return false;
    }
    return true;
}
//օգտագործվում է loginProces.php
function get_user_by_attr($attrName, $attrValue, $doc=null) {
    if ($doc == null) {
        $doc = new DOMDocument('1.0');           //ստեղծումա DOM obekt,որը պարունակում է xml-ը
        $xmlFile = "db/users-from-php.xml";            //XML-ի ճանապարհը
        $doc->load($xmlFile);                          //DOM-ի մեջ ավելացնում է $xmlFile
    }
    //DOM-ի մեջ գտնենք user-ը տրամադրած email-ով
    $users = $doc->getElementsByTagName("user");
    foreach ($users as $user) {
        if ($attrValue == $user->getAttribute($attrName)) {   //("test@test.com" == $user->getAttribute("email")) or ("21312sdasd" == $user->getAttribute("id"))
            return $user;
        }
    }
    return null;
}
