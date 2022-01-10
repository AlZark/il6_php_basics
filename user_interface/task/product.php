<?php include 'helper.php';

$product = getProductById($_GET['id']);
?>

<body>
<html>

<div class="grid">
        <div class="product-wrap">
            <div class="name">
                <?php echo $product['name'] ?>
            </div>
            <div class="price">
                <?php echo $product['price'] . 'Eur' ?>
            </div>
            <div class="qty">
                <?php echo $product['qty'] ?>
            </div>
            <div class="sku">
                <?php echo $product['sku'] ?>
            </div>
        </div>
</div>

</body>
</html>