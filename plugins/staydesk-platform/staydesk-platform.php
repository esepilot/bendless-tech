<?php
/**
 * Plugin Name: StayDesk Hotel Platform
 * Plugin URI: https://bendlesstech.com/staydesk
 * Description: Complete hotel management SaaS platform with booking engine, payment tracking, and multi-tenant architecture
 * Version: 1.0.0
 * Author: BendlessTech
 * Author URI: https://bendlesstech.com
 * License: GPL v2 or later
 * Text Domain: staydesk-platform
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Plugin version and constants
define('STAYDESK_VERSION', '1.0.0');
define('STAYDESK_PATH', plugin_dir_path(__FILE__));
define('STAYDESK_URL', plugin_dir_url(__FILE__));

// Pricing constants
define('STAYDESK_MONTHLY_PRICE', 49900);  // ₦49,900
define('STAYDESK_YEARLY_PRICE', 598800);  // ₦598,800
define('STAYDESK_YEARLY_DISCOUNT', 0.10); // 10% discount for first 10 hotels

// Activation hook
function activate_staydesk_platform() {
    require_once STAYDESK_PATH . 'includes/class-activator.php';
    StayDesk_Activator::activate();
}
register_activation_hook(__FILE__, 'activate_staydesk_platform');

// Deactivation hook
function deactivate_staydesk_platform() {
    require_once STAYDESK_PATH . 'includes/class-deactivator.php';
    StayDesk_Deactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_staydesk_platform');

// Include required files
require_once STAYDESK_PATH . 'includes/class-hotel.php';
require_once STAYDESK_PATH . 'includes/class-booking.php';
require_once STAYDESK_PATH . 'includes/class-payment.php';
require_once STAYDESK_PATH . 'includes/class-subscription.php';
require_once STAYDESK_PATH . 'includes/class-paystack.php';
require_once STAYDESK_PATH . 'includes/class-dashboard.php';
require_once STAYDESK_PATH . 'includes/class-api.php';

// Initialize plugin
function run_staydesk_platform() {
    // Enqueue scripts and styles
    add_action('wp_enqueue_scripts', 'staydesk_enqueue_assets');
    
    // Register custom rewrite rules
    add_action('init', 'staydesk_register_rewrites');
    
    // Template routing
    add_filter('template_include', 'staydesk_template_router');
    
    // Initialize hotel management
    if (is_user_logged_in()) {
        $hotel = new StayDesk_Hotel();
    }
    
    // Initialize dashboard if on dashboard pages
    if (is_user_logged_in() && isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/staydesk/dashboard') !== false) {
        $dashboard = new StayDesk_Dashboard();
    }
    
    // Register AJAX handlers
    add_action('wp_ajax_staydesk_register_user', 'staydesk_handle_registration');
    add_action('wp_ajax_nopriv_staydesk_register_user', 'staydesk_handle_registration');
}
add_action('plugins_loaded', 'run_staydesk_platform');

// Handle user registration via AJAX
function staydesk_handle_registration() {
    check_ajax_referer('staydesk_register', 'nonce');
    
    $data = $_POST['data'];
    
    // Create WordPress user
    $username = sanitize_user($data['username']);
    $email = sanitize_email($data['email']);
    $password = $data['password'];
    
    $user_id = wp_create_user($username, $password, $email);
    
    if (is_wp_error($user_id)) {
        wp_send_json_error(array('message' => $user_id->get_error_message()));
    }
    
    // Log user in
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);
    
    // Create hotel
    $hotel = new StayDesk_Hotel();
    $hotel_id = $hotel->create_hotel($data);
    
    if ($hotel_id) {
        wp_send_json_success(array('hotel_id' => $hotel_id, 'user_id' => $user_id));
    } else {
        wp_send_json_error(array('message' => 'Failed to create hotel'));
    }
}

// Register rewrite rules
function staydesk_register_rewrites() {
    add_rewrite_rule('^staydesk/?$', 'index.php?staydesk_page=landing', 'top');
    add_rewrite_rule('^staydesk/register/?$', 'index.php?staydesk_page=register', 'top');
    add_rewrite_rule('^staydesk/login/?$', 'index.php?staydesk_page=login', 'top');
    add_rewrite_rule('^staydesk/dashboard/?$', 'index.php?staydesk_page=dashboard', 'top');
    add_rewrite_rule('^staydesk/dashboard/([^/]+)/?$', 'index.php?staydesk_page=dashboard&staydesk_section=$matches[1]', 'top');
    
    add_rewrite_tag('%staydesk_page%', '([^&]+)');
    add_rewrite_tag('%staydesk_section%', '([^&]+)');
}

// Template router
function staydesk_template_router($template) {
    $staydesk_page = get_query_var('staydesk_page');
    
    if ($staydesk_page) {
        $templates = array(
            'landing' => 'templates/page-staydesk-landing.php',
            'register' => 'templates/page-register.php',
            'login' => 'templates/page-login.php',
            'dashboard' => 'templates/dashboard/dashboard-router.php',
        );
        
        if (isset($templates[$staydesk_page])) {
            $custom_template = STAYDESK_PATH . $templates[$staydesk_page];
            if (file_exists($custom_template)) {
                return $custom_template;
            }
        }
    }
    
    return $template;
}

// Enqueue assets
function staydesk_enqueue_assets() {
    wp_enqueue_style('staydesk-style', STAYDESK_URL . 'assets/css/style.css', array(), STAYDESK_VERSION);
    wp_enqueue_script('staydesk-script', STAYDESK_URL . 'assets/js/script.js', array('jquery'), STAYDESK_VERSION, true);
    
    // Localize script for AJAX
    wp_localize_script('staydesk-script', 'staydeskAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('staydesk_nonce'),
    ));
}
