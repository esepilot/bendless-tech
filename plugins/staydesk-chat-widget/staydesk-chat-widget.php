<?php
/**
 * Plugin Name: StayDesk Chat Widget
 * Plugin URI: https://bendlesstech.com/staydesk/widget
 * Description: Bilingual chat widget (English + Nigerian Pidgin) for hotels - handles bookings, enquiries, and refunds
 * Version: 1.0.0
 * Author: BendlessTech
 * Author URI: https://bendlesstech.com
 * License: GPL v2 or later
 * Text Domain: staydesk-widget
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Plugin constants
define('STAYDESK_WIDGET_VERSION', '1.0.0');
define('STAYDESK_WIDGET_PATH', plugin_dir_path(__FILE__));
define('STAYDESK_WIDGET_URL', plugin_dir_url(__FILE__));

// Include required files
require_once STAYDESK_WIDGET_PATH . 'includes/class-widget.php';
require_once STAYDESK_WIDGET_PATH . 'includes/class-responses.php';
require_once STAYDESK_WIDGET_PATH . 'includes/class-language.php';
require_once STAYDESK_WIDGET_PATH . 'includes/class-booking-handler.php';

// Initialize plugin
function run_staydesk_widget() {
    // Initialize widget handler
    $widget = new StayDesk_Widget();
    
    // Register AJAX endpoints
    add_action('wp_ajax_staydesk_widget_chat', array($widget, 'handle_chat_message'));
    add_action('wp_ajax_nopriv_staydesk_widget_chat', array($widget, 'handle_chat_message'));
    
    // Register widget embed endpoint
    add_action('template_redirect', 'staydesk_widget_embed');
}
add_action('plugins_loaded', 'run_staydesk_widget');

// Widget embed endpoint
function staydesk_widget_embed() {
    if (isset($_GET['staydesk_widget']) && isset($_GET['hotel_id'])) {
        $hotel_id = sanitize_text_field($_GET['hotel_id']);
        header('Content-Type: application/javascript');
        include STAYDESK_WIDGET_PATH . 'assets/js/widget-embed.js';
        exit;
    }
}

// REST API for widget
add_action('rest_api_init', function() {
    register_rest_route('staydesk-widget/v1', '/chat', array(
        'methods' => 'POST',
        'callback' => 'staydesk_widget_handle_message',
        'permission_callback' => '__return_true',
    ));
    
    register_rest_route('staydesk-widget/v1', '/widget-config/(?P<hotel_id>[0-9]+)', array(
        'methods' => 'GET',
        'callback' => 'staydesk_widget_get_config',
        'permission_callback' => '__return_true',
    ));
});

function staydesk_widget_handle_message($request) {
    $widget = new StayDesk_Widget();
    $params = $request->get_json_params();
    
    $hotel_id = intval($params['hotel_id']);
    $message = sanitize_text_field($params['message']);
    $language = sanitize_text_field($params['language'] ?? 'english');
    $session_id = sanitize_text_field($params['session_id'] ?? '');
    
    $response = $widget->process_message($hotel_id, $message, $language, $session_id);
    
    return rest_ensure_response($response);
}

function staydesk_widget_get_config($request) {
    global $wpdb;
    
    $hotel_id = intval($request['hotel_id']);
    
    $hotel = $wpdb->get_row($wpdb->prepare(
        "SELECT hotel_name, hotel_slug FROM {$wpdb->prefix}staydesk_hotels WHERE id = %d AND status = 'active'",
        $hotel_id
    ));
    
    if (!$hotel) {
        return new WP_Error('not_found', 'Hotel not found', array('status' => 404));
    }
    
    return rest_ensure_response(array(
        'hotel_id' => $hotel_id,
        'hotel_name' => $hotel->hotel_name,
        'hotel_slug' => $hotel->hotel_slug,
        'api_url' => rest_url('staydesk-widget/v1/chat'),
    ));
}
