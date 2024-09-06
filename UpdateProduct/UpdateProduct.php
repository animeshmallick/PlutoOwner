<?php

use Data\model\Product;
use Data\model\ProductTag;
use Data\model\ProductUnit;
use UpdateProduct\UpdateProductService;
include("UpdateProductService.php");
$helper = new UpdateProductService();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $myObj = new stdClass();
    $myObj->method = 'GET';


    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        $myObj->product_id = $product_id;
        $product = $helper->getProductWithProductID($product_id);
        if ($product != null) {
            $myObj->isValidProduct = true;
            $myObj->product = $product;

            include('../Data/model/ProductTag.php');
            include('../Data/model/ProductUnit.php');
            $productTags = (new ProductTag())->getProductCategories();
            $productUnits = (new ProductUnit())->getProductUnit();
            ?>

            <form method="post">
                <label for="product_id">Product ID:</label>
                <input type="text" name="product_id" value="<?php echo $product->getProductId(); ?>" id="product_id" readonly><br /><br />

                <label for="product_name">Product Name:</label>
                <input type="text" name="name" value="<?php echo $product->getProductName(); ?>" id="product_name"><br /><br />

                <label for="product_description">Product Description:</label>
                <textarea name="description" rows="2" cols="50" id="product_description"><?php echo $product->getProductDescription(); ?></textarea><br /><br />

                <label for="product_tags">Tags:</label><br />
                <?php for($i = 0; $i < sizeof($productTags); $i++) {
                    if (in_array($productTags[$i], explode("&&", $product->getProductTagsAsString()))){ ?>
                        <input type="checkbox" name="tags[]" id="product_tags" value ="<?php echo $productTags[$i];?>" checked><?php echo $productTags[$i];?>  <br />
                    <?php }else { ?>
                        <input type="checkbox" name="tags[]" id="product_tags" value ="<?php echo $productTags[$i];?>"><?php echo $productTags[$i];?>  <br />
                    <?php }
                    ?>

                <?php }?><br /><br />

                <label for="product_unit_count">Choose Quantity:</label>
                <select name="unit_count" id="product_unit_count">
                    <?php for($i = 1; $i < 51; $i++) {
                        if($product->getProductInventory() == $i) {?>
                            <option value="<?php echo $i;?>" selected><?php echo $i;?></option>
                    <?php }else{ ?>
                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php }
                    }?>
                </select><br /><br />

                <label for="product_unit">Choose Quantity Units:</label>
                <select name="unit" id="product_unit">
                    <?php for($i = 1; $i < sizeof($productUnits); $i++) {
                        if($productUnits[$i] == $product->getProductUnit()){ ?>
                            <option value="<?php echo $productUnits[$i]; ?>" selected><?php echo $productUnits[$i];?></option>
                    <?php }else{ ?>
                           <option value="<?php echo $productUnits[$i]; ?>"><?php echo $productUnits[$i];?></option>
                        <?php }
                    }?>
                </select><br /><br />

                <label for="product_unit_mrp">Unit MRP:</label>
                <input type="text" name="unit_mrp" value="<?php echo $product->getProductUnitMRP(); ?>" id="product_unit_mrp"><br /><br />

                <label for="product_unit_cost">Unit Cost:</label>
                <input type="text" name="unit_cost" value="<?php echo $product->getProductUnitCost(); ?>" id="product_unit_cost"><br /><br />

                <label for="product_keywords">Product Keywords:</label>
                <textarea name="keywords" rows="2" cols="50" id="product_keywords" placeholder="Add each keyword after ','"><?php echo implode(",", explode("&&", $product->getProductKeywordsAsString())); ?></textarea><br /><br />

                <label for="product_is_restricted">Is product restricted:</label>
                <select name="is_restricted" id="product_is_restricted">
                    <option value="Yes" <?php if($product->getProductIsRestricted() == '1'){echo "selected";}?>>Yes</option>
                    <option value="No" <?php if($product->getProductIsRestricted() == '0'){echo "selected";}?>>No</option>
                </select><br /><br />
                <input type = "submit">
            </form>
            <?php
        } else {
            $myObj->isValidProduct = false;
        }
    }else{
        $myObj->errorMessage = "'product_id' is required";
    }
    if ($myObj->product == null) {
        header('Content-Type: application/json');
        echo json_encode($myObj);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['tags']) && isset($_POST['keywords']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['unit']) &&
        isset($_POST['unit_mrp']) && isset($_POST['unit_cost']) && isset($_POST['unit_count']) &&
        isset($_POST['is_restricted']) && isset($_POST['product_id'])) {

        $productID = $_POST['product_id'];
        $productTags = $_POST['tags'];
        $productKeywords = explode(",", $_POST['keywords']);
        $productName = $_POST['name'];
        $productDescription = $_POST['description'];
        $productUnit = $_POST['unit'];
        $productUnitMRP = $_POST['unit_mrp'];
        $productUnitCost = $_POST['unit_cost'];
        $productIsRestricted = $_POST['is_restricted'];
        $productInventory = $_POST['unit_count'];

        $newProduct = new Product($productID, $productTags, $productName, $productDescription,
                                    $productKeywords, $productUnit, $productUnitCost,
                                    $productUnitMRP, 0.0, "Not Set",
                      true, $productInventory, $productIsRestricted);
        $resp = $helper->updateProductInDB($newProduct);
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}
exit;
?>