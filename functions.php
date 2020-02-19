<?php

// stop default js
function load_script()
{
    if (!is_admin()) {
        wp_deregister_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'load_script');

// add all css and js
function add_all_cssandjs()
{
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.2.1.min.js', array(), '3.2.1');
    wp_enqueue_script('mainJs', get_stylesheet_directory_uri().'/src/assets/js/main.js', array('jquery'));

    wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
    wp_enqueue_style('maincss', get_template_directory_uri().'/style.css');
    // $phpDatas = array(
    //     'url' => get_stylesheet_directory_uri(),
    // );
    // wp_localize_script('mainJs', 'phpData', $phpDatas);
    // add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
}
add_action('wp_enqueue_scripts', 'add_all_cssandjs');

function add_favicon()
{
    // echo '<link rel="shortcut icon" href=" '.get_stylesheet_directory_uri().'/src/assets/img/home/favicon.ico" type="image/x-icon" />'."\n";
    // echo '<link rel="apple-touch-icon" href=" '.get_stylesheet_directory_uri().'/src/assets/img/home/apple-touch-icon-180x180.png" type="image/x-icon" />'."\n";
    // echo '<link rel="icon" type="image/png" href="'.get_stylesheet_directory_uri().'/src/assets/img/home/icon-192x192.png" />'."\n";
}
add_action('wp_head', 'add_favicon');

// title tag
add_theme_support('title-tag');
// add image size
add_image_size('sidebar-thumb', 575, 575, true);
add_image_size('large-thumb', 1240, 827, true);
// navigation settings
function twpp_setup_theme()
{
    register_nav_menu('header-navigation', 'Header Navigation');
    register_nav_menu('except-homepage', 'Exept HomePage');
}

add_action('after_setup_theme', 'twpp_setup_theme');

// add class into a tag on nav
function wpse156165_menu_add_class($atts, $item, $args)
{
    $class = 'gray dropdown-item card-link d-block fSize1';
    $atts['class'] = $class;

    return $atts;
}
add_filter('nav_menu_link_attributes', 'wpse156165_menu_add_class', 10, 3);

function thumb_up()
{
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'thumb_up');

function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 150,
        'single_image_width' => 150,

        'product_grid' => array(
            'default_rows' => 3,
            'min_rows' => 2,
            'max_rows' => 8,
            'default_columns' => 4,
            'min_columns' => 2,
            'max_columns' => 5,
        ),
    ));
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');

// hooks
// remove related product on product page
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

// remove sales
add_filter('woocommerce_product_get_sale_price', '__return_empty_string');
add_filter('woocommerce_variation_prices_sale_price', '__return_empty_string');

add_filter('woocommerce_variation_prices_price', 'custom_get_price', 10, 2);
add_filter('woocommerce_product_get_price', 'custom_get_price', 10, 2);

function custom_get_price($price, $product)
{
    if ($product->is_type('variable')) {
        $prices = $product->get_variation_prices();

        return min($prices['regular_price']);
    } else {
        return $product->get_regular_price();
    }
}