<?php
namespace wp_eats;
add_filter("page_template", "wp_eats\override_template", 1, 1);

function override_template($template){
    global $post;
    $load_assets = false;
    if (get_theme_mod('wp-eats-dashboard-site') == $post->ID) {
        $load_assets = true;
        $template = WP_EATS_DIR . '/templates/dashboard.php';
    } else if (get_theme_mod('wp-eats-coupons-site') == $post->ID) {
        $load_assets = true;
        $template = WP_EATS_DIR . '/templates/coupons.php';
    } else if (get_theme_mod('wp-eats-invoices-site') == $post->ID) {
        $load_assets = true;
        $template = WP_EATS_DIR . '/templates/invoices.php';
    } else if (get_theme_mod('wp-eats-restaurants-site') == $post->ID) {
        $load_assets = true;
        $template = WP_EATS_DIR . '/templates/restaurants.php';
    } else if (get_theme_mod('wp-eats-users-site') == $post->ID) {
        $load_assets = true;
        $template = WP_EATS_DIR . '/templates/users.php';
    } else if (get_theme_mod('wp-eats-orders-site') == $post->ID) {
        $load_assets = true;
        $template = WP_EATS_DIR . '/templates/orders.php';
    }

    if($load_assets) {
        wp_enqueue_script('wp-eats-js', 'da');
        wp_enqueue_style('wp-eats-css', WP_EATS_URL . 'assets/css/style.css', null, WP_EATS_VERSION);
    }
    return $template;
}


