<?php

namespace wp_eats;
class Invoice
{
    private $post;
    public function __construct($post) {

        if ($post instanceof \WP_Post) {
            $this->post = $post;
        } else {
            $this->post = get_post($post);
        }
        if ($this->post->post_type == "eats-invoice") {

        }
    }
}