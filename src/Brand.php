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
                $new_brand = new Brand($brand_name, $brand_id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands *;");
        }

        static function find($search_id)
        {
            $found_brand = null;
            $brands = Brand::getAll();
            foreach($brands as $brand) {
                $brand_id = $brand->getBrandId();
                if ($brand_id == $search_id) {
                  $found_brand = $brand;
                }
            }
            return $found_brand;
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE brands SET brand_name = '{$new_name}' WHERE id = {$this->getBrandId()};");
            $this->setBrandName($new_name);
        }

        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getBrandId()}, {$store->getStoreId()} );");
        }

        function getStores()
        {
            $query = $GLOBALS['DB']->query("SELECT stores.* FROM brands JOIN brands_stores ON (brands.id = brands_stores.brand_id) JOIN  stores ON (brands_stores.store_id = stores.id) WHERE brands.id = {$this->getBrandId()} ");
            $brand_stores = $query->fetchAll(PDO::FETCH_ASSOC);
            $stores = array();
            foreach($brand_stores as $brand_store) {
                $store_id = $brand_store['id'];
                $store_name = $brand_store['store_name'];
                $new_store = new Store($store_name, $store_id);
                array_push($stores, $new_store);
            }
            return $stores;
        }



























    }
?>
