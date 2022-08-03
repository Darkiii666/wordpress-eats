<?php
namespace wp_eats;
function customizer_init($wp_customize)
{

    $wp_customize->add_section('wp-eats-settings', array(
        'title' => __('WordPress Eats Settings', "wp-eats"),
        'description' => __('Set settings for plugin'),
        'priority' => 250,
        'capability' => 'edit_theme_options',
    ));

    $wp_customize->add_setting("wp-eats-dashboard-site");
    $wp_customize->add_control("wp-eats-dashboard-site", array(
            "type" => "dropdown-pages",
            "priority" => 10,
            "section" => "wp-eats-settings",
            'label' => __( 'Dashboard Site', "wp-eats" ),
            'description' => __( '', "wp-eats" ),
            'allow_addition' => "true"
        )
    );
    $wp_customize->add_setting("wp-eats-coupons-site");
    $wp_customize->add_control("wp-eats-coupons-site", array(
            "type" => "dropdown-pages",
            "priority" => 10,
            "section" => "wp-eats-settings",
            'label' => __( 'Coupons Site', "wp-eats" ),
            'description' => __( '', "wp-eats" ),
            'allow_addition' => "true"
        )
    );
    $wp_customize->add_setting("wp-eats-invoices-site");
    $wp_customize->add_control("wp-eats-invoices-site", array(
            "type" => "dropdown-pages",
            "priority" => 10,
            "section" => "wp-eats-settings",
            'label' => __( 'Invoices Site', "wp-eats" ),
            'description' => __( '', "wp-eats" ),
            'allow_addition' => "true"
        )
    );
    $wp_customize->add_setting("wp-eats-restaurants-site");
    $wp_customize->add_control("wp-eats-restaurants-site", array(
            "type" => "dropdown-pages",
            "priority" => 10,
            "section" => "wp-eats-settings",
            'label' => __( 'Restaurants', "wp-eats" ),
            'description' => __( '', "wp-eats" ),
            'allow_addition' => "true"
        )
    );
    $wp_customize->add_setting("wp-eats-users-site");
    $wp_customize->add_control("wp-eats-users-site", array(
            "type" => "dropdown-pages",
            "priority" => 10,
            "section" => "wp-eats-settings",
            'label' => __( 'Users', "wp-eats" ),
            'description' => __( '', "wp-eats" ),
            'allow_addition' => "true"
        )
    );
    $wp_customize->add_setting("wp-eats-orders-site");
    $wp_customize->add_control("wp-eats-orders-site", array(
            "type" => "dropdown-pages",
            "priority" => 10,
            "section" => "wp-eats-settings",
            'label' => __( 'Orders', "wp-eats" ),
            'description' => __( '', "wp-eats" ),
            'allow_addition' => "true"
        )
    );


}




function customizer_save()
{

}

add_action('customize_register', 'wp_eats\customizer_init');
add_action('customize_save_after', 'wp_eats\customizer_save');