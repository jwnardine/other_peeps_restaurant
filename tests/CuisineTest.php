<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    // require_once "src/Restaurant.php";


    $server = 'mysql:host=localhost;dbname=chomp_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);



    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Cuisine::deleteAll();
            Restaurant::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Mexican";
            $test_cuisine = new Cuisine($name);

            //Act
            $result = $test_cuisine->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Mexican";
            $id = 1;
            $test_cuisine = new Cuisine($name, $id);

            //Act
            $result = $test_cuisine->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        //function update()?

        //function delete()?

        function test_save()
        {
            //Arrange
            $name = "Japanese";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();
            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals($test_cuisine, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Japanese";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            $name2 = "Mexican";
            $test_cuisine2 = new Cuisine($name2);
            $test_cuisine2->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([$test_cuisine, $test_cuisine2], $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "German";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            $new_name = "HOMESTAR";

            //Act
            $test_cuisine->update($new_name);

            //Assert
            $this->assertEquals("HOMESTAR", $test_cuisine->getName());

        }

        function test_getRestaurants()
        {
            //Arrange
            $name = "Lebanese";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $cuisine_id = $test_cuisine->getId();

            $rest_name = "Nicholas";
            $location = "NE Grand";
            $price_range = "$";
            $test_restaurant = new Restaurant($rest_name, $id, $location, $price_range, $cuisine_id);
            $test_restaurant->save();

            $rest_name2 = "Ye olde cart";
            $location2 = "Downtown";
            $price_range2 = "$";
            $test_restaurant2 = new Restaurant($rest_name2, $id, $location2, $price_range2, $cuisine_id);
            $test_restaurant2->save();

            //Act
            $result = $test_cuisine->getRestaurants();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        function test_delete()
        {
         //Arrange
         $name = "Work stuff";
         $id = null;
         $test_cuisine = new Cuisine($name, $id);
         $test_cuisine->save();

         $name2 = "Home stuff";
         $test_cuisine2 = new Cuisine($name2, $id);
         $test_cuisine2->save();


         //Act
         $test_cuisine->delete();

         //Assert
         $this->assertEquals([$test_cuisine2], Cuisine::getAll());
        }

        function testDeleteCuisine()
    {
        //Arrange
        $name = "Cuban";
        $id = null;
        $test_cuisine = new Cuisine($name, $id);
        $test_cuisine->save();

        $rest_name = "Yada yada rest";
        $location = "nowhere";
        $price_range = "$$$$";
        $cuisine_id = $test_cuisine->getId();
        $test_restaurant = new Restaurant($rest_name, $id, $location, $price_range, $cuisine_id);
        $test_restaurant->save();


        //Act
        $test_cuisine->delete();

        //Assert
        $this->assertEquals([], Restaurant::getAll());
    }

        function test_deleteAll()
        {
            //Arrange
            $name = "Italian";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            //Act
            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Italian";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            $name2 = "Mexican";
            $test_cuisine2 = new Cuisine($name2);
            $test_cuisine2->save();

            //Act
            $result = Cuisine::find($test_cuisine2->getId());

            //Assert
            $this->assertEquals($test_cuisine2, $result);

        }

        // function test_getRestaurants()
        // {
        //
        // }

    }
 ?>
