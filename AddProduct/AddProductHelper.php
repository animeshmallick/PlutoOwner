<?php

namespace AddProduct;

use Data\DBConnection;
use Data\model\Product;

require("../Data/model/Product.php");
require("../Data/DBConnection.php");

class AddProductHelper
{
    public function get_product($productTags, $productName, $productDescription, $productKeywords, $productUnit,
                                $productUnitCost, $productUnitMRP, $productInventory,
                                $productIsRestricted)
    {
        $product = new Product(null, $productTags, $productName, $productDescription, $productKeywords, $productUnit, $productUnitCost,
            $productUnitMRP, 0.0, "Not Set", true, $productInventory, $productIsRestricted);

        if (!$this->is_valid()) {
            return "Cannot create product object the given product details.";
        }
        return $product;
    }

    public function is_valid(): bool
    {
        return true;
    }

    public function add_product_to_db($product): bool
    {
        $conn = (new DBConnection())->get_db_connection();
        $sql_query = $this->get_sql_query_to_add_product($product);
        #echo "Query : ".$sql_query."<br ><br >";

        if ($conn->query($sql_query) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function get_sql_query_to_add_product($product): string
    {
        date_default_timezone_set('Asia/Kolkata');

        return sprintf("INSERT INTO `products` (`product_tags`, `product_name`, `product_description`, `product_unit`, `product_unit_mrp`,
                    `product_unit_discount`, `product_keywords`, `product_unit_cost`, `product_image_key`, `product_is_restricted`,
                    `product_inventory`, `product_is_buyable`, `product_listed_at`) 
                    VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
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
            date("Y-m-d H:i:s"));
    }
}