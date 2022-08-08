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
        wp_enqueue_script('wp-eats-bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', null, WP_EATS_VERSION, true);
        wp_enqueue_script('wp-eats-datepicker-js', 'https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.2.0/dist/js/datepicker-full.min.js', null, WP_EATS_VERSION, true);
        wp_enqueue_script('wp-eats-js', WP_EATS_URL . 'assets/js/script.js', null, WP_EATS_VERSION, true);
        wp_enqueue_style('wp-eats-bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', null, WP_EATS_VERSION);
        wp_enqueue_style('wp-eats-datepicker-css', 'https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.2.0/dist/css/datepicker-bs5.min.css', null, WP_EATS_VERSION);
        wp_enqueue_style('wp-eats-css', WP_EATS_URL . 'assets/css/style.css', null, WP_EATS_VERSION);
    }
    return $template;
}


