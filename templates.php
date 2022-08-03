<?php
namespace wp_eats;
add_filter("page_template", "wp_eats\override_template", 1, 1);

function override_template($template){
    global $post;
    $invoices_list_id = get_theme_mod('wp-eats-invoices-site');

    if ($invoices_list_id == $post->ID) {
        $template = WP_EATS_DIR . '/templates/invoice-list.php';
    }
    return $template;
}


