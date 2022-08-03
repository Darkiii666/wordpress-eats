<?php
namespace wp_eats;
function wp_eats_customizer($wp_customize)
{

    $wp_customize->add_section('wp-eats-settings', array(
        'title' => __('WordPress Eats Settings', "wp-eats"),
        'description' => __('Set settings for plugin'),
        'priority' => 250,
        'capability' => 'edit_theme_options',
    ));


    $wp_customize->add_setting("wp-eats-invoices-site");
    $wp_customize->add_control("wp-eats-invoices-site", array(
            "type" => "dropdown-pages",
            "priority" => 10,
            "section" => "wp-eats-settings",
            'label' => __( 'Site with Invoices', "wp-eats" ),
            'description' => __( 'Where list with invoices should be displayed', "wp-eats" ),
            'allow_addition' => "true"
        )
    );

}




function wp_eats_customizer_save()
{

}

add_action('customize_register', 'wp_eats_customizer');
add_action('customize_save_after', 'wp_eats_customizer_save');