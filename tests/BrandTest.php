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
            $this->assertEquals($name, $result);
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
        function testSetStudentId()
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

    }
?>
