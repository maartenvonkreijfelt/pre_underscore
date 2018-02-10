<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Pre_Underscores
 */










/**
 * Set up the WordPress core custom header feature.
 *
 * @uses pre_underscores_header_style()
 */
function pre_underscores_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'pre_underscores_custom_header_args', array(
		//for default image you could for instance place: get_parent_theme_file_uri( '/assets/images/header.jpg' )
		//'default-image'          => get_parent_theme_file_uri( '/assets/images/header.jpg' ),
		'default-image'          => '',
		'default-text-color'     => 'ffffff',
		'width'                  => 2000,
		'height'                 => 850,
		'flex-height'            => true,
		'wp-head-callback'       => 'pre_underscores_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'pre_underscores_custom_header_setup' );
