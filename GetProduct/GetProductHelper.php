<?php
/** @noinspection DuplicatedCode */
namespace GetProduct;

use Data\DBConnection;
use Data\model\Product;
use stdClass;

require("../Data/DBConnection.php");
require("../Data/model/Product.php");

class GetProductHelper
{
    //ToDo: $updateLink hardcoded temporarily at line 110.needs to be figured out
    private $updateProductURL = "http://%s/PlutoOwner/UpdateProduct/UpdateProduct.php?product_id=%s";

    public function getProductSearchKeywords(array $searchTags): array
    {
        $unique_tags = array();
        foreach ($searchTags as $tag) {
            if (!in_array($tag, $unique_tags) && strlen($tag) > 0) {
                $unique_tags[] = $tag;
            }
        }
        return $unique_tags;
    }

    public function getAllProductsWith($searchTags, bool $updateFlag): array
    {
        $products = $this->getAllProductsFromDB();
        $productSearchList = array();

        foreach ($products as $product) {
            $myObj = new stdClass();
            $myObj->id = $product->getProductId();
            $myObj->searchKey = $searchTags;
            $myObj->matchPercentage = $this->getMatchPercentage($this->getProductSearchableTags($product), $searchTags);
            $myObj->product = $product;
            if ($updateFlag) {
                $myObj->link = $this->getProductUpdateLink($product->getProductId());
            }
            $productSearchList[] = $myObj;
        }
        return $productSearchList;
    }

    private function getAllProductsFromDB(): array
    {
        $connection = (new DBConnection())->get_db_connection();
        $sql_query_to_get_all_products = "SELECT * FROM products";

        $result = $connection->query($sql_query_to_get_all_products);

        $products = array();

        while ($row = $result->fetch_assoc()) {
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

            $product = new Product($productID, explode('&&', $productTagsString), $productName,
                $productDescription, explode('&&', $productKeywordsString),
                $productUnit, $productUnitCost, $productUnitMRP, $productUnitDiscount,
                $productImageKey, $productIsBuyable, $productInventory, $productIsRestricted);

            $products[] = $product;
        }
        return $products;
    }

    private function getProductSearchableTags(Product $product): array
    {
        $productTags = array();
        foreach ($product->getProductTags() as $tag) {
            foreach (explode(' ', $tag) as $productTagEntity) {
                if (!in_array($productTagEntity, $productTags)) {
                    $productTags[] = strtolower($productTagEntity);
                }
            }
        }
        foreach (explode(' ', $product->getProductDescription()) as $productTagEntity) {
            if (!in_array($productTagEntity, $productTags)) {
                $productTags[] = strtolower($productTagEntity);
            }
        }
        foreach ($product->getProductKeywords() as $tag) {
            foreach (explode(' ', $tag) as $productTagEntity) {
                if (!in_array($productTagEntity, $productTags)) {
                    $productTags[] = strtolower($productTagEntity);
                }
            }
        }
        return $productTags;
    }

    private function getMatchPercentage(array $productSearchTags, array $searchTags): float
    {
        $percent = 0.00;
        foreach ($searchTags as $etag) {
            foreach ($productSearchTags as $tag) {
                similar_text($tag, $etag, $temp_percent);
                $percent = $percent + $temp_percent;
            }
        }
        return $percent / count($productSearchTags);
    }

    private function getProductUpdateLink($productID): string
    {
        return sprintf($this->updateProductURL, $_SERVER['HTTP_HOST'], $productID);
    }
}