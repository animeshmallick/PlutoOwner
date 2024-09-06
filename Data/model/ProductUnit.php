<?php

namespace Data\model;
class ProductUnit
{
    private $productUnit;

    public function __construct()
    {
        $this->setProductUnit();
    }

    private function setProductUnit()
    {
        $this->productUnit = array("10gms", "20gms", "50gms", "100gms", "200gms", "250gms", "500gms", "1KG", "2KG", "5KG", "10KG",
            "1Piece", "Pack of 2", "Pack of 4", "Pack of 8",
            "50ML", "100ML", "250ML", "500ML", "1Litre", "2Litres", "5Litres", "10Litres");
    }

    public function getProductUnit()
    {
        return $this->productUnit;
    }
}