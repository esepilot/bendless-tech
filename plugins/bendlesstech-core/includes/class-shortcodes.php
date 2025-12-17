<?php
/**
 * Shortcodes Class
 * 
 * Registers shortcodes for all BendlessTech Core pages
 * Allows embedding pages anywhere using [bendlesstech_page type="..."]
 *
 * @package BendlessTech_Core
 * @since 1.0.0
 */

class BendlessTech_Shortcodes {
    
    /**
     * Constructor - Register all shortcodes
     */
    public function __construct() {
        // Register main shortcode
        add_shortcode('bendlesstech_page', array($this, 'render_page_shortcode'));
        
        // Register individual shortcodes for convenience
        add_shortcode('bendlesstech_home', array($this, 'render_home'));
        add_shortcode('bendlesstech_website_service', array($this, 'render_website_service'));
        add_shortcode('bendlesstech_inventory_service', array($this, 'render_inventory_service'));
        add_shortcode('bendlesstech_about', array($this, 'render_about'));
        add_shortcode('bendlesstech_contact', array($this, 'render_contact'));
        add_shortcode('bendlesstech_privacy', array($this, 'render_privacy'));
        add_shortcode('bendlesstech_terms', array($this, 'render_terms'));
    }
    
    /**
     * Main shortcode handler
     * Usage: [bendlesstech_page type="home"]
     */
    public function render_page_shortcode($atts) {
        $atts = shortcode_atts(array(
            'type' => 'home',
        ), $atts, 'bendlesstech_page');
        
        $type = sanitize_text_field($atts['type']);
        
        // Map types to template files
        $templates = array(
            'home' => 'templates/page-home.php',
            'website-service' => 'templates/page-website-service.php',
            'inventory-service' => 'templates/page-inventory-service.php',
            'about' => 'templates/page-about.php',
            'contact' => 'templates/page-contact.php',
            'privacy' => 'templates/page-privacy.php',
            'terms' => 'templates/page-terms.php',
        );
        
        if (!isset($templates[$type])) {
            return '<p>Invalid page type. Available types: ' . implode(', ', array_keys($templates)) . '</p>';
        }
        
        return $this->render_template($templates[$type]);
    }
    
    /**
     * Individual shortcode handlers
     */
    public function render_home($atts) {
        return $this->render_template('templates/page-home.php');
    }
    
    public function render_website_service($atts) {
        return $this->render_template('templates/page-website-service.php');
    }
    
    public function render_inventory_service($atts) {
        return $this->render_template('templates/page-inventory-service.php');
    }
    
    public function render_about($atts) {
        return $this->render_template('templates/page-about.php');
    }
    
    public function render_contact($atts) {
        return $this->render_template('templates/page-contact.php');
    }
    
    public function render_privacy($atts) {
        return $this->render_template('templates/page-privacy.php');
    }
    
    public function render_terms($atts) {
        return $this->render_template('templates/page-terms.php');
    }
    
    /**
     * Render template and return output
     */
    private function render_template($template_file) {
        $template_path = BENDLESSTECH_CORE_PATH . $template_file;
        
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
