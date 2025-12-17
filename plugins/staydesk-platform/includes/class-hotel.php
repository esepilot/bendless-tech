<?php
/**
 * Hotel Management Class
 */

class StayDesk_Hotel {
    
    public function __construct() {
        add_action('wp_ajax_create_hotel', array($this, 'create_hotel'));
        add_action('wp_ajax_update_hotel', array($this, 'update_hotel'));
        add_action('wp_ajax_add_room', array($this, 'add_room'));
        add_action('wp_ajax_update_room', array($this, 'update_room'));
        add_action('wp_ajax_get_hotel_data', array($this, 'get_hotel_data'));
    }
    
    public function create_hotel($data = null) {
        global $wpdb;
        
        if ($data === null) {
            check_ajax_referer('staydesk_nonce', 'nonce');
            $data = $_POST;
        }
        
        $user_id = get_current_user_id();
        
        if (!$user_id) {
            if ($data === null) {
                wp_send_json_error(array('message' => 'User not logged in'));
            }
            return false;
        }
        
        // Check if user already has a hotel
        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}staydesk_hotels WHERE user_id = %d",
            $user_id
        ));
        
        if ($existing) {
            if ($data === null) {
                wp_send_json_error(array('message' => 'Hotel already exists for this user'));
            }
            return false;
        }
        
        $hotel_slug = sanitize_title($data['hotel_name']);
        
        $result = $wpdb->insert(
            $wpdb->prefix . 'staydesk_hotels',
            array(
                'user_id' => $user_id,
                'hotel_name' => sanitize_text_field($data['hotel_name']),
                'hotel_slug' => $hotel_slug,
                'email' => sanitize_email($data['email']),
                'phone' => sanitize_text_field($data['phone']),
                'address' => sanitize_textarea_field($data['address']),
                'city' => sanitize_text_field($data['city']),
                'state' => sanitize_text_field($data['state']),
                'country' => sanitize_text_field($data['country'] ?? 'Nigeria'),
                'status' => 'active',
            ),
            array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );
        
        if ($result) {
            $hotel_id = $wpdb->insert_id;
            if ($data === null) {
                wp_send_json_success(array('hotel_id' => $hotel_id, 'message' => 'Hotel created successfully'));
            }
            return $hotel_id;
        }
        
        if ($data === null) {
            wp_send_json_error(array('message' => 'Failed to create hotel'));
        }
        return false;
    }
    
    public function get_hotel_by_user($user_id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}staydesk_hotels WHERE user_id = %d",
            $user_id
        ));
    }
    
    public function get_hotel_data() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        
        $user_id = get_current_user_id();
        $hotel = $this->get_hotel_by_user($user_id);
        
        if ($hotel) {
            wp_send_json_success($hotel);
        } else {
            wp_send_json_error(array('message' => 'Hotel not found'));
        }
    }
    
    public function update_hotel() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        global $wpdb;
        
        $user_id = get_current_user_id();
        $hotel = $this->get_hotel_by_user($user_id);
        
        if (!$hotel) {
            wp_send_json_error(array('message' => 'Hotel not found'));
        }
        
        $update_data = array();
        $format = array();
        
        $fields = array(
            'hotel_name', 'email', 'phone', 'address', 'city', 'state', 
            'description', 'check_in_time', 'check_out_time', 'cancellation_policy',
            'refund_policy', 'payment_methods', 'amenities', 'policies', 'faqs'
        );
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                if (in_array($field, array('amenities', 'policies', 'faqs', 'payment_methods'))) {
                    $update_data[$field] = json_encode($_POST[$field]);
                } else {
                    $update_data[$field] = sanitize_textarea_field($_POST[$field]);
                }
                $format[] = '%s';
            }
        }
        
        if (!empty($update_data)) {
            $result = $wpdb->update(
                $wpdb->prefix . 'staydesk_hotels',
                $update_data,
                array('id' => $hotel->id),
                $format,
                array('%d')
            );
            
            if ($result !== false) {
                wp_send_json_success(array('message' => 'Hotel updated successfully'));
            }
        }
        
        wp_send_json_error(array('message' => 'Failed to update hotel'));
    }
    
    public function add_room() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        global $wpdb;
        
        $user_id = get_current_user_id();
        $hotel = $this->get_hotel_by_user($user_id);
        
        if (!$hotel) {
            wp_send_json_error(array('message' => 'Hotel not found'));
        }
        
        $result = $wpdb->insert(
            $wpdb->prefix . 'staydesk_rooms',
            array(
                'hotel_id' => $hotel->id,
                'room_type' => sanitize_text_field($_POST['room_type']),
                'description' => sanitize_textarea_field($_POST['description']),
                'price_per_night' => floatval($_POST['price_per_night']),
                'capacity' => intval($_POST['capacity']),
                'total_rooms' => intval($_POST['total_rooms']),
                'amenities' => json_encode($_POST['amenities'] ?? array()),
                'status' => 'active',
            ),
            array('%d', '%s', '%s', '%f', '%d', '%d', '%s', '%s')
        );
        
        if ($result) {
            wp_send_json_success(array('room_id' => $wpdb->insert_id, 'message' => 'Room added successfully'));
        }
        
        wp_send_json_error(array('message' => 'Failed to add room'));
    }
    
    public function update_room() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        global $wpdb;
        
        $user_id = get_current_user_id();
        $hotel = $this->get_hotel_by_user($user_id);
        
        if (!$hotel) {
            wp_send_json_error(array('message' => 'Hotel not found'));
        }
        
        $room_id = intval($_POST['room_id']);
        
        $result = $wpdb->update(
            $wpdb->prefix . 'staydesk_rooms',
            array(
                'room_type' => sanitize_text_field($_POST['room_type']),
                'description' => sanitize_textarea_field($_POST['description']),
                'price_per_night' => floatval($_POST['price_per_night']),
                'capacity' => intval($_POST['capacity']),
                'total_rooms' => intval($_POST['total_rooms']),
                'amenities' => json_encode($_POST['amenities'] ?? array()),
            ),
            array('id' => $room_id, 'hotel_id' => $hotel->id),
            array('%s', '%s', '%f', '%d', '%d', '%s'),
            array('%d', '%d')
        );
        
        if ($result !== false) {
            wp_send_json_success(array('message' => 'Room updated successfully'));
        }
        
        wp_send_json_error(array('message' => 'Failed to update room'));
    }
}
