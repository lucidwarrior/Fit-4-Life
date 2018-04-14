<?php

/**
* Post Type: All
*/


function cptui_register_my_cpts() {

	/**
	 * Post Type: Workouts.
	 */

	$labels = array(
		"name" => __( "Workouts", "twentyseventeen" ),
		"singular_name" => __( "Workout", "twentyseventeen" ),
	);

	$args = array(
		"label" => __( "Workouts", "twentyseventeen" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => true,
		"show_in_menu" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "fit4life_workout", "with_front" => false ),
		"query_var" => true,
		"menu_position" => 6,
		"menu_icon" => "dashicons-universal-access-alt",
		"supports" => array( "title", "thumbnail", "author" ),
		"taxonomies" => array( "fit4life_tax_purpose", "fit4life_tax_concentration", "fit4life_tax_membership" ),
	);

	register_post_type( "fit4life_workout", $args );

	/**
	 * Post Type: Exercises.
	 */

	$labels = array(
		"name" => __( "Exercises", "twentyseventeen" ),
		"singular_name" => __( "Exercise", "twentyseventeen" ),
	);

	$args = array(
		"label" => __( "Exercises", "twentyseventeen" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => true,
		"show_in_menu" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "fit4life_exercise", "with_front" => false ),
		"query_var" => true,
		"menu_position" => 8,
		"menu_icon" => "dashicons-universal-access",
		"supports" => array( "title", "thumbnail" ),
		"taxonomies" => array( "fit4life_tax_movement", "fit4life_tax_area", "fit4life_tax_usage" ),
	);

	register_post_type( "fit4life_exercise", $args );

	/**
	 * Post Type: Fitness Test.
	 */

	$labels = array(
		"name" => __( "Fitness Test", "twentyseventeen" ),
		"singular_name" => __( "Fitness Test", "twentyseventeen" ),
	);

	$args = array(
		"label" => __( "Fitness Test", "twentyseventeen" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => true,
		"show_in_menu" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "fit4life_fit_test", "with_front" => false ),
		"query_var" => true,
		"menu_position" => 9,
		"menu_icon" => "dashicons-chart-line",
		"supports" => array( "title", "thumbnail", "author" ),
	);

	register_post_type( "fit4life_fit_test", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );




/**
* Taxonomy: All
*/


function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Movements.
	 */

	$labels = array(
		"name" => __( "Movements", "twentyseventeen" ),
		"singular_name" => __( "Movement", "twentyseventeen" ),
	);

	$args = array(
		"label" => __( "Movements", "twentyseventeen" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Movements",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'fit4life_tax_movement', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "fit4life_tax_movement", array( "fit4life_exercise" ), $args );

	/**
	 * Taxonomy: Areas.
	 */

	$labels = array(
		"name" => __( "Areas", "twentyseventeen" ),
		"singular_name" => __( "Area", "twentyseventeen" ),
	);

	$args = array(
		"label" => __( "Areas", "twentyseventeen" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Areas",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'fit4life_tax_area', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "fit4life_tax_area", array( "fit4life_exercise" ), $args );

	/**
	 * Taxonomy: Usage.
	 */

	$labels = array(
		"name" => __( "Usage", "twentyseventeen" ),
		"singular_name" => __( "Usage", "twentyseventeen" ),
	);

	$args = array(
		"label" => __( "Usage", "twentyseventeen" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Usage",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'fit4life_tax_usage', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "fit4life_tax_usage", array( "fit4life_exercise" ), $args );

	/**
	 * Taxonomy: Purpose.
	 */

	$labels = array(
		"name" => __( "Purpose", "twentyseventeen" ),
		"singular_name" => __( "Purpose", "twentyseventeen" ),
	);

	$args = array(
		"label" => __( "Purpose", "twentyseventeen" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Purpose",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'fit4life_tax_purpose', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "fit4life_tax_purpose", array( "fit4life_workout" ), $args );

	/**
	 * Taxonomy: Concentration.
	 */

	$labels = array(
		"name" => __( "Concentration", "twentyseventeen" ),
		"singular_name" => __( "Concentration", "twentyseventeen" ),
	);

	$args = array(
		"label" => __( "Concentration", "twentyseventeen" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Concentration",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'fit4life_tax_concentration', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "fit4life_tax_concentration", array( "fit4life_workout" ), $args );

	/**
	 * Taxonomy: Focus.
	 */

	$labels = array(
		"name" => __( "Focus", "twentyseventeen" ),
		"singular_name" => __( "Focus", "twentyseventeen" ),
	);

	$args = array(
		"label" => __( "Focus", "twentyseventeen" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Focus",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'fit4life_tax_focus', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "fit4life_tax_focus", array( "fit4life_exercise" ), $args );

	/**
	 * Taxonomy: Memberships.
	 */

	$labels = array(
		"name" => __( "Memberships", "twentyseventeen" ),
		"singular_name" => __( "Membership", "twentyseventeen" ),
	);

	$args = array(
		"label" => __( "Memberships", "twentyseventeen" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Memberships",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'fit4life_tax_membership', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "fit4life_tax_membership", array( "fit4life_workout" ), $args );
}

add_action( 'init', 'cptui_register_my_taxes' );
