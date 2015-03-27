<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Store.php";
    require_once "src/Brand.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');
    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function testGetBrandName()
        {
            //Arrange
            $name = "nike";
            $test_brand = new Brand($name);

            //Act
            $result = $test_brand->getBrandName();

            //Assert
            $this->assertEquals($name, $result);
        }
        function testSetBrandName()
        {
            //Arrange
            $name = "nike";
            $test_brand = new Brand($name);
            //Act
            $test_brand->setBrandName("puma");
            $result = $test_brand->getBrandName();
            //Assert
            $this->assertEquals("puma", $result);
        }

        function testGetBrandId()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_brand = new Brand($name,$id);
            //Act
            $result = $test_brand->getBrandId();
            //Assert
            $this->assertEquals(4, $result);
        }
        // //Create a Student with the id in the constructor and be able to change its value, and then get the new id out.
        function testSetBrandId()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_brand = new Brand($name,$id);
            //Act
            $test_brand->setBrandId(5);
            $result = $test_brand->getBrandId();
            //Assert
            $this->assertEquals(5, $result);
        }

        function testSave()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_brand = new Brand($name,$id);
            $test_brand->save();

            //Act
            $result = Brand::getAll();
            //Assert
            $this->assertEquals([$test_brand], $result);
        }

        function testGetAll()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_brand = new Brand($name,$id);
            $test_brand->save();

            $name2 = "puma";
            $id2 = 5;
            $test_brand2 = new Brand($name2,$id2);
            $test_brand2->save();

            //Act
            $result = Brand::getAll();
            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_brand = new Brand($name,$id);
            $test_brand->save();

            $name2 = "puma";
            $id2 = 5;
            $test_brand2 = new Brand($name2,$id2);
            $test_brand2->save();

            //Act
            Brand::deleteAll();

            //Assert
            $result = Brand::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_brand = new Brand($name,$id);
            $test_brand->save();

            $name2 = "puma";
            $id2 = 5;
            $test_brand2 = new Brand($name2,$id2);
            $test_brand2->save();

            //Act
            $result = Brand::find($test_brand2->getBrandId());
            //Assert
            $this->assertEquals($test_brand2, $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "nike";
            $id = 4;
            $test_brand = new Brand($name,$id);
            $test_brand->save();

            //Act
            $test_brand->update("puma");
            $result = $test_brand->getBrandName();
            //Assert
            $this->assertEquals("puma", $result);
        }

        function testAddStore()
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
            $test_brand->addStore($test_store);

            //Assert
            $result = $test_brand->getStores();
            $this->assertEquals([$test_store], $result);
        }

        function testGetStores()
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

            $name3 = "fredMeyer";
            $id3= 5;
            $test_store2 = new Store($name3,$id3);
            $test_store2->save();

            //Act
            $test_brand->addStore($test_store);
            $test_brand->addStore($test_store2);

            //Assert
            $result = $test_brand->getStores();
            $this->assertEquals([$test_store,$test_store2], $result);
        }


    }
?>
