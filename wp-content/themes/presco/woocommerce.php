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

global $post;
get_header();
$object = get_queried_object();
$shop_page_id = get_option( 'woocommerce_shop_page_id' );
$page = new Page($shop_page_id);
//print_r($object);
?>
<div class="wrapper" id="woocommerce-wrapper">
    <?php
    if(is_shop()) {
        ?>
        <div class="page-title">
            <div id="content" class="container">
                <div class="row">
                    <div class="col-12">
                        <h1>Products</h1>
                        <?= $page->getSnippet() ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else { ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="woocommerce-breadcrumb">
                        <?=woocommerce_breadcrumb()?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div id="content" class="container">
        <div class="row">
            <div class="col-12">
                <main class="site-main" id="main">
                    <?php get_template_part( 'loop-templates/content', 'woocommerce' ); ?>
                </main>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
