<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Restaurant.php";
    require_once "src/Cuisine.php";

    $server = 'mysql:host=localhost;dbname=chomp_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Cuisine::deleteAll();
            Restaurant::deleteAll();
        }

        function test_getName()
        {
            $rest_name = "Bear Tooth";
            $id = 1;
            $location = "Spenard Road";
            $price_range = "$";
            $cuisine_id = 1;

            $test_restaurant = new Restaurant($rest_name, $id, $location, $price_range, $cuisine_id);

            //Act
            $result = $test_restaurant->getRestName();

            //Assert
            $this->assertEquals($rest_name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Ethiopian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $rest_name = "Bear Tooth";

            $location = "Spenard Road";
            $price_range = "$";
            $cuisine_id = $test_cuisine->getId();
            // var_dump($cuisine_id);

            $test_restaurant = new Restaurant($rest_name, $id, $location, $price_range, $cuisine_id);
            $test_restaurant->save();

            //Act
            $result = $test_restaurant->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getCuisineId()
        {
            //Arrange
            $name = "Mexican";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $rest_name = "La Bonita";
            $cuisine_id = $test_cuisine->getId();
            $location = "N Killingsworth";
            $price_range = "$";
            $test_restaurant = new Restaurant($rest_name, $id, $location, $price_range, $cuisine_id);

            //Act
            $result = $test_restaurant->getCuisineId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $rest_name = "Bear Tooth";
            $id = 1;
            $location = "Spenard Road";
            $price_range = "$";
            $cuisine_id = 1;

            $test_restaurant = new Restaurant($rest_name, $id, $location, $price_range, $cuisine_id);

            $test_restaurant->save();

            //Act
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals($test_restaurant, $result[0]);
        }


        function test_getAll()
        {
            //Arrange
            $rest_name = "Bear Tooth";
            $id = 1;
            $location = "Spenard Road";
            $price_range = "$";
            $cuisine_id = 1;

            $test_restaurant = new Restaurant($rest_name, $id, $location, $price_range, $cuisine_id);

            $test_restaurant->save();

            $rest_name2 = "Organic Oasis";
            $id = 2;
            $location2 = "2606 Spenard Road";
            $price_range2 = "$$";
            $cuisine_id = 1;

            $test_restaurant2 = new Restaurant($rest_name2, $id, $location2, $price_range2, $cuisine_id);

            $test_restaurant2->save();

            //Act
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        function test_find()
        {
            //Arrange
            $rest_name = "Bear Tooth";
            $id = 1;
            $location = "Spenard Road";
            $price_range = "$";
            $cuisine_id = 1;

            $test_restaurant = new Restaurant($rest_name, $id, $location, $price_range, $cuisine_id);

            $test_restaurant->save();

            $rest_name2 = "Organic Oasis";
            $id = 2;
            $location2 = "2606 Spenard Road";
            $price_range2 = "$$";
            $cuisine_id = 1;

            $test_restaurant2 = new Restaurant($rest_name2, $id, $location2, $price_range2, $cuisine_id);

            $test_restaurant2->save();

            //Act
            $result = Restaurant::find($test_restaurant2->getId());

            //Assert
            $this->assertEquals($test_restaurant2, $result);

        }

        function test_update()
		{
			//Arrange
			$name = "Mexican";
			$test_cuisine = new Cuisine($name);
			$test_cuisine->save();
			$rest_name = "Taco Bell";
			$location = "123 Test Street";
			$cuisine_id =  $test_cuisine->getId();
            $price_range = "Hella cheap";
            $id = 1;
			$test_restaurant = new Restaurant($rest_name, $id, $location, $cuisine_id, $price_range);
			$test_restaurant->save();
			$new_name = "Taco Hell";
			//Act
			$test_restaurant->update($new_name);
			//Assert
			$this->assertEquals('Taco Hell', $test_restaurant->getRestName());
		}




    }

?>
