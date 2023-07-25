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
        'show_in_admin_bar' => true
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
        'post', // Change 'post' to 'page' if you want to associate tags with pages instead
        'normal',
        'default'
    );
}

// Render the metabox content
function tm_render_javascript_tags_metabox($post) {
    // Add nonce for security
    wp_nonce_field('tm_javascript_tags_metabox', 'tm_javascript_tags_metabox_nonce');

    // Get existing JavaScript tags for the post
    $tags = get_post_meta($post->ID, 'tm_javascript_tags', true);

    // Display the tags input
    ?>
    <label for="tm_javascript_tags">Add JavaScript Tags:</label><br>
    <textarea name="tm_javascript_tags" id="tm_javascript_tags" rows="6" cols="60"><?php echo esc_textarea($tags); ?></textarea><br>
    <?php
}

// Save the selected JavaScript tags
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
}

// Add metabox and save functionality
add_action('add_meta_boxes_post', 'tm_add_javascript_tags_metabox');
add_action('save_post', 'tm_save_javascript_tags_metabox');

// Function to display JavaScript tags for a specific post/page
function tm_display_javascript_tags($post_id) {
    $tags = get_post_meta($post_id, 'tm_javascript_tags', true);

    if (!empty($tags)) {
        echo '<!-- Custom JavaScript Tags -->' . PHP_EOL;
        echo '<script type="text/javascript">' . PHP_EOL;
        echo $tags . PHP_EOL;
        echo '</script>' . PHP_EOL;
    }
}
