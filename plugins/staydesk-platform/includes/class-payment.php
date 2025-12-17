<?php
/**
 * Payment Management Class
 */

class StayDesk_Payment {
    
    public function __construct() {
        add_action('wp_ajax_record_payment', array($this, 'record_payment'));
        add_action('wp_ajax_nopriv_record_payment', array($this, 'record_payment'));
        add_action('wp_ajax_get_payments', array($this, 'get_payments'));
    }
    
    public function record_payment() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        global $wpdb;
        
        $result = $wpdb->insert(
            $wpdb->prefix . 'staydesk_payments',
            array(
                'hotel_id' => intval($_POST['hotel_id']),
                'booking_id' => intval($_POST['booking_id'] ?? 0),
                'payment_reference' => sanitize_text_field($_POST['payment_reference']),
                'amount' => floatval($_POST['amount']),
                'payment_method' => sanitize_text_field($_POST['payment_method']),
                'payment_status' => sanitize_text_field($_POST['payment_status']),
                'payment_type' => sanitize_text_field($_POST['payment_type'] ?? 'booking'),
                'transaction_id' => sanitize_text_field($_POST['transaction_id'] ?? ''),
                'metadata' => json_encode($_POST['metadata'] ?? array()),
                'paid_at' => current_time('mysql'),
            ),
            array('%d', '%d', '%s', '%f', '%s', '%s', '%s', '%s', '%s', '%s')
        );
        
        if ($result) {
            // Update booking payment status if applicable
            if (!empty($_POST['booking_id'])) {
                $wpdb->update(
                    $wpdb->prefix . 'staydesk_bookings',
                    array('payment_status' => 'paid', 'booking_status' => 'confirmed'),
                    array('id' => intval($_POST['booking_id'])),
                    array('%s', '%s'),
                    array('%d')
                );
            }
            
            wp_send_json_success(array('payment_id' => $wpdb->insert_id, 'message' => 'Payment recorded'));
        }
        
        wp_send_json_error(array('message' => 'Failed to record payment'));
    }
    
    public function get_payments() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        global $wpdb;
        
        $user_id = get_current_user_id();
        $hotel = new StayDesk_Hotel();
        $hotel_data = $hotel->get_hotel_by_user($user_id);
        
        if (!$hotel_data) {
            wp_send_json_error(array('message' => 'Hotel not found'));
        }
        
        $payments = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}staydesk_payments 
            WHERE hotel_id = %d 
            ORDER BY created_at DESC 
            LIMIT 100",
            $hotel_data->id
        ));
        
        wp_send_json_success($payments);
    }
}
