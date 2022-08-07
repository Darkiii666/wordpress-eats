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
    public function get_company(){
        return get_post_meta($this->post->ID, 'company-id', true);
    }
    public function set_company($company_id): void
    {
        // TODO Verify if ID exists and is company post type
        if (is_numeric($company_id)) {
            delete_post_meta($this->post->ID, 'company-id');
            update_post_meta($this->post->ID, 'company-id', $company_id);
        } else {
            add_post_meta($this->post->ID, 'company-id', 'null', true);
        }
    }
    public function set_invoice_dates($date_from, $date_to): void
    {
        if (strtotime($date_from) && strtotime($date_to)) {
            // TODO more complex date validation
            delete_post_meta($this->post->ID, 'date-from');
            update_post_meta($this->post->ID, 'date-from', strtotime($date_from));

            delete_post_meta($this->post->ID, 'date-to');
            update_post_meta($this->post->ID, 'date-to', strtotime($date_to));
        }
    }
    public function get_invoice_dates($date_format = "Y/m/d"): array
    {
        $date_from = date($date_format, get_post_meta($this->post->ID, 'date-from', true));
        $date_to = date($date_format, get_post_meta($this->post->ID, 'date-to', true));
        return array(
            'date_from' => $date_from,
            'date_to' => $date_to,
        );
    }
    public function set_invoice_prices($total, $fees, $transfer): void
    {
        if (is_numeric($total) && is_numeric($fees) && is_numeric($transfer)){
            delete_post_meta($this->post->ID, 'price-total');
            update_post_meta($this->post->ID, 'price-total', strtotime($total));

            delete_post_meta($this->post->ID, 'price-fees');
            update_post_meta($this->post->ID, 'price-fees', strtotime($fees));

            delete_post_meta($this->post->ID, 'price-transfer');
            update_post_meta($this->post->ID, 'price-transfer', strtotime($transfer));
        }
    }
    public function get_invoice_prices(): array {
        $price_total = get_post_meta($this->post->ID, 'price-total', true);
        $price_fees = get_post_meta($this->post->ID, 'price-fees', true);
        $price_transfer = get_post_meta($this->post->ID, 'price-transfer', true);
        return array(
            "total" => $price_total,
            "fees" => $price_fees,
            "transfer" => $price_transfer
        );
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