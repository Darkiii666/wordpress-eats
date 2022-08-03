<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />


    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <title><?php wp_title() ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class('wp-eats-body'); ?>>
<?php wp_body_open(); ?>

<header class="wp-eats__header">
    <div class="wp-eats__logo">
        <img src="<?php echo wp_eats\get_image_url("logo.svg")?>" alt="<?php echo get_bloginfo('name')?>">
    </div>
    <nav class="wp-eats__menu">
        <?php $nav_links = \wp_eats\WP_Eats::get_main_nav();
        foreach ($nav_links as $nav_link):?>
            <?php (get_the_ID() == $nav_link) ? $current = " wp-eats__nav-item--current" : $current = "";?>
            <a href="<?php echo get_permalink($nav_link)?>" class="wp-eats__nav-item<?php echo $current;?>"><?php echo get_the_title($nav_link)?></a>
        <?php endforeach;?>
    </nav>
</header>