<?php

/*

 WARNING: This file is part of the core Genesis framework. DO NOT edit

 this file under any circumstances. Please do all modifications

 in the form of a child theme.

 */



/**

 * Handles the header structure.

 *

 * This file is a core Genesis file and should not be edited.

 *

 * @category Genesis

 * @package  Templates

 * @author   StudioPress

 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)

 * @link     http://www.studiopress.com/themes/genesis

 */



do_action( 'genesis_doctype' );

do_action( 'genesis_title' );

do_action( 'genesis_meta' );



wp_head(); /** we need this for plugins **/

?>
    <script language="javascript" src="<?php bloginfo("template_url"); ?>/js/jquery.min.js" type="text/javascript"></script>
    <script language="javascript" src="<?php bloginfo("template_url"); ?>/js/jquery-ui.min.js" type="text/javascript"></script>
    
    <link rel="stylesheet" type="text/css" href="<?php bloginfo("template_url"); ?>/css/validationEngine.jquery.css" />
    <script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/languages/jquery.validationEngine-en.js"></script>
    <script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/jquery.validationEngine.js"></script>

</head>

<body <?php body_class(); ?>>

<?php

do_action( 'genesis_before' );

?>

<div id="wrap">

<?php

do_action( 'genesis_before_header' );

do_action( 'genesis_header' );

do_action( 'genesis_after_header' );



echo '<div id="inner">';

genesis_structural_wrap( 'inner' );

