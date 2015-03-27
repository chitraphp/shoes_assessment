<?php
    class Store
    {
        private $store_id;
        private $store_name;

        function __construct($store_name, $store_id = null)
        {
            $this->store_id = $store_id;
            $this->store_name = $store_name;
        }
        function getStoreName()
        {
            return $this->store_name;
        }
        function setStoreName($new_name)
        {
            $this->store_name = (string) $new_name;
        }
        function getStoreId()
        {
            return $this->store_id;
        }

        function setStoreId($new_id)
        {
            $this->store_id = (int) $new_id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO stores (store_name) VALUES ('{$this->getStoreName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setStoreId($result['id']);
        }

        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();
            foreach($returned_stores as $store) {
                $store_name = $store['store_name'];
                $store_id = $store['id'];
                $new_store = new Store($store_name, $store_id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores *;");
        }

        static function find($search_id)
        {
            $found_store = null;
            $stores = Store::getAll();
            foreach($stores as $store) {
                $store_id = $store->getStoreId();
                if ($store_id == $search_id) {
                  $found_store = $store;
                }
            }
            return $found_store;
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET store_name = '{$new_name}' WHERE id = {$this->getStoreId()};");
            $this->setStoreName($new_name);
        }

        function addBrand($brand)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$brand->getBrandId()}, {$this->getStoreId()} );");
        }

        function getBrands()
        {
            $query = $GLOBALS['DB']->query("SELECT brands.* FROM stores JOIN brands_stores ON (stores.id = brands_stores.store_id) JOIN  brands ON (brands_stores.brand_id = brands.id) WHERE stores.id = {$this->getStoreId()} ");
            $store_brands = $query->fetchAll(PDO::FETCH_ASSOC);
            $brands = array();
            foreach($store_brands as $store_brand) {
                $brand_id = $store_brand['id'];
                $brand_name = $store_brand['brand_name'];
                $new_brand = new Brand($brand_name, $brand_id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getStoreId()};");
            $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE store_id = {$this->getStoreId()};");
        }

    }

    ?>
