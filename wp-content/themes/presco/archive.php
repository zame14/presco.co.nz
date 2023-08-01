<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$cate = get_queried_object();
$category_id = $cate->term_id;
$template = get_post_format();
$category = new Category($category_id);
get_header();
?>
    <div class="wrapper" id="archive-wrapper">
        <div class="page-title">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php
                        if($cate->taxonomy == "service-category" || $cate->taxonomy == "equipment-category") {?>
                            <h1><?=$cate->name?></h1>
                            <div class="snippet"><?=$category->getSnippet()?></div>
                            <?php
                        } else { ?>
                            <?=the_archive_title( '<h1>', '</h1>' )?>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="content" class="container">
            <div class="row">
                <div class="col-12">
                    <?=breadcrumb()?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <main class="site-main" id="main">
                        <?php
                        if($cate->taxonomy == "service-category" || $cate->taxonomy == "equipment-category") { ?>
                            <?= get_template_part( 'loop-templates/content', 'category' ); ?>
                            <?php
                        } else {
                            ?>
                            <?php while (have_posts()) : the_post(); ?>
                                <?php

                                /*
                                 * Include the Post-Format-specific template for the content.
                                 * If you want to override this in a child theme, then include a file
                                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                 */
                                get_template_part('loop-templates/content', get_post_format());
                                ?>
                            <?php endwhile; ?>
                            <?php
                        }
                        ?>
                    </main><!-- #main -->
                </div>
            </div><!-- .row -->
        </div><!-- #content -->
    </div><!-- #page-wrapper -->
<?php get_footer(); ?>