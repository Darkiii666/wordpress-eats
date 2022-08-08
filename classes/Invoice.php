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
    public function set_invoice_dates($start_date, $end_date): void
    {
        if (strtotime($start_date) && strtotime($end_date)) {
            // TODO more complex date validation
            delete_post_meta($this->post->ID, 'start-date');
            update_post_meta($this->post->ID, 'start-date', strtotime($start_date));

            delete_post_meta($this->post->ID, 'end-date');
            update_post_meta($this->post->ID, 'end-date', strtotime($end_date));
        }
    }
    public function get_invoice_dates($date_format = "Y/m/d"): array
    {
        $start_date = get_post_meta($this->post->ID, 'start-date', true);
        if (is_numeric($start_date)) $start_date = date($date_format, $start_date);
        $end_date = get_post_meta($this->post->ID, 'end-date', true);
        if (is_numeric($end_date)) $end_date = date($date_format, $end_date);
        return array(
            'start_date' => $start_date,
            'end_date' => $end_date,
        );
    }
    public function set_invoice_prices($total, $fees, $transfer): void
    {

        if (is_numeric($total) && is_numeric($fees) && is_numeric($transfer)){

            delete_post_meta($this->post->ID, 'price-total');
            update_post_meta($this->post->ID, 'price-total', $total);

            delete_post_meta($this->post->ID, 'price-fees');
            update_post_meta($this->post->ID, 'price-fees', $fees);

            delete_post_meta($this->post->ID, 'price-transfer');
            update_post_meta($this->post->ID, 'price-transfer', $transfer);
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