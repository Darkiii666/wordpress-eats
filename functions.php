<?php
namespace wp_eats;
function get_image_url($name): string
{
    return plugin_dir_url("wordpress-eats.php") . "assets/img/" . $name;
}