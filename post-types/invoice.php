<?php
namespace wp_eats;


function register_invoice_post_type(): void
{
    $supports = array(
        'title',
    );

    $labels = array(
        'name' => _x('Invoices', 'Post Type General Name', 'wp-eats'),
        'singular_name' => _x('Invoice', 'Post Type Singular Name', 'wp-eats'),
        'menu_name' => __('Invoices', 'wp-eats'),
        'name_admin_bar' => __('Post Type'),
        'archives' => __('Invoices List', "wp-eats"),
        'attributes' => __('Invoices List'),
        'parent_item_colon' => __('Parent Item:'),
        'all_items' => __('All Invoices', 'wp-eats'),
        'add_new_item' => __('Add new Invoice', 'wp-eats'),
        'add_new' => __('Add Invoice', 'wp-eats'),
        'new_item' => __('New Invoice', 'wp-eats'),
        'edit_item' => __('Edit Invoice', 'wp-eats'),
        'update_item' => __('Update Invoice', 'wp-eats'),
        'view_item' => __('View Invoice', 'wp-eats'),
        'view_items' => __('View Invoices', 'wp-eats'),
        'search_items' => __('Search'),
        'not_found' => __('Not Found'),
        'not_found_in_trash' => __('Not found in Trash'),
        'featured_image' => __('Featured Image'),
        'set_featured_image' => __('Set featured image'),
        'remove_featured_image' => __('Remove featured image'),
        'use_featured_image' => __('Use as featured image'),
        'insert_into_item' => __('Insert into item'),
        'uploaded_to_this_item' => __('Uploaded to this item'),
        'items_list' => __('Items list'),
        'items_list_navigation' => __('Items list navigation'),
        'filter_items_list' => __('Filter items list'),
    );
    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'has_archive' => false,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'taxonomies' => array(),
        'rewrite' => array('slug' => __("invoices", "wp-eats")),
        'label' => __('Invoice', "wp-eats"),
        'description' => __('Invoices Description', 'wp-eats'),
        'register_meta_box_cb' => 'wp_eats\invoice_meta_boxes'
    );

    register_post_type('eats-invoice', $args);
}
add_action( 'init', 'wp_eats\register_invoice_post_type' );

function invoice_meta_boxes($post): void
{

    add_meta_box("invoice-status", __("Invoice Status", "wp-eats"), function ($post){
        $invoice = new Invoice($post);
        $statuses = Invoice::get_invoice_statuses();
        $current_status = $invoice->get_invoice_status();
        echo '<select name="invoice-status" id="invoice-status">';
        foreach ($statuses as $status_id => $status_name) {
            $selected = '';
            if ($status_id == $current_status) $selected = ' selected="true"';
            echo '<option value="' . esc_attr($status_id) .'"' . $selected .'>' . $status_name . '</option>';
        }

        echo '</select>';

    }, null, 'side');
    add_meta_box("invoice-sender", __("Invoice Sender", "wp-eats"), function ($post){
        $invoice = new Invoice($post);
        $companies = WP_Eats::get_companies();
        $current_company = $invoice->get_company();
        echo '<select name="invoice-sender" id="invoice-sender">';
            echo '<option value="">' . __("Select Company", "wp-eats") . '</option>';
            foreach ($companies as $company) {
                $selected = '';
                if ($current_company == $company->ID) $selected = ' selected="true"';
                echo '<option value="' . esc_attr($company->ID) .'"' . $selected .'>' . $company->post_title . '</option>';
            }
        echo '</select>';
    }, null, 'side');
    add_meta_box("invoice-dates", __("Dates", "wp-eats"), function ($post){
        $invoice = new Invoice($post);
        $dates = $invoice->get_invoice_dates('Y-m-d');
        echo '<p><label>'. __("Start Date", "wp-eats") .': <input type="date" name="start-date" value=' . $dates['start_date'] .'></label></p>';
        echo '<p><label>'. __("End Date", "wp-eats") .': <input type="date" name="end-date" value="'. $dates['end_date'] .'"></label></p>';
    }, null);

    add_meta_box("invoice-fees", __("Fees", "wp-eats"), function ($post){
        $invoice = new Invoice($post);
        $prices = $invoice->get_invoice_prices();
        echo '<p><label>'. __("Total", "wp-eats") .': <input type="text" name="price-total" value="'. $prices['total'] .'"></label></p>';
        echo '<p><label>'. __("Fees", "wp-eats") .': <input type="text" name="price-fees" value="'. $prices['fees'] .'"></label></p>';
        echo '<p><label>'. __("Transfer", "wp-eats") .': <input type="text" name="price-transfer" value="'. $prices['transfer'] .'"></label></p>';
        echo '<p><label>'. __("Orders", "wp-eats") .': <input type="text" name="orders" value="'. '' .'"></label></p>';
    }, null);
}
add_action("save_post_eats-invoice", function ($post_id, $post, $update){
    $invoice = new Invoice($post);
    $invoice->set_invoice_status($_REQUEST['invoice-status']);
    $invoice->set_company($_REQUEST['invoice-sender']);
    $invoice->set_invoice_dates($_REQUEST['start-date'], $_REQUEST['end-date']);
    $invoice->set_invoice_prices($_REQUEST['price-total'], $_REQUEST['price-fees'], $_REQUEST['price-transfer']);
}, 10, 3);