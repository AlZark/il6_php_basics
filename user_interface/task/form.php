<html>
<head>
    <title>New Product</title>
</head>
<body>
<div class="content">
    <h2>Add new product</h2>
    <form action="create.php" method="post">
        <input type="text" name="product_name" placeholder="Shoes"><br>
        <input type="text" name="sku" placeholder="xxxxxxx001"><br>
        <input type="number" name="qty" placeholder="10"><br>
        <input type="price" name="price" placeholder="26.00"> Eur.<br>
        <input type="submit" value="Add_product" name="submit">
    </form>
</div>

</body>
</html>