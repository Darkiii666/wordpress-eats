<?php

namespace wp_eats;

class WP_Eats
{
    static function get_endpoints(): array {
        return array(
            "wp-eats-dashboard-site",
            "wp-eats-coupons-site",
            "wp-eats-invoices-site",
            "wp-eats-restaurants-site",
            "wp-eats-users-site",
            "wp-eats-orders-site",
        );
    }
    static function get_image_url($name): string
    {
        return WP_EATS_URL . "assets/img/" . $name;
    }
    static function get_main_nav(): array {
        $endpoints = self::get_endpoints();
        $pages = array();
        foreach ($endpoints as $endpoint) {
            $page_id = get_theme_mod($endpoint);
            if (is_numeric($page_id)){
                $pages[] = $page_id;
            }
        }
        return $pages;
    }
}