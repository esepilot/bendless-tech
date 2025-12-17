<?php
/**
 * Booking Management Class
 */

class StayDesk_Booking {
    
    public function __construct() {
        add_action('wp_ajax_create_booking', array($this, 'create_booking'));
        add_action('wp_ajax_nopriv_create_booking', array($this, 'create_booking'));
        add_action('wp_ajax_update_booking_status', array($this, 'update_booking_status'));
        add_action('wp_ajax_cancel_booking', array($this, 'cancel_booking'));
        add_action('wp_ajax_get_bookings', array($this, 'get_bookings'));
    }
    
    public function create_booking() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        global $wpdb;
        
        $hotel_id = intval($_POST['hotel_id']);
        $room_id = intval($_POST['room_id']);
        
        // Generate unique booking reference
        $booking_reference = 'SD-' . strtoupper(substr(md5(time() . $hotel_id . $room_id), 0, 10));
        
        // Check room availability
        $check_in = sanitize_text_field($_POST['check_in_date']);
        $check_out = sanitize_text_field($_POST['check_out_date']);
        
        if (!$this->check_availability($room_id, $check_in, $check_out)) {
            wp_send_json_error(array('message' => 'Room not available for selected dates'));
        }
        
        $result = $wpdb->insert(
            $wpdb->prefix . 'staydesk_bookings',
            array(
                'hotel_id' => $hotel_id,
                'room_id' => $room_id,
                'booking_reference' => $booking_reference,
                'guest_name' => sanitize_text_field($_POST['guest_name']),
                'guest_email' => sanitize_email($_POST['guest_email']),
                'guest_phone' => sanitize_text_field($_POST['guest_phone']),
                'check_in_date' => $check_in,
                'check_out_date' => $check_out,
                'num_guests' => intval($_POST['num_guests']),
                'total_amount' => floatval($_POST['total_amount']),
                'payment_status' => 'pending',
                'booking_status' => 'pending',
                'special_requests' => sanitize_textarea_field($_POST['special_requests'] ?? ''),
            ),
            array('%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%f', '%s', '%s', '%s')
        );
        
        if ($result) {
            $booking_id = $wpdb->insert_id;
            
            // Send confirmation email
            $this->send_booking_confirmation($booking_id);
            
            wp_send_json_success(array(
                'booking_id' => $booking_id,
                'booking_reference' => $booking_reference,
                'message' => 'Booking created successfully'
            ));
        }
        
        wp_send_json_error(array('message' => 'Failed to create booking'));
    }
    
    public function check_availability($room_id, $check_in, $check_out) {
        global $wpdb;
        
        // Get room details
        $room = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}staydesk_rooms WHERE id = %d",
            $room_id
        ));
        
        if (!$room) {
            return false;
        }
        
        // Count overlapping bookings
        $overlapping = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}staydesk_bookings 
            WHERE room_id = %d 
            AND booking_status IN ('confirmed', 'checked_in')
            AND (
                (check_in_date <= %s AND check_out_date > %s)
                OR (check_in_date < %s AND check_out_date >= %s)
                OR (check_in_date >= %s AND check_out_date <= %s)
            )",
            $room_id, $check_in, $check_in, $check_out, $check_out, $check_in, $check_out
        ));
        
        return ($overlapping < $room->total_rooms);
    }
    
    public function update_booking_status() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        global $wpdb;
        
        $booking_id = intval($_POST['booking_id']);
        $status = sanitize_text_field($_POST['status']);
        
        $result = $wpdb->update(
            $wpdb->prefix . 'staydesk_bookings',
            array('booking_status' => $status),
            array('id' => $booking_id),
            array('%s'),
            array('%d')
        );
        
        if ($result !== false) {
            wp_send_json_success(array('message' => 'Booking status updated'));
        }
        
        wp_send_json_error(array('message' => 'Failed to update booking'));
    }
    
    public function cancel_booking() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        global $wpdb;
        
        $booking_id = intval($_POST['booking_id']);
        
        $result = $wpdb->update(
            $wpdb->prefix . 'staydesk_bookings',
            array('booking_status' => 'cancelled'),
            array('id' => $booking_id),
            array('%s'),
            array('%d')
        );
        
        if ($result !== false) {
            wp_send_json_success(array('message' => 'Booking cancelled successfully'));
        }
        
        wp_send_json_error(array('message' => 'Failed to cancel booking'));
    }
    
    public function get_bookings() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        global $wpdb;
        
        $user_id = get_current_user_id();
        $hotel = new StayDesk_Hotel();
        $hotel_data = $hotel->get_hotel_by_user($user_id);
        
        if (!$hotel_data) {
            wp_send_json_error(array('message' => 'Hotel not found'));
        }
        
        $bookings = $wpdb->get_results($wpdb->prepare(
            "SELECT b.*, r.room_type 
            FROM {$wpdb->prefix}staydesk_bookings b
            LEFT JOIN {$wpdb->prefix}staydesk_rooms r ON b.room_id = r.id
            WHERE b.hotel_id = %d
            ORDER BY b.created_at DESC
            LIMIT 100",
            $hotel_data->id
        ));
        
        wp_send_json_success($bookings);
    }
    
    private function send_booking_confirmation($booking_id) {
        global $wpdb;
        
        $booking = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}staydesk_bookings WHERE id = %d",
            $booking_id
        ));
        
        if (!$booking) {
            return;
        }
        
        $hotel = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}staydesk_hotels WHERE id = %d",
            $booking->hotel_id
        ));
        
        $subject = 'Booking Confirmation - ' . $booking->booking_reference;
        $message = "Your booking has been confirmed.\n\n";
        $message .= "Booking Reference: {$booking->booking_reference}\n";
        $message .= "Hotel: {$hotel->hotel_name}\n";
        $message .= "Check-in: {$booking->check_in_date}\n";
        $message .= "Check-out: {$booking->check_out_date}\n";
        $message .= "Total Amount: ₦" . number_format($booking->total_amount, 2) . "\n";
        
        wp_mail($booking->guest_email, $subject, $message);
    }
}
