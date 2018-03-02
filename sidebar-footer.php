<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pre_Underscores
 */

if ( ! is_active_sidebar( 'footer-1' ) ) {
	return;
}
?>

<aside id="footer-widget-area" class="footer-widgets">
	<?php dynamic_sidebar( 'footer-1' ); ?>
</aside><!-- #footer-widget-area -->
