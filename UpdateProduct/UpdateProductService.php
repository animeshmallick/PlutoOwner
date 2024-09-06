<?php

namespace UpdateProduct;

use Data\DBConnection;
use Data\model\Product;
use stdClass;

require("../Data/DBConnection.php");
require("../Data/model/Product.php");

class UpdateProductService
{
    public function getProductWithProductID($productID): ?Product
    {
        $connection = (new DBConnection())->get_db_connection();
        $sql_query_to_get_product = "SELECT * FROM products where product_id=" . $productID;

        $result = $connection->query($sql_query_to_get_product);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $productID = $row["product_id"];
            $productName = $row["product_name"];
            $productTagsString = $row["product_tags"];
            $productDescription = $row["product_description"];
            $productUnit = $row["product_unit"];
            $productUnitMRP = $row["product_unit_mrp"];
            $productUnitDiscount = $row["product_unit_discount"];
            $productKeywordsString = $row["product_keywords"];
            $productUnitCost = $row["product_unit_cost"];
            $productImageKey = $row["product_image_key"];
            $productIsRestricted = $row["product_is_restricted"];
            $productInventory = $row["product_inventory"];
            $productIsBuyable = $row["product_is_buyable"];

            return new Product($productID, explode('&&', $productTagsString), $productName,
                $productDescription, explode('&&', $productKeywordsString),
                $productUnit, $productUnitCost, $productUnitMRP, $productUnitDiscount,
                $productImageKey, $productIsBuyable, $productInventory, $productIsRestricted);
        }
        return null;
    }

    public function updateProductInDB(Product $newProduct): stdClass
    {
        $connection = (new DBConnection())->get_db_connection();
        $sql_query = $this->get_sql_query_to_update_product($newProduct);
        if ($connection->query($sql_query) === true) {
            $myObj = new stdClass();
            $myObj->message = "Product updated successfully";
            $myObj->newProduct = $newProduct;
            return $myObj;
        }else{
            $myObj = new stdClass();
            $myObj->message = "Product not updated";
            $myObj->error = $connection->error;
            return $myObj;
        }
    }
    public function get_sql_query_to_update_product(Product $product): string
    {
        date_default_timezone_set('Asia/Kolkata');

        return sprintf("UPDATE `products` SET `product_tags` = '%s', `product_name` = '%s', `product_description` = '%s',
                      `product_unit` = '%s', `product_unit_mrp` = '%s', `product_unit_discount` = '%s', `product_keywords` = '%s', 
                      `product_unit_cost` = '%s', `product_image_key` ='%s', `product_is_restricted` = '%s', `product_inventory` = '%s',
                    `product_is_buyable` = '%s' where `product_id` = '%s'",
            $product->getProductTagsAsString(),
            $product->getProductName(),
            $product->getProductDescription(),
            $product->getProductUnit(),
            $product->getProductUnitMrp(),
            $product->getProductUnitDiscount(),
            $product->getProductKeywordsAsString(),
            $product->getProductUnitCost(),
            $product->getProductImageKey(),
            $product->getProductIsRestricted(),
            $product->getProductInventory(),
            $product->getProductIsBuyable(),
            $product->getProductID());
    }
}