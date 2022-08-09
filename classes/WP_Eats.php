<?php

namespace wp_eats;

class WP_Eats
{
    static function get_currency(): string {
        return "$";
    }
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
    static function get_invoice_list($args = array()): \WP_Query
    {
        $defaults = array(
            "posts_per_page" => 15,
        );

        $args = wp_parse_args($args, $defaults);
        // Overwrite post type
        $args["post_type"] = "eats-invoice";
        return new \WP_Query($args);
    }
    static function get_companies(): array{
        $companies = array();

        $companies_query = new \WP_Query(array(
            "post_type" => "eats-company",
            "posts_per_page" => -1,
        ));
        if ($companies_query->have_posts()) $companies = $companies_query->posts;
        return $companies;

    }
    static function parse_invoices_list_request($request): array {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array();
        $args['posts_per_page'] = 12;
        $args['paged'] = $paged;
        $args['meta_query'] = array(
            "relation" => "AND"
        );
        if (!empty($request['invoice-status']) && $request['invoice-status'] != "all") {
            $args['meta_query']['invoice_status_clause'] = array(
                'key' => 'invoice-status',
                'value' => $request['invoice-status'],
            );
        }
        if (!empty($request['search-name'])) {
            $args['s'] = $request['search-name'];
        }
        /*
        if (!empty($request['date-from']) && !empty($request['date-to'])) {
            if (strtotime($request['date-from']) && strtotime($request['date-to'])) {
                $date_from = strtotime($request['date-from']);
                $date_to = strtotime($request['date-to']);
                $args['meta_query']['date_clause'] = array(
                    'key' => 'start-date',
                    'type'    => 'NUMERIC',
                    'compare' => 'BETWEEN',
                    'value' => array($date_from, $date_to),
                );
            }

        }*/

        return $args;
    }
    static function get_format_date(): string {
        //TODO options for setting custom format
        return "Y/m/d";
    }
    static function format_price(string $price): string {
        return $price . self::get_currency();
    }
    static function parse_invoices_action($request): void
    {
        foreach ($_REQUEST as $key => $value) {
            if (empty($value)) unset($_REQUEST['key']);
        }
        if (isset($request['action'])) {
            if ($request['action'] == "mark-as-paid") {
                if (/*wp_verify_nonce($request["wp_eats_nonce"], 'mark-as-paid') &&*/ @is_array($request['posts'])) {
                    foreach ($request['posts'] as $post_id) {
                        $invoice = new Invoice($post_id);
                        $invoice->set_invoice_status('paid');
                    }
                };
            }

        }
    }
}