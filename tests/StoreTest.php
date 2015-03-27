<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Store.php";
    require_once "src/Brand.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');
    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function testGetStoreName()
        {
            //Arrange
            $name = "Target";
            $test_store = new Store($name);

            //Act
            $result = $test_store->getStoreName();

            //Assert
            $this->assertEquals($name, $result);
        }
        function testSetStoreName()
        {
            //Arrange
            $name = "nike";
            $test_brand = new Store($name);
            //Act
            $test_brand->setStoreName("puma");
            $result = $test_brand->getStoreName();
            //Assert
            $this->assertEquals("puma", $result);
        }

        function testGetStoreId()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_store = new Store($name,$id);
            //Act
            $result = $test_store->getStoreId();
            //Assert
            $this->assertEquals(4, $result);
        }
        // //Create a Student with the id in the constructor and be able to change its value, and then get the new id out.
        function testSetStoreId()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_brand = new Store($name,$id);
            //Act
            $test_brand->setStoreId(5);
            $result = $test_brand->getStoreId();
            //Assert
            $this->assertEquals(5, $result);
        }

        function testSave()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_store = new Store($name,$id);
            $test_store->save();

            //Act
            $result = Store::getAll();
            //Assert
            $this->assertEquals([$test_store], $result);
        }

        function testGetAll()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_store = new Store($name,$id);
            $test_store->save();

            $name2 = "puma";
            $id2 = 5;
            $test_store2 = new Store($name2,$id2);
            $test_store2->save();

            //Act
            $result = Store::getAll();
            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_store = new Store($name,$id);
            $test_store->save();

            $name2 = "puma";
            $id2 = 5;
            $test_store2 = new Store($name2,$id2);
            $test_store2->save();

            //Act
            Store::deleteAll();

            //Assert
            $result = Store::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_store = new Store($name,$id);
            $test_store->save();

            $name2 = "puma";
            $id2 = 5;
            $test_store2 = new Store($name2,$id2);
            $test_store2->save();

            //Act
            $result = Store::find($test_store2->getStoreId());
            //Assert
            $this->assertEquals($test_store2, $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_store = new Store($name,$id);
            $test_store->save();

            //Act
            $test_store->update("puma");
            $result = $test_store->getStoreName();
            //Assert
            $this->assertEquals("puma", $result);
        }

        function testAddBrand()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_brand = new Brand($name,$id);
            $test_brand->save();

            $name2 = "Target";
            $id2 = 5;
            $test_store = new Store($name2,$id2);
            $test_store->save();

            //Act
            $test_store->addBrand($test_brand);

            //Assert
            $result = $test_store->getBrands();
            $this->assertEquals([$test_brand], $result);
        }

        function testGetBrands()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_brand = new Brand($name,$id);
            $test_brand->save();

            $name2 = "nike";
            $id2 = 4;
            $test_brand2 = new Brand($name2,$id2);
            $test_brand2->save();


            $name3 = "fredMeyer";
            $id3= 5;
            $test_store = new Store($name3,$id3);
            $test_store->save();

            //Act
            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);

            //Assert
            $result = $test_store->getBrands();
            $this->assertEquals([$test_brand,$test_brand2], $result);
        }

        function testDelete()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_brand = new Brand($name,$id);
            $test_brand->save();

            $name2 = "fredMeyer";
            $id2= 5;
            $test_store = new Store($name2,$id2);
            $test_store->save();


            $name3 = "Target";
            $id3= 5;
            $test_store2 = new Store($name3,$id3);
            $test_store2->save();

            //Act
            $test_store->delete();

            //Assert
            $result = Store::getAll();
            $this->assertEquals([$test_store2], $result);
        }


    }
?>
