<?php
/*
 * Cuisine - A framework for WordPress developers.
 * Based on php 5.4 features and above.
 *
 * @author  Julien Lambé <julien@cuisine.com>
 * @link 	http://www.cuisine.com/
 */

/*----------------------------------------------------*/
// The directory separator.
/*----------------------------------------------------*/
defined('DS') ? DS : define('DS', DIRECTORY_SEPARATOR);

/*----------------------------------------------------*/
// Asset directory URL.
/*----------------------------------------------------*/
defined('CUISINE_ASSETS') ? CUISINE_ASSETS : define('CUISINE_ASSETS', get_template_directory_uri().'/app/assets');

/*----------------------------------------------------*/
// Theme Textdomain.
/*----------------------------------------------------*/
defined('CUISINE_THEME_TEXTDOMAIN') ? CUISINE_THEME_TEXTDOMAIN : define('CUISINE_THEME_TEXTDOMAIN', 'cuisine-theme');

/*----------------------------------------------------*/
// Cuisine Theme class.
// Check if the framework is loaded. If not, warn the user
// to activate it before continuing using the theme.
/*----------------------------------------------------*/
if (!class_exists('THFWK_CuisineTheme'))
{
    class THFWK_CuisineTheme
    {
        /**
         * Theme class instance.
         *
         * @var \THFWK_CuisineTheme
         */
        private static $instance = null;
        
        /**
         * Switch that tell if core and datas plugins are loaded.
         *
         * @var bool
         */
        private $pluginsAreLoaded = false;

        private function __construct()
        {
        	// Check if framework is loaded.
        	add_action('after_setup_theme', array($this, 'check'));
        }
        
        /**
    	 * Init the class.
         *
         * @return \THFWK_CuisineTheme
    	 */
    	public static function getInstance()
    	{
    		if (is_null(static::$instance))
            {
    	    	static::$instance = new static();  
    	    }
    	 	return static::$instance;
    	}
    	
    	/**
         * Trigger by the action hook 'after_switch_theme'.
         * Check if the framework and dependencies are loaded.
         *
         * @return void
    	 */
    	public function check()
    	{
            $symfony = class_exists('Symfony\Component\ClassLoader\ClassLoader');
    	    $cuisine = class_exists('THFWK_Cuisine');

            // Symfony dependency and Cuisine plugin classes are available.
            if ($symfony && $cuisine)
            {
                $this->pluginsAreLoaded = $cuisine;
            }

        	// Display a message to the user in the admin panel when he's activating the theme
            // if the plugin is not available.
        	if (!$cuisine)
            {
            	add_action('admin_notices', array($this, 'displayMessage'));
                return;
        	}

            // Display a message if Symfony Class Loader component is not available.
            if (!$symfony)
            {
                add_action('admin_notices', array($this, 'displayNotice'));
                return;
            }
    	}
    	
    	/**
         * Display a notice to the user if framework is not loaded.
         *
         * @return void
    	 */
    	public function displayMessage()
    	{
    		?>
    		    <div id="message" class="error">
                    <p><?php _e("You first need to activate the <b>Cuisine framework</b> in order to use this theme.", CUISINE_THEME_TEXTDOMAIN); ?></p>
                </div>
    		<?php
    	}

        /**
         * Display a notice to the user if the Symfony class loaded is not available.
         *
         * @return void
         */
        public function displayNotice()
        {
        ?>
            <div id="message" class="error">
                <p><?php _e(sprintf('<b>Cuisine theme:</b> %s', "Symfony Class Loader component not found. Make sure the Cuisine plugin includes it before proceeding."), CUISINE_THEME_TEXTDOMAIN); ?></p>
            </div>
        <?php
        }
    	
    	/**
         * Return true if framework is loaded.
         *
         * @return boolean
    	 */
    	public function isPluginLoaded()
    	{
    		return $this->pluginsAreLoaded;
    	}
    }
}

/*----------------------------------------------------*/
// Instantiate the theme class.
/*----------------------------------------------------*/
THFWK_CuisineTheme::getInstance();

/*----------------------------------------------------*/
// Set theme's paths.
/*----------------------------------------------------*/
add_filter('cuisine_framework_paths', 'cuisine_setApplicationPaths');
add_filter('cuisine_application_paths', 'cuisine_setApplicationPaths');

if (!function_exists('cuisine_setApplicationPaths'))
{
    function cuisine_setApplicationPaths($paths)
    {
        // Theme base path.
        $paths['base'] = __DIR__.DS;

        // Application path.
        $paths['app'] = __DIR__.DS.'app'.DS;

        // Application admin directory.
        $paths['admin'] = __DIR__.DS.'app'.DS.'admin'.DS;

        // Application storage directory.
        $paths['storage'] = __DIR__.DS.'app'.DS.'storage'.DS;

        return $paths;
    }
}

/*----------------------------------------------------*/
// Set theme's configurations.
/*----------------------------------------------------*/
add_action('cuisine_configurations', function()
{
    Cuisine\Configuration\Config::make(array(
        'app'    => array(
            'application',
            'constants',
            'images',
            'loading',
            'menus',
            'sidebars',
            'supports',
            'templates'
        )
    ));

   Cuisine\Configuration\Config::set();
});

/*----------------------------------------------------*/
// Register theme view paths.
/*----------------------------------------------------*/
add_filter('cuisineViewPaths', function($paths)
{
    $paths[] = cuisine_path('app').'views'.DS;
    return $paths;
});

/*----------------------------------------------------*/
// Register theme asset paths.
/*----------------------------------------------------*/
add_filter('cuisineAssetPaths', function($paths)
{
    $paths[CUISINE_ASSETS] = cuisine_path('app').'assets';
    return $paths;
});

/*----------------------------------------------------*/
// Bootstrap theme.
/*----------------------------------------------------*/
add_action('cuisine_bootstrap', function()
{
    /*----------------------------------------------------*/
    // Handle errors, warnings, exceptions.
    /*----------------------------------------------------*/
    set_exception_handler(function($e)
    {
        Cuisine\Error\Error::exception($e);
    });

    set_error_handler(function($code, $error, $file, $line)
    {
        // Check if the class exists
        // Otherwise WP can't find it when
        // constructing its "Menus" page
        // under appearance in administration.
        if (class_exists('Cuisine\Error\Error'))
        {
            Cuisine\Error\Error::native($code, $error, $file, $line);
        }
    });

    if (defined('CUISINE_ERROR_SHUTDOWN') && CUISINE_ERROR_SHUTDOWN)
    {
        register_shutdown_function(function()
        {
            Cuisine\Error\Error::shutdown();
        });
    }

    // Passing in the value -1 will show every errors.
    $report = defined('CUISINE_ERROR_REPORT') ? CUISINE_ERROR_REPORT : 0;
    error_reporting($report);

    /*----------------------------------------------------*/
    // Set class aliases.
    /*----------------------------------------------------*/
    $aliases = Cuisine\Configuration\Application::get('aliases');

    foreach ($aliases as $namespace => $className)
    {
        class_alias($namespace, $className);
    }

    /*----------------------------------------------------*/
    // Application textdomain.
    /*----------------------------------------------------*/
    defined('CUISINE_TEXTDOMAIN') ? CUISINE_TEXTDOMAIN : define('CUISINE_TEXTDOMAIN', Cuisine\Configuration\Application::get('textdomain'));

    /*----------------------------------------------------*/
    // Trigger framework default configuration.
    /*----------------------------------------------------*/
    Cuisine\Configuration\Configuration::make();

    /*----------------------------------------------------*/
    // Application constants.
    /*----------------------------------------------------*/
    Cuisine\Configuration\Constant::load();

    /*----------------------------------------------------*/
    // Application page templates.
    /*----------------------------------------------------*/
    Cuisine\Configuration\Template::init();

    /*----------------------------------------------------*/
    // Application image sizes.
    /*----------------------------------------------------*/
    Cuisine\Configuration\Images::install();

    /*----------------------------------------------------*/
    // Parse application files and include them.
    // Extends the 'functions.php' file by loading
    // files located under the 'admin' folder.
    /*----------------------------------------------------*/
    Cuisine\Core\AdminLoader::add();
    Cuisine\Core\WidgetLoader::add();

    /*----------------------------------------------------*/
    // Application widgets.
    /*----------------------------------------------------*/
    Cuisine\Core\WidgetLoader::load();

    /*----------------------------------------------------*/
    // Application global JS object.
    /*----------------------------------------------------*/
    Cuisine\Ajax\Ajax::set();
});

/*----------------------------------------------------*/
// Handle application requests/responses.
/*----------------------------------------------------*/
function cuisine_start_app()
{
    if (THFWK_CuisineTheme::getInstance()->isPluginLoaded())
    {
        do_action('cuisine_parse_query', $arg = '');

        /*----------------------------------------------------*/
        // Application routes.
        /*----------------------------------------------------*/
        require cuisine_path('app').'routes.php';

        /*----------------------------------------------------*/
        // Run application and return a response.
        /*----------------------------------------------------*/
        do_action('cuisine_run');
	}
    else
    {
        _e("The theme won't work until you install the Cuisine framework plugin correctly.", CUISINE_THEME_TEXTDOMAIN);
	}
}