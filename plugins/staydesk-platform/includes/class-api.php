<?php
/**
 * API Handler Class
 */

class StayDesk_API {
    
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }
    
    public function register_routes() {
        // Public API for chat widget and bookings
        register_rest_route('staydesk/v1', '/hotels/(?P<slug>[a-zA-Z0-9-]+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_hotel_public_data'),
            'permission_callback' => '__return_true',
        ));
        
        register_rest_route('staydesk/v1', '/hotels/(?P<slug>[a-zA-Z0-9-]+)/rooms', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_hotel_rooms'),
            'permission_callback' => '__return_true',
        ));
        
        register_rest_route('staydesk/v1', '/hotels/(?P<slug>[a-zA-Z0-9-]+)/check-availability', array(
            'methods' => 'POST',
            'callback' => array($this, 'check_room_availability'),
            'permission_callback' => '__return_true',
        ));
    }
    
    public function get_hotel_public_data($request) {
        global $wpdb;
        
        $slug = $request['slug'];
        
        $hotel = $wpdb->get_row($wpdb->prepare(
            "SELECT id, hotel_name, hotel_slug, email, phone, address, city, state, 
            description, check_in_time, check_out_time, cancellation_policy, 
            refund_policy, payment_methods, amenities, policies, faqs 
            FROM {$wpdb->prefix}staydesk_hotels 
            WHERE hotel_slug = %s AND status = 'active'",
            $slug
        ));
        
        if (!$hotel) {
            return new WP_Error('not_found', 'Hotel not found', array('status' => 404));
        }
        
        // Parse JSON fields
        $hotel->amenities = json_decode($hotel->amenities);
        $hotel->policies = json_decode($hotel->policies);
        $hotel->faqs = json_decode($hotel->faqs);
        $hotel->payment_methods = json_decode($hotel->payment_methods);
        
        return rest_ensure_response($hotel);
    }
    
    public function get_hotel_rooms($request) {
        global $wpdb;
        
        $slug = $request['slug'];
        
        // Get hotel ID
        $hotel_id = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}staydesk_hotels WHERE hotel_slug = %s",
            $slug
        ));
        
        if (!$hotel_id) {
            return new WP_Error('not_found', 'Hotel not found', array('status' => 404));
        }
        
        $rooms = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}staydesk_rooms 
            WHERE hotel_id = %d AND status = 'active'",
            $hotel_id
        ));
        
        foreach ($rooms as $room) {
            $room->amenities = json_decode($room->amenities);
        }
        
        return rest_ensure_response($rooms);
    }
    
    public function check_room_availability($request) {
        global $wpdb;
        
        $slug = $request['slug'];
        $room_id = $request->get_param('room_id');
        $check_in = $request->get_param('check_in');
        $check_out = $request->get_param('check_out');
        
        $booking = new StayDesk_Booking();
        $available = $booking->check_availability($room_id, $check_in, $check_out);
        
        return rest_ensure_response(array(
            'available' => $available,
            'room_id' => $room_id,
            'check_in' => $check_in,
            'check_out' => $check_out,
        ));
    }
}
