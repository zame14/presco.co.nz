<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
get_header();
global $post;
?>
    <div class="wrapper" id="page-wrapper">
        <div id="content" class="container">
            <div class="row">
                <div class="col-12">
                    <?=breadcrumb()?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <main class="site-main" id="main">
                        <?php while (have_posts()) : the_post(); ?>
                            <?=get_template_part('loop-templates/content', 'service')?>
                        <?php endwhile; // end of the loop. ?>
                    </main>
                </div>
            </div>
        </div>
    </div><!-- #page-wrapper -->
<?php
get_footer();