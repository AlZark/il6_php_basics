<?php
//
//$productPrice = 12;
//$discount = 20;
//
//function getDiscountedPrice($price, $discount){
//    $discountedPrice = $price * ((100 - $discount) / 100);
//    $finalPriceWithTax = getPriceWithVat($discountedPrice);
//    return $finalPriceWithTax;
//}
//
//function getPriceWithVat($price){
//    return $price * 1.21;
//}
//
//echo '<div class="price">' . getDiscountedPrice($productPrice, $discount) . '</div>';
//
//$userEmail = '       Algm@Ail.com';
//
//function clearEmail($email){
//    return trim(strtolower($email));
//}
//
//function isEmailValid($email){
//
//    //return strpos($email, '@') !== false;
//    if(strpos($email, '@')) {
//        return true;
//    } else {
//        return false;
//    }
//}
//
//if(isEmailValid($userEmail)){
//    echo clearEmail($userEmail);
//}else{
//    echo 'Invalid email';
//}
//


//$name = 'Algirdas';
//$surname = 'Zarkaitis';
//
//function getNickName($name, $surname){
//    return trim(strtolower(substr($name, 0, 3) . substr($surname, 0,3)) . rand(1, 100));
//}
//
//echo getNickName($name, $surname);

function getSlug($title){
    return str_replace(" ", "-", $title);
}