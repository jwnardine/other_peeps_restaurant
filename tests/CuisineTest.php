<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";


    $server = 'mysql:host=localhost;dbname=chomp_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);



    class  CuisineTest extends PHPUnit_Framework_TestCase
    {
        // protected function tearDown()
        // {
        //     Cuisine::deleteAll();
        //     Restaurant::deleteAll();
        // }

        function test_getName()
        {
            $name = "Mexican";
            $test_cuisine = new Cuisine($name);

            //Act
        }

    }
 ?>
