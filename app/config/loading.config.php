<?php

return array(

    /**
     * Mapping for all classes without a namespace.
     * The key is the class name and the value is the
     * absolute path to your class file.
     *
     * Watch your commas...
     */
    // Controllers
    'BaseController'        => cuisine_path('app').'controllers'.DS.'BaseController.php',
    'HomeController'        => cuisine_path('app').'controllers'.DS.'HomeController.php',

    // Models
    'PostModel'             => cuisine_path('app').'models'.DS.'PostModel.php',

    // Miscellaneous

);