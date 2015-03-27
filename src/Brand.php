<?php
    class Brand
    {
        private $brand_id;
        private $brand_name;

        function __construct($brand_name, $brand_id = null)
        {
            $this->brand_id = $brand_id;
            $this->brand_name = $brand_name;
        }
        function getBrandName()
        {
            return $this->brand_name;
        }
        function setBrandName($new_name)
        {
            $this->brand_name = (string) $new_name;
        }
        function getBrandId()
        {
            return $this->brand_id;
        }

        function setBrandId($new_id)
        {
            $this->brand_id = (int) $new_id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO brands (brand_name) VALUES ('{$this->getBrandName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setBrandId($result['id']);
        }

        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();
            foreach($returned_brands as $brand) {
                $brand_name = $brand['brand_name'];
                $brand_id = $brand['id'];
                $new_brand = new Task($brand_name, $brand_id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }









    }
?>
