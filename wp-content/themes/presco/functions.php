<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
require_once('modal/class.Base.php');
require_once('modal/class.Page.php');
require_once('modal/class.Service.php');
require_once('modal/class.Equipment.php');
require_once('modal/class.Product.php');
require_once('modal/class.Category.php');

add_action( 'wp_enqueue_scripts', 'p_enqueue_styles');
function p_enqueue_styles() {
    //wp_enqueue_style( 'bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css');
    wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/slick-carousel/slick/slick.css');
    wp_enqueue_style( 'slick-theme', get_stylesheet_directory_uri() . '/slick-carousel/slick/slick-theme.css');
    wp_enqueue_style( 'understrap-theme', get_stylesheet_directory_uri() . '/style.css');
}
add_image_size( 'banner', 2000, 800, true);
add_image_size( 'tall-grid', 400, 600, true);
function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );
function dg_remove_page_templates( $templates ) {
    unset( $templates['page-templates/blank.php'] );
    unset( $templates['page-templates/right-sidebarpage.php'] );
    unset( $templates['page-templates/both-sidebarspage.php'] );
    unset( $templates['page-templates/empty.php'] );
    unset( $templates['page-templates/fullwidthpage.php'] );
    unset( $templates['page-templates/left-sidebarpage.php'] );
    unset( $templates['page-templates/right-sidebarpage.php'] );

    return $templates;
}
add_filter( 'theme_page_templates', 'dg_remove_page_templates' );
function formatPhoneNumber($ph) {
    $ph = str_replace('(', '', $ph);
    $ph = str_replace(')', '', $ph);
    $ph = str_replace(' ', '', $ph);
    $ph = str_replace('+64', '0', $ph);

    return $ph;
}
add_action('init', 'p_register_menus');
function p_register_menus() {
    register_nav_menus(
        Array(
            'parent-menu' => __('Parent Menu'),
            'presco-menu' => __('Presco Menu'),
            'environmental-menu' => __('Environmental Menu'),
            'prenail-menu' => __('Prenail Menu'),
            'hire-menu' => __('Hire Menu'),
            'presco-footer-menu' => __('Presco Footer Menu'),
            'environmental-footer-menu' => __('Environmental Footer Menu'),
            'prenail-footer-menu' => __('Prenail Footer Menu'),
            'hire-footer-menu' => __('Hire Footer Menu'),
        )
    );
}
function getParentPageID()
{
    global $post;
    $page_id = 13; // presco home page
    $arr = array('environmental_page_id','prenail_page_id','hire_page_id');
    foreach ($arr as $slug)
    {
        if($post->ID == get_field($slug,13)) {
            $page_id = get_field($slug,13);
        } else {
            // not on environmental home page but check if we on a environmental sub page
            $children = get_children(get_field($slug,13));
            foreach($children as $child) {
                if ($post->ID == $child->ID) {
                    $page_id = get_field($slug,13);
                    break;
                }
            }
        }
    }
    // check module pages
    $post_type = get_post_type($post->ID);
    if($post_type == "service") {
        $page_id = get_field('environmental_page_id',13);
    }
    if($post_type == "product") {
        $page_id = get_field('environmental_page_id',13);
    }
    if($post_type == "equipment-hire") {
        $page_id = get_field('hire_page_id',13);
    }
    return $page_id;
}
function isParentPage()
{
    global $post;
    $parent = false;
    if($post->ID == 13) {
        $parent = true;
    } else {
        // check other parent pages
        $arr = array('environmental_page_id','prenail_page_id','hire_page_id');
        foreach ($arr as $slug)
        {
            if($post->ID == get_field($slug,13)) {
                $parent = true;
                break;
            }
        }
    }
    return $parent;
}
function footer_widget_init()
{
    register_sidebar( array(
        'name'          => __( 'Footer Widget Right', 'understrap' ),
        'id'            => 'footerwidget',
        'description'   => 'Widget area in the footer',
        'before_widget'  => '<div class="footer-widget-wrapper">',
        'after_widget'   => '</div><!-- .footer-widget -->',
        'before_title'   => '<h3 class="widget-title">',
        'after_title'    => '</h3>',
    ) );
}
add_action( 'widgets_init', 'footer_widget_init' );
function quickLinks_shortcode()
{
    $i = 1;
    $arr = array('environmental_page_id','prenail_page_id','hire_page_id');
    $html = '<div class="quick-links-wrapper">';
    foreach($arr as $slug) {
        $page_id = get_field($slug,13);
        $page = new Page($page_id);
        $slug = str_replace(" ", "-", $page->getTitle());
        $slug = strtolower($slug);
        $html .= '<div class="inner-wrapper img' . $i . '" onclick="location.href=/' . $slug . '/">
            <div class="image-wrapper">
                <img src="' . get_field('grid_image',$page_id) . '" alt="' . $page->getTitle() . '" />
            </div>
            <div class="visit-site">
                <span>Visit Site</span>
            </div>
        </div>';
        $i++;
    }
    $html .= '</div>';
    return $html;
}
add_shortcode('quick_links','quickLinks_shortcode');
function servicesModule_shortcode()
{
    $arr = get_terms( array(
        'taxonomy' => 'service-category',
        'hide_empty' => false,
        'orderby' => 'ID',
        'parent' => 0
    ) );
    $html = '<div class="row justify-content-center services-module">';
    foreach($arr as $object) {
        $category = new Category($object->term_id);
        $html .= '<div class="col-12">
            <h2>' . $category->getTitle() . '</h2>
        </div>';
        foreach (getServiceByCategory($category->id()) as $service)
        {
            $html .= $service->getPanel();
        }
    }
    $html .= '</div>';
    return $html;
}
add_shortcode('services','servicesModule_shortcode');
function getServiceByCategory($term_id)
{
    $arr = Array();
    $posts_array = get_posts([
        'post_type' => 'service',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'ID',
        'order' => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => 'service-category',
                'field' => 'term_id',
                'terms' => $term_id
            )
        )
    ]);
    foreach ($posts_array as $post) {
        $service = new Service($post);
        $arr[] = $service;
    }
    return $arr;
}
function serviceNameField_shortcode()
{
    global $post;
    $service = new Service($post->ID);
    $html = '<input type="hidden" name="service" value="' . $service->getTitle() . '" />';
    return $html;
}
add_shortcode('service_field','serviceNameField_shortcode');
function getImageID($image_url)
{
    global $wpdb;
    $sql = 'SELECT ID FROM ' . $wpdb->prefix . 'posts WHERE guid = "' . $image_url . '"';
    $result = $wpdb->get_results($sql);

    return $result[0]->ID;
}
function breadcrumb()
{
    global $post;
    $post_type = get_post_type($post->ID);
    $page = new Page($post->ID);
    $page_title = $page->getTitle();
    $home_id = getParentPageID();
    $html = '<ul class="presco-breadcrumb">
    <li><a href="' . get_page_link($home_id) . '">Home</a></li>';
        if(!is_archive()) {
            if ($post_type == "service") {
                $service = new Service($post->ID);
                $cat = $service->getCategory();
                $html .= '<li><a href="' . get_page_link(92) . '">Services</a></li>';
                $html .= '<li><a href="' . $cat->slug() . '">' . $cat->getTitle() . '</a></li>';
            }
            if ($post_type == "equipment-hire") {
                $equipment = new Equipment($post->ID);
                $html .= '<li><a href="' . get_page_link(100) . '">Equipment</a></li>';
                $categories = $equipment->getCategories();
                foreach ($categories as $cat) {
                    $html .= '<li><a href="' . $cat->slug() . '">' . $cat->getTitle() . '</a></li>';
                }
            }
            $html .= '<li>' . $page_title . '</li>';
        } else {
            if ($post_type == "equipment-hire") {
                $cate = get_queried_object();
                $category_id = $cate->term_id;
                $parent_id = $cate->parent;
                $html .= '<li><a href="' . get_page_link(100) . '">Equipment</a></li>';
                if($parent_id == 0) {
                    // on parent category
                    $category = new Category($category_id);
                    $html .= '<li>' . $category->getTitle() . '</li>';
                } else {
                    // on a sub category
                    // get parent category
                    $parent = new Category($parent_id);
                    $html .= '<li><a href="' . $parent->slug() . '">' . $parent->getTitle() . '</a></li>';
                    $category = new Category($category_id);
                    $html .= '<li>' . $category->getTitle() . '</li>';
                }
            }
        }
    $html .= '    
    </ul>';
    return $html;
}
add_filter('woocommerce_show_page_title', 'pc_hide_shop_page_title');
function pc_hide_shop_page_title($title) {
    $title = false;
    return $title;
}
function cartMenu()
{
    global $post;
    $page = new Page($post->ID);
    $html = '';
    if($page->isThisPage('environmental_page_id')) {
        $html = '<div class="cart-menu">
            <ul>
                <li><a href="' . get_page_link(770) . '"><span class="fa fa-shopping-cart"></span><span class="items">' . WC()->cart->get_cart_contents_count() . '</span></a></li>
            </ul>
        </div>';
    }
    return $html;
}
function equipmentModule_shortcode()
{
    $arr = get_terms( array(
        'taxonomy' => 'equipment-category',
        'hide_empty' => false,
        'orderby' => 'ID',
        'parent' => 0
    ) );
    $html = '<div class="row justify-content-center services-module">';
    foreach($arr as $object) {
        $category = new Category($object->term_id);
        $html .= '<div class="col-12">
            <h2>' . $category->getTitle() . '</h2>
        </div>';
        foreach (getEquipmentByCategory($category->id()) as $equipment)
        {
            $html .= $equipment->getPanel();
        }
    }
    $html .= '</div>';
    return $html;
}
add_shortcode('equipment','equipmentModule_shortcode');
function getEquipmentByCategory($term_id)
{
    $arr = Array();
    $posts_array = get_posts([
        'post_type' => 'equipment-hire',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'ID',
        'order' => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => 'equipment-category',
                'field' => 'term_id',
                'terms' => $term_id
            )
        )
    ]);
    foreach ($posts_array as $post) {
        $equipment = new Equipment($post);
        $arr[] = $equipment;
    }
    return $arr;
}
function getProductByCategory($term_id)
{
    $arr = Array();
    $posts_array = get_posts([
        'post_type' => 'product',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'ID',
        'order' => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $term_id
            )
        )
    ]);
    foreach ($posts_array as $post) {
        $product = new Product($post);
        $arr[] = $product;
    }
    return $arr;
}
function equipmentNameField_shortcode()
{
    global $post;
    $equipment = new Equipment($post->ID);
    $html = '<input type="hidden" name="equipment" value="' . $equipment->getTitle() . '" />';
    return $html;
}
add_shortcode('equipment_field','equipmentNameField_shortcode');
function hireMegaMenu_shortcode()
{
    $arr = get_terms( array(
        'taxonomy' => 'equipment-category',
        'hide_empty' => false,
        'orderby' => 'ID',
        'parent' => 0
    ) );
    $html = '<ul class="mega-menu">
        <li><a href="' . get_page_link(100) . '">browse all</a></li>';
        // loop through categories
        foreach($arr as $object) {
            $category = new Category($object->term_id);
            $html .= '<li><a href="' . $category->slug() . '">' . $category->getTitle() . '</a>';
            // loop through sub categories
            $arr1 = get_terms( array(
                'taxonomy' => 'equipment-category',
                'hide_empty' => false,
                'orderby' => 'ID',
                'parent' => $category->id()
            ) );
            $html .= '<ul class="sub-menu">';
            foreach($arr1 as $object1) {
                $sub_category = new Category($object1->term_id);
                $html .= '<li><a href="' . $sub_category->slug() . '">' . $sub_category->getTitle() . '</li>';
            }
            $html .= '</ul>';
        }
    $html .= '
    </ul>';
    return $html;
}
add_shortcode('hire_mega_menu','hireMegaMenu_shortcode');
function serviceMegaMenu_shortcode()
{
    $arr = get_terms( array(
        'taxonomy' => 'service-category',
        'hide_empty' => false,
        'orderby' => 'ID',
        'parent' => 0
    ) );
    $html = '<ul class="mega-menu">
        <li><a href="' . get_page_link(92) . '">browse all</a></li>';
    // loop through categories
    foreach($arr as $object) {
        $category = new Category($object->term_id);
        $html .= '<li><a href="' . $category->slug() . '">' . $category->getTitle() . '</a>';
        // loop through services
        $html .= '<ul class="sub-menu">';
        foreach(getServiceByCategory($object->term_id) as $service) {
            $html .= '<li><a href="' . $service->link() . '">' . $service->getTitle() . '</li>';
        }
        $html .= '</ul>';
    }
    $html .= '
    </ul>';
    return $html;
}
add_shortcode('service_mega_menu','serviceMegaMenu_shortcode');
function productMegaMenu_shortcode()
{
    $exclude = array(30);
    $arr = get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'orderby' => 'ID',
        'parent' => 0,
        'exclude' => $exclude
    ) );
    $html = '<ul class="mega-menu">
        <li><a href="' . get_page_link(93) . '">browse all</a></li>';
    // loop through categories
    foreach($arr as $object) {
        $category = new Category($object->term_id);
        $html .= '<li><a href="' . $category->slug() . '">' . $category->getTitle() . '</a>';
        // loop through services
        $html .= '<ul class="sub-menu">';
        foreach(getProductByCategory($object->term_id) as $product) {
            $html .= '<li><a href="' . $product->link() . '">' . $product->getTitle() . '</li>';
        }
        $html .= '</ul>';
    }
    $html .= '
    </ul>';
    return $html;
}
add_shortcode('product_mega_menu','productMegaMenu_shortcode');