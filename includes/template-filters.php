<?php  // Fit4Life Custom Template Filters


// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


// hint: Assign template files to custom post types
add_filter( 'single_template', 'get_fit4life_fit_test_template' );
add_filter( 'single_template', 'get_fit4life_workout_template' );
add_filter( 'single_template', 'get_fit4life_exercise_template' );

add_filter( 'archive_template', 'get_fit4life_exercise_archive' );
add_filter( 'archive_template', 'get_fit4life_workout_archive' );

add_filter( 'archive_template', 'get_fit4life_tax_area_template' );
//add_filter( 'archive_template', 'get_fit4life_tax_concentration_template' );
//add_filter( 'single_template', 'get_fit4life_tax_focus_template' );
//add_filter( 'single_template', 'get_fit4life_tax_membership_template' );
//add_filter( 'single_template', 'get_fit4life_tax_movement_template' );
//add_filter( 'single_template', 'get_fit4life_tax_purpose_template' );
//add_filter( 'single_template', 'get_fit4life_tax_usage_template' );


// hint: Assign template to custom post type fit4life_fit_test
if( !function_exists('get_fit4life_fit_test_template') ):

  function get_fit4life_fit_test_template($single_template) {

     global $post;

     if ($post->post_type == 'fit4life_fit_test') {
          $single_template = plugin_dir_path(__FILE__) . '../single-fit4life_fit_test.php';
     }
   return $single_template;
  }

endif;


// hint: Assign template to custom post type fit4life_workout
if( !function_exists('get_fit4life_workout_template') ):

  function get_fit4life_workout_template($single_template) {

     global $post;

     if ($post->post_type == 'fit4life_workout') {
          $single_template = plugin_dir_path(__FILE__) . '../single-fit4life_workout.php';
     }
   return $single_template;
  }

endif;


// hint: Assign template to custom post type fit4life_exercise
if( !function_exists('get_fit4life_exercise_template') ):

  function get_fit4life_exercise_template($single_template) {

     global $post;

     if ($post->post_type == 'fit4life_exercise') {
          $single_template = plugin_dir_path(__FILE__) . '../single-fit4life_exercise.php';
     }
   return $single_template;
  }

endif;


// hint: Assign template to custom archive archive-fit4life_exercise
if( !function_exists('get_fit4life_exercise_archive') ):

  function get_fit4life_exercise_archive($archive_template) {

     global $post;

     if (is_post_type_archive ( 'fit4life_exercise' ) ) {
          $archive_template = plugin_dir_path(__FILE__) . '../archive-fit4life_exercise.php';
     }
   return $archive_template;
  }

endif;


// hint: Assign template to custom post type
if( !function_exists('get_fit4life_workout_archive') ):

  function get_fit4life_workout_archive($archive_template) {

     global $post;

     if (is_post_type_archive ( 'fit4life_workout' ) ) {
          $archive_template = plugin_dir_path(__FILE__) . '../archive-fit4life_workout.php';
     }
   return $archive_template;
  }

endif;


// hint: Assign template to custom post type
if( !function_exists('get_fit4life_tax_area_template') ):

  function get_fit4life_tax_area_template($archive_template) {

     global $post;

     if (is_post_type_archive ( 'fit4life_tax_area' ) ) {
          $archive_template = plugin_dir_path(__FILE__) . '../taxonomy-fit4life_tax_area.php';
     }
   return $archive_template;
  }

endif;
