<?php
/**
 * Fired during plugin activation
 */

class StayDesk_Activator {
    
    public static function activate() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Hotels table
        $table_hotels = $wpdb->prefix . 'staydesk_hotels';
        $sql_hotels = "CREATE TABLE IF NOT EXISTS $table_hotels (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id bigint(20) UNSIGNED NOT NULL,
            hotel_name varchar(255) NOT NULL,
            hotel_slug varchar(255) NOT NULL UNIQUE,
            email varchar(255) NOT NULL,
            phone varchar(50) NOT NULL,
            address text,
            city varchar(100),
            state varchar(100),
            country varchar(100) DEFAULT 'Nigeria',
            description longtext,
            check_in_time varchar(20),
            check_out_time varchar(20),
            cancellation_policy text,
            refund_policy text,
            payment_methods text,
            logo_url varchar(500),
            images longtext,
            amenities longtext,
            policies longtext,
            faqs longtext,
            status varchar(20) DEFAULT 'active',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY user_id (user_id),
            KEY hotel_slug (hotel_slug),
            KEY status (status)
        ) $charset_collate;";
        
        // Rooms table
        $table_rooms = $wpdb->prefix . 'staydesk_rooms';
        $sql_rooms = "CREATE TABLE IF NOT EXISTS $table_rooms (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            hotel_id bigint(20) UNSIGNED NOT NULL,
            room_type varchar(255) NOT NULL,
            description text,
            price_per_night decimal(10,2) NOT NULL,
            capacity int(11) DEFAULT 2,
            total_rooms int(11) NOT NULL,
            amenities longtext,
            images longtext,
            status varchar(20) DEFAULT 'active',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY hotel_id (hotel_id),
            KEY status (status)
        ) $charset_collate;";
        
        // Bookings table
        $table_bookings = $wpdb->prefix . 'staydesk_bookings';
        $sql_bookings = "CREATE TABLE IF NOT EXISTS $table_bookings (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            hotel_id bigint(20) UNSIGNED NOT NULL,
            room_id bigint(20) UNSIGNED NOT NULL,
            booking_reference varchar(50) NOT NULL UNIQUE,
            guest_name varchar(255) NOT NULL,
            guest_email varchar(255) NOT NULL,
            guest_phone varchar(50) NOT NULL,
            check_in_date date NOT NULL,
            check_out_date date NOT NULL,
            num_guests int(11) DEFAULT 1,
            total_amount decimal(10,2) NOT NULL,
            payment_status varchar(20) DEFAULT 'pending',
            booking_status varchar(20) DEFAULT 'pending',
            special_requests text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY hotel_id (hotel_id),
            KEY room_id (room_id),
            KEY booking_reference (booking_reference),
            KEY check_in_date (check_in_date),
            KEY check_out_date (check_out_date),
            KEY booking_status (booking_status)
        ) $charset_collate;";
        
        // Guests table
        $table_guests = $wpdb->prefix . 'staydesk_guests';
        $sql_guests = "CREATE TABLE IF NOT EXISTS $table_guests (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            hotel_id bigint(20) UNSIGNED NOT NULL,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            phone varchar(50),
            address text,
            city varchar(100),
            country varchar(100),
            id_type varchar(50),
            id_number varchar(100),
            total_bookings int(11) DEFAULT 0,
            total_spent decimal(10,2) DEFAULT 0,
            last_visit date,
            notes text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY hotel_id (hotel_id),
            KEY email (email)
        ) $charset_collate;";
        
        // Payments table
        $table_payments = $wpdb->prefix . 'staydesk_payments';
        $sql_payments = "CREATE TABLE IF NOT EXISTS $table_payments (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            hotel_id bigint(20) UNSIGNED NOT NULL,
            booking_id bigint(20) UNSIGNED,
            payment_reference varchar(100) NOT NULL,
            amount decimal(10,2) NOT NULL,
            payment_method varchar(50) NOT NULL,
            payment_status varchar(20) DEFAULT 'pending',
            payment_type varchar(50) DEFAULT 'booking',
            transaction_id varchar(255),
            metadata longtext,
            paid_at datetime,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY hotel_id (hotel_id),
            KEY booking_id (booking_id),
            KEY payment_reference (payment_reference),
            KEY payment_status (payment_status)
        ) $charset_collate;";
        
        // Subscriptions table
        $table_subscriptions = $wpdb->prefix . 'staydesk_subscriptions';
        $sql_subscriptions = "CREATE TABLE IF NOT EXISTS $table_subscriptions (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            hotel_id bigint(20) UNSIGNED NOT NULL,
            plan_type varchar(20) NOT NULL,
            amount decimal(10,2) NOT NULL,
            discount_applied decimal(10,2) DEFAULT 0,
            status varchar(20) DEFAULT 'active',
            start_date date NOT NULL,
            end_date date NOT NULL,
            next_billing_date date,
            paystack_subscription_code varchar(255),
            paystack_customer_code varchar(255),
            auto_renew tinyint(1) DEFAULT 1,
            is_first_10_yearly tinyint(1) DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY hotel_id (hotel_id),
            KEY status (status),
            KEY next_billing_date (next_billing_date)
        ) $charset_collate;";
        
        // Refunds table
        $table_refunds = $wpdb->prefix . 'staydesk_refunds';
        $sql_refunds = "CREATE TABLE IF NOT EXISTS $table_refunds (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            hotel_id bigint(20) UNSIGNED NOT NULL,
            booking_id bigint(20) UNSIGNED NOT NULL,
            payment_id bigint(20) UNSIGNED,
            refund_reference varchar(100) NOT NULL UNIQUE,
            amount decimal(10,2) NOT NULL,
            reason text,
            status varchar(20) DEFAULT 'pending',
            processed_at datetime,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY hotel_id (hotel_id),
            KEY booking_id (booking_id),
            KEY status (status)
        ) $charset_collate;";
        
        // Chat widget conversations table
        $table_conversations = $wpdb->prefix . 'staydesk_conversations';
        $sql_conversations = "CREATE TABLE IF NOT EXISTS $table_conversations (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            hotel_id bigint(20) UNSIGNED NOT NULL,
            session_id varchar(100) NOT NULL,
            visitor_name varchar(255),
            visitor_email varchar(255),
            messages longtext,
            status varchar(20) DEFAULT 'active',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY hotel_id (hotel_id),
            KEY session_id (session_id),
            KEY status (status)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_hotels);
        dbDelta($sql_rooms);
        dbDelta($sql_bookings);
        dbDelta($sql_guests);
        dbDelta($sql_payments);
        dbDelta($sql_subscriptions);
        dbDelta($sql_refunds);
        dbDelta($sql_conversations);
        
        // Flush rewrite rules
        flush_rewrite_rules();
        
        // Create default pages
        self::create_default_pages();
    }
    
    private static function create_default_pages() {
        $pages = array(
            'staydesk' => 'StayDesk - Hotel Management Platform',
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
