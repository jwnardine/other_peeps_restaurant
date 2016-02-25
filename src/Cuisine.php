<?php


    class Cuisine
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cuisine (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function getRestaurants() {
            $restaurants = [];
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant WHERE cuisine_id = {$this->getId()};");

            foreach($returned_restaurants as $restaurant)
            {
                $rest_name = $restaurant['rest_name'];
                $id = $restaurant['id'];
                $location = $restaurant['location'];
                $price_range = $restaurant['price_range'];
                $cuisine_id = $restaurant['cuisine_id'];
                $new_restaurant =  new Restaurant($rest_name, $id, $location, $price_range, $cuisine_id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine;");
            $cuisines = [];

            foreach ($returned_cuisines as $cuisine) {
                $name = $cuisine['name'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine($name, $id);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisine;");
        }

        static function find($search_id)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();

            foreach ($cuisines as $cuisine) {
                if ($cuisine->getId() == $search_id) {
                    $found_cuisine = $cuisine;
                }
            }
            return $found_cuisine;
        }
    }

?>
