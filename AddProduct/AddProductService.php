<?php /** @noinspection DuplicatedCode */

use AddProduct\AddProductHelper;

require("AddProductHelper.php");
$helper = new AddProductHelper();
$myObj = new stdClass();

$myObj->method = 'GET';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['tags']) && isset($_GET['keywords']) && isset($_GET['name']) && isset($_GET['description']) && isset($_GET['unit']) &&
                isset($_GET['unit_mrp']) && isset($_GET['unit_cost']) && isset($_GET['unit_count']) &&
                            isset($_GET['is_restricted'])) {
        $productTags = $_GET['tags'];
        $productKeywords = explode(",", $_GET['keywords']);
        $productName = $_GET['name'];
        $productDescription = $_GET['description'];
        $productUnit = $_GET['unit'];
        $productUnitMRP = $_GET['unit_mrp'];
        $productUnitCost = $_GET['unit_cost'];
        $productIsRestricted = $_GET['is_restricted'];
        $productInventory = $_GET['unit_count'];

        $myObj->allMandatoryFieldsAvaialble = true;


        $product = $helper->get_product($productTags, $productName, $productDescription, $productKeywords,
                                        $productUnit, $productUnitCost, $productUnitMRP,
                                        $productInventory, $productIsRestricted);

        $myObj->product = $product;


        if ($helper->add_product_to_db($product)) {
            $myObj->message = "Product added successfully";
        } else {
            $myObj->message = "Product not added";
        }

    } else {
        $myObj->allMandatoryFieldsAvaialble = true;
    }
}
header('Content-Type: application/json');
echo json_encode($myObj);
exit;

