<?php
/**
 * Handle form submissions and lead capture
 */

class BendlessTech_Forms {
    
    public function __construct() {
        add_action('wp_ajax_submit_website_lead', array($this, 'handle_website_lead'));
        add_action('wp_ajax_nopriv_submit_website_lead', array($this, 'handle_website_lead'));
        
        add_action('wp_ajax_submit_inventory_lead', array($this, 'handle_inventory_lead'));
        add_action('wp_ajax_nopriv_submit_inventory_lead', array($this, 'handle_inventory_lead'));
        
        add_action('wp_ajax_submit_contact_form', array($this, 'handle_contact_form'));
        add_action('wp_ajax_nopriv_submit_contact_form', array($this, 'handle_contact_form'));
    }
    
    public function handle_website_lead() {
        check_ajax_referer('bendlesstech_nonce', 'nonce');
        
        // Sanitize input
        $data = array(
            'business_name' => sanitize_text_field($_POST['business_name']),
            'contact_name' => sanitize_text_field($_POST['contact_name']),
            'whatsapp' => sanitize_text_field($_POST['whatsapp']),
            'email' => sanitize_email($_POST['email']),
            'industry' => sanitize_text_field($_POST['industry']),
            'website_type' => sanitize_text_field($_POST['website_type']),
            'features' => sanitize_textarea_field($_POST['features']),
            'budget_range' => sanitize_text_field($_POST['budget_range']),
            'notes' => sanitize_textarea_field($_POST['notes']),
        );
        
        // Validate required fields
        if (empty($data['business_name']) || empty($data['contact_name']) || 
            empty($data['whatsapp']) || empty($data['email'])) {
            wp_send_json_error(array('message' => 'Please fill in all required fields.'));
        }
        
        // Validate email
        if (!is_email($data['email'])) {
            wp_send_json_error(array('message' => 'Please enter a valid email address.'));
        }
        
        // Save to database
        global $wpdb;
        $table = $wpdb->prefix . 'bt_leads';
        
        $result = $wpdb->insert(
            $table,
            array(
                'type' => 'website_development',
                'business_name' => $data['business_name'],
                'contact_name' => $data['contact_name'],
                'whatsapp' => $data['whatsapp'],
                'email' => $data['email'],
                'data' => json_encode($data),
                'status' => 'new',
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );
        
        if ($result === false) {
            wp_send_json_error(array('message' => 'Failed to save lead. Please try again.'));
        }
        
        // Send email notification
        $email = new BendlessTech_Email();
        $email->send_website_lead_notification($data);
        
        wp_send_json_success(array('message' => 'Thank you! We will contact you via WhatsApp within 15 minutes.'));
    }
    
    public function handle_inventory_lead() {
        check_ajax_referer('bendlesstech_nonce', 'nonce');
        
        // Sanitize input
        $data = array(
            'business_name' => sanitize_text_field($_POST['business_name']),
            'contact_name' => sanitize_text_field($_POST['contact_name']),
            'whatsapp' => sanitize_text_field($_POST['whatsapp']),
            'email' => sanitize_email($_POST['email']),
            'industry' => sanitize_text_field($_POST['industry']),
            'inventory_size' => sanitize_text_field($_POST['inventory_size']),
            'num_products' => sanitize_text_field($_POST['num_products']),
            'num_users' => sanitize_text_field($_POST['num_users']),
            'features' => sanitize_textarea_field($_POST['features']),
            'challenges' => sanitize_textarea_field($_POST['challenges']),
            'notes' => sanitize_textarea_field($_POST['notes']),
        );
        
        // Validate required fields
        if (empty($data['business_name']) || empty($data['contact_name']) || 
            empty($data['whatsapp']) || empty($data['email'])) {
            wp_send_json_error(array('message' => 'Please fill in all required fields.'));
        }
        
        // Validate email
        if (!is_email($data['email'])) {
            wp_send_json_error(array('message' => 'Please enter a valid email address.'));
        }
        
        // Save to database
        global $wpdb;
        $table = $wpdb->prefix . 'bt_leads';
        
        $result = $wpdb->insert(
            $table,
            array(
                'type' => 'inventory_system',
                'business_name' => $data['business_name'],
                'contact_name' => $data['contact_name'],
                'whatsapp' => $data['whatsapp'],
                'email' => $data['email'],
                'data' => json_encode($data),
                'status' => 'new',
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );
        
        if ($result === false) {
            wp_send_json_error(array('message' => 'Failed to save lead. Please try again.'));
        }
        
        // Send email notification
        $email = new BendlessTech_Email();
        $email->send_inventory_lead_notification($data);
        
        wp_send_json_success(array('message' => 'Thank you! We will contact you via WhatsApp within 15 minutes.'));
    }
    
    public function handle_contact_form() {
        check_ajax_referer('bendlesstech_nonce', 'nonce');
        
        // Sanitize input
        $data = array(
            'name' => sanitize_text_field($_POST['name']),
            'email' => sanitize_email($_POST['email']),
            'whatsapp' => sanitize_text_field($_POST['whatsapp']),
            'message' => sanitize_textarea_field($_POST['message']),
        );
        
        // Validate
        if (empty($data['name']) || empty($data['email']) || empty($data['message'])) {
            wp_send_json_error(array('message' => 'Please fill in all required fields.'));
        }
        
        if (!is_email($data['email'])) {
            wp_send_json_error(array('message' => 'Please enter a valid email address.'));
        }
        
        // Send email
        $email = new BendlessTech_Email();
        $email->send_contact_notification($data);
        
        wp_send_json_success(array('message' => 'Thank you for your message! We will get back to you soon.'));
    }
}
