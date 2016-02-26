<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";

    // session_start();

    $app['debug'] = true;

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=chomp';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig',
        array(
            'cuisines' => Cuisine::getAll()
        ));
    });

    $app->get("/cuisines/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.html.twig', array(
            'cuisine' => $cuisine,
            'restaurants' => $cuisine->getRestaurants()
        ));
    });

    $app->post("/restaurants", function() use ($app) {
        $rest_name = $_POST['rest_name'];
        $location = $_POST['location'];
        $price_range = $_POST['price_range'];
        $cuisine_id = $_POST['cuisine_id'];
        var_dump($cuisine_id);
        $new_restaurant = new Restaurant($rest_name, $id = null, $location, $price_range, $cuisine_id);
        $new_restaurant->save();
        $cuisine = Cuisine::find($cuisine_id);
        return $app['twig']->render('cuisine.html.twig', array(
            'cuisine' => $cuisine,
            'restaurants' => $cuisine->getRestaurants()
        ));

    });

    $app->get("/cuisines/{id}/edit", function($id) use ($app) {
        $new_cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $new_cuisine));
    });

    $app->patch("/cuisines/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $cuisine = Cuisine::find($id);
        $cuisine->update($name);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->post("/cuisines", function() use ($app) {
        $new_cuisine = new Cuisine($_POST['name']);
        $new_cuisine->save();
        return $app['twig']->render('index.html.twig', array(
            'cuisines' => Cuisine::getAll()
        ));
    });


    $app->delete("/cuisines/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $cuisine->delete();
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
});

    $app->get("/restaurant/{cuisine_id}/{id}/edit_form", function($cuisine_id, $id) use ($app)
    {

        $current_restaurant = Restaurant::find($id);
        $cuisine = Cuisine::find($cuisine_id);
        var_dump($cuisine_id);
        return $app['twig']->render('cuisine.html.twig', array('current_restaurant' => $current_restaurant, 'cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants(), 'form' => true));
    });


    $app->patch("/restaurants/updated", function() use ($app) {
        $new_name = $_POST['new_name'];
		$restaurant_to_edit = Restaurant::find($_POST['current_restaurantId']);
		$restaurant_to_edit->update($new_name);
		$cuisine = Cuisine::find($_POST['cuisine_id']);
		return $app['twig']->render('cuisine.html.twig', array('restaurants' => $cuisine->getRestaurants(), 'cuisine' => $cuisine));
	});

    $app->post("/delete_cuisines", function() use ($app) {
       Cuisine::deleteAll();
       return $app['twig']->render('index.html.twig');
    });


    $app->post("/delete_restaurants", function() use ($app) {
       Restaurant::deleteAll();
       $cuisine = Cuisine::find($_POST['cuisine_id']);
       return $app['twig']->render('cuisine.html.twig', array(
           'cuisine' => $cuisine
       ));
   });



    return $app;
 ?>
