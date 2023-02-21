# PHP Custom Framework


This is a guide to build a custom MCV framework using PHP. Thanks to https://lancecourse.com/en/howto/how-to-start-your-own-php-mvc-framework-in-4-steps for providing the initial guidelines.

## Step 1
First, pipe all requests through index.php. To do this, create .htaccess file within root directory. 

* If using Apache
```angular2svg
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f

RewriteRule ^(.+)$ index.php/$1 [L]
```

* If using NGINX
```angular2svg
# nginx configuration

location / {
    if (!-e $request_filename){
        rewrite ^(.+)$ /index.php/$1 break;
    }
}
```
Create an index.php file in the same directory 
```angular2svg
<?php

    if (!isset($_SERVER['PATH_INFO']))
    {
        echo "Home page";
        exit();
    }

    print "The request path is : ".$_SERVER['PATH_INFO'];
?>
```
Try accessing the application through various urls to confirm functionality. All urls are parse by index.php. From here, we can implement decisions base on the url.

## Step 2

Add folders to contain Models Views and Controls

```angular2svg
- project 
    - vendor/
    - composer.json
    - composer.lock
    - index.php
    - .htaccess
    - Models/
    - Views/
    - Controllers/
```

## Step 3

Handle all requests: Routing

The logic applied in this step is very straight forward. Our base url will never change. Our application will begin by parsing the url contents after the base url. The first section (after the base url) will dictate which controller to use. For instance:

```angular2svg
https://www.example.com/controller
```
The following section will be the action or method of the controller:

```angular2svg
https://www.example.com/controller/action
```

Finally, anything that is passed into the url after the action will be a parameter

```angular2svg
https://www.example.com/controller/action/param1/param2/param3
```

To implement this in code, replace the contents of index.php with the following code.

```angular2svg
$url = isset($_SERVER['PATH_INFO']) ? explode('/', $_SERVER['PATH_INFO']) : '/';

var_dump($url);
```

We can see the php outputs the path array of the url entered.

<hr>
In the MVC design pattern, the controller takes care of the user actions. Thus we need to call a particular controller every time a request is made.

Let's add some logic to handle requests that land at the root '/':
```angular2svg
if ($url == '/') { // We are the root level or home page
    // This is the home page
    // Initiate the home controller
    // and render the home view
    echo "<h1>Home</h1>";

} else { // This is not the home page

    // Initiate the appropriate controller
    // and render the required view

    // Let's extract the first element of the url
    // array.  This is the controller
    $requestedController = $url[0];

    // If there is a second element in the array
    // it is the action
    $requestedAction = isset($url[1]) ? $url[1] : '';

    // Implement logic to ensure the controller exists
    // TODO: Implement logic to ensure MODEL and VIEW Exist
    $ctrlPath = __DIR__ . '/Controllers/' . $requestedController.'_controller.php';
    if (file_exists($ctrlPath)){ // Does the controller exists
        // Logic 
    }else { // The controller does not exist
        header('HTTP/1.1 404 Not Found');
        die('404 - The file - '.$ctrlPath.' - not found');
    }
}
```

To create a page, you need to create a controller, a model and a view for it. So let's create some pages starting from the home page.