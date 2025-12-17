<?php
/**
 * Dashboard Router - Routes to different dashboard sections
 */

// Ensure user is logged in
if (!is_user_logged_in()) {
    wp_redirect(site_url('/staydesk/login'));
    exit;
}

$section = get_query_var('staydesk_section', 'main');

// Include the appropriate dashboard template
$templates = array(
    'main' => 'dashboard-main.php',
    'bookings' => 'dashboard-bookings.php',
    'rooms' => 'dashboard-rooms.php',
    'payments' => 'dashboard-payments.php',
    'guests' => 'dashboard-guests.php',
    'reports' => 'dashboard-reports.php',
    'chat-widget' => 'dashboard-widget.php',
    'settings' => 'dashboard-settings.php',
    'subscription' => 'dashboard-subscription.php',
);

$template_file = isset($templates[$section]) ? $templates[$section] : 'dashboard-main.php';
$template_path = STAYDESK_PATH . 'templates/dashboard/' . $template_file;

if (file_exists($template_path)) {
    include $template_path;
} else {
    // Fallback to main dashboard
    include STAYDESK_PATH . 'templates/dashboard/dashboard-main.php';
}
