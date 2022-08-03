<?php

namespace wp_eats;
class Invoice
{
    protected $post;
    protected $id;
    private array $statuses;
    static function get_invoice_statuses(): array {
        return array(
            "ongoing" => __("Ongoing", "wp-eats"),
            "pending" => __("Pending", "wp-eats"),
            "verified" => __("Verified", "wp-eats"),
        );
    }
    public function get_invoice_status(): string {
        return get_post_meta($this->post->ID, 'invoice-status', true);
    }
    public function set_invoice_status($status): void
    {
        if (isset($this->statuses[$status])) {
            delete_post_meta($this->post->ID, 'invoice-status');
            update_post_meta($this->post->ID, 'invoice-status', $_REQUEST['invoice-status']);
        } else {
            add_post_meta($this->post->ID, 'invoice-status', 'ongoing', true);
        }
    }

    public function __construct(\WP_Post | int $post) {

        if ($post instanceof \WP_Post) {
            $this->post = $post;
        } else {
            $this->post = get_post($post);
        }
        if ($this->post->post_type == "eats-invoice") {
            $this->statuses = self::get_invoice_statuses();
            $this->id = $post->ID;
        } else {
            return null;
        }
    }
}