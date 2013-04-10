<?php
/**
 * The main template file.
 *
 * This is the cheque template that will be using for manual and laser cheque
 *
 * @package WordPress
 * @subpackage c-t
 * @since c-t 1.0
 */
?>

<?php get_header(); ?>
<?php 
	if ( get_option('permalink_structure') != '' ) { echo 'permalinks enabled'; } 
	else{echo "Permalinks not enabled.";}
?>
    <div id="cheque_holder"><!-- Main cheque holder start -->
    	Here will go everything
    </div><!-- Main cheque holder end -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>