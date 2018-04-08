<?php  // Fit4Life SHORTCODES

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


// 2.1
// hint: registers all our custom shortcodes on init
add_action( 'init', 'fit4life_register_shortcodes' );

// 2.2
// hint: registers all our custom shortcodes
function fit4life_register_shortcodes() {

	add_shortcode( 'fit4life_active_workouts', 'fit4life_active_workouts_shortcode' );
  add_shortcode( 'fit4life_active_fit_tests', 'fit4life_active_fit_tests_shortcode' );

}

// 2.3
// hint: list active program posts using shortcode [fit4life_active_workouts]
function fit4life_active_workouts_shortcode( $args, $content="") {

	// setup our output variable - the form html

	global $post;
	$current_user = wp_get_current_user();
	$member_name = $current_user->first_name . " " . $current_user->last_name;

	$user_args = array(
		'posts_per_page'   => 15,
		'post_type' => array('fit4life_workout'),
		'author' => $current_user->ID,
		'orderby' => 'post_date',
		'order' => 'ASC',
		'post_status' => 'publish',
	);

	$output = '<div class="member_post_sidebar">';

	$myposts = get_posts( $user_args );

	if($myposts) {

    $output .= '<ul class="prog_active_list">';

		foreach ( $myposts as $post ) : setup_postdata( $post );

			$output .= '<li class="prog_active_item">&#8594; <a href="'. get_permalink() . '">' . get_the_title() . '</a></li>';

		endforeach;

    $output .= '</ul>';

		}

		else {

			$output = 'No Workouts Assigned';

		}

		wp_reset_postdata();

	$output .= '</div>';

	// return our results/html
	return $output;

}


// 2.4
// hint: list active fitness test posts using shortcode [fit4life_active_fit_tests]
function fit4life_active_fit_tests_shortcode( $args, $content="") {

	// setup our output variable - the form html

	global $post;
	$current_user = wp_get_current_user();
	$member_name = $current_user->first_name . " " . $current_user->last_name;

	$user_args = array(
		'posts_per_page'   => 15,
		'post_type' => array('fit4life_fit_test'),
		'author' => $current_user->ID,
		'orderby' => 'post_date',
		'order' => 'ASC',
		'post_status' => 'publish',
	);

	$output = '<div class="member_post_sidebar">';

	$myposts = get_posts( $user_args );

	if($myposts) {

  	$output .= '<ul class="prog_active_list">';

		foreach ( $myposts as $post ) : setup_postdata( $post );

			$output .= '<li class="prog_active_item">&#8594; <a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';

		endforeach;

    $output .= '</ul>';

		}

		else {

			$output = 'No Fitness Test Assigned';

		}

	wp_reset_postdata();

	$output .= '</div>';

	// return our results/html
	return $output;

}
