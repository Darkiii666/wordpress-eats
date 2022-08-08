<?php
namespace wp_eats;
function register_image_sizes(): void
{
    add_image_size('company-thumbnail', 40, 40, array(true, true));

}

add_action( 'after_setup_theme', 'wp_eats\register_image_sizes' );