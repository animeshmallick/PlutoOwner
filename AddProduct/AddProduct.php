<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Product</title>
</head>
<body>
<h1>Add new Product</h1>
<?php

use Data\model\ProductTag;
use Data\model\ProductUnit;

include('../Data/model/ProductTag.php');
include('../Data/model/ProductUnit.php');
$productTags = (new ProductTag())->getProductCategories();
$productUnits = (new ProductUnit())->getProductUnit();
?>
    <form action="AddProductService.php" method="get">
        <label for="product_name">Product Name:</label>
        <input type="text" name="name" value="" id="product_name"><br /><br />

        <label for="product_description">Product Description:</label>
        <textarea name="description" rows="2" cols="50" id="product_description"></textarea><br /><br />

        <label for="product_tags">Tags:</label><br />
            <?php for($i = 0; $i < sizeof($productTags); $i++) { ?>
                <input type="checkbox" name="tags[]" id="product_tags" value ="<?php echo $productTags[$i];?>"><?php echo $productTags[$i];?>  <br />
            <?php }?><br /><br />

        <label for="product_unit_count">Choose Quantity:</label>
        <select name="unit_count" id="product_unit_count">
            <?php for($i = 1; $i < 51; $i++) {?>
                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php }?>
        </select><br /><br />

        <label for="product_unit">Choose Quantity Units:</label>
        <select name="unit" id="product_unit">
            <?php for($i = 1; $i < sizeof($productUnits); $i++) {?>
                <option value="<?php echo $productUnits[$i]; ?>"><?php echo $productUnits[$i];?></option>
            <?php }?>
        </select><br /><br />

        <label for="product_unit_mrp">Unit MRP:</label>
        <input type="text" name="unit_mrp" value="0.00" id="product_unit_mrp"><br /><br />

        <label for="product_unit_cost">Unit Cost:</label>
        <input type="text" name="unit_cost" value="0.00" id="product_unit_cost"><br /><br />

        <label for="product_keywords">Product Keywords:</label>
        <textarea name="keywords" rows="2" cols="50" id="product_keywords" placeholder="Add each keyword after ','"></textarea><br /><br />

        <label for="product_is_restricted">Is product restricted:</label>
        <select name="is_restricted" id="product_is_restricted">
            <option value="Yes">Yes</option>
            <option value="No" selected>No</option>
        </select><br /><br />
        <input type = "submit">
    </form>
</body>
</html>