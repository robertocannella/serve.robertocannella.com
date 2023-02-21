<?php
/**
 *  index page. This page serves as a router for the site.
 *
 * @package 'server.robertocannella.com'
 */

require_once 'vendor/autoload.php';
use App\Models;
use App\Views;
use App\Controllers;

// Explode the url for parsing if it isn't the root directory
$url = isset($_SERVER['PATH_INFO']) ? explode('/', $_SERVER['PATH_INFO']) : '/';

if ($url == '/') { // We are the root level or home page
    // This is the home page. Initiate the home controller and render the home view

    $indexModel = new Models\IndexModel();
    $indexController = new Controllers\IndexController($indexModel);
    $indexView = new Views\IndexView($indexController, $indexModel);

    print $indexView->index();

} else { // This is not the home page

    // Initiate the appropriate controller
    // and render the required view

    // Let's extract the first element of the url
    // array.  This is the controller
    $requestedController = ucfirst($url[1]);

    // If there is a second element in the array
    // it is the action
    $requestedAction = isset($url[2]) ? ucfirst($url[2]) : '';

    // The remaining parts are considered as
    // arguments of the method
    $requestedParams = array_slice($url, 2);


    // Implement logic to ensure the controller exists
    // TODO: Implement logic to ensure MODEL and VIEW Exist
    $ctrlPath = __DIR__ . '/src/Controllers/' . $requestedController.'Controller.php';

    if (file_exists($ctrlPath)){ // Does the controller exists

        /*
         * Build the MVC Objects dynamically (using namespace reflections)
         * SEE:  https://stackoverflow.com/questions/8734522/dynamically-call-class-with-variable-number-of-parameters-in-the-constructor
         *
         */
        $modelClass         = "App\\Models\\{$requestedController}Model";
        $controllerClass    = "App\\Controllers\\{$requestedController}Controller";
        $viewClass          = "App\\Views\\{$requestedController}View";


        // Create the model for this view
        $modelObj = new $modelClass;

        // Create the controller for this view
        $controllerParams = [ $modelObj ];
        try {
            $reflection = new \ReflectionClass($controllerClass);
            $controllerObj = $reflection->newInstanceArgs($controllerParams);

            // Create the View for this view
            try{
                $reflection = new \ReflectionClass($viewClass);
                $viewObj = $reflection->newInstanceArgs([$controllerObj, $controllerObj->modelObj]);
                // If there is a method - Second parameter
                if ($requestedAction != '')
                {
                    // then we call the method via the view
                    // dynamic call of the view
                    print $viewObj->$requestedAction($requestedParams);
                }

            }catch (ReflectionException $e){
                error_log($e);
            }
        } catch (ReflectionException $e) {
                error_log($e);
        }


    }else { // The controller does not exist
        header('HTTP/1.1 404 Not Found');
        die('404 - The file - '.$ctrlPath.' - not found');
        //require the 404 controller and initiate it
        //Display its view
    }
}

