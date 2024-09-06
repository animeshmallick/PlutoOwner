<?php

use GetProduct\GetProductHelper;

require ("GetProductHelper.php");
$helper = new GetProductHelper();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $productKeywords = null;
    $productName = null;
    $updateProduct = false;
    $updateFlag = false;

    if (isset($_GET['tag'])){
        $productKeywords = $_GET['tag'];
    }
    if (isset($_GET['name'])){
        $productName = $_GET['name'];
    }
    if ($productKeywords == null && $productName == null)
        die();

    $searchTags = null;
    if ($productName != null) {
        $searchTags .= $productName."&&";
    }
    if ($productKeywords != null) {
        foreach ($productKeywords as $productKeyword) {
            $searchTags .= $productKeyword."&&";
        }
    }
    if (isset($_GET['update_product'])){
        $updateProduct = $_GET['update_product'];
        if ($updateProduct == 'true'){
            $updateFlag = true;        
        }
    }
    $searchKeywords = array_map(function ($str){ return strtolower($str); },
                                $helper->getProductSearchKeywords(explode("&&",str_replace(' ', '&&', $searchTags))));
    $productSearchResults = $helper->getAllProductsWith($searchKeywords,$updateFlag);

    header('Content-Type: application/json');
    echo json_encode($productSearchResults);
}