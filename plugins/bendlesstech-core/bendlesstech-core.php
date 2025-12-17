<?php
/**
 * Plugin Name: BendlessTech Core
 * Plugin URI: https://bendlesstech.com
 * Description: Core plugin for BendlessTech platform - handles services, lead capture, and marketing pages
 * Version: 1.0.0
 * Author: BendlessTech
 * Author URI: https://bendlesstech.com
 * License: GPL v2 or later
 * Text Domain: bendlesstech-core
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Plugin version
define('BENDLESSTECH_CORE_VERSION', '1.0.0');
define('BENDLESSTECH_CORE_PATH', plugin_dir_path(__FILE__));
define('BENDLESSTECH_CORE_URL', plugin_dir_url(__FILE__));

// Activation hook
function activate_bendlesstech_core() {
    require_once BENDLESSTECH_CORE_PATH . 'includes/class-activator.php';
    BendlessTech_Core_Activator::activate();
}
register_activation_hook(__FILE__, 'activate_bendlesstech_core');

// Deactivation hook
function deactivate_bendlesstech_core() {
    require_once BENDLESSTECH_CORE_PATH . 'includes/class-deactivator.php';
    BendlessTech_Core_Deactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_bendlesstech_core');

// Include required files
require_once BENDLESSTECH_CORE_PATH . 'includes/class-forms.php';
require_once BENDLESSTECH_CORE_PATH . 'includes/class-admin.php';
require_once BENDLESSTECH_CORE_PATH . 'includes/class-whatsapp.php';
require_once BENDLESSTECH_CORE_PATH . 'includes/class-email.php';
require_once BENDLESSTECH_CORE_PATH . 'includes/class-shortcodes.php';

// Initialize plugin
function run_bendlesstech_core() {
    // Register custom post types
    add_action('init', 'bendlesstech_register_post_types');
    
    // Initialize forms
    $forms = new BendlessTech_Forms();
    
    // Initialize WhatsApp button
    $whatsapp = new BendlessTech_WhatsApp();
    
    // Initialize shortcodes
    $shortcodes = new BendlessTech_Shortcodes();
    
    // Initialize admin if user has capability
    if (is_admin() || (isset($_GET['page']) && $_GET['page'] === 'bendlesstech-admin')) {
        $admin = new BendlessTech_Admin();
    }
    
    // Enqueue scripts and styles
    add_action('wp_enqueue_scripts', 'bendlesstech_enqueue_assets');
    
    // Register page templates
    add_filter('template_include', 'bendlesstech_page_template');
}
add_action('plugins_loaded', 'run_bendlesstech_core');

// Register custom post types
function bendlesstech_register_post_types() {
    // Services post type
    register_post_type('bt_service', array(
        'labels' => array(
            'name' => 'Services',
            'singular_name' => 'Service',
            'add_new' => 'Add New Service',
            'add_new_item' => 'Add New Service',
            'edit_item' => 'Edit Service',
            'new_item' => 'New Service',
            'view_item' => 'View Service',
            'search_items' => 'Search Services',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-admin-tools',
    ));
    
    // Testimonials post type
    register_post_type('bt_testimonial', array(
        'labels' => array(
            'name' => 'Testimonials',
            'singular_name' => 'Testimonial',
            'add_new' => 'Add New Testimonial',
        ),
        'public' => true,
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-star-filled',
    ));
    
    // FAQs post type
    register_post_type('bt_faq', array(
        'labels' => array(
            'name' => 'FAQs',
            'singular_name' => 'FAQ',
            'add_new' => 'Add New FAQ',
        ),
        'public' => true,
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-editor-help',
    ));
}

// Enqueue assets
function bendlesstech_enqueue_assets() {
    wp_enqueue_style('bendlesstech-core-style', BENDLESSTECH_CORE_URL . 'assets/css/style.css', array(), BENDLESSTECH_CORE_VERSION);
    wp_enqueue_script('bendlesstech-core-script', BENDLESSTECH_CORE_URL . 'assets/js/script.js', array('jquery'), BENDLESSTECH_CORE_VERSION, true);
    
    // Localize script for AJAX
    wp_localize_script('bendlesstech-core-script', 'bendlesstechAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('bendlesstech_nonce'),
    ));
}

// Template routing
function bendlesstech_page_template($template) {
    if (is_page()) {
        $slug = get_post_field('post_name', get_post());
        $custom_templates = array(
            'home' => 'templates/page-home.php',
            'custom-website-development' => 'templates/page-website-service.php',
            'secure-inventory-system' => 'templates/page-inventory-service.php',
            'about' => 'templates/page-about.php',
            'contact' => 'templates/page-contact.php',
            'privacy-policy' => 'templates/page-privacy.php',
            'terms-of-service' => 'templates/page-terms.php',
        );
        
        if (isset($custom_templates[$slug])) {
            $custom_template = BENDLESSTECH_CORE_PATH . $custom_templates[$slug];
            if (file_exists($custom_template)) {
                return $custom_template;
            }
        }
    }
    
    return $template;
}
