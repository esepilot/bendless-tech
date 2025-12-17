<?php
/**
 * Fired during plugin activation
 */

class BendlessTech_Core_Activator {
    
    public static function activate() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Leads table
        $table_leads = $wpdb->prefix . 'bt_leads';
        $sql_leads = "CREATE TABLE IF NOT EXISTS $table_leads (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            type varchar(50) NOT NULL,
            business_name varchar(255) NOT NULL,
            contact_name varchar(255) NOT NULL,
            whatsapp varchar(20) NOT NULL,
            email varchar(255) NOT NULL,
            data longtext NOT NULL,
            status varchar(20) DEFAULT 'new',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY type (type),
            KEY status (status),
            KEY created_at (created_at)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_leads);
        
        // Flush rewrite rules
        flush_rewrite_rules();
        
        // Create default pages if they don't exist
        self::create_default_pages();
    }
    
    private static function create_default_pages() {
        $pages = array(
            'home' => 'Welcome to BendlessTech',
            'custom-website-development' => 'Custom Website Development',
            'secure-inventory-system' => 'Complete Secure Inventory System',
            'about' => 'About Us',
            'contact' => 'Contact',
            'privacy-policy' => 'Privacy Policy',
            'terms-of-service' => 'Terms of Service',
        );
        
        foreach ($pages as $slug => $title) {
            $page_check = get_page_by_path($slug);
            if (!$page_check) {
                wp_insert_post(array(
                    'post_title' => $title,
                    'post_name' => $slug,
                    'post_status' => 'publish',
                    'post_type' => 'page',
                    'post_content' => '',
                ));
            }
        }
    }
}
