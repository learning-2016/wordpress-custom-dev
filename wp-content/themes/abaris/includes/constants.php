<?php
	/* Defining directory PATH Constants */
	define( 'ABARIS_PARENT_DIR', get_template_directory() );
	define( 'ABARIS_CHILD_DIR', get_stylesheet_directory() );
	define( 'ABARIS_INCLUDES_DIR', ABARIS_PARENT_DIR. '/includes' );

	/** Defining URL Constants */
	define( 'ABARIS_PARENT_URL', get_template_directory_uri() );
	define( 'ABARIS_CHILD_URL', get_stylesheet_directory_uri() );
	define( 'ABARIS_INCLUDES_URL', ABARIS_PARENT_URL . '/includes' );

	/* 
	Check for language directory setup in Child Theme
	If not present, use parent theme's languages dir
	*/
	if ( ! defined( 'ABARIS_LANGUAGES_URL' ) ) /** So we can predefine to child theme */
		define( 'ABARIS_LANGUAGES_URL', ABARIS_PARENT_URL . '/languages' );

	if ( ! defined( 'ABARIS_LANGUAGES_DIR' ) ) /** So we can predefine to child theme */
		define( 'ABARIS_LANGUAGES_DIR', ABARIS_PARENT_DIR . '/languages' );