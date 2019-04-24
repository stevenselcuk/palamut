<?php
/**
 * Portfolio Front-Page for Palamut Portfolio Config.
 *
 * Shows Portfolio Loop
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package palamut
 */

get_header();
get_template_part( 'components/cpts/portfolio/portfolio' );
get_sidebar();
get_footer();
