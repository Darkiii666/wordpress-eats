<?php
namespace wp_eats;
function get_image_url($name): string
{
    return WP_Eats::get_image_url($name);
}
function get_main_nav() {
    $endpoints = array(
        "wp-eats-dashboard-site",
        "wp-eats-coupons-site",
        "wp-eats-invoices-site",
        "wp-eats-restaurants-site",
        "wp-eats-users-site",
        "wp-eats-orders-site",
        );
    $pages = array();
    foreach ($endpoints as $endpoint) {
        $page_id = get_theme_mod($endpoint);
        if (is_numeric($page_id)){
            $pages[] = $page_id;
        }
    }
    return $pages;
}