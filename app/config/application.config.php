<?php

return array(

	/*
	* Edit this file in order to configure your application
	* settings or preferences.
	* 
	*/

	/* --------------------------------------------------------------- */
	// Application textdomain
	/* --------------------------------------------------------------- */
	'textdomain'    => 'cuisine',

	/* --------------------------------------------------------------- */
	// Global Javascript namespace of your application
	/* --------------------------------------------------------------- */
	'namespace'     => 'cuisine',

	/* --------------------------------------------------------------- */
	// Set WordPress admin ajax file without the PHP extension
	/* --------------------------------------------------------------- */
	'ajaxurl'	    => 'admin-ajax',

	/* --------------------------------------------------------------- */
	// Encoding
	/* --------------------------------------------------------------- */
	'encoding'	    => 'UTF-8',

	/* --------------------------------------------------------------- */
	// Cleanup Header
	/* --------------------------------------------------------------- */
	'cleanup'	    => true,

	/* --------------------------------------------------------------- */
	// Restrict access to the WordPress Admin for users with a
	// specific role. 
	// Once the theme is activated, you can only log in by going
	// to 'wp-login.php' or 'login' (if permalinks changed) urls.
	// By default, allows 'administrator', 'editor', 'author',
	// 'contributor' and 'subscriber' to access the ADMIN area.
	// Edit this configuration in order to limit access.
	/* --------------------------------------------------------------- */
	'access'	    => array(
		'administrator',
		'editor',
		'author',
		'contributor',
		'subscriber'
	),

	/* --------------------------------------------------------------- */
	// Application classes' alias
	/* --------------------------------------------------------------- */
	'aliases'	    => array(
		'Cuisine\\Ajax\\Ajax'						=> 'Ajax',
		'Cuisine\\Facades\\Asset'					=> 'Asset',
		'Cuisine\\Configuration\\Application'		=> 'Application',
		'Cuisine\\Route\\Controller'               => 'Controller',
		'Cuisine\\Facades\\Field'					=> 'Field',
		'Cuisine\\Facades\\Form'					=> 'Form',
		'Cuisine\\Facades\\Html'                   => 'Html',
		'Cuisine\\Facades\\Input'                  => 'Input',
		'Cuisine\\Metabox\\Meta'					=> 'Meta',
		'Cuisine\\Facades\\Metabox'				=> 'Metabox',
		'Cuisine\\Page\\Option'					=> 'Option',
		'Cuisine\\Facades\\Page'					=> 'Page',
		'Cuisine\\Facades\\PostType'				=> 'PostType',
		'Cuisine\\Facades\\Route'					=> 'Route',
		'Cuisine\\Facades\\Section'                => 'Section',
		'Cuisine\\Session\\Session'				=> 'Session',
		'Cuisine\\Taxonomy\\TaxField'              => 'TaxField',
		'Cuisine\\Taxonomy\\TaxMeta'               => 'TaxMeta',
		'Cuisine\\Facades\\Taxonomy'				=> 'Taxonomy',
		'Cuisine\\Facades\\User'					=> 'User',
		'Cuisine\\Facades\\Validator'              => 'Validator',
		'Cuisine\\Facades\\Loop'					=> 'Loop',
		'Cuisine\\Facades\\View'					=> 'View'
	)

);