<?php
namespace wp_eats;


function register_company_post_type(): void
{
    $supports = array(
        'title',
        'editor',
        'thumbnail',
        'excerpt',
    );

    $labels = array(
        'name' => _x('Companies', 'Post Type General Name', 'wp-eats'),
        'singular_name' => _x('Company', 'Post Type Singular Name', 'wp-eats'),
        'menu_name' => __('Companies', 'wp-eats'),
        'name_admin_bar' => __('Post Type'),
        'archives' => __('Companies List', "wp-eats"),
        'attributes' => __('Companies List'),
        'parent_item_colon' => __('Parent Item:'),
        'all_items' => __('All Companies', 'wp-eats'),
        'add_new_item' => __('Add new Company', 'wp-eats'),
        'add_new' => __('Add Company', 'wp-eats'),
        'new_item' => __('New Company', 'wp-eats'),
        'edit_item' => __('Edit Company', 'wp-eats'),
        'update_item' => __('Update Company', 'wp-eats'),
        'view_item' => __('View Company', 'wp-eats'),
        'view_items' => __('View Companies', 'wp-eats'),
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
        'rewrite' => array('slug' => __("Companies", "wp-eats")),
        'label' => __('Company', "wp-eats"),
        'description' => __('Companies Description', 'wp-eats'),
        'register_meta_box_cb' => 'wp_eats\Company_meta_boxes'
    );

    register_post_type('eats-company', $args);
}
add_action( 'init', 'wp_eats\register_company_post_type' );

function company_meta_boxes($post): void
{

}
add_action("save_post_eats-Company", function ($post_id, $post, $update){

}, 10, 3);