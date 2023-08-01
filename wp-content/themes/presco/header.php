<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
global $post;
$page_id = getParentPageID();
$page = new Page($page_id);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site <?=$page->getPageClass()?>" id="page">
    <section id="header">
        <div class="logo">
            <a href="<?=$page->link()?>"><?=$page->getLogo()?></a>
        </div>
        <div class="container-fluid top-menu-wrapper">
            <div class="row">
                <div class="col-12">
                    <?php wp_nav_menu(
                        array(
                            'theme_location'  => 'parent-menu',
                            'container_class' => 'parent-menu-wrapper',
                            'container_id'    => '',
                            'menu_class'      => '',
                            'fallback_cb'     => '',
                            'menu_id'         => 'parent-menu',
                        )
                    ); ?>
                </div>
            </div>
        </div>
        <div class="btn-container">
            <a href="<?=get_page_link(13)?>" class="btn btn-secondary">return to main presco home <span class="fa fa-angle-right"></span></a>
            <a href="tel:<?=formatPhoneNumber(get_field('phone',13))?>" class="btn btn-primary"><span class="fa fa-phone"></span><?=get_field('phone',13)?></a>
        </div>
        <section id="presco-menu-wrapper-mobile">
            <div class="main-nav wrapper-fluid wrapper-navbar" id="wrapper-navbar">
                <nav class="site-navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
                    <?php wp_nav_menu(
                        array(
                            'theme_location'  => 'primary',
                            'container_class' => 'collapse navbar-collapse navbar-responsive-collapse',
                            'container_id'    => '',
                            'menu_class'      => 'nav navbar-nav',
                            'fallback_cb'     => '',
                            'menu_id'         => 'mobile-menu',
                        )
                    ); ?>
                </nav>
            </div>
        </section>
    </section>
    <section id="presco-menu-wrapper">
        <div class="main-nav wrapper-fluid wrapper-navbar" id="wrapper-navbar">
            <nav class="site-navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => $page->getMenuID(),
                        'container_class' => 'collapse navbar-collapse navbar-responsive-collapse',
                        'menu_class' => 'nav navbar-nav',
                        'fallback_cb' => '',
                        'menu_id' => $page->getMenuID()
                    )
                );
                ?>
            </nav>
        </div>
        <?=cartMenu()?>
    </section>