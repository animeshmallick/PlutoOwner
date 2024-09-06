<?php

namespace Data\model;

class ProductTag
{
    private $productTags;

    public function __construct() {
        $this->setProductTags();
    }

    private function setProductTags()
    {
        $this->productTags = array("Fresh Vegetable", "Fresh Fruits", "Dairy", "Cereals and Breakfast", "Rice, Atta and Dals",
            "Oils and Ghee", "Masala and Dry Fruits", "Bakery", "Biscuits and Cakes", "Tea and Coffee", "Kitchen and Dining",
            "Chips and Namkeens", "Ice Cream and Frozen", "Chocolate and Sweets", "Cold Drinks and Juices", "Noodles",
            "Sauce and Spreads", "Bath and Body", "Hair Care", "Skincare and Beauty", "Oral Care", "Feminine and Hygiene",
            "Health Care", "Baby Care", "Cleaning Essentials", "Home and fashions", "Electronic and Electronics",
            "Toys and Stationary");
    }
    public function getProductCategories(){
        return $this->productTags;
    }
}