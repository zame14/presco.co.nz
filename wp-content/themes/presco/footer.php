<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
global $post;
?>
<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="inner-wrapper">
                    <div class="f-col-1">
                        <h4>Presco</h4>
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'presco-footer-menu',
                                'container_class' => '',
                                'menu_class' => 'footer-menu',
                                'fallback_cb' => '',
                                'menu_id' => 'presco-footer-menu'
                            )
                        );
                        ?>
                    </div>
                    <div class="f-col-2">
                        <h4>Presco Environmental</h4>
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'environmental-footer-menu',
                                'container_class' => '',
                                'menu_class' => 'footer-menu',
                                'fallback_cb' => '',
                                'menu_id' => 'environmental-footer-menu'
                            )
                        );
                        ?>
                    </div>
                    <div class="f-col-3">
                        <h4>Presco Prenail</h4>
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'prenail-footer-menu',
                                'container_class' => '',
                                'menu_class' => 'footer-menu',
                                'fallback_cb' => '',
                                'menu_id' => 'prenail-footer-menu'
                            )
                        );
                        ?>
                    </div>
                    <div class="f-col-4">
                        <h4>Presco Hire</h4>
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'hire-footer-menu',
                                'container_class' => '',
                                'menu_class' => 'footer-menu',
                                'fallback_cb' => '',
                                'menu_id' => 'hire-footer-menu'
                            )
                        );
                        ?>
                    </div>
                    <div class="f-col-5">
                        <?php
                        if(is_active_sidebar('footerwidget')){
                            dynamic_sidebar('footerwidget');
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="copyright">
    <div class="row">
        <div class="col-12">
            &copy; <?=date('Y')?> Presco Group Limited, All Right Reserved
        </div>
    </div>
</section>
</div><!-- #page we need this extra closing tag here -->
<?php wp_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/js/noframework.waypoints.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=get_stylesheet_directory_uri()?>/slick-carousel/slick/slick.js"></script>
<script src="<?=get_stylesheet_directory_uri()?>/js/theme.js" type="text/javascript"></script>
</body>
</html>