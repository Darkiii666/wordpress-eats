<?php

namespace wp_eats;
class Invoice
{
    protected \WP_Post|null $post;
    public int $ID;
    private array $statuses;
    public string $status_name;
    public string $status_code;
    static function get_invoice_statuses(): array {
        return array(
            "ongoing" => __("Ongoing", "wp-eats"),
            "pending" => __("Pending", "wp-eats"),
            "verified" => __("Verified", "wp-eats"),
        );
    }
    public function get_invoice_status(): string {
        return $this->status_code;
    }
    public function get_invoice_status_name(): string {
        return $this->status_name;
    }
    public function set_invoice_status($status): void
    {
        if (isset($this->statuses[$status])) {
            delete_post_meta($this->post->ID, 'invoice-status');
            update_post_meta($this->post->ID, 'invoice-status', $status);
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
            $this->ID = $post->ID;
            $this->status_code = get_post_meta($this->post->ID, 'invoice-status', true);
            if (empty($this->status_code)) {
                $this->status_code = array_key_first($this->statuses);
                $this->set_invoice_status($this->status_code);
            }
            $this->status_name = $this->statuses[$this->status_code];
        } else {
            return null;
        }
    }
}