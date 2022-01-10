<?php
include 'helper.php';

$product_name = $_POST['product_name'];
$sku = $_POST['sku'];
$qty = $_POST['qty'];
$price = $_POST['price'];

if (
    isset($product_name) &&
    isset($sku) &&
    isset($qty) &&
    isset($price)
)
{
    $next_id = getNextProductId();
    $data = [];
    $data[] = [$next_id, $product_name, $sku, $qty, $price];
    writeToCsv($data, 'products.csv');
} else {
    echo 'All fields are required';
}