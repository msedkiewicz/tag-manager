<?php

// Register custom post types
function tm_post_types() {
    register_post_type('tagmanager', array(
        'supports' => array('title', 'editor', 'excerpt', ),
        'rewrite' => array(
            'slug' => 'blog',
        ),
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Posty typu Tag Manager',
            'add_new_item' => 'Dodaj post',
            'edit_item' => 'Edytuj post',
            'all_items' => 'Lista postów',
            'singular_name' => 'Post typu Tag Manager',
        ),
        'menu_icon' => 'dashicons-editor-code',
    ));
}
// Register the custom post type
add_action('init', 'tm_post_types');