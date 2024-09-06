<?php

namespace Data\model;
use JsonSerializable;

class Product implements JsonSerializable
{
    private $productId;
    private $productTags;
    private $productName;
    private $productDescription;
    private $productKeywords;
    private $productUnit;
    private $productUnitMRP;
    private $productUnitCost;
    private $productIsRestricted;
    private $productInventory;
    private $productUnitDiscount;
    private $productIsBuyable;
    private $productImageKey;

    public function __construct($productId, array $productTags, $productName, $productDescription, array $productKeywords,
                                $productUnit, $productUnitCost, $productUnitMRP, $productUnitDiscount,
                                $productImageKey, $productIsBuyable, $productInventory, $productIsRestricted)
    {
        $this->getProduct($productId, $productTags, $productName, $productDescription, $productKeywords,
            $productUnit, $productUnitCost, $productUnitMRP,
            $productInventory, $productIsRestricted, $productIsBuyable, $productImageKey, $productUnitDiscount);
    }

    public function getProduct($productId, array $productTags, $productName, $productDescription, array $productKeywords,
                               $productUnit, $productUnitCost, $productUnitMRP,
                               $productInventory, $productIsRestricted, $productIsBuyable,
                               $productImageKey, $productUnitDiscount)
    {
        $this->productId = $productId;
        $this->productTags = $productTags;
        $this->productName = $productName;
        $this->productDescription = $productDescription;
        $this->productKeywords = $productKeywords;
        $this->productUnit = $productUnit;
        $this->productUnitMRP = $productUnitMRP;
        $this->productUnitCost = $productUnitCost;
        $this->productIsRestricted = $productIsRestricted;
        $this->productInventory = $productInventory;
        $this->productIsBuyable = $productIsBuyable;
        $this->productImageKey = $productImageKey;
        $this->productUnitDiscount = $productUnitDiscount;

    }

    public function getProductTagsAsString(): string
    {
        return implode("&&", $this->productTags);
    }

    public function getProductTags()
    {
        return $this->productTags;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function getProductDescription()
    {
        return $this->productDescription;
    }

    public function getProductKeywords()
    {
        return $this->productKeywords;
    }

    public function getProductKeywordsAsString(): string
    {
        return implode("&&", $this->productKeywords);
    }

    public function getProductUnit()
    {
        return $this->productUnit;
    }

    public function getProductUnitMRP()
    {
        return $this->productUnitMRP;
    }

    public function getProductUnitCost()
    {
        return $this->productUnitCost;
    }

    public function getProductIsRestricted()
    {
        return $this->productIsRestricted;
    }

    public function getProductInventory()
    {
        return $this->productInventory;
    }

    public function getProductUnitDiscount()
    {
        return $this->productUnitDiscount;
    }

    public function getProductIsBuyable()
    {
        return $this->productIsBuyable;
    }

    public function getProductImageKey()
    {
        return $this->productImageKey;
    }

    public function getProductId()
    {
        return $this->productId;
    }


    public function jsonSerialize(): array
    {
        return ['productId' => $this->productId,
            'productTags' => $this->productTags,
            'productName' => $this->productName,
            'productDescription' => $this->productDescription,
            'productKeywords' => $this->productKeywords,
            'productUnit' => $this->productUnit,
            'productUnitMRP' => $this->productUnitMRP,
            'productUnitCost' => $this->productUnitCost,
            'productIsRestricted' => $this->productIsRestricted,
            'productInventory' => $this->productInventory,
            'productIsBuyable' => $this->productIsBuyable,
            'productImageKey' => $this->productImageKey,
            'productUnitDiscount' => $this->productUnitDiscount];
    }
}