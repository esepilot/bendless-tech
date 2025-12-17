<?php
/**
 * Booking Handler Class for Chat Widget
 */

class StayDesk_Widget_Booking_Handler {
    
    public function handle_booking_request($hotel_id, $check_in, $check_out, $num_guests) {
        global $wpdb;
        
        // Check room availability
        $available_rooms = $this->get_available_rooms($hotel_id, $check_in, $check_out);
        
        if (empty($available_rooms)) {
            return array(
                'success' => false,
                'message' => 'Sorry, no rooms available for those dates.',
                'available_rooms' => array(),
            );
        }
        
        return array(
            'success' => true,
            'message' => 'Great! Here are the available rooms:',
            'available_rooms' => $available_rooms,
        );
    }
    
    private function get_available_rooms($hotel_id, $check_in, $check_out) {
        global $wpdb;
        
        $rooms = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}staydesk_rooms 
            WHERE hotel_id = %d AND status = 'active'",
            $hotel_id
        ));
        
        $available = array();
        
        foreach ($rooms as $room) {
            // Count bookings for this room in the date range
            $booked = $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->prefix}staydesk_bookings 
                WHERE room_id = %d 
                AND booking_status IN ('confirmed', 'checked_in')
                AND (
                    (check_in_date <= %s AND check_out_date > %s)
                    OR (check_in_date < %s AND check_out_date >= %s)
                    OR (check_in_date >= %s AND check_out_date <= %s)
                )",
                $room->id, $check_in, $check_in, $check_out, $check_out, $check_in, $check_out
            ));
            
            $available_count = $room->total_rooms - $booked;
            
            if ($available_count > 0) {
                $available[] = array(
                    'id' => $room->id,
                    'type' => $room->room_type,
                    'price' => $room->price_per_night,
                    'capacity' => $room->capacity,
                    'available_count' => $available_count,
                    'description' => $room->description,
                );
            }
        }
        
        return $available;
    }
    
    public function create_booking_from_chat($data) {
        global $wpdb;
        
        // Generate booking reference
        $reference = 'SD-CHAT-' . strtoupper(substr(md5(time()), 0, 10));
        
        // Calculate total amount
        $room = $wpdb->get_row($wpdb->prepare(
            "SELECT price_per_night FROM {$wpdb->prefix}staydesk_rooms WHERE id = %d",
            $data['room_id']
        ));
        
        $check_in = new DateTime($data['check_in']);
        $check_out = new DateTime($data['check_out']);
        $nights = $check_out->diff($check_in)->days;
        $total = $room->price_per_night * $nights;
        
        $result = $wpdb->insert(
            $wpdb->prefix . 'staydesk_bookings',
            array(
                'hotel_id' => $data['hotel_id'],
                'room_id' => $data['room_id'],
                'booking_reference' => $reference,
                'guest_name' => $data['guest_name'],
                'guest_email' => $data['guest_email'],
                'guest_phone' => $data['guest_phone'],
                'check_in_date' => $data['check_in'],
                'check_out_date' => $data['check_out'],
                'num_guests' => $data['num_guests'],
                'total_amount' => $total,
                'payment_status' => 'pending',
                'booking_status' => 'pending',
            ),
            array('%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%f', '%s', '%s')
        );
        
        if ($result) {
            return array(
                'success' => true,
                'booking_reference' => $reference,
                'total_amount' => $total,
                'message' => 'Booking created successfully! Your reference is: ' . $reference,
            );
        }
        
        return array(
            'success' => false,
            'message' => 'Failed to create booking. Please try again.',
        );
    }
    
    public function handle_refund_request($hotel_id, $booking_reference, $reason, $language = 'english') {
        global $wpdb;
        
        // Find booking
        $booking = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}staydesk_bookings 
            WHERE hotel_id = %d AND booking_reference = %s",
            $hotel_id, $booking_reference
        ));
        
        if (!$booking) {
            if ($language === 'pidgin') {
                return array(
                    'success' => false,
                    'message' => 'Sorry o, I no fit find that booking reference. Check am well and try again.',
                );
            }
            return array(
                'success' => false,
                'message' => 'Booking not found. Please check your reference and try again.',
            );
        }
        
        // Create refund request
        $refund_ref = 'REF-' . strtoupper(substr(md5(time()), 0, 10));
        
        $result = $wpdb->insert(
            $wpdb->prefix . 'staydesk_refunds',
            array(
                'hotel_id' => $hotel_id,
                'booking_id' => $booking->id,
                'refund_reference' => $refund_ref,
                'amount' => $booking->total_amount,
                'reason' => $reason,
                'status' => 'pending',
            ),
            array('%d', '%d', '%s', '%f', '%s', '%s')
        );
        
        if ($result) {
            if ($language === 'pidgin') {
                return array(
                    'success' => true,
                    'refund_reference' => $refund_ref,
                    'message' => "Your refund request don enter o! Reference: {$refund_ref}. We go process am and contact you soon. 💰",
                );
            }
            return array(
                'success' => true,
                'refund_reference' => $refund_ref,
                'message' => "Your refund request has been submitted! Reference: {$refund_ref}. We'll process it and contact you soon. 💰",
            );
        }
        
        if ($language === 'pidgin') {
            return array(
                'success' => false,
                'message' => 'Sorry o, something go wrong. Abeg try again or call us directly.',
            );
        }
        return array(
            'success' => false,
            'message' => 'Failed to submit refund request. Please try again or contact us directly.',
        );
    }
}
