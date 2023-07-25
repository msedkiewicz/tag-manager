<?php

// Register custom post types
function tm_custom_post_type() {
    $labels = array(
        'name' => 'Tagi',
        'singular_name' => 'Tag',
        'menu_name' => 'Tagi',
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'show_in_admin_bar' => true,
        'rewrite' => array('slug' => 'javascript-tags')
    );

    register_post_type('tag', $args);
}
// Register the custom post type
add_action('init', 'tm_custom_post_type');

// Add metabox to the custom post type editor page
function tm_add_javascript_tags_metabox() {
    add_meta_box(
        'tm_javascript_tags_metabox',
        'JavaScript Tags for Your Post/Page',
        'tm_render_javascript_tags_metabox',
        'javascript-tags', // Change 'javascript_tag' to your custom post type slug
        'normal',
        'default'
    );
}

// Render the metabox content
function tm_render_javascript_tags_metabox($post) {
    // Add nonce for security
    wp_nonce_field('tm_javascript_tags_metabox', 'tm_javascript_tags_metabox_nonce');

    // Get associated posts/pages for the tag
    $associated_items = get_post_meta($post->ID, 'tm_associated_items', true);
    if (!is_array($associated_items)) {
        $associated_items = array();
    }

    // Display the checkboxes for selecting posts/pages
    $args = array(
        'post_type' => array('post', 'page'),
        'posts_per_page' => -1,
    );
    $query = new WP_Query($args);

    echo '<label>Select Posts/Pages to Associate with this JavaScript Tag:</label><br>';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $item_id = get_the_ID();
            $checked = in_array($item_id, $associated_items) ? 'checked' : '';
            echo '<input type="checkbox" name="tm_associated_items[]" value="' . $item_id . '" ' . $checked . '> ';
            echo get_the_title() . '<br>';
        }
        wp_reset_postdata();
    }
}

// Save the selected JavaScript tags and associated items
function tm_save_javascript_tags_metabox($post_id) {
    // Check if nonce is set
    if (!isset($_POST['tm_javascript_tags_metabox_nonce'])) {
        return;
    }

    // Verify nonce
    if (!wp_verify_nonce($_POST['tm_javascript_tags_metabox_nonce'], 'tm_javascript_tags_metabox')) {
        return;
    }

    // Check if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save JavaScript tags
    if (isset($_POST['tm_javascript_tags'])) {
        $tags = sanitize_textarea_field($_POST['tm_javascript_tags']);
        update_post_meta($post_id, 'tm_javascript_tags', $tags);
    }

    // Save associated items (posts/pages)
    if (isset($_POST['tm_associated_items'])) {
        $associated_items = array_map('intval', $_POST['tm_associated_items']);
        update_post_meta($post_id, 'tm_associated_items', $associated_items);
    } else {
        delete_post_meta($post_id, 'tm_associated_items');
    }
}

// Add metabox and save functionality
add_action('add_meta_boxes_post', 'tm_add_javascript_tags_metabox');
add_action('save_post', 'tm_save_javascript_tags_metabox');

// Function to get JavaScript tags for a specific post/page
function tm_get_javascript_tags($post_id) {
    return get_post_meta($post_id, 'tm_javascript_tags', true);
}


// Output the saved associated items for debugging
add_action('edit_form_after_title', 'tm_debug_associated_items');
function tm_debug_associated_items() {
    global $post;
    if ($post->post_type === 'tag') {
        $associated_items = get_post_meta($post->ID, 'tm_associated_items', true);
        echo '<pre>Associated Items: ';
        print_r($associated_items);
        echo '</pre>';
    }
}
