<?php

namespace UpdateProduct;

use Data\DBConnection;
use Data\model\Product;

require("../Data/DBConnection.php");
require("../Data/model/Product.php");

class UpdateProductService
{
    public function getProductWithProductID($productID)
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
}