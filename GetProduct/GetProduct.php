<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Get Product</title>
</head>
<body>
<h1>Get Product</h1>
<?php

use Data\model\ProductTag;

include('../Data/model/ProductTag.php');

$productTags = (new ProductTag())->getProductCategories();
?>
<form action="../GetProduct/GetProductService.php" method="get">
    <label for="product_name">Product Name:</label>
    <input type="text" name="name" value="" id="product_name"><br /><br />

    <label for="product_tag">Tags:</label><br />
    <?php for($i = 0; $i < sizeof($productTags); $i++) { ?>
        <input type="checkbox" name="tag[]" id="product_tag" value ="<?php echo $productTags[$i];?>"><?php echo $productTags[$i];?>  <br />
    <?php }?><br /><br />

    <label for="update_product">Update Product</label>
    <input type="checkbox" name="update_product" id="update_product" value="Check to update product">
    <br /><br />
    <input type = "submit">
</form> 
</body>
</html>