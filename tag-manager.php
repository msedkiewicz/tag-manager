<?php
/**
 * Plugin Name: Marketing Tag Manager
 * Description: Tag manager plugin (not only) for Marketing team!
 * Version: 1.0.0
 * Requires at least: 6.2
 * Requires PHP: 8.0
 * Author: Lena Sędkiewicz
 * Author URI: https://msedkiewicz.pl/
 * License: GPLv2 or later
 * Text Domain: tagmanager
 * Domain Path:  /languages
*/

if( !defined('ABSPATH') ){
    die('Go and watch LOTR!');
};

if( !class_exists('TagManagerMsedkiewicz')) {
    class TagManagerMsedkiewicz {
        // Constructor method to initialize the plugin
        public function __construct() {
            // Add activation and deactivation hooks
            register_activation_hook(__FILE__, array($this, 'plugin_activation'));
            register_deactivation_hook(__FILE__, array($this, 'plugin_deactivation'));

            // Run database cleanup on uninstall
            register_uninstall_hook(__FILE__, array(__CLASS__, 'plugin_uninstall'));
        }

        // Activation hook callback
        public function plugin_activation() {
            // Code to be executed upon activation.
            // For example, set default options or perform setup tasks.
            add_option('your_plugin_option', 'default_value');
        }

        // Deactivation hook callback
        public function plugin_deactivation() {
            // Code to be executed upon deactivation.
            // For example, remove any temporary data or deactivate features.
            delete_option('your_plugin_option');
        }

        // Uninstall hook static callback
        public static function plugin_uninstall() {
            // Code to be executed upon uninstallation.
            // For example, remove any custom database tables or options.
            delete_option('your_plugin_option');
            // Additional cleanup tasks can be done here as needed.
        }
    }
    new TagManagerMsedkiewicz;
}