<?php
/**
 * Shortcodes Class
 * 
 * Registers shortcodes for all StayDesk Platform pages
 * Allows embedding pages anywhere using [staydesk_page type="..."]
 *
 * @package StayDesk_Platform
 * @since 1.0.0
 */

class StayDesk_Shortcodes {
    
    /**
     * Constructor - Register all shortcodes
     */
    public function __construct() {
        // Register main shortcode
        add_shortcode('staydesk_page', array($this, 'render_page_shortcode'));
        
        // Register individual shortcodes for convenience
        add_shortcode('staydesk_landing', array($this, 'render_landing'));
        add_shortcode('staydesk_register', array($this, 'render_register'));
        add_shortcode('staydesk_login', array($this, 'render_login'));
        add_shortcode('staydesk_dashboard', array($this, 'render_dashboard'));
    }
    
    /**
     * Main shortcode handler
     * Usage: [staydesk_page type="landing"]
     */
    public function render_page_shortcode($atts) {
        $atts = shortcode_atts(array(
            'type' => 'landing',
            'section' => '', // For dashboard sections
        ), $atts, 'staydesk_page');
        
        $type = sanitize_text_field($atts['type']);
        $section = sanitize_text_field($atts['section']);
        
        // Map types to template files
        $templates = array(
            'landing' => 'templates/page-staydesk-landing.php',
            'register' => 'templates/page-register.php',
            'login' => 'templates/page-login.php',
            'dashboard' => 'templates/dashboard/dashboard-router.php',
        );
        
        if (!isset($templates[$type])) {
            return '<p>Invalid page type. Available types: ' . implode(', ', array_keys($templates)) . '</p>';
        }
        
        // Set section for dashboard if provided
        if ($type === 'dashboard' && !empty($section)) {
            set_query_var('staydesk_section', $section);
        }
        
        return $this->render_template($templates[$type]);
    }
    
    /**
     * Individual shortcode handlers
     */
    public function render_landing($atts) {
        return $this->render_template('templates/page-staydesk-landing.php');
    }
    
    public function render_register($atts) {
        return $this->render_template('templates/page-register.php');
    }
    
    public function render_login($atts) {
        return $this->render_template('templates/page-login.php');
    }
    
    public function render_dashboard($atts) {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return '<div class="staydesk-error"><p>Please <a href="/staydesk/login">log in</a> to access the dashboard.</p></div>';
        }
        
        // Extract section if provided
        $atts = shortcode_atts(array(
            'section' => '',
        ), $atts, 'staydesk_dashboard');
        
        $section = sanitize_text_field($atts['section']);
        
        if (!empty($section)) {
            set_query_var('staydesk_section', $section);
        }
        
        return $this->render_template('templates/dashboard/dashboard-router.php');
    }
    
    /**
     * Render template and return output
     */
    private function render_template($template_file) {
        $template_path = STAYDESK_PATH . $template_file;
        
        if (!file_exists($template_path)) {
            return '<p>Template not found: ' . esc_html($template_file) . '</p>';
        }
        
        // Start output buffering
        ob_start();
        
        // Include the template
        include $template_path;
        
        // Get the output and clean buffer
        $output = ob_get_clean();
        
        return $output;
    }
}
