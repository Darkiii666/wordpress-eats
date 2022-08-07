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
    static function get_invoice_list($args = array()): array|bool
    {
        $defaults = array(
            "posts_per_page" => 15,
        );

        $args = wp_parse_args($args, $defaults);
        // Overwrite post type
        $args["post_type"] = "eats-invoice";
        $invoice_query = new \WP_Query($args);

        if ($invoice_query->have_posts()) return $invoice_query->posts;
        else return false;
    }
}